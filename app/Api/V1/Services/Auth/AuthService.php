<?php

namespace App\Api\V1\Services\Auth;

use App\Api\V1\Services\Auth\AuthServiceInterface;
use  App\Api\V1\Repositories\User\UserRepositoryInterface;
use Illuminate\Http\Request;
use App\Admin\Traits\Setup;
use App\Enums\User\UserGender;
use App\Enums\User\UserRoles;
use App\Enums\User\UserVip;
use Illuminate\Support\Facades\URL;

class AuthService implements AuthServiceInterface
{
    use Setup;
    /**
     * Current Object instance
     *
     * @var array
     */
    protected $data;

    protected $repository;

    protected $instance;

    public function __construct(UserRepositoryInterface $repository){
        $this->repository = $repository;
    }

    public function store(Request $request){

        $data = $request->validated();
        $data['username'] = $data['phone'];
        $data['code'] = $this->createCodeUser();
        $data['roles'] = UserRoles::Member();
        $data['vip'] = UserVip::Default();
        $data['gender'] = UserGender::Male();
        $data['password'] = bcrypt($data['password']);
        return $this->repository->create($data);
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

    public function updateTokenPassword(Request $request){
        $user  = $this->repository->findByKey('email', $request->input('email'));
        $this->data['token_get_password'] = $this->generateTokenGetPassword();
        $this->instance['user'] = $this->repository->updateObject($user, $this->data);
        return $this;
    }

    public function generateRouteGetPassword($routeName){
        $this->instance['url'] = URL::temporarySignedRoute(
            $routeName, now()->addMinutes(30), [
                'token' => $this->data['token_get_password'],
                'code' => $this->instance['user']->code
            ]
        );
        return $this;
    }

    public function getInstance(){
        return $this->instance;
    }
}
