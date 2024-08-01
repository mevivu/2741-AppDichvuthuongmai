<?php

namespace App\Admin\Http\Controllers\Order;

use App\Admin\DataTables\Order\RentingOrderDataTable;
use App\Admin\Http\Controllers\Controller;
use App\Admin\Repositories\Order\OrderRepositoryInterface;
use App\Admin\Services\Order\OrderServiceInterface;
use App\Enums\Order\OrderStatus;
use App\Admin\Http\Requests\Order\RentVehicleOrderRequest;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use App\Enums\Payment\PaymentMethod;
use App\Traits\ResponseController;

class RentingOrderController extends Controller
{
    use ResponseController;
    public function __construct(
        OrderRepositoryInterface $repository,
        OrderServiceInterface $service
    ) {
        parent::__construct();
        $this->repository = $repository;
        $this->service = $service;
    }
    public function getView(): array
    {
        return [
            'index' => 'admin.renting_orders.index',
            'create' => 'admin.renting_orders.create',
            'edit' => 'admin.renting_orders.edit',
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
            'payment_methods' => PaymentMethod::asSelectArray(),
            'breadcrumbs' => $this->crums->add(__('renting-order'), route($this->route['index']))->add(__('add'))
        ]);
    }
    public function store(RentVehicleOrderRequest $request): RedirectResponse
    {
        $order = $this->service->storeRentOrder($request);
        return $this->handleResponse($order, $request, $this->route['index'], $this->route['edit']);
    }
    public function edit($id): Factory|View|Application
    {
        $order = $this->repository->findOrFailWithRelations($id);
        return view(
            $this->view['edit'],
            [
                'order' => $order,
                'status' => OrderStatus::asSelectArray(),
                'payment_methods' => PaymentMethod::asSelectArray(),
                'breadcrumbs' => $this->crums->add(__('renting-order'), route($this->route['index']))->add(__('edit'))
            ],
        );
    }
    public function update(RentVehicleOrderRequest $request): RedirectResponse
    {
        $response = $this->service->updateRentOrder($request);
        return $this->handleUpdateResponse($response);
    }

    public function delete($id): RedirectResponse
    {
        $response = $this->service->delete($id);
        return $this->handleUpdateResponse($response);
    }

    public function confirm($id)
    {
        $response = $this->service->confirm($id);
        return $this->handleUpdateResponse($response);
    }

    public function cancel($id)
    {
        $response = $this->service->cancel($id);
        return $this->handleUpdateResponse($response);
    }
}
