<?php

namespace App\Admin\DataTables\Order;

use App\Admin\DataTables\BaseDataTable;
use App\Admin\Repositories\Order\OrderRepositoryInterface;
use App\Enums\Order\OrderStatus;
use App\Enums\Payment\PaymentMethod;
use Illuminate\Database\Eloquent\Builder;

class RentingOrderDataTable extends BaseDataTable
{

    protected $nameTable = 'rentingOrderTable';

    protected array $actions = ['excel', 'reset', 'reload'];

    public function __construct(
        OrderRepositoryInterface $repository
    )
    {
        parent::__construct();

        $this->repository = $repository;
    }
    protected function setColumnSearch()
    {
        $this->columnAllSearch = [0, 1, 2, 3, 4, 5, 6, 7, 8];

        $this->columnSearchDate = [8];

        $this->columnSearchSelect = [
            [
                'column' => 4,
                'data' => OrderStatus::asSelectArray()
            ],
            [
                'column' => 5,
                'data' => PaymentMethod::asSelectArray()
            ],
        ];
    }

    public function setView(): void
    {
        $this->view = [
            'action' => 'admin.renting_orders.datatable.action',
            'editlink' => 'admin.renting_orders.datatable.editlink',
            'status' => 'admin.renting_orders.datatable.status',
            'user' => 'admin.renting_orders.datatable.user',
            'vehicle' => 'admin.renting_orders.datatable.vehicle',
            'payment_method' => 'admin.renting_orders.datatable.payment-method',
        ];
    }

    protected function setCustomEditColumns(): void
    {
        $this->customEditColumns = [
            'id' => $this->view['editlink'],
            'status' => $this->view['status'],
            'total' => '{{ format_price($total) }}',
            'user' => $this->view['user'],
            'vehicle' => $this->view['vehicle'],
            'payment_method' => $this->view['payment_method'],
            'created_at' => '{{ format_date($created_at) }}',
            'order_type' => '{{ App\Enums\Order\OrderType::getDescription($order_type) }}',
        ];
    }

    /**
     * Get query source of dataTable.
     *
     * @return Builder
     */
    public function query(): Builder
    {
        return $this->repository->getByQueryBuilder([], ['user', 'vehicle']);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */

    /**
     * Get columns.
     *
     * @return void
     */
    protected function setCustomColumns(): void
    {
        $this->customColumns = config('datatables_columns.renting-order', []);
    }

    protected function setCustomAddColumns(): void
    {
        $this->customAddColumns = [
            'action' => $this->view['action'],
        ];
    }

    protected function filename(): string
    {
        return 'order_' . date('YmdHis');
    }

    protected function setCustomRawColumns(): void
    {
        $this->customRawColumns = ['id', 'status', 'user', 'action', 'payment_method', 'vehicle'];
    }

    public function setCustomFilterColumns(): void
    {
        $this->customFilterColumns = [
            'user' => function ($query, $keyword) {
                $query->whereHas('user', function ($subQuery) use ($keyword) {
                    $subQuery->where('fullname', 'like', '%' . $keyword . '%');
                });
            },
            'vehicle' => function ($query, $keyword) {
                $query->whereHas('vehicle', function ($subQuery) use ($keyword) {
                    $subQuery->where('name', 'like', '%' . $keyword . '%');
                });
            },
        ];
    }
}
