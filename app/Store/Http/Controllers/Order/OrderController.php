<?php

namespace App\Store\Http\Controllers\Order;

use App\Admin\Http\Controllers\Controller;
use App\Admin\Repositories\Order\OrderRepository;
use App\Admin\DataTables\Order\OrderStoreDataTable;
use App\Admin\Services\Order\OrderServiceInterface;
use App\Admin\Repositories\Order\OrderItemRepositoryInterface;
use App\Enums\Order\OrderStatus;
use App\Enums\Payment\PaymentMethod;
use App\Enums\Shipping\ShippingMethod;
use App\Admin\Http\Requests\Order\OrderStoreRequest;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;


class OrderController extends Controller
{
    private OrderItemRepositoryInterface $orderItemRepository;
    protected $repositoryOrder;
    public function __construct(
        OrderRepository $repositoryOrder,
        OrderServiceInterface $service,
        OrderItemRepositoryInterface $orderItemRepository,
    ){

        parent::__construct();
        $this->repositoryOrder = $repositoryOrder;
        $this->service = $service;
        $this->orderItemRepository = $orderItemRepository;
    }

    public function getView(): array
    {

        return [
            'index' => 'stores.orders.index',
            'create' => 'stores.orders.create',
            'edit' => 'stores.orders.edit'
        ];
    }

    public function getRoute(): array
    {

        return [
            'index' => 'store.order.index',
            'create' => 'store.order.create',
            'edit' => 'store.order.edit',
            'delete' => 'store.order.delete'
        ];
    }

    public function index(OrderStoreDataTable $dataTable){

        return $dataTable->render($this->view['index'], [
            'breadcrums' => $this->crums->add(__('list')),
        ]);

    }

    /**
     * @throws Exception
     */
    public function edit($id): Factory|View|Application
    {

        $response = $this->repositoryOrder->findOrFail($id);
        $orderItems = $this->orderItemRepository->getBy(['order_id' => $id]);
        return view(
            $this->view['edit'],
            [
                'order' => $response,
                'orderItems' => $orderItems,
                'status' => OrderStatus::asSelectArray(),
                'shipping' => ShippingMethod::asSelectArray(),
                'payment' => PaymentMethod::asSelectArray(),
                'breadcrums' => $this->crums->add(__('order'), route($this->route['index']))->add(__('edit'))
            ],
        );
    }

    public function update(OrderStoreRequest $request)
    {

        $response = $this->service->updateStore($request);

        if ($response) {


            return $request->input('submitter') == 'save'
                ? back()->with('success', __('notifySuccess'))
                : to_route($this->route['index'])->with('success', __('notifySuccess'));
        }

        return back()->with('error', __('notifyFail'));
    }
    public function accept($id){
        $response = $this->service->updateOrder($id);

        if($response){
            return  to_route($this->route['index'])->with('success', __('notifySuccess'));
        }

        return back()->with('error', __('notifyFail'));

    }
    public function refuse($id){

        $response = $this->service->updateOrderRefuse($id);

        if($response){
            return  to_route($this->route['index'])->with('success', __('notifySuccess'));
        }

        return back()->with('error', __('notifyFail'));

    }

}
