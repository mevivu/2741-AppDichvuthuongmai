<?php

namespace App\Api\V1\Services\Store;

use App\Admin\Repositories\Store\StoreRepositoryInterface;
use App\Admin\Traits\Roles;
use App\Api\V1\Support\UseLog;
use App\Enums\Store\BossType;
use App\Admin\Services\File\FileService;
use App\Api\V1\Support\AuthServiceApi;
use App\Constants\ImageFields;
use Exception;
use Illuminate\Http\Request;
use App\Admin\Traits\Setup;
use Illuminate\Support\Facades\DB;
use Throwable;

class StoreService implements StoreServiceInterface
{
    use Setup, Roles, UseLog, AuthServiceApi; // Thêm AuthServiceApi trait ở đây

    /**
     * Current Object instance
     *
     * @var array
     */
    protected array $data;

    protected $repository;

    protected $instance;
    protected FileService $fileService;

    public function __construct(StoreRepositoryInterface $repository, FileService $fileService) // Thêm FileService vào constructor
    {
        $this->repository = $repository;
        $this->fileService = $fileService; // Khởi tạo FileService
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
            $this->logError('Failed to process create store', $e);
            return false;
        }
    }

    /**
     * @throws Exception
     */
    // public function update(Request $request): object|bool
    // {

    //     $this->data = $request->validated();

    //     if (isset($this->data['password']) && $this->data['password']) {
    //         $this->data['password'] = bcrypt($this->data['password']);
    //     } else {
    //         unset($this->data['password']);
    //     }

    //     return $this->repository->update($this->data['id'], $this->data);

    // }

    public function update(Request $request): bool|object
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();
            $store = $this->getCurrentStoreUser(); // Gọi phương thức từ AuthServiceApi trait
            $logo = $data['logo'];
            if ($logo) {
                $data['logo'] = $this->fileService->uploadAvatar('images/stores', $logo, $store->logo);
            }
            $response = $this->repository->update($store->id, $data);
            DB::commit();
            return $response;
        } catch (Exception $e) {
            DB::rollback();
            $this->logError('Failed to process update store API', $e);
            return false;
        }
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
