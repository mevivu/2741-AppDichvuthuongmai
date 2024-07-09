<?php

namespace App\Admin\Http\Controllers\Topping;

use App\Admin\Http\Controllers\Controller;
use App\Admin\Http\Requests\Admin\AdminRequest;
use App\Admin\Http\Requests\Topping\ToppingRequest;
use App\Admin\Repositories\Topping\ToppingRepositoryInterface;
use App\Admin\Services\Topping\ToppingServiceInterface;
use App\Admin\DataTables\Topping\ToppingDataTable;
use App\Enums\Topping\ToppingStatus;

class ToppingController extends Controller
{
    public function __construct(
        ToppingRepositoryInterface $repository,
        ToppingServiceInterface $service
    ){

        parent::__construct();

        $this->repository = $repository;

        $this->service = $service;

    }

    public function getView(){
        return [
            'index' => 'stores.toppings.index',
            'create' => 'stores.toppings.create',
            'edit' => 'stores.toppings.edit'
        ];
    }

    public function getRoute(){
        return [
            'index' => 'admin.topping.index',
            'create' => 'admin.topping.create',
            'edit' => 'admin.topping.edit',
            'delete' => 'admin.topping.delete'
        ];
    }
    public function index(ToppingDataTable $dataTable){
        return $dataTable->render($this->view['index']);
    }

    public function create(){
		$roles = $this->repository->getAllRolesByGuardName('admin');
        $status = ToppingStatus::asSelectArray();
        return view($this->view['create'], [
			'roles' => $roles,
            'status' => $status
		]);
    }


    public function store(ToppingRequest $request){
        $instance = $this->service->store($request);


        return to_route($this->route['edit'], $instance->id)->with('success', __('notifySuccess'));

    }

    public function edit($id){

        $instance = $this->repository->findOrFail($id);
        return view(
            $this->view['edit'],
			[
                'topping' => $instance,
            ],
        );

    }

    public function update(ToppingRequest $request){
        $this->service->update($request);

        return back()->with('success', __('notifySuccess'));

    }

    public function delete($id){

        $this->service->delete($id);

        return to_route($this->route['index'])->with('success', __('notifySuccess'));

    }
}
