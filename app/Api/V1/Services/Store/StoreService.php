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
    private string $folderStore = "images/stores";

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
            if (isset($data['logo'])) {
                $logo = $data['logo'];
                $data['logo'] = $this->fileService->uploadAvatar($this->folderStore, $logo, null);
            }

            $data['code'] = $this->createCodeStore();
            $data['username'] = $data['store_phone'];
            $data['contact_name'] = $data['store_name'];
            $data['contact_phone'] = $data['store_phone'];
            $data['address_detail'] = $data['address'];
            $store = $this->repository->create($data);

            $this->repository->assignRoles($store, [$this->getRoleStore()]);

            DB::commit();
            return $store;
        } catch (Throwable $e) {
            DB::rollback();
            $this->logError('Failed to process create store API', $e);
            return false;
        }
    }

    public function update(Request $request): bool|object
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();
            $store = $this->getCurrentStoreUser();
            if (isset($data['logo'])) {
                $logo = $data['logo'];
                $data['logo'] = $this->fileService->uploadAvatar('images/stores', $logo, $store->logo);
            }
            $data['username'] = isset($data['store_phone']) ? $data['store_phone'] : null;
            $data['contact_name'] = isset($data['store_name']) ? $data['store_name'] : null;
            $data['contact_phone'] = isset($data['store_phone']) ? $data['store_phone'] : null;
            $data['address_detail'] = isset($data['address']) ? $data['address'] : null;
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
