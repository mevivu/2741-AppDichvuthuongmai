<?php

namespace App\Admin\Http\Controllers\Store;

use App\Admin\Http\Controllers\Controller;
use App\Admin\Http\Requests\Store\StoreRequest;
//use App\Admin\Http\Resources\Store\StoreResource;
use App\Admin\Repositories\Store\StoreRepositoryInterface;
use App\Admin\Services\Store\StoreServiceInterface;
use App\Admin\DataTables\Store\StoreDataTable;
use App\Enums\Store\StoreStatus;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
class StoreController extends Controller
{
    public function __construct(
        StoreRepositoryInterface $repository,
        StoreServiceInterface    $service
    )
    {

        parent::__construct();

        $this->repository = $repository;
        $this->service = $service;
    }

    public function getView()
    {
        return [
            'index' => 'admin.stores.index',
            'create' => 'admin.stores.create',
            'edit' => 'admin.stores.edit'
        ];
    }

    public function getRoute()
    {
        return [
            'index' => 'admin.store.index',
            'create' => 'admin.store.create',
            'edit' => 'admin.store.edit',
            'delete' => 'admin.store.delete'
        ];
    }

    public function index(StoreDataTable $dataTable)
    {
        return $dataTable->render($this->view['index'], [
            'breadcrums' => $this->crums->add(__('store'))
        ]);
    }



    public function create()
    {
        return view($this->view['create'], [
            'status' => StoreStatus::asSelectArray(),
            'breadcrums' => $this->crums->add(__('store'), route($this->route['index']))->add(__('add'))
        ]);
    }

    public function store(StoreRequest $request)
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

        $instance = $this->repository->findOrFail($id, ['category', 'area']);

        return view(
            $this->view['edit'],
            [
                'store' => $instance,
                'status' => StoreStatus::asSelectArray(),
                'breadcrums' => $this->crums->add(__('store'), route($this->route['index']))->add(__('edit'))
            ]
        );
    }

    public function update(StoreRequest $request)
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

        $this->service->delete($id);

        return to_route($this->route['index'])->with('success', __('notifySuccess'));
    }

    public function selectSearch(Request $request)
    {
        $searchTerm = $request->input('term');
        $users = $this->repository->searchAllLimit($searchTerm);
        $this->instance = $users;

        return $this->selectResponse();
    }
}
