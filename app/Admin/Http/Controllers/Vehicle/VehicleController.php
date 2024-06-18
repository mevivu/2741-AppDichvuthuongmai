<?php

namespace App\Admin\Http\Controllers\Vehicle;

use App\Admin\Http\Controllers\BaseController;
use App\Admin\Http\Requests\Vehicle\VehicleRequest;
use App\Admin\DataTables\Vehicle\VehicleDataTable;
use App\Admin\Repositories\Vehicle\VehicleRepositoryInterface;
use App\Admin\Services\Vehicle\VehicleServiceInterface;
use App\Enums\Vehicle\VehicleType;

class VehicleController extends BaseController
{

    protected $repository;
    protected $service;

    public function __construct(
        VehicleRepositoryInterface $repository,
        VehicleServiceInterface $service,
    ) {

        parent::__construct();

        $this->repository = $repository;

        $this->service = $service;
    }

    public function getView()
    {
        return [
            'index' => 'admin.vehicle.index',
            'create' => 'admin.vehicle.create',
            'edit' => 'admin.vehicle.edit'
        ];
    }

    public function getRoute()
    {
        return [
            'index' => 'admin.vehicle.index',
            'create' => 'admin.vehicle.create',
            'edit' => 'admin.vehicle.edit',
            'delete' => 'admin.vehicle.delete'
        ];
    }

    public function index(VehicleDataTable $dataTable)
    {
        return $dataTable->render(
            $this->view['index'],
            [
                'type' => VehicleType::asSelectArray(),
            ]
        );
    }

    public function create()
    {
        return view($this->view['create'], ['type' => VehicleType::asSelectArray(),]);
    }

    public function store(VehicleRequest $request)
    {
        $vehicle = $this->service->store($request);

        return to_route($this->route['edit'], $vehicle->id)->with('success', __('notifySuccess'));
    }

    public function edit($id)
    {
        $vehicle = $this->repository->findOrFail($id);
        return view(
            $this->view['edit'],
            [
                'vehicle' => $vehicle,
                'type' => VehicleType::asSelectArray(),
            ],
        );
    }

    public function update(VehicleRequest $request)
    {
        $this->service->update($request);

        return back()->with('success', __('notifySuccess'));
    }

    public function delete($id)
    {
        $this->service->delete($id);

        return to_route($this->route['index'])->with('success', __('notifySuccess'));
    }
}
