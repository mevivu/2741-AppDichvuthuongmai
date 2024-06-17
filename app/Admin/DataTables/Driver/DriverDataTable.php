<?php

namespace App\Admin\DataTables\Driver;

use App\Admin\DataTables\BaseDataTable;
use App\Admin\Repositories\Driver\DriverRepositoryInterface;
use App\Enums\Driver\AutoAccept;
use App\Enums\Driver\DriverStatus;
use Illuminate\Database\Eloquent\Builder;

class DriverDataTable extends BaseDataTable
{

    protected $nameTable = 'DriverTable';

    public function __construct(
        DriverRepositoryInterface $repository
    )
    {
        $this->repository = $repository;

        parent::__construct();
    }

    public function setView(): void
    {
        $this->view = [
            'action' => 'admin.drivers.datatable.action',
            'fullname' => 'admin.drivers.datatable.fullname',
            'role' => 'admin.drivers.datatable.role',
            'status' => 'admin.drivers.datatable.status',
            'auto_accept' => 'admin.drivers.datatable.auto_accept',

        ];
    }

    public function setColumnSearch(): void
    {

        $this->columnAllSearch = [0, 1, 2, 4, 5,6];

        $this->columnSearchDate = [6];

        $this->columnSearchSelect = [

            [
                'column' => 4,
                'data' => DriverStatus::asSelectArray()
            ],
            [
                'column' => 5,
                'data' => AutoAccept::asSelectArray()
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
        $this->customColumns = config('datatables_columns.driver', []);
    }

    protected function setCustomEditColumns(): void
    {
        $this->customEditColumns = [
            'fullname' => function ($driver) {
                return view($this->view['fullname'], [
                    'id' => $driver->id,
                    'fullname' => $driver->user->fullname,
                ])->render();
            },

            'order_accepted' => function ($driver) {
                return view($this->view['status'], [
                    'status' => $driver->order_accepted->value,
                ])->render();
            },
            'auto_accept' => function ($driver) {
                return view($this->view['auto_accept'], [
                    'status' => $driver->auto_accept->value,
                ])->render();
            },
            'created_at' => '{{ format_date($created_at) }}'
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
        $this->customRawColumns = ['fullname', 'action','order_accepted','auto_accept'];
    }

    public function setCustomFilterColumns(): void
    {
        $this->customFilterColumns = [
            'fullname' => function ($query, $keyword) {
                $query->whereHas('user', function ($subQuery) use ($keyword) {
                    $subQuery->where('fullname', 'like', '%' . $keyword . '%');
                });
            },


        ];
    }
}
