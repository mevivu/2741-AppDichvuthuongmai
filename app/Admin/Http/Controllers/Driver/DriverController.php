<?php

namespace App\Admin\Http\Controllers\Driver;

use App\Admin\DataTables\Driver\DriverDataTable;
use App\Admin\Http\Controllers\Controller;
use App\Admin\Http\Requests\Driver\DriverRequest;
use App\Admin\Repositories\Area\AreaRepositoryInterface;
use App\Admin\Repositories\Driver\DriverRepositoryInterface;
use App\Admin\Services\Driver\DriverService;
use App\Admin\Services\Driver\DriverServiceInterface;
use App\Enums\Driver\DriverStatus;
use App\Enums\User\UserGender;
use App\Enums\User\UserRoles;

class DriverController extends Controller
{

    protected  AreaRepositoryInterface $areaRepository;
    protected DriverService $userDriverService;
    public function __construct(
        DriverRepositoryInterface $repository,
        DriverServiceInterface    $service,
        AreaRepositoryInterface $areaRepository,
        DriverService        $userDriverService,
    )
    {

        parent::__construct();

        $this->repository = $repository;
        $this->service = $service;
        $this->userDriverService = $userDriverService;
        $this->areaRepository = $areaRepository;
    }

    public function getView(): array
    {

        return [
            'index' => 'admin.drivers.index',
            'create' => 'admin.drivers.create',
            'edit' => 'admin.drivers.edit',
        ];
    }

    public function getRoute(): array
    {

        return [
            'index' => 'admin.driver.index',
            'newDriver' => 'admin.driver.newDriver',
            'create' => 'admin.driver.create',
            'edit' => 'admin.driver.edit',
            'delete' => 'admin.driver.delete'
        ];
    }

    public function index(DriverDataTable $dataTable)
    {

        return $dataTable->render($this->view['index'], [
            'breadcrums' => $this->crums->add(__('driver'))
        ]);
    }

    public function create()
    {
        $areas = $this->areaRepository->getAll();

        return view($this->view['create'], [
            'gender' => UserGender::asSelectArray(),
            'roles' => UserRoles::asSelectArray(),
            'areas' => $areas,
            'order_accepted' =>DriverStatus::asSelectArray(),
            'breadcrums' => $this->crums->add(__('driver'), route($this->route['index']))->add(__('add'))
        ]);
    }

    public function store(DriverRequest $request)
    {
        $response = $this->service->store($request);

        if ($response) {
            return $request->input('submitter') == 'save'
                ? to_route($this->route['edit'], $response->id)->with('success', __('notifySuccess'))
                : to_route($this->route['index'])->with('success', __('notifySuccess'));
        }



        return back()->with('error', __('notifyFail'))->withInput();


    }

    public function edit($id)
    {
        $driver = $this->repository->findOrFail($id);
        $areas = $this ->areaRepository->getAll();


        return view(
            $this->view['edit'],
            [
                'gender' => UserGender::asSelectArray(),
                'roles' => UserRoles::asSelectArray(),
                'order_accepted' =>DriverStatus::asSelectArray(),
                'areas' => $areas,
                'driver' => $driver,
                'breadcrums' => $this->crums->add(__('driver'), route($this->route['index']))->add(__('edit')),


            ],
        );
    }

    public function update(DriverRequest $request)
    {

        $response = $this->service->update($request);

        if ($response) {
            return $request->input('submitter') == 'save'
                ? back()->with('success', __('notifySuccess'))
                : to_route($this->route['index'])->with('success', __('notifySuccess'));
        }

        return back()->with('error', __('notifyFail'));
    }

    public function delete($id)
    {
        $driver = $this->repository->findOrFail($id);
        $this->service->delete($id, $driver->user->id);

        return to_route($this->route['index'])->with('success', __('notifySuccess'));
    }
}
