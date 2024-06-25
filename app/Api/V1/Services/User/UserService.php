<?php

namespace App\Api\V1\Services\User;

use App\Admin\Traits\Roles;
use  App\Api\V1\Repositories\User\UserRepositoryInterface;
use App\Enums\User\Gender;
use Illuminate\Http\Request;
use App\Admin\Traits\Setup;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;


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
            throw $e;
//            return false;
        }

    }

    public function update(Request $request)
    {

        $this->data = $request->validated();

        if (isset($this->data['password']) && $this->data['password']) {
            $this->data['password'] = bcrypt($this->data['password']);
        } else {
            unset($this->data['password']);
        }

        return $this->repository->update($this->data['id'], $this->data);

    }

    public function delete($id)
    {
        return $this->repository->delete($id);

    }

}
