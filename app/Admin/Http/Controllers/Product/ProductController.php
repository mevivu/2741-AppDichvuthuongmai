<?php

namespace App\Admin\Http\Controllers\Product;

use App\Admin\Http\Controllers\Controller;
use App\Admin\Http\Requests\Product\ProductRequest;
use App\Admin\Repositories\Product\ProductRepositoryInterface;
use App\Admin\Services\Product\ProductServiceInterface;
use App\Admin\DataTables\Product\ProductDataTable;
use App\Enums\Product\ProductType;
use App\Admin\Repositories\Category\CategoryRepositoryInterface;
use App\Admin\Repositories\Attribute\AttributeRepositoryInterface;
use App\Admin\Http\Resources\Product\ProductEditResource;
use App\Admin\Repositories\Topping\ToppingRepositoryInterface;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;


class ProductController extends Controller
{
    protected $repositoryCategory;
    protected $repositoryAttribute;
    protected $repositoryTopping;

    public function __construct(
        ProductRepositoryInterface $repository,
        CategoryRepositoryInterface $repositoryCategory,
        ToppingRepositoryInterface $repositoryTopping,
        AttributeRepositoryInterface $repositoryAttribute,
        ProductServiceInterface $service
    ) {
        parent::__construct();
        $this->repository = $repository;
        $this->repositoryCategory = $repositoryCategory;
        $this->repositoryTopping = $repositoryTopping;
        $this->repositoryAttribute = $repositoryAttribute;
        $this->service = $service;
    }

    public function getView(): array
    {
        return [
            'index' => 'admin.products.index',
            'create' => 'admin.products.create',
            'edit' => 'admin.products.edit',
            'search_render_list' => 'admin.orders.partials.list-search-result-product'
        ];
    }

    public function getRoute(): array
    {
        return [
            'index' => 'admin.product.index',
            'create' => 'admin.product.create',
            'edit' => 'admin.product.edit',
            'delete' => 'admin.product.delete'
        ];
    }
    public function index(ProductDataTable $dataTable)
    {
        $inStock = [1 => __('Còn hàng'), 0 => __('Hết hàng')];
        $isUserDiscount = [1 => __('Có'), 0 => __('Không')];
        $categories = $this->repositoryCategory->getFlatTree();
        $categories = $categories->map(function ($category) {
            return [$category->id => generate_text_depth_tree($category->depth) . $category->name];
<<<<<<< HEAD
        });
        $toppings = $this->repositoryTopping->getFlatTree();
        $toppings = $toppings->map(function ($topping) {
            return [$topping->id => generate_text_depth_tree($topping->depth) . $topping->name];
=======
>>>>>>> 4b56050f4255d0d88105c67cfbc5436467f668fc
        });
        return $dataTable->render($this->view['index'], [
            'in_stock' => $inStock,
            'is_user_discount' => $isUserDiscount,
            'categories' => $categories,
            'toppings' => $toppings,
        ]);

    }

    public function create(): Factory|View|Application
    {
        $categories = $this->repositoryCategory->getFlatTree();
        $attributes = $this->repositoryAttribute->getAllPluckById();
<<<<<<< HEAD
        $toppings = $this->repositoryTopping->getFlatTree();
=======
        $toppings = $this->repository->getAllTopping(); // lấy danh sách các tiện ích

>>>>>>> 4b56050f4255d0d88105c67cfbc5436467f668fc
        return view(
            $this->view['create'],
            [
                'type' => ProductType::asSelectArray(),
                'categories' => $categories,
                'attributes' => $attributes,
<<<<<<< HEAD
                'toppings' => $toppings
=======
                'toppings' => $toppings,
>>>>>>> 4b56050f4255d0d88105c67cfbc5436467f668fc
            ]
        );
    }

    public function store(ProductRequest $request): RedirectResponse
    {

        $instance = $this->service->store($request);
        if ($instance) {
            return to_route($this->route['edit'], $instance->id);
        }
        return back()->with('error', __('notifyFail'))->withInput();
    }

    public function edit($id, Request $request): Factory|View|Application
    {

        $product = $this->repository->loadRelations($this->repository->findOrFail($id), [
            'categories:id',
            'toppings:id',
            'productAttributes' => function ($query) {
                return $query->with(['attribute.variations', 'attributeVariations:id']);
            },
            'productVariations.attributeVariations'
        ]);
        $product = new ProductEditResource($product);
        $categories = $this->repositoryCategory->getFlatTree();
        $toppings = $this->repositoryTopping->getFlatTree();
        $attributes = $this->repositoryAttribute->getAllPluckById();
        $toppings = $this->repository->getAllTopping();//Lấy danh sách topping
        $response = $this->repository->findOrFail($id);

        return view(
            $this->view['edit'],
            [
                'product' => (object) $product->toArray($request),
                'type' => ProductType::asSelectArray(),
                'categories' => $categories,
                'attributes' => $attributes,
                'toppings' => $toppings
            ]
        );
    }

    public function update(ProductRequest $request): RedirectResponse
    {

        $instance = $this->service->update($request);

        if ($instance) {
            return back()->with('success', __('notifySuccess'));
        }
        return back()->with('error', __('notifyFail'));


    }

    public function delete($id): RedirectResponse
    {

        $this->service->delete($id);

        return to_route($this->route['index'])->with('success', __('notifySuccess'));

    }

    public function searchRenderProductAndVariation(ProductRequest $request): Factory|View|Application
    {
        $products = $this->repository->getByColumnsWithRelationsLimit([
            'name' => $request->input('key')
        ]);
        return view($this->view['search_render_list'], compact('products'));
    }

}
