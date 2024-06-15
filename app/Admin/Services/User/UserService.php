<?php

namespace App\Admin\Services\User;

use App\Admin\Services\User\UserServiceInterface;
use  App\Admin\Repositories\User\UserRepositoryInterface;
use App\Models\Role;
use Exception;
use Illuminate\Http\Request;
use App\Admin\Traits\Setup;
use App\Enums\User\UserRoles;

class UserService implements UserServiceInterface
{
    use Setup;

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
            $roles = $request->roles;
            if (!is_array($roles)) {
                $roles = explode(',', $roles);
            }
            if(!empty($roles)){
                foreach ($roles as $role) {
                    $user->roles()->attach(Role::where('name', $role)->first()->id, ['model_type' => get_class($user)]);
                }
            }
            return $user;
        } catch (Exception $e) {
            throw  $e;

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

        return $this->repository->update($this->data['id'], $this->data);

    }

    public function delete($id)
    {
        return $this->repository->delete($id);

    }

}
