<?php

namespace App\Admin\Http\Controllers\Vehicle;

use App\Admin\Http\Controllers\BaseController;
use App\Admin\Http\Requests\Vehicle\VehicleRequest;
use App\Admin\DataTables\Vehicle\VehicleDataTable;
use App\Admin\Repositories\Vehicle\VehicleRepositoryInterface;
use App\Admin\Services\Vehicle\VehicleServiceInterface;
use App\Enums\User\Gender;
use App\Enums\Vehicle\VehicleType;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class VehicleController extends BaseController
{

    protected VehicleRepositoryInterface $repository;
    protected VehicleServiceInterface $service;

    public function __construct(
        VehicleRepositoryInterface $repository,
        VehicleServiceInterface $service,
    ) {

        parent::__construct();

        $this->repository = $repository;

        $this->service = $service;
    }

    public function getView(): array
    {
        return [
            'index' => 'admin.vehicle.index',
            'create' => 'admin.vehicle.create',
            'edit' => 'admin.vehicle.edit'
        ];
    }

    public function getRoute(): array
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

    public function create(): Factory|View|Application
    {
        return view($this->view['create'],
            [
                'type' => VehicleType::asSelectArray(),
                'gender' => Gender::asSelectArray(),
            ]
        );
    }

    public function store(VehicleRequest $request): RedirectResponse
    {
        $vehicle = $this->service->store($request);

        return to_route($this->route['edit'], $vehicle->id)->with('success', __('notifySuccess'));
    }

    /**
     * @throws Exception
     */
    public function edit($id): Factory|View|Application
    {
        $vehicle = $this->repository->findOrFail($id);
        return view(
            $this->view['edit'],
            [
                'vehicle' => $vehicle,
                'type' => VehicleType::asSelectArray(),
                'gender' => Gender::asSelectArray(),
            ],
        );
    }

    public function update(VehicleRequest $request): RedirectResponse
    {
        $this->service->update($request);

        return back()->with('success', __('notifySuccess'));
    }

    public function delete($id): RedirectResponse
    {
        $this->service->delete($id);

        return to_route($this->route['index'])->with('success', __('notifySuccess'));
    }
}
