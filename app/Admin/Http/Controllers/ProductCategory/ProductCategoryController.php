<?php

namespace App\Admin\Http\Controllers\ProductCategory;

use App\Admin\DataTables\ProductCategory\ProductCategoryDataTable;
use App\Admin\Http\Controllers\Controller;
use App\Admin\Http\Requests\Category\ProductCategoryRequest;
use App\Admin\Repositories\Category\CategoryRepositoryInterface;
use App\Admin\Services\Category\CategoryServiceInterface;
use App\Traits\ResponseController;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class ProductCategoryController extends Controller
{
    use ResponseController;

    public function __construct(
        CategoryRepositoryInterface $repository,
        CategoryServiceInterface    $service
    )
    {

        parent::__construct();

        $this->repository = $repository;

        $this->service = $service;

    }

    public function getView(): array
    {
        return [
            'index' => 'admin.categories.index',
            'create' => 'admin.categories.create',
            'edit' => 'admin.categories.edit'
        ];
    }

    public function getRoute(): array
    {
        return [
            'index' => 'admin.category.index',
            'create' => 'admin.category.create',
            'edit' => 'admin.category.edit',
            'delete' => 'admin.category.delete'
        ];
    }

    public function index(ProductCategoryDataTable $dataTable)
    {
        return $dataTable->render($this->view['index'], [
            'active' => [
                'Hoạt động' => 'Hoạt động',
                'Ẩn' => 'Ẩn'
            ]
        ]);
    }

    public function create(): Factory|View|Application
    {
        $categories = $this->repository->getFlatTree();
        return view($this->view['create'], ['categories' => $categories]);
    }

    public function store(ProductCategoryRequest $request): RedirectResponse
    {

        $response = $this->service->store($request);

        return $this->handleResponse($response, $request, $this->route['index'], $this->route['edit']);


    }

    /**
     * @throws Exception
     */
    public function edit($id): Factory|View|Application
    {
        $categories = $this->repository->getFlatTreeNotInNode([$id]);
        $instance = $this->repository->findOrFail($id);
        return view(
            $this->view['edit'], [
                'category' => $instance,
                'categories' => $categories
            ]
        );
    }

    public function update(ProductCategoryRequest $request): RedirectResponse
    {

        $this->service->update($request);

        return back()->with('success', __('notifySuccess'));

    }

    public function delete($id): RedirectResponse
    {

        $response = $this->service->delete($id);

        return $this->handleUpdateResponse($response);


    }
}
