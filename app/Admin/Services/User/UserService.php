<?php

namespace App\Admin\Services\User;

use App\Admin\Services\User\UserServiceInterface;
use  App\Admin\Repositories\User\UserRepositoryInterface;
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

    public function __construct(UserRepositoryInterface $repository){
        $this->repository = $repository;
    }

    public function store(Request $request){

        $this->data = $request->validated();
        $this->data['username'] = $this->data['phone'];
        $this->data['code'] = $this->createCodeUser();
        $this->data['avatar'] = $request->avatar;
        $this->data['roles'] = UserRoles::Customer;
        $this->data['password'] = bcrypt($this->data['password']);
        $this->data['longitude'] = $request['lng'];
        $this->data['latitude'] = $request['lat'];

        if ($request->has('birthday')) {
            $this->data['birthday'] = $request->birthday;
        }



        return $this->repository->create($this->data);
    }

    public function update(Request $request){

        $this->data = $request->validated();
        $this->data['longitude'] = $request['lng'];
        $this->data['latitude'] = $request['lat'];
        if ($request->has('avatar')) {
            $this->data['avatar'] = $request->avatar;
        }
        if(isset($this->data['password']) && $this->data['password']){
            $this->data['password'] = bcrypt($this->data['password']);
        }else{
            unset($this->data['password']);
        }
        if ($request->has('birthday')) {
            $this->data['birthday'] = $request->birthday;
        }

        return $this->repository->update($this->data['id'], $this->data);

    }

    public function delete($id){
        return $this->repository->delete($id);

    }

}
