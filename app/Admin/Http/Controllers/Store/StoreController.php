<?php

namespace App\Admin\Http\Controllers\Store;

use App\Admin\Http\Controllers\Controller;
use App\Admin\Http\Requests\Store\StoreRequest;
use App\Admin\Repositories\Store\StoreRepositoryInterface;
use App\Admin\Services\Store\StoreServiceInterface;
use App\Admin\DataTables\Store\StoreDataTable;
use App\Enums\Store\StoreStatus;
use App\Models\StoreCategory;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
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

    public function getView(): array
    {
        return [
            'index' => 'admin.stores.index',
            'create' => 'admin.stores.create',
            'edit' => 'admin.stores.edit'
        ];
    }

    public function getRoute(): array
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
            'breadcrumbs' => $this->crums->add(__('store'))
        ]);
    }



    public function create(): Factory|View|Application
    {
        $store_categories = StoreCategory::all();
        return view($this->view['create'], [
            'status' => StoreStatus::asSelectArray(),
            'breadcrumbs' => $this->crums->add(__('store'), route($this->route['index']))->add(__('add')),
            'store_categories' => $store_categories,


        ]);
    }

    public function store(StoreRequest $request): RedirectResponse
    {

        $response = $this->service->store($request);

        if ($response) {
            return $request->input('submitter') == 'save'
                ? to_route($this->route['edit'], $response->id)->with('success', __('notifySuccess'))
                : to_route($this->route['index'])->with('success', __('notifySuccess'));
        }

        return back()->with('error', __('notifyFail'))->withInput();
    }

    /**
     * @throws \Exception
     */
    public function edit($id): Factory|View|Application
    {

        $instance = $this->repository->findOrFail($id);

        return view(
            $this->view['edit'],
            [
                'store' => $instance,
                'status' => StoreStatus::asSelectArray(),
                'breadcrumbs' => $this->crums->add(__('store'), route($this->route['index']))->add(__('edit'))
            ]
        );
    }

    public function update(StoreRequest $request): RedirectResponse
    {

        $response = $this->service->update($request);

        if ($response) {
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

    public function selectSearch(Request $request)
    {
        $searchTerm = $request->input('term');
        $users = $this->repository->searchAllLimit($searchTerm);
        $this->instance = $users;

        return $this->selectResponse();
    }
    public function getById($id)
    {
        $store = $this->repository->findOrFail($id);
        return response()->json($store);
    }
}
