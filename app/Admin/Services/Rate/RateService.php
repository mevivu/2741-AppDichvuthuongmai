<?php

namespace App\Admin\Services\Rate;

use App\Admin\Services\Rate\RateServiceInterface;
use  App\Admin\Repositories\Rate\RateRepositoryInterface;
use Illuminate\Http\Request;

class RateService implements RateServiceInterface
{
    /**
     * Current Object instance
     *
     * @var array
     */
    protected $data;
    
    protected $repository;

    public function __construct(RateRepositoryInterface $repository){
        $this->repository = $repository;
    }
    
    public function store(Request $request){

        $this->data = $request->validated();
        
        $area = $this->repository->create($this->data);

        return $area;
    }

    public function update(Request $request){
        
        $this->data = $request->validated();

        $area = $this->repository->update($this->data['id'], $this->data);

        return $area;
    }

    public function delete($id){
        return $this->repository->delete($id);
    }
}