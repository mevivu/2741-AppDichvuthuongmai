<?php

namespace App\Admin\Http\Controllers\Order;

use App\Admin\DataTables\Order\OrderDataTable;
use App\Admin\DataTables\Order\OrderDriverHistoryDataTable;
use App\Admin\DataTables\Order\OrderDriverIncomeDataTable;
use App\Admin\Http\Controllers\Controller;
use App\Admin\Http\Requests\Order\OrderRequest;
use App\Admin\Repositories\Order\OrderItemRepositoryInterface;
use App\Admin\Repositories\Order\OrderRepositoryInterface;
use App\Admin\Repositories\Driver\DriverRepositoryInterface;
use App\Admin\Services\Order\OrderServiceInterface;
use App\Enums\Driver\DriverAssignmentType;
use App\Enums\Order\OrderStatus;
use App\Enums\Payment\PaymentMethod;
use App\Enums\Shipping\ShippingMethod;
use App\Models\Store;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    protected OrderItemRepositoryInterface $orderItemRepository;
    protected DriverRepositoryInterface $driverRepository;

    public function __construct(
        OrderRepositoryInterface      $repository,
        OrderServiceInterface         $service,
        OrderItemRepositoryInterface  $orderItemRepository,
        DriverRepositoryInterface $driverRepository
    )
    {

        parent::__construct();

        $this->repository = $repository;
        $this->service = $service;
        $this->orderItemRepository = $orderItemRepository;
        $this->driverRepository = $driverRepository;
    }

    public function getView(): array
    {

        return [
            'index' => 'admin.orders.index',
            'create' => 'admin.orders.create',
            'edit' => 'admin.orders.edit',
            'orderDriverHistory' => 'admin.orders.history',
            'orderDriverIncome' => 'admin.orders.driver-income'
        ];
    }

    public function getRoute(): array
    {

        return [
            'index' => 'admin.order.index',
            'create' => 'admin.area.create',
            'edit' => 'admin.order.edit',
            'delete' => 'admin.area.delete',
            'orderDriverHistory' => 'admin.order.orderDriverHistory',
            'orderDriverIncome' => 'admin.order.orderDriverIncome'
        ];
    }

    public function index(OrderDataTable $dataTable)
    {

        return $dataTable->render($this->view['index'], [
            'breadcrums' => $this->crums->add(__('order'))
        ]);
    }

    public function orderDriverHistory($id, OrderDriverHistoryDataTable $dataTable)
    {
        return $dataTable->setUserId($id)->render($this->view['orderDriverHistory'], [
            'breadcrums' => $this->crums->add(__('user'),
                route($this->route['orderDriverHistory'], ['id' => $id]))->add(__('view_order_driver_history'))
        ]);
    }

    /**
     * @throws Exception
     */
    public function orderDriverIncome($id, OrderDriverIncomeDataTable $dataTable)
    {
        $parts = explode('&', $id);
        $driverId = $parts[0];
        $driver = $this->driverRepository->findOrFail($driverId);

        $date1 = $parts[1] ?? null;
        $date2 = $parts[2] ?? null;

        $totalIncome = 0;

        if (is_null($date1) && is_null($date2)) {
            $totalIncome = $this->repository->getTotalDriverIncome($driverId, null, null);
        }

        return $dataTable->setUserId($driverId)->render($this->view['orderDriverIncome'], [
            'driver' => $driver,
            'totalIncome' => $totalIncome,
            'breadcrums' => $this->crums->add(__('user'),
                route($this->route['orderDriverIncome'], ['id' => $id]))->add(__('income_driver'))
        ]);
    }

    public function getTotalDriverIncome(Request $request): JsonResponse
    {
        $month = $request->input('month');
        $driverId = $request->input('driver_id');
        $totalIncome = 0;

        if ($month) {
            list($year, $month) = explode('-', $month);

            $totalIncome = $this->repository->getTotalDriverIncome($driverId,$month, $year);
        }

        return response()->json($totalIncome);
    }


    public function create(): Factory|View|Application
    {
        $stores = Store::all();

        return view($this->view['create'], [
            'breadcrums' => $this->crums->add(__('order'), route($this->route['index']))->add(__('add')),
            'status' => OrderStatus::asSelectArray(),
            'shipping' => ShippingMethod::asSelectArray(),
            'driver_assignment' => DriverAssignmentType::asSelectArray(),
            'payment' => PaymentMethod::asSelectArray(),
            'stores'=>$stores
        ]);
    }

    public function getInfoOrder(OrderRequest $request): JsonResponse
    {
        return $this->service->getInformationOrder($request);
    }

    public function store(OrderRequest $request): RedirectResponse
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
     * @throws Exception
     */
    public function edit($id): Factory|View|Application
    {

        $response = $this->repository->findOrFail($id);
        $orderItems = $this->orderItemRepository->getBy(['order_id' => $id], ['product', 'itemToppings.topping']);

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

    public function update(OrderRequest $request): RedirectResponse
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
}
