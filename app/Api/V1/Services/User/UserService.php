<?php

namespace App\Api\V1\Services\User;

use App\Admin\Services\File\FileService;
use App\Admin\Traits\Roles;
use  App\Api\V1\Repositories\User\UserRepositoryInterface;
use App\Api\V1\Support\AuthServiceApi;
use App\Enums\User\Gender;
use Exception;
use Illuminate\Http\Request;
use App\Admin\Traits\Setup;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;


class UserService implements UserServiceInterface
{
    use Setup, Roles, AuthServiceApi;

    /**
     * Current Object instance
     *
     * @var array
     */
    protected $data;

    protected $repository;

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
            Log::error('Failed to process Register user', [
                'error' => $e->getMessage(),
            ]);
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
                $data['avatar'] = $this->fileService->uploadAvatar('images', $avatar, $user->avatar);
            }
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
