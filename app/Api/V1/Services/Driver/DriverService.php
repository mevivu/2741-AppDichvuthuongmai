<?php

namespace App\Api\V1\Services\Driver;

use App\Admin\Repositories\Vehicle\VehicleRepositoryInterface;
use App\Admin\Services\File\FileService;
use App\Admin\Traits\Roles;
use App\Api\V1\Repositories\Driver\DriverRepositoryInterface;
use App\Api\V1\Repositories\User\UserRepositoryInterface;
use App\Api\V1\Support\AuthServiceApi;
use App\Api\V1\Support\UseLog;
use App\Constants\ImageFields;
use App\Enums\User\Gender;
use Exception;
use Illuminate\Http\Request;
use App\Admin\Traits\Setup;
use Illuminate\Support\Facades\DB;
use Throwable;


class DriverService implements DriverServiceInterface
{
    use Setup, Roles, AuthServiceApi, UseLog;

    /**
     * Current Object instance
     *
     * @var array
     */
    protected array $data;

    private string $folderDriver = "images/drivers";

    protected DriverRepositoryInterface $repository;

    protected UserRepositoryInterface $userRepository;
    protected VehicleRepositoryInterface $vehicleRepository;

    protected FileService $fileService;

    public function __construct(
        DriverRepositoryInterface $repository,
        UserRepositoryInterface   $userRepository,
        VehicleRepositoryInterface $vehicleRepository,
        FileService               $fileService
    ) {
        $this->repository = $repository;
        $this->userRepository = $userRepository;
        $this->vehicleRepository = $vehicleRepository;
        $this->fileService = $fileService;
    }


    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();
            $data = $this->fileService->uploadImages($this->folderDriver, $data, ImageFields::getDriverFields());
            $data['username'] = $data['phone'];
            $data['code'] = $this->createCodeUser();
            $data['gender'] = Gender::Female;
            // create user
            $user = $this->userRepository->create($data);
            $this->userRepository->assignRoles($user, [$this->getRoleDriver()]);
            $data['user_id'] = $user->id;
            // create driver
            $driver = $this->repository->create($data);
            $data['driver_id'] = $driver->id;
            // create vehicle
            $this->vehicleRepository->create($data);

            DB::commit();
            return $driver;
        } catch (Throwable $e) {
            DB::rollback();
            $this->logError('Failed to process register driver', $e);
            return false;
        }
    }

    public function update(Request $request)
    {
        DB::beginTransaction();
        try {

            $data = $request->validated();
            $driver = $this->getCurrentDriver();
            $data = $this->fileService->uploadImages(
                $this->folderDriver,
                $data,
                ImageFields::getDriverFields(),
                $driver,
                ['user' => ['avatar']]
            );
            $user = $this->getCurrentUser();
            if (isset($data['phone'])) {
                $data['username'] = $data['phone'];
            }
            $this->userRepository->update($user->id, $data);
            $this->repository->update($driver->id, $data);
            $this->vehicleRepository->update($driver->vehicle->id, $data);
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollback();
            $this->logError('Failed to process update driver', $e);
            return false;
        }
    }


    /**
     * @throws Exception
     */
    public function delete($id): object|bool
    {
        return $this->repository->delete($id);
    }
}
