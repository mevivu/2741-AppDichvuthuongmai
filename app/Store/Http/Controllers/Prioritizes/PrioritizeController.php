<?php

namespace App\Store\Http\Controllers\Prioritizes;

use App\Admin\Http\Controllers\Controller;
use App\Admin\Http\Requests\prioritizes\PrioritizeRequest;
use App\Admin\Services\Prioritizes\PrioritizeServiceInterface;
use App\Admin\Repositories\Admin\AdminRepositoryInterface;


class PrioritizeController extends Controller
{
    public function __construct(
        AdminRepositoryInterface $repository,
        PrioritizeServiceInterface $service,

    ){

        parent::__construct();
        $this->service = $service;
        $this->repository = $repository;
    }

    public function getView(){

        return [
            'index' => 'stores.prioritizes.create',
            'edit' => 'stores.prioritizes.edit',
        ];
    }

    public function getRoute(){

        return [
            'index' => 'store.prioritize.index',
        ];
    }
    public function index(){

        return view($this->view['index']);

    }

    public function getprice(PrioritizeRequest $request){
        $info = $this->repository->searchAllLimit()->first();
        $price = auth('store')->user()->priority;
        $result = $request->day*$price;
        return view($this->view['edit'],[
            'kq'=>$result,
            'day'=>$request->day,
            'info'=>$info,
            ],
        );
        
    }
    public function store(PrioritizeRequest $request){
        if($request->input('submitter') == 'save'){
            $this->service->store($request);
            return redirect('/stores/dashboard')->with('success', __('notifySuccess'));
        }else{
            return redirect('/stores/dashboard')->with('success', __('notifySuccess'));
        }
    }
    
}
