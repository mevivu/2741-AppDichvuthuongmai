<?php

namespace App\Admin\Http\Controllers\Area;

use App\Admin\Http\Controllers\Controller;
use App\Admin\Http\Requests\Area\AreaRequest;
use App\Admin\Repositories\Area\AreaRepositoryInterface;
use App\Admin\Services\Area\AreaServiceInterface;
use App\Admin\DataTables\Area\AreaDataTable;
use App\Enums\Area\AreaStatus;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class AreaController extends Controller
{

    public function __construct(
        AreaRepositoryInterface $repository,
        AreaServiceInterface $service
    ){

        parent::__construct();

        $this->repository = $repository;
        $this->service = $service;
    }

    public function getView(): array
    {

        return [
            'index' => 'admin.areas.index',
            'create' => 'admin.areas.create',
            'edit' => 'admin.areas.edit'
        ];
    }

    public function getRoute(): array
    {

        return [
            'index' => 'admin.area.index',
            'create' => 'admin.area.create',
            'edit' => 'admin.area.edit',
            'delete' => 'admin.area.delete'
        ];
    }
    public function index(AreaDataTable $dataTable){

        return $dataTable->render($this->view['index'], [
            'breadcrumbs' => $this->crums->add(__('area'))
        ]);
    }

    public function create(): Factory|View|Application
    {

        return view($this->view['create'], [
            'breadcrums' => $this->crums->add(__('area'),
                route($this->route['index']))->add(__('add')),
            'status' => AreaStatus::asSelectArray()
        ]);
    }

    public function store(AreaRequest $request): RedirectResponse
    {

        $response = $this->service->store($request);

        if($response){
            return $request->input('submitter') == 'save'
                    ? to_route($this->route['edit'], $response->id)->with('success', __('notifySuccess'))
                    : to_route($this->route['index'])->with('success', __('notifySuccess'));
        }

        return back()->with('error', __('notifyFail'))->withInput();
    }

    /**
     * @throws Exception
     */
    public function edit($id): Factory|View|Application
    {

        $area = $this->repository->findOrFail($id);

        return view(
            $this->view['edit'],
            [
                'area' => $area,
                'status' => AreaStatus::asSelectArray(),
                'breadcrums' => $this->crums->add(__('area'), route($this->route['index']))->add(__('edit'))
            ],
        );
    }

    public function update(AreaRequest $request): RedirectResponse
    {

        $response = $this->service->update($request);

        if($response){
            return $request->input('submitter') == 'save'
                    ? back()->with('success', __('notifySuccess'))
                    : to_route($this->route['index'])->with('success', __('notifySuccess'));
        }

        return back()->with('error', __('notifyFail'));
    }

    public function delete($id): RedirectResponse
    {

        $this->service->delete($id);

        return to_route($this->route['index'])->with('success', __('notifySuccess'));
    }
}
