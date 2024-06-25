<?php

namespace App\Api\V1\Services\Auth;

use App\Admin\Repositories\Store\StoreRepositoryInterface;
use App\Admin\Traits\Roles;
use App\Enums\Store\BossType;
use Illuminate\Http\Request;
use App\Admin\Traits\Setup;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use Throwable;

class StoreService implements StoreServiceInterface
{
    use Setup, Roles;

    /**
     * Current Object instance
     *
     * @var array
     */
    protected $data;

    protected $repository;

    protected $instance;

    public function __construct(StoreRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            $data = $request->validated();
            $data['username'] = $data['store_phone'];
            $data['code'] = $this->createCodeUser();
            $data['password'] = bcrypt($data['password']);
            $data['contact_name'] = $data['store_name'];
            $data['contact_phone'] = $data['store_phone'];
            $data['address_detail'] = $data['address'];
            $type = $data['type'];
            unset($data['type']);
            $store = $this->repository->create($data);

            switch ($type) {
                case BossType::Restaurant->value:
                    $this->repository->assignRoles($store, [$this->getRoleRestaurant()]);
                    break;
                case BossType::Grocery->value:
                    $this->repository->assignRoles($store, [$this->getRoleStore()]);
                    break;
                case BossType::Hotel->value:
                    $this->repository->assignRoles($store, [$this->getRoleHotel()]);
                    break;
            }

            DB::commit();
            return $store;
        } catch (Throwable $e) {
            DB::rollback();
            Log::error('Failed to process transaction', [
                'error' => $e->getMessage(),
            ]);
            return false;
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

    public function updateTokenPassword(Request $request)
    {
        $user = $this->repository->findByKey('email', $request->input('email'));
        $this->data['token_get_password'] = $this->generateTokenGetPassword();
        $this->instance['user'] = $this->repository->updateObject($user, $this->data);
        return $this;
    }

    public function generateRouteGetPassword($routeName)
    {
        $this->instance['url'] = URL::temporarySignedRoute(
            $routeName, now()->addMinutes(30), [
                'token' => $this->data['token_get_password'],
                'code' => $this->instance['user']->code
            ]
        );
        return $this;
    }

    public function getInstance()
    {
        return $this->instance;
    }
}
