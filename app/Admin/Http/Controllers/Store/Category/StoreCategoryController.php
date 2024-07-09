<?php

namespace App\Admin\Http\Controllers\Store\Category;

use App\Admin\Http\Controllers\Controller;
use App\Admin\Http\Requests\Store\Category\StoreCategoryRequest;
use App\Admin\Repositories\StoreCategory\StoreCategoryRepositoryInterface;
use App\Admin\Services\Store\Category\StoreCategoryServiceInterface;
use App\Admin\DataTables\Store\Category\StoreCategoryDataTable;
use App\Enums\DefaultStatus;

class StoreCategoryController extends Controller
{
    public function __construct(
        StoreCategoryRepositoryInterface $repository,
        StoreCategoryServiceInterface    $service
    )
    {

        parent::__construct();

        $this->repository = $repository;
        $this->service = $service;
    }

    public function getView()
    {

        return [
            'index' => 'admin.stores.categories.index',
            'create' => 'admin.stores.categories.create',
            'edit' => 'admin.stores.categories.edit'
        ];
    }

    public function getRoute()
    {

        return [
            'index' => 'admin.store.category.index',
            'create' => 'admin.store.category.create',
            'edit' => 'admin.store.category.edit',
            'delete' => 'admin.store.category.delete'
        ];
    }

    public function index(StoreCategoryDataTable $dataTable)
    {
        return $dataTable->render($this->view['index'], [
            'status' => DefaultStatus::asSelectArray()
        ]);
    }


    public function create()
    {

        $categories = $this->repository->getFlatTree();

        return view($this->view['create'], [
            'categories' => $categories,
            'status' => DefaultStatus::asSelectArray(),
            'breadcrumbs' => $this->crums->add(__('store'))->add(__('category2'), route($this->route['index']))->add(__('add'))
        ]);
    }

    public function store(StoreCategoryRequest $request)
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

        $category = $this->repository->findOrFail($id);

        return view(
            $this->view['edit'],
            [
                'category' => $category,
                'status' => DefaultStatus::asSelectArray(),
                'breadcrumbs' => $this->crums->add(__('store'))->add(__('category2'), route($this->route['index']))->add(__('edit'))
            ],
        );
    }

    public function update(StoreCategoryRequest $request)
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
}
