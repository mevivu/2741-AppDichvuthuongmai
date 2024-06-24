<?php

namespace App\Admin\Services\User;

use  App\Admin\Repositories\User\UserRepositoryInterface;
use App\Admin\Traits\Roles;
use Exception;
use Illuminate\Http\Request;
use App\Admin\Traits\Setup;

class UserService implements UserServiceInterface
{
    use Setup,Roles;

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
        try {
            $this->data = $request->validated();
            $this->data['username'] = $this->data['phone'];
            $this->data['code'] = $this->createCodeUser();
            $this->data['avatar'] = $request->avatar;
            $this->data['password'] = bcrypt($this->data['password']);
            $this->data['longitude'] = $request['lng'];
            $this->data['latitude'] = $request['lat'];

            if ($request->has('birthday')) {
                $this->data['birthday'] = $request->birthday;
            }

            $user = $this->repository->create($this->data);
            $roles = $this->getRoleCustomer();
            $this->repository->assignRoles($user, $roles);
            return $user;
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request)
    {

        $this->data = $request->validated();
        $this->data['longitude'] = $request['lng'];
        $this->data['latitude'] = $request['lat'];
        if ($request->has('avatar')) {
            $this->data['avatar'] = $request->avatar;
        }
        if (isset($this->data['password']) && $this->data['password']) {
            $this->data['password'] = bcrypt($this->data['password']);
        } else {
            unset($this->data['password']);
        }
        if ($request->has('birthday')) {
            $this->data['birthday'] = $request->birthday;
        }
        $this->repository->syncUserRoles($this->data['id'], $request->roles);

        $user =  $this->repository->update($this->data['id'], $this->data);
        $roles = $this->getRoleCustomer();
        $this->repository->assignRoles($user, $roles);
        return $user;

    }

    public function delete($id)
    {
        return $this->repository->delete($id);

    }

}
