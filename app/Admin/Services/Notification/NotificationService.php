<?php

namespace App\Admin\Services\Notification;

use App\Admin\Repositories\Admin\AdminRepositoryInterface;
use App\Admin\Repositories\Driver\DriverRepositoryInterface;
use App\Admin\Repositories\Notification\NotificationRepositoryInterface;
use App\Admin\Repositories\Store\StoreRepositoryInterface;
use App\Admin\Repositories\User\UserRepositoryInterface;
use App\Admin\Traits\AuthService;
use App\Admin\Traits\Roles;
use App\Enums\Notification\NotificationStatus;
use App\Traits\NotifiesViaFirebase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NotificationService implements NotificationServiceInterface
{
    use NotifiesViaFirebase, AuthService, Roles;

    /**
     * Current Object instance
     *
     * @var array
     */
    protected $data;

    protected $repository;
    private DriverRepositoryInterface $driverRepository;
    private StoreRepositoryInterface $storeRepository;
    private AdminRepositoryInterface $adminRepository;
    private UserRepositoryInterface $userRepository;

    public function __construct(
        NotificationRepositoryInterface $repository,
        StoreRepositoryInterface        $storeRepository,
        UserRepositoryInterface        $userRepository,
        AdminRepositoryInterface        $adminRepository,
        DriverRepositoryInterface         $driverRepository
    ) {
        $this->repository = $repository;
        $this->driverRepository = $driverRepository;
        $this->storeRepository = $storeRepository;
        $this->adminRepository = $adminRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * Lưu trữ thông báo và gửi đến những người nhận phù hợp.
     *
     * @param Request $request  Yêu cầu chứa dữ liệu thông báo đã được kiểm duyệt.
     * @return bool True nếu thông báo được lưu trữ và gửi thành công, False nếu không.
     */
    public function store(Request $request)
    {
        $this->data = $request->validated();

        $notification = false;

        switch ($this->data['type']) {
            case \App\Enums\Notification\NotificationType::All->value:
                $recipients = [$this->storeRepository, $this->driverRepository, $this->userRepository, $this->adminRepository];
                foreach ($recipients as $repository) {
                    if ($repository == $this->userRepository) {
                        $users = $repository->getUserByRole($this->getRoleCustomer());
                    } else {
                        $users = $repository->getAll();
                    }
                    $this->data['store_id'] = null;
                    $this->data['driver_id'] = null;
                    $this->data['user_id'] = null;
                    foreach ($users as $user) {
                        switch ($repository) {
                            case $this->storeRepository:
                                $this->data['store_id'] = $user->id;
                                break;
                            case $this->driverRepository:
                                $this->data['driver_id'] = $user->id;
                                break;
                            case $this->userRepository:
                                $this->data['user_id'] = $user->id;
                                break;
                            default:
                                $this->data['admin_id'] = $user->id;
                                break;
                        }
                        $notification = $this->repository->create($this->data);

                        $device_token = $user->device_token;
                        $this->data['device_token'] = $device_token;

                        if ($notification && $device_token) {
                            $this->sendFirebaseNotification([$device_token], null, $notification->title, $notification->message);
                        }
                    }
                }
                break;
            case \App\Enums\Notification\NotificationType::Driver->value:
                $this->data['store_id'] = null;
                $this->data['user_id'] = null;
                $notification = $this->handleNotificationOption('driver_id');
                break;
            case \App\Enums\Notification\NotificationType::Customer->value:
                $this->data['store_id'] = null;
                $this->data['driver_id'] = null;
                $notification = $this->handleNotificationOption('user_id');
                break;
            default:
                $this->data['driver_id'] = null;
                $this->data['user_id'] = null;
                $notification = $this->handleNotificationOption('store_id');
                break;
        }

        return $notification ? true : false;
    }

    /**
     * Xử lý tùy chọn gửi thông báo dựa trên kiểu người nhận và dữ liệu yêu cầu.
     *
     * @param string $objectId Tên trường lưu trữ ID người dùng trong kho lưu trữ.
     * @return bool True nếu thông báo được tạo và gửi thành công, False nếu không.
     */
    private function handleNotificationOption(string $objectId)
    {

        if ($this->data['option'] == \App\Enums\Notification\NotificationOption::All->value) {
            switch ($this->data['type']) {
                case \App\Enums\Notification\NotificationType::Driver->value:
                    $users = $this->driverRepository->getAll();
                    break;
                case \App\Enums\Notification\NotificationType::Customer->value:
                    $users = $this->userRepository->getUserByRole($this->getRoleCustomer());
                    break;
                default:
                    $users = $this->storeRepository->getAll();
                    break;
            }
            foreach ($users as $item) {
                $this->data[$objectId] = $item->id;
                switch ($this->data['type']) {
                    case \App\Enums\Notification\NotificationType::Driver->value:
                        $device_token = $item->user->device_token;
                        break;
                    case \App\Enums\Notification\NotificationType::Customer->value:
                        $device_token = $item->device_token;
                        break;
                    default:
                        $device_token = $item->device_token;
                        break;
                }
                $this->data['device_token'] = $device_token;

                $notification = $this->repository->create($this->data);
                if ($notification && $device_token) {
                    $this->sendFirebaseNotification([$device_token], null, $notification->title, $notification->message);
                }
            }
        } else {
            switch ($this->data['type']) {
                case \App\Enums\Notification\NotificationType::Driver->value:
                    $item = $this->driverRepository->findOrFail($this->data[$objectId]);
                    break;
                case \App\Enums\Notification\NotificationType::Customer->value:
                    $item = $this->userRepository->findOrFail($this->data[$objectId]);
                    break;
                default:
                    $item = $this->storeRepository->findOrFail($this->data[$objectId]);
                    break;
            }
            $notification = $this->repository->create($this->data);
            if ($item->user) {
                $device_token = $item->user->device_token;
            } else {
                $device_token = $item->device_token;
            }
            $this->data['device_token'] = $device_token;
            if ($notification && $device_token) {
                $this->sendFirebaseNotification([$device_token], null, $notification->title, $notification->message);
            }
        }

        return true; // Thông báo được xử lý thành công
    }


    public function update(Request $request): object|bool
    {

        $this->data = $request->validated();

        return $this->repository->update($this->data['id'], $this->data);
    }

    /**
     * @throws \Exception
     */
    public function delete($id): object|bool
    {
        return $this->repository->delete($id);
    }

    /**
     * @throws \Exception
     */
    public function updateDeviceToken($request): JsonResponse
    {
        try {
            $data = $request->validate([
                'device_token' => 'required|string'
            ]);
            $admin = $this->getCurrentAdmin();

            if ($admin->device_token == null || $admin->device_token != $data['device_token']) {
                $this->adminRepository->update($admin->id, [
                    'device_token' => $data['device_token'],
                ]);
                return response()->json(['message' => 'Update device token success.'], 200);
            } else {
                return response()->json(['message' => 'Device token is up to date.'], 200);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to update token.', 'error' => $e->getMessage()], 500);
        }
    }


    /**
     * Gets notifications for admin
     *
     * @param Request $request
     * @return mixed
     */
    public function getNotifications(Request $request): mixed
    {
        $data = $request->validated();
        return $this->repository->getBy(['admin_id' => $data['admin_id'], 'status' => NotificationStatus::NOT_READ]);
    }

    /**
     * Gets notifications for store
     *
     * @param Request $request
     * @return mixed
     */

    public function updateStatus(Request $request): JsonResponse
    {
        $data = $request->validated();

        $filters = [];
        if (!empty($data['admin_id'])) {
            $filters['admin_id'] = $data['admin_id'];
        }

        $notifications = $this->repository->getBy($filters);

        foreach ($notifications as $notification) {
            $this->repository->update($notification->id, ['status' => NotificationStatus::READ]);
        }

        return response()->json(['success' => "Updated successfully"]);
    }
}
