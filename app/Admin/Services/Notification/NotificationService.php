<?php

namespace App\Admin\Services\Notification;

use App\Admin\Repositories\Admin\AdminRepositoryInterface;
use App\Admin\Repositories\Notification\NotificationRepositoryInterface;
use App\Admin\Repositories\User\UserRepositoryInterface;
use App\Enums\Notification\NotificationStatus;
use App\Models\Notification;
use App\Traits\NotifiesViaFirebase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationService implements NotificationServiceInterface
{
    use NotifiesViaFirebase;

    /**
     * Current Object instance
     *
     * @var array
     */
    protected $data;

    protected $repository;
    private UserRepositoryInterface $userRepository;
    private AdminRepositoryInterface $adminRepository;

    public function __construct(NotificationRepositoryInterface $repository,
                                AdminRepositoryInterface        $adminRepository,
                                UserRepositoryInterface         $userRepository)
    {
        $this->repository = $repository;
        $this->userRepository = $userRepository;
        $this->adminRepository = $adminRepository;
    }

    public function store(Request $request)
    {
        $data = $request->validated();
        if (empty($data['user_id'])) {
            $data['user_id'] = $this->userRepository->getIdAllUser();

        }

        foreach ($data['user_id'] as $item) {
            $noti = new Notification();
            $noti->user_id = $item;
            $noti->admin_id = Auth::guard('admin')->user()->id;
            $noti->title = $data['title'];
            $noti->message = $data['message'];
            $noti->status = $data['status'];
            $noti->save();

            $device_token = $noti->user->device_token;

            if ($noti && $device_token) {
                $deviceTokens = [$device_token];
                $this->sendFirebaseNotification($deviceTokens, null, $noti->title, $noti->message);
            }


        }
        return 1;

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
        $data = $request->validate([
            'user_id' => 'required|exists:admins,id',
            'device_token' => 'required|string'
        ]);
        $user = $this->adminRepository->findOrFail($data['user_id']);

        if ($user->device_token === $data['device_token'] && $user->device_token_updated_at->gt(now()->subDay())) {
            return response()->json(['message' => 'Token is up-to-date, no need to update.'], 200);
        }
        try {
            $this->adminRepository->update($data['user_id'],
                [
                    'device_token' => $data['device_token'],
                    'device_token_updated_at' => now()
                ]);
//            $this->registerDeviceToTopic($data['device_token'], "Notification");

            return response()->json(['message' => 'Token successfully stored.'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to store token.', 'error' => $e->getMessage()], 500);
        }
    }


    public function getNotifications(Request $request)
    {
        $data = $request->validated();
        return $this->repository->getByAdminId($data['admin_id'], 20);
    }

    public function updateStatus(Request $request): JsonResponse
    {
        $data = $request->validated();
        $notifications = $this->repository->getBy([
            'admin_id' => $data['admin_id']
        ]);
        foreach ($notifications as $notification) {
            $this->repository->updateAttribute($notification->id, 'read', NotificationStatus::READ);
        }
        return response()->json([
            'success' => "updated successfully"
        ]);
    }
}
