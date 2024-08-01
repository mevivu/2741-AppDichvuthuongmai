<?php

namespace App\Admin\Services\Vehicle;

use App\Admin\Repositories\Driver\DriverRepositoryInterface;
use App\Admin\Services\Vehicle\VehicleServiceInterface;
use App\Admin\Repositories\Vehicle\VehicleRepositoryInterface;
use App\Admin\Repositories\VehicleOwner\VehicleOwnerRepositoryInterface;
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

    protected VehicleOwnerRepositoryInterface $vehicleOwnerRepository;

    protected DriverRepositoryInterface $driverRepository;

    public function __construct(
        VehicleRepositoryInterface $repository,
        DriverRepositoryInterface  $driverRepository,
        VehicleOwnerRepositoryInterface    $vehicleOwnerRepository
    ) {

        $this->repository = $repository;
        $this->vehicleOwnerRepository = $vehicleOwnerRepository;
        $this->driverRepository = $driverRepository;
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();
            $vehicleOwner = $this->vehicleOwnerRepository->create($data);
            $data['vehicle_owner_id'] = $vehicleOwner->id;
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
            $this->vehicleOwnerRepository->update($vehicle->id, $data);

            DB::commit();
            return $this->repository->update($data['id'], $data);
        } catch (Exception $e) {
            DB::rollback();
            $this->logError('Failed to process update vehicle', $e);
            return false;
        }
    }

    public function delete($id): object|bool
    {

        return $this->repository->delete($id);
    }
}
