<?php

namespace App\Api\V1\Services\Store;

use App\Admin\Repositories\Store\StoreRepositoryInterface;
use App\Admin\Traits\Roles;
use App\Enums\Store\BossType;
use Exception;
use Illuminate\Http\Request;
use App\Admin\Traits\Setup;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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

    /**
     * @throws Exception
     */
    public function update(Request $request): object|bool
    {

        $this->data = $request->validated();

        if (isset($this->data['password']) && $this->data['password']) {
            $this->data['password'] = bcrypt($this->data['password']);
        } else {
            unset($this->data['password']);
        }

        return $this->repository->update($this->data['id'], $this->data);

    }

    public function delete($id): object|bool
    {
        return $this->repository->delete($id);

    }

    public function getInstance()
    {
        return $this->instance;
    }
}
