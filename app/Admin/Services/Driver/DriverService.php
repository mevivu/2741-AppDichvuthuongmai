<?php

namespace App\Admin\Services\Driver;

use App\Admin\Repositories\Order\OrderRepositoryInterface;
use App\Admin\Repositories\User\UserRepositoryInterface;
use App\Admin\Repositories\Driver\DriverRepository;
use App\Admin\Services\Driver\DriverServiceInterface;
use App\Admin\Traits\Setup;
use App\Enums\Driver\AutoAccept;
use App\Enums\User\UserRoles;
use App\Enums\User\UserVip;
use App\Events\DriverCreated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DriverService implements DriverServiceInterface
{
    use Setup;
    /**
     * Current Object instance
     *
     * @var array
     */
    protected $data;

    protected $repository;
    protected $orderRepository;
    protected $rateRepository;

    protected UserRepositoryInterface $userRepository;



    public function __construct(DriverRepository                $repository,
                                OrderRepositoryInterface       $orderRepository,
                                UserRepositoryInterface        $userRepository)
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
            $roles = ['driver'];
            $this->repository->assignRoles($user, $roles);
            $userId = $user->id;
            if (!isset($data['auto_accept'])) {
                $data['auto_accept'] = AutoAccept::Off;
            }
            $data['current_lat'] = $data['end_lat'];
            $data['current_lng'] = $data['end_lng'];
            $data['current_address'] = $data['end_address'];
            $data['user_id'] = $userId;
            $driver_info = $this->repository->create($data);
            DB::commit();

            return $driver_info;
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;

        }
    }

    public function update(Request $request)
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

            $driver_info = $this->repository->update($data['id'], $data);
            DB::commit();

            return $driver_info;
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function delete($id, $userId)
    {
        $this->userRepository->updateAttribute($userId, 'roles', UserRoles::Customer->value);
        return $this->repository->delete($id);
    }


}
