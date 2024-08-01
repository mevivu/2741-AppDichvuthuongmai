<?php

namespace App\Admin\Services\Store;

use App\Admin\Services\Store\StoreServiceInterface;
use  App\Admin\Repositories\Store\StoreRepositoryInterface;
use App\Admin\Traits\Setup;
use Exception;
use Illuminate\Http\Request;

class StoreService implements StoreServiceInterface
{
    use Setup;

    /**
     * Current Object instance
     *
     * @var array
     */
    protected array $data;

    protected StoreRepositoryInterface $repository;

    public function __construct(StoreRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @throws Exception
     */
    public function store(Request $request)
    {


        $this->data = $request->validated();
        $this->data['code'] = $this->CreateCodeStore();

        return $this->repository->create($this->data);
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

    /**
     * @throws Exception
     */
    public function delete($id): object|bool
    {
        return $this->repository->delete($id);

    }
}
