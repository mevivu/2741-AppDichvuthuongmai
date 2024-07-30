<?php

namespace App\Admin\Http\Controllers\Order;

use App\Admin\DataTables\Order\RentingOrderDataTable;
use App\Admin\Http\Controllers\Controller;
use App\Admin\Repositories\Order\OrderRepositoryInterface;
use App\Admin\Services\Order\OrderServiceInterface;
use App\Enums\Order\OrderStatus;
use App\Admin\Http\Requests\Order\OrderRequest;
use App\Admin\Http\Requests\Order\RentVehicleOrderRequest;
use App\Admin\Repositories\User\UserRepositoryInterface;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use App\Admin\Repositories\Product\{ProductRepositoryInterface, ProductVariationRepositoryInterface};
use App\Enums\Payment\PaymentMethod;

class RentingOrderController extends Controller
{
    protected UserRepositoryInterface $repositoryUser;
    protected ProductRepositoryInterface $repositoryProduct;
    protected ProductVariationRepositoryInterface $repositoryProductVariation;

    public function __construct(
        OrderRepositoryInterface $repository,
        UserRepositoryInterface $repositoryUser,
        ProductRepositoryInterface $repositoryProduct,
        ProductVariationRepositoryInterface $repositoryProductVariation,
        OrderServiceInterface $service
    ) {
        parent::__construct();
        $this->repository = $repository;
        $this->repositoryUser = $repositoryUser;
        $this->repositoryProduct = $repositoryProduct;
        $this->repositoryProductVariation = $repositoryProductVariation;
        $this->service = $service;
    }
    public function getView(): array
    {
        return [
            'index' => 'admin.renting_orders.index',
            'create' => 'admin.renting_orders.create',
            'edit' => 'admin.renting_orders.edit',
            'info_shipping' => 'admin.renting_orders.partials.info-shipping',
            'add_item_product' => 'admin.renting_orders.partials.add-item-product',
            'total' => 'admin.renting_orders.partials.total'
        ];
    }

    public function getRoute(): array
    {
        return [
            'index' => 'admin.renting-order.index',
            'create' => 'admin.renting-order.create',
            'edit' => 'admin.renting-order.edit',
            'delete' => 'admin.renting-order.delete',
        ];
    }
    public function index(RentingOrderDataTable $dataTable)
    {
        return $dataTable->render($this->view['index'], [
            'status' => OrderStatus::asSelectArray()
        ]);
    }
    public function create(): Factory|View|Application
    {
        return view($this->view['create'], [
            'payment_methods' => PaymentMethod::asSelectArray()
        ]);
    }
    public function store(RentVehicleOrderRequest $request): RedirectResponse
    {
        $order = $this->service->storeRentOrder($request);
        if ($order) {
            return to_route($this->route['edit'], $order->id)->with('success', __('notifySuccess'));
        }
        return back()->with('error', __('notifyFail'));
    }
    public function edit($id): Factory|View|Application
    {
        $order = $this->repository->findOrFailWithRelations($id);
        $status = OrderStatus::asSelectArray();
        $payment_methods = PaymentMethod::asSelectArray();
        return view($this->view['edit'], compact('order', 'status', 'payment_methods'));
    }
    public function update(RentVehicleOrderRequest $request): RedirectResponse
    {
        $response = $this->service->updateRentOrder($request);
        if ($response) {
            return back()->with('success', __('notifySuccess'));
        }
        return back()->with('error', __('notifyFail'));
    }

    public function delete($id): RedirectResponse
    {
        $this->service->delete($id);
        return to_route($this->route['index'])->with('success', __('notifySuccess'));
    }

    public function confirm($id)
    {
        $result = $this->service->confirm($id);
        if ($result) {
            return to_route($this->route['index'])->with('success', __('Duyệt đơn hàng thành công'));
        }
        return to_route($this->route['index'])->with('error', __('Duyệt đơn hàng thất bại'));
    }

    public function cancel($id)
    {
        $result = $this->service->cancel($id);
        if ($result) {
            return to_route($this->route['index'])->with('success', __('Từ chối đơn hàng thành công'));
        }
        return to_route($this->route['index'])->with('error', __('Từ chối đơn hàng thất bại'));
    }
}
