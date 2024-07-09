<?php

namespace App\Admin\Services\Store\Category;

use App\Admin\Services\Store\Category\StoreCategoryServiceInterface;
use  App\Admin\Repositories\StoreCategory\StoreCategoryRepositoryInterface;
use Illuminate\Http\Request;

class StoreCategoryService implements StoreCategoryServiceInterface
{
    /**
     * Current Object instance
     *
     * @var array
     */
    protected $data;
    
    protected $repository;

    public function __construct(StoreCategoryRepositoryInterface $repository){
        $this->repository = $repository;
    }
    
    public function store(Request $request){

        $this->data = $request->validated();

        return $this->repository->create($this->data);
    }

    public function update(Request $request){
        
        $this->data = $request->validated();

        return $this->repository->update($this->data['id'], $this->data);

    }

    public function delete($id){
        return $this->repository->delete($id);

    }

}