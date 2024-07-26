<?php

namespace App\Admin\DataTables\Order;

use App\Admin\DataTables\BaseDataTable;
use App\Admin\Repositories\Order\OrderRepositoryInterface;
use App\Enums\Order\OrderStatus;
use App\Enums\Order\OrderType;
use Illuminate\Database\Eloquent\Builder;

class OrderDataTable extends BaseDataTable
{

    protected $nameTable = 'orderTable';

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
        $this->columnAllSearch = [0, 1, 2, 3, 4, 5, 6];

        $this->columnSearchDate = [6];

        $this->columnSearchSelect = [
            [
                'column' => 4,
                'data' => OrderStatus::asSelectArray()
            ],
            [
                'column' => 5,
                'data' => OrderType::asSelectArray()
            ],
        ];
    }

    public function setView(): void
    {
        $this->view = [
            'action' => 'admin.orders.datatable.action',
            'editlink' => 'admin.orders.datatable.editlink',
            'status' => 'admin.orders.datatable.status',
            'user' => 'admin.orders.datatable.user',
        ];
    }

    protected function setCustomEditColumns(): void
    {
        $this->customEditColumns = [
            'id' => $this->view['editlink'],
            'status' => $this->view['status'],
            'total' => '{{ format_price($total) }}',
            'user' => $this->view['user'],
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
        return $this->repository->getByQueryBuilder([], ['user','driver']);
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
        $this->customColumns = config('datatables_columns.order', []);
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
        $this->customRawColumns = ['id', 'status', 'user', 'action', 'driver'];
    }

    public function setCustomFilterColumns(): void
    {
        $this->customFilterColumns = [
            'user' => function ($query, $keyword) {
                $query->whereHas('user', function ($subQuery) use ($keyword) {
                    $subQuery->where('fullname', 'like', '%' . $keyword . '%');
                });
            },
            'driver' => function ($query, $keyword) {
                $query->whereHas('driver.user', function ($subQuery) use ($keyword) {
                    $subQuery->where('fullname', 'like', '%' . $keyword . '%');
                });
            },
        ];
    }
}
