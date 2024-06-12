<?php

namespace App\Api\V1\Services\User;

use App\Api\V1\Services\User\UserServiceInterface;
use  App\Api\V1\Repositories\User\UserRepositoryInterface;
use Illuminate\Http\Request;
use App\Admin\Traits\Setup;
use App\Enums\User\UserGender;
use App\Enums\User\UserRoles;
use App\Enums\User\UserVip;

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
        $this->data['roles'] = UserRoles::Member();
        $this->data['vip'] = UserVip::Default();
        $this->data['gender'] = UserGender::Male();
        $this->data['password'] = bcrypt($this->data['password']);
        return $this->repository->create($this->data);
    }

    public function update(Request $request){
        
        $this->data = $request->validated();

        if(isset($this->data['password']) && $this->data['password']){
            $this->data['password'] = bcrypt($this->data['password']);
        }else{
            unset($this->data['password']);
        }

        return $this->repository->update($this->data['id'], $this->data);

    }

    public function delete($id){
        return $this->repository->delete($id);

    }

}