<?php

namespace App\Admin\Services\User;

use App\Admin\Repositories\Cart\CartRepository;
use App\Admin\Repositories\Cart\CartRepositoryInterface;
use  App\Admin\Repositories\User\UserRepositoryInterface;
use App\Admin\Traits\Roles;
use App\Api\V1\Support\UseLog;
use Exception;
use Illuminate\Http\Request;
use App\Admin\Traits\Setup;
use Illuminate\Support\Facades\DB;

class UserService implements UserServiceInterface
{
    use Setup, Roles, UseLog;

    /**
     * Current Object instance
     *
     * @var array
     */
    protected array $data;

    protected UserRepositoryInterface $repository;

    protected CartRepositoryInterface $cartRepository;

    public function __construct(UserRepositoryInterface $repository,
                                CartRepositoryInterface $cartRepository)
    {
        $this->repository = $repository;
        $this->cartRepository = $cartRepository;
    }

    public function store(Request $request): object|false
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();
            $data['username'] = $data['phone'];
            $data['code'] = $this->createCodeUser();
            $data['password'] = bcrypt($data['password']);
            $data['longitude'] = $request['lng'];
            $data['latitude'] = $request['lat'];

            $user = $this->repository->create($data);
            $roles = $this->getRoleCustomer();
            //create role
            $this->repository->assignRoles($user, [$roles]);

            //create cart for new user
            if ($user) {
                $userId = $user->id;
                $cartData = ['user_id' => $userId];
                $this->cartRepository->create($cartData);
            }
            DB::commit();
            return $user;
        } catch (Exception $e) {
            DB::rollback();
            $this->logError('Failed to process create user', $e);
            return false;
        }
    }

    public function update(Request $request): object|bool
    {

        DB::beginTransaction();
        try {
            $data = $request->validated();
            if (isset($data['password']) && $data['password']) {
                $data['password'] = bcrypt($data['password']);
            } else {
                unset($data['password']);
            }
            $data['longitude'] = $request['lng'];
            $data['latitude'] = $request['lat'];

            $user = $this->repository->update($data['id'], $data);
            DB::commit();
            return $user;

        } catch (Exception $e) {
            DB::rollback();
            $this->logError('Failed to process update user', $e);
            return false;
        }
    }

    public function delete($id): object
    {
        return $this->repository->delete($id);

    }

}
