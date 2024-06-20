<?php

namespace App\Admin\DataTables\Order;

use App\Admin\DataTables\BaseDataTable;
use App\Admin\Repositories\Order\OrderRepositoryInterface;
use App\Enums\Order\OrderStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Request;


class OrderDriverIncomeDataTable extends BaseDataTable
{

    protected $nameTable = 'driverIncomeTable';
    protected $userId;

    public function setUserId($userId): static
    {
        $this->userId = $userId;
        return $this;
    }

    public function __construct(
        OrderRepositoryInterface $repository
    )
    {
        $this->repository = $repository;

        parent::__construct();
    }

    public function setView()
    {
        $this->view = [
            'code' => 'admin.orders.datatable.code',
            'total' => 'admin.orders.datatable.total-income',

        ];
    }

    public function setColumnSearch(): void
    {

        $this->columnAllSearch = [0, 1, 2];

        $this->columnSearchDate = [2];

        $this->columnSearchSelect = [

        ];
    }

    /**
     * Get query source of dataTable.
     *
     * @return Builder
     */
    public function query(): Builder
    {
        $date = Request::input('month');
        if ($date) {
            list($year, $month) = explode('-', $date);
            return $this->repository->getOrderByMonthAndYear($this->userId, $month, $year);
        }
        $filter = [
            'status' => ['status', '=', OrderStatus::Completed],
            'driver_id' => ['driver_id', '=', $this->userId],
        ];
        return $this->repository->getByQueryBuilder($filter);
    }

    protected function setCustomColumns(): void
    {
        $this->customColumns = config('datatables_columns.income-by-driver', []);
    }

    protected function setCustomEditColumns(): void
    {
        $this->customEditColumns = [
            'code' => $this->view['code'],
            'created_at' => '{{ format_date($created_at) }}',
            'transport_fee' => '{{ format_price($transport_fee) }}',
        ];
    }

    protected function setCustomAddColumns(): void
    {
        $this->customAddColumns = [
            'income' => function ($order) {
                $total_income = $order->transport_fee - ($order->system_revenue ?? 0);
                $formatted_income = format_price($total_income);

                return view($this->view['total'], [
                    'total_income' => $formatted_income,
                ])->render();
            },
        ];
    }

    protected function setCustomRawColumns(): void
    {
        $this->customRawColumns = ['code', 'income'];
    }

    public function setCustomFilterColumns(): void
    {
        $this->customFilterColumns = [

        ];
    }
}
