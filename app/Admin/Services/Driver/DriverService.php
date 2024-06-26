<?php

namespace App\Admin\Services\Driver;

use App\Admin\Repositories\Driver\DriverRepositoryInterface;
use App\Admin\Repositories\Order\OrderRepositoryInterface;
use App\Admin\Repositories\User\UserRepositoryInterface;
use App\Admin\Traits\Roles;
use App\Admin\Traits\Setup;
use App\Enums\Driver\AutoAccept;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DriverService implements DriverServiceInterface
{
    use Setup, Roles;

    /**
     * Current Object instance
     *
     * @var array
     */
    protected array $data;

    protected DriverRepositoryInterface $repository;
    protected OrderRepositoryInterface $orderRepository;

    protected UserRepositoryInterface $userRepository;


    public function __construct(DriverRepositoryInterface $repository,
                                OrderRepositoryInterface  $orderRepository,
                                UserRepositoryInterface   $userRepository)
    {
        $this->repository = $repository;
        $this->orderRepository = $orderRepository;
        $this->userRepository = $userRepository;

    }

    public function store(Request $request)
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
            $roles = $this->getRoleDriver();
            $driver = $this->repository->create($data);
            $this->repository->assignRoles($driver->user, [$roles]);
            DB::commit();

            return $driver;
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;

        }
    }

    public function update(Request $request): object
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
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
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

            $userId = $driver->user_id;
            $this->userRepository->delete($userId);
//            $imageFields = getImageFields();
            DB::commit();

            return $this->repository->delete($id);
        } catch (Exception $e) {
            DB::rollback();
            Log::error('Error deleting driver', [
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }


}
