<?php

namespace App\Api\V1\Services\Driver;

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

    protected FileService $fileService;

    public function __construct(DriverRepositoryInterface $repository,
                                UserRepositoryInterface   $userRepository,
                                FileService               $fileService)
    {
        $this->repository = $repository;
        $this->userRepository = $userRepository;
        $this->fileService = $fileService;
    }


    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();
            $data = $this->fileService->uploadImages($this->folderDriver, $data, ImageFields::getDriverFields());
            $userInfo = [
                'phone' => $data['phone'],
                'password' => bcrypt($data['password']),
                'username' => $data['phone'],
                'email' => $data['email'],
                'fullname' => $data['fullname'],
                'code' => $this->createCodeUser(),
                'gender' => Gender::Female,
                'avatar' => $data['avatar']
            ];
            // create user
            $createdUser = $this->userRepository->create($userInfo);
            $this->userRepository->assignRoles($createdUser, [$this->getRoleDriver()]);
            $data['user_id'] = $createdUser->id;
            // create driver
            $driver = $this->repository->create($data);

            DB::commit();
            return $driver;
        } catch (Throwable $e) {
            DB::rollback();
            $this->logError('Failed to process register driver', $e);
            return false;
        }

    }

    public function update(Request $request): bool|object
    {
        DB::beginTransaction();
        try {

            $data = $request->validated();
            $driver = $this->getCurrentDriver();
            $data = $this->fileService->uploadImages($this->folderDriver, $data,
                ImageFields::getDriverFields(), $driver, ['user' => ['avatar']]);
            $user = $this->getCurrentUser();
            $userInfo = [
                'email' => $data['email'],
                'fullname' => $data['fullname'],
                'gender' => $data['gender'],
                'avatar' => $data['avatar']
            ];
            $this->userRepository->update($user->id, $userInfo);
            $driver = $this->repository->update($driver->id, $data);

            DB::commit();
            return $driver;
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
