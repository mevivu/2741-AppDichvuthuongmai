<?php

namespace App\Admin\Http\Controllers\Store\Category;

use App\Admin\Http\Controllers\Controller;
use App\Admin\Http\Requests\Store\Category\StoreCategoryRequest;
use App\Admin\Repositories\StoreCategory\StoreCategoryRepositoryInterface;
use App\Admin\Services\Store\Category\StoreCategoryServiceInterface;
use App\Admin\DataTables\Store\Category\StoreCategoryDataTable;
use App\Enums\DefaultStatus;
use App\Traits\ResponseController;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class StoreCategoryController extends Controller
{
    use ResponseController;

    public function __construct(
        StoreCategoryRepositoryInterface $repository,
        StoreCategoryServiceInterface    $service
    )
    {

        parent::__construct();

        $this->repository = $repository;
        $this->service = $service;
    }

    public function getView(): array
    {

        return [
            'index' => 'admin.stores.categories.index',
            'create' => 'admin.stores.categories.create',
            'edit' => 'admin.stores.categories.edit'
        ];
    }

    public function getRoute(): array
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
            'status' => DefaultStatus::asSelectArray(),
            'breadcrumbs' => $this->crums->add(__('storeCategory'))
        ]);

    }


    public function create(): Factory|View|Application
    {

        $categories = $this->repository->getFlatTree();

        return view($this->view['create'], [
            'categories' => $categories,
            'status' => DefaultStatus::asSelectArray(),
            'breadcrumbs' => $this->crums->add(__('store'))->add(__('category2'), route($this->route['index']))->add(__('add'))
        ]);
    }

    public function store(StoreCategoryRequest $request): RedirectResponse
    {

        $response = $this->service->store($request);

        return $this->handleResponse($response, $request, $this->route['index'], $this->route['edit']);

    }

    /**
     * @throws \Exception
     */
    public function edit($id): Factory|View|Application
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

    public function update(StoreCategoryRequest $request): RedirectResponse
    {

        $response = $this->service->update($request);

        return $this->handleUpdateResponse($response);

    }

    public function delete($id): RedirectResponse
    {

        $this->service->delete($id);

        return to_route($this->route['index'])->with('success', __('notifySuccess'));
    }
}
