<?php

namespace App\Api\V1\Services\User;

use App\Admin\Services\File\FileService;
use App\Admin\Traits\Roles;
use  App\Api\V1\Repositories\User\UserRepositoryInterface;
use App\Api\V1\Support\AuthServiceApi;
use App\Api\V1\Support\UseLog;
use App\Enums\User\Gender;
use Exception;
use Illuminate\Http\Request;
use App\Admin\Traits\Setup;
use Illuminate\Support\Facades\DB;
use Throwable;


class UserService implements UserServiceInterface
{
    use Setup, Roles, AuthServiceApi, UseLog;

    /**
     * Current Object instance
     *
     * @var array
     */
    protected array $data;

    protected UserRepositoryInterface $repository;

    protected FileService $fileService;

    public function __construct(UserRepositoryInterface $repository,
                                FileService             $fileService)
    {
        $this->repository = $repository;
        $this->fileService = $fileService;
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();
            $data['username'] = $data['phone'];
            $data['password'] = bcrypt($data['password']);
            $data['code'] = $this->createCodeUser();
            $data['gender'] = Gender::Female;

            $user = $this->repository->create($data);
            $this->repository->assignRoles($user, [$this->getRoleCustomer()]);
            DB::commit();
            return $user;
        } catch (Throwable $e) {
            DB::rollback();
            $this->logError('Failed to process register user API', $e);
            return false;
        }

    }

    public function update(Request $request): bool|object
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();
            $user = $this->getCurrentUser();
            $avatar = $data['avatar'];
            if ($avatar) {
                $data['avatar'] = $this->fileService->uploadAvatar('images/users', $avatar, $user->avatar);
            }
            $response = $this->repository->update($user->id, $data);
            DB::commit();
            return $response;
        } catch (Exception $e) {
            DB::rollback();
            $this->logError('Failed to process update user API', $e);
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
