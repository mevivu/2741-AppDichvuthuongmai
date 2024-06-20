<?php

namespace App\Admin\DataTables\Transaction;

use App\Admin\DataTables\BaseDataTable;
use App\Admin\Repositories\DriverTransaction\TransactionRepositoryInterface;
use App\Enums\Driver\DriverTransactionStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Request;

class TransactionIncomeDataTable extends BaseDataTable
{

    protected $nameTable = 'transactionTable';

    public function __construct(
        TransactionRepositoryInterface $repository
    )
    {
        $this->repository = $repository;

        parent::__construct();

    }

    public function setView(): void
    {
        $this->view = [
            'action' => 'admin.transactions.datatable.action',
            'id' => 'admin.transactions.datatable.id',
        ];
    }

    public function setColumnSearch(): void
    {

        $this->columnAllSearch = [0, 1, 2];

        $this->columnSearchDate = [2];
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
            return $this->repository->getTransactionsByMonthAndYear($month, $year);
        }
        $filter = [
            'status' => ['status', '!=', DriverTransactionStatus::Pending]
        ];
        return $this->repository->getByQueryBuilder($filter);
    }

    protected function setCustomColumns(): void
    {
        $this->customColumns = config('datatables_columns.income', []);
    }

    protected function setCustomEditColumns(): void
    {
        $this->customEditColumns = [

            'created_at' => '{{ format_datetime($created_at) }}',
            'amount' => '{{ format_price($amount)}}',
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
        $this->customRawColumns = ['action', 'id'];
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
