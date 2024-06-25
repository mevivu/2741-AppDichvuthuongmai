<?php

namespace App\Admin\Services\User;

use  App\Admin\Repositories\User\UserRepositoryInterface;
use App\Admin\Traits\Roles;
use Exception;
use Illuminate\Http\Request;
use App\Admin\Traits\Setup;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UserService implements UserServiceInterface
{
    use Setup, Roles;

    /**
     * Current Object instance
     *
     * @var array
     */
    protected $data;

    protected $repository;

    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function store(Request $request): object|false
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();
            $data['username'] = $data['phone'];
            $data['code'] = $this->createCodeUser();
            $data['password'] = bcrypt($data['password']);

            $user = $this->repository->create($data);
            $roles = $this->getRoleCustomer();
            $this->repository->assignRoles($user, [$roles]);

            DB::commit();
            return $user;
        } catch (Exception $e) {
            DB::rollback();
            Log::error('Failed to process create user', [
                'error' => $e->getMessage(),
            ]);
            return false;
        }
    }

    public function update(Request $request): object|bool
    {
        $data = $request->validated();

        DB::beginTransaction();
        try {
            if (isset($data['password']) && $data['password']) {
                $data['password'] = bcrypt($data['password']);
            } else {
                unset($data['password']);
            }

            $user = $this->repository->update($data['id'], $data);
            DB::commit();
            return $user;

        } catch (Exception $e) {
            DB::rollback();
            Log::error('Failed to process update user', [
                'error' => $e->getMessage(),
            ]);
            return false;
        }
    }

    public function delete($id): object
    {
        return $this->repository->delete($id);

    }

}
