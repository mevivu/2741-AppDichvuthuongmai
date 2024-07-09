<?php

namespace App\Admin\Services\Vehicle;

use App\Admin\Repositories\Driver\DriverRepositoryInterface;
use App\Admin\Repositories\User\UserRepositoryInterface;
use App\Admin\Services\Vehicle\VehicleServiceInterface;
use App\Admin\Repositories\Vehicle\VehicleRepositoryInterface;
use App\Admin\Traits\Roles;
use App\Api\V1\Support\UseLog;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class VehicleService implements VehicleServiceInterface
{
    use UseLog, Roles;

    /**
     * Current Object instance
     *
     * @var array
     */
    protected array $data;

    protected VehicleRepositoryInterface $repository;

    protected UserRepositoryInterface $userRepository;

    protected DriverRepositoryInterface $driverRepository;

    public function __construct(VehicleRepositoryInterface $repository,
                                DriverRepositoryInterface  $driverRepository,
                                UserRepositoryInterface    $userRepository)
    {

        $this->repository = $repository;
        $this->userRepository = $userRepository;
        $this->driverRepository = $driverRepository;

    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();
            $dataUser = $data['user_info'];
            $dataUser['address'] = $data['address'];
            $dataUser['latitude'] = $data['lat'];
            $dataUser['longitude'] = $data['lng'];
            $dataUser['code'] = uniqid_real();
            $roles = $this->getRoleVehicleOwner();
            $user = $this->userRepository->create($dataUser);
            $this->repository->assignRoles($user, [$roles]);
            $userId = $user->id;
            $data['user_id'] = $userId;
            $driver = $this->driverRepository->create($data);
            $data['driver_id'] = $driver->id;
            $vehicle = $this->repository->create($data);
            DB::commit();
            return $vehicle;
        } catch (Exception $e) {
            DB::rollback();
            $this->logError('Failed to process create vehicle', $e);
            throw $e;
//            return false;
        }
    }

    /**
     * @throws Exception
     */
    public function update(Request $request): object|bool
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();
            $vehicle = $this->repository->findOrFail($data['id']);
            $driver = $vehicle->driver;
            $userId = $driver->user->id;
            $dataUser = $data['user_info'];
            $dataUser['address'] = $data['address'];
            $dataUser['latitude'] = $data['lat'];
            $dataUser['longitude'] = $data['lng'];
            $this->userRepository->update($userId, $dataUser);
            $this->driverRepository->update($driver->id,$data);

            DB::commit();
            return $this->repository->update($data['id'], $data);
        } catch (Exception $e) {
            DB::rollback();
            $this->logError('Failed to process create vehicle', $e);
            return false;
        }
    }

    public function delete($id): object|bool
    {

        return $this->repository->delete($id);
    }
}
