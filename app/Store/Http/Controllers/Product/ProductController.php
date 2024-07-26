<?php

namespace App\Store\Http\Controllers\Product;

use App\Admin\Http\Controllers\Controller;
use App\Admin\Repositories\Product\ProductRepositoryInterface;
use App\Admin\DataTables\Product\ProductStoreDataTable;
use App\Admin\Services\Product\ProductServiceInterface;
use App\Enums\DefaultStatus;
use App\Enums\Product\StockStatus;
use App\Admin\Repositories\StoreCategory\StoreCategoryRepositoryInterface;
use App\Store\Http\Requests\Discount\ProductStoreRequest;
use App\Traits\AuthService;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;


class ProductController extends Controller
{
    use AuthService;

    protected StoreCategoryRepositoryInterface $repoStoreCategory;
    private StoreCategoryRepositoryInterface $storeCategoryRepository;

    public function __construct(
        ProductRepositoryInterface       $repository,
        StoreCategoryRepositoryInterface $repoStoreCategory,
        ProductServiceInterface          $service,
        StoreCategoryRepositoryInterface $storeCategoryRepository,
    )
    {

        parent::__construct();
        $this->repoStoreCategory = $repoStoreCategory;
        $this->repository = $repository;
        $this->service = $service;
        $this->storeCategoryRepository = $storeCategoryRepository;
    }

    public function getView(): array
    {

        return [
            'index' => 'stores.products.index',
            'create' => 'stores.products.create',
            'edit' => 'stores.products.edit'
        ];
    }

    public function getRoute(): array
    {

        return [
            'index' => 'store.product.index',
            'create' => 'store.product.create',
            'edit' => 'store.product.edit',
            'delete' => 'store.product.delete'
        ];
    }

    public function index(ProductStoreDataTable $dataTable)
    {
        return $dataTable->render($this->view['index'], [
            'status' => DefaultStatus::asSelectArray(),
            'breadcrums' => $this->crums->add(__('listproduct')),

        ]);

    }

    public function create(): Factory|View|Application|RedirectResponse
    {
        $store = $this->getCurrentStoreUser();
        $StoreProductall = $this->service->getproduct($store->id);
        if (count($StoreProductall) <= 100) {
            $categories = $this->storeCategoryRepository->getAll();
            return view($this->view['create'], [
                'breadcrums' => $this->crums->add(__('listproduct'), route($this->route['index']))->add(__('add')),
                'store_categories' => $categories,
                'store_id' => $store,
                'status' => DefaultStatus::asSelectArray(),
                'stocks' => StockStatus::asSelectArray(),
            ]);
        } else {
            return to_route($this->route['index'])->with('warning', __('Bạn đã đủ 100 sp'));
        }

    }

    public function store(ProductStoreRequest $request): RedirectResponse
    {
        $response = $this->service->createByStore($request);

        if ($response) {
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
        $store_id = $this->getCurrentStoreUser();
        $product = $this->repository->findOrFail($id);
        $categories = $this->storeCategoryRepository->getAll();
        $discounts = $product->discounts;
        $toppings = $product->toppings;
        return view(
            $this->view['edit'],
            [
                'store_id' => $store_id,
                'store_categories' => $categories,
                'page' => $product,
                'discounts' => $discounts,
                'toppings' => $toppings,
                'breadcrums' => $this->crums->add(__('product'), route($this->route['index']))->add(__('edit')),
                'status' => DefaultStatus::asSelectArray(),
                'stocks' => StockStatus::asSelectArray(),
            ],
        );
    }

    public function update(ProductStoreRequest $request): RedirectResponse
    {

        $response = $this->service->updateByStore($request);

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


    public function draft($id): RedirectResponse
    {
        $this->service->draft($id);
        return to_route($this->route['index'])->with('success', __('đã đổi'));
    }

}
