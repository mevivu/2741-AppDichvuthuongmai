<?php

namespace App\Admin\DataTables\Transaction;

use App\Admin\DataTables\BaseDataTable;
use App\Admin\Repositories\DriverTransaction\TransactionRepositoryInterface;
use App\Enums\Driver\DriverTransactionStatus;
use Illuminate\Database\Eloquent\Builder;

class TransactionDataTable extends BaseDataTable
{

    protected $nameTable = 'transactionTable';

    public function __construct(
        TransactionRepositoryInterface $repository
    )
    {
        $this->repository = $repository;

        parent::__construct();

    }

    public function setView()
    {
        $this->view = [
            'action' => 'admin.transactions.datatable.action',
            'driver' => 'admin.transactions.datatable.driver',
            'status' => 'admin.transactions.datatable.status',
            'code' => 'admin.transactions.datatable.code',
            'id' => 'admin.transactions.datatable.id'
        ];
    }

    public function setColumnSearch(): void
    {

        $this->columnAllSearch = [0, 1, 2, 3, 4, 5];

        $this->columnSearchDate = [4];
         $this->columnSearchSelect = [
             [
                 'column' => 3,
                 'data' => DriverTransactionStatus::asSelectArray()
             ],
         ];
    }

    /**
     * Get query source of dataTable.
     *
     * @return Builder
     */
    public function query(): Builder
    {
        return $this->repository->getQueryBuilderOrderBy();
    }

    protected function setCustomColumns(): void
    {
        $this->customColumns = config('datatables_columns.transaction', []);
    }

    protected function setCustomEditColumns(): void
    {
        $this->customEditColumns = [
            'order_id' => function ($transaction) {
                return view($this->view['code'], [
                    'code' => $transaction->order->code,
                    'id' => $transaction->order->id
                ])->render();
            },
            'created_at' => '{{ format_date($created_at) }}',
            'driver_id' => function ($transaction) {
                $driverName = $transaction->driver && $transaction->driver->user ? $transaction->driver->user->fullname : 'N/A';
                return view($this->view['driver'], [
                    'driver_name' => $driverName,
                    'driver_id' => $transaction->driver_id,
                ])->render();
            },
            'status' => $this->view['status'],
            'id' => function ($transaction) {
                return view($this->view['id'], ['id' => $transaction->id,])->render();
            },
        ];
    }

    protected function setCustomAddColumns(): void
    {
        $this->customAddColumns = [
            'action' => $this->view['action'],
        ];
    }

    protected function setCustomRawColumns(): void
    {
        $this->customRawColumns = ['driver_id', 'action', 'status', 'order_id','id'];
    }

    public function setCustomFilterColumns(): void
    {
        $this->customFilterColumns = [
            'driver_id' => function ($query, $keyword) {
                $query->whereHas('driver.user', function ($subQuery) use ($keyword) {
                    $subQuery->where('fullname', 'like', '%' . $keyword . '%');
                });
            },

        ];
    }

}
