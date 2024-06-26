<?php

namespace App\Api\V1\Services\Driver;

use App\Admin\Services\File\FileService;
use App\Admin\Traits\Roles;
use App\Api\V1\Repositories\Driver\DriverRepositoryInterface;
use App\Api\V1\Repositories\User\UserRepositoryInterface;
use App\Api\V1\Support\AuthServiceApi;
use App\Enums\User\Gender;
use Exception;
use Illuminate\Http\Request;
use App\Admin\Traits\Setup;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;


class DriverService implements DriverServiceInterface
{
    use Setup, Roles, AuthServiceApi;

    /**
     * Current Object instance
     *
     * @var array
     */
    protected array $data;

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

    public static function getImageFields(): array
    {
        return [
            'avatar',
            'id_card_front',
            'id_card_back',
            'license_plate_image',
            'vehicle_registration_front',
            'vehicle_registration_back',
            'driver_license_front',
            'driver_license_back',
            'vehicle_front_image',
            'vehicle_back_image',
            'vehicle_side_image',
            'vehicle_interior_image',
            'insurance_front_image',
            'insurance_back_image'
        ];
    }


    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();
            $data = $this->fileService->uploadImages("images/drivers",$data, $this->getImageFields());
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
            $this->repository->assignRoles($createdUser, [$this->getRoleDriver()]);
            $data['user_id'] = $createdUser->id;
            // create driver
            $driver = $this->repository->create($data);

            DB::commit();
            return $driver;
        } catch (Throwable $e) {
            DB::rollback();
            Log::error('Failed to process Register user', [
                'error' => $e->getMessage(),
            ]);
            throw $e;
//            return false;
        }

    }

    public function update(Request $request): bool|object
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();
            $user = $this->getCurrentUser();
            $avatar = $data['avatar'];
            $userInfo = [
                'phone' => $data['phone'],
                'password' => bcrypt($data['password']),
                'username' => $user['phone'],
                'email' => $data['email'],
                'fullname' => $data['fullname'],
                'code' => $this->createCodeUser(),
                'gender' => Gender::Female,
                'avatar' => $this->fileService->uploadAvatar('images', $avatar, $avatar)
            ];
            $createdUser = $this->userRepository->create($userInfo);


            $response = $this->repository->update($user->id, $data);
            DB::commit();
            return $response;
        } catch (Exception $e) {
            DB::rollback();
            Log::error('Failed to process update user', [
                'error' => $e->getMessage(),
            ]);
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
