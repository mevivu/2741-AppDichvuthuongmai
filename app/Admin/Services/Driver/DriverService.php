<?php

namespace App\Admin\Services\Driver;

use App\Admin\Repositories\Order\OrderRepositoryInterface;
use App\Admin\Repositories\Rate\RateRepositoryInterface;
use App\Admin\Repositories\User\UserRepositoryInterface;
use App\Admin\Repositories\Driver\DriverRepository;
use App\Admin\Services\Driver\DriverServiceInterface;
use App\Admin\Traits\Setup;
use App\Enums\Driver\AutoAccept;
use App\Enums\User\UserRoles;
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
                                RateRepositoryInterface        $rateRepository,

                                UserRepositoryInterface        $userRepository)
    {
        $this->repository = $repository;
        $this->orderRepository = $orderRepository;
        $this->userRepository = $userRepository;
        $this->rateRepository = $rateRepository;


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

    public function getRateConfirm($driver_id)
    {
        $total = $this->orderRepository->getByQueryBuilder([
            'driver_id' => $driver_id
        ])->get();
        $total_accept = $this->rateRepository->findBy([
            'driver_id' => $driver_id
        ])->order_acceptance_rate ?? 0;

        return $total_accept == 0 ? 0 : $total_accept / count($total) * 100;
    }

    public function getRateComplete($driver_id)
    {
        $total = $this->orderRepository->getByQueryBuilder([
            'driver_id' => $driver_id
        ])->get();
        $total_complete = $this->rateRepository->findBy([
            'driver_id' => $driver_id
        ])->order_completion_rate ?? 0;

        return $total_complete == 0 ? 0 : $total_complete / count($total) * 100;
    }

    public function getRateCancle($driver_id)
    {
        $total = $this->orderRepository->getByQueryBuilder([
            'driver_id' => $driver_id
        ])->get();
        $total_cancle = $this->rateRepository->findBy([
            'driver_id' => $driver_id
        ])->order_cancellation_rate ?? 0;

        return $total_cancle == 0 ? 0 : $total_cancle / count($total) * 100;
    }


}
