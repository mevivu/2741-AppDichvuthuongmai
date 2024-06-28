<?php

namespace App\Admin\Services\Driver;

use App\Admin\Repositories\Driver\DriverRepositoryInterface;
use App\Admin\Repositories\Order\OrderRepositoryInterface;
use App\Admin\Repositories\User\UserRepositoryInterface;
use App\Admin\Repositories\Vehicle\VehicleRepositoryInterface;
use App\Admin\Services\File\FileService;
use App\Admin\Traits\Roles;
use App\Admin\Traits\Setup;
use App\Api\V1\Support\UseLog;
use App\Constants\ImageFields;
use App\Enums\Driver\AutoAccept;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class DriverService implements DriverServiceInterface
{
    use Setup, Roles, UseLog;

    /**
     * Current Object instance
     *
     * @var array
     */
    protected array $data;

    protected DriverRepositoryInterface $repository;

    protected OrderRepositoryInterface $orderRepository;

    protected UserRepositoryInterface $userRepository;

    protected VehicleRepositoryInterface $vehicleRepository;

    protected FileService $fileService;


    public function __construct(DriverRepositoryInterface $repository,
                                OrderRepositoryInterface  $orderRepository,
                                FileService               $fileService,
                                VehicleRepositoryInterface  $vehicleRepository,
                                UserRepositoryInterface   $userRepository)
    {
        $this->repository = $repository;
        $this->orderRepository = $orderRepository;
        $this->userRepository = $userRepository;
        $this->fileService = $fileService;
        $this->vehicleRepository = $vehicleRepository;

    }

    public function store(Request $request): object|bool
    {
        try {
            DB::beginTransaction();
            $data = $request->validated();

            $dataUser = $data['user_info'];
            $dataUser['address'] = $data['address'];
            $dataUser['latitude'] = $data['lat'];
            $dataUser['longitude'] = $data['lng'];
            $dataUser['code'] = uniqid_real();
            $dataUser['username'] = $dataUser['phone'];
            $user = $this->userRepository->create($dataUser);
            // roles
            $roles = $this->getRoleDriver();
            $this->repository->assignRoles($user, [$roles]);
            $userId = $user->id;
            if (!isset($data['auto_accept'])) {
                $data['auto_accept'] = AutoAccept::Off;
            }
            $data['current_lat'] = $data['end_lat'];
            $data['current_lng'] = $data['end_lng'];
            $data['current_address'] = $data['end_address'];
            $data['user_id'] = $userId;
            $driver = $this->repository->create($data);
            $data['driver_id'] = $driver->id;
            $this->vehicleRepository->create($data);
            DB::commit();

            return $driver;
        } catch (Throwable $e) {
            DB::rollBack();
            $this->logError('Failed to process create driver CMS', $e);
            return false;

        }
    }

    public function update(Request $request): object|bool
    {
        try {
            DB::beginTransaction();
            $data = $request->validated();
            $dataUser = $data['user_info'];
            $dataUser['address'] = $data['address'];
            $dataUser['latitude'] = $data['lat'];
            $dataUser['longitude'] = $data['lng'];

            if (isset($dataUser['password']) && $dataUser['password']) {
                $dataUser['password'] = bcrypt($dataUser['password']);
            } else {
                unset($dataUser['password']);
            }
            $this->userRepository->update($dataUser['id'], $dataUser);

            if (!array_key_exists('auto_accept', $data)) {
                $data['auto_accept'] = AutoAccept::Off->value;
            }
            $data['current_lat'] = $data['end_lat'];
            $data['current_lng'] = $data['end_lng'];
            $data['current_address'] = $data['end_address'];
            $roles = $this->getRoleDriver();
            $driver = $this->repository->update($data['id'], $data);
            $this->repository->assignRoles($driver->user, [$roles]);
            DB::commit();

            return $driver;
        } catch (Throwable $e) {
            DB::rollBack();
            $this->logError('Failed to process update driver CMS', $e);
            return false;
        }
    }

    /**
     * @throws Exception
     */
    public function delete($id): object|bool
    {
        DB::beginTransaction();
        try {
            $driver = $this->repository->findOrFail($id);

            $user = $driver->user;
            $this->fileService->delete($user->avatar);
            $this->userRepository->delete($user->id);
            $imageFields = ImageFields::getDriverFields();
            foreach ($imageFields as $field) {
                $imagePath = $driver->{$field};
                if ($imagePath) {
                    $this->fileService->delete($imagePath);
                }
            }
            DB::commit();

            return $this->repository->delete($id);
        } catch (Exception $e) {
            DB::rollback();
            $this->logError('Error deleting driver', $e);
            return false;
        }
    }


}
