<?php

namespace App\Admin\DataTables\Store\Category;

use App\Admin\DataTables\BaseDataTable;
use App\Admin\Repositories\StoreCategory\StoreCategoryRepositoryInterface;
use App\Enums\DefaultStatus;
use Illuminate\Database\Eloquent\Builder;

class StoreCategoryDataTable extends BaseDataTable
{

    protected $nameTable = 'storeCatTable';

    public function __construct(
        StoreCategoryRepositoryInterface $repository
    )
    {
        $this->repository = $repository;

        parent::__construct();

    }

    public function setView(): void
    {
        $this->view = [
            'action' => 'admin.stores.categories.datatable.action',
            'name' => 'admin.stores.categories.datatable.name',
            'status' => 'admin.stores.categories.datatable.status',
        ];
    }

    public function setColumnSearch(): void
    {

        $this->columnAllSearch = [0, 1, 2];

        $this->columnSearchDate = [2];

        $this->columnSearchSelect = [
            [
                'column' =>1,
                'data' => DefaultStatus::asSelectArray()
            ]
        ];
    }

    /**
     * Get query source of dataTable.
     *
     * @return Builder
     */
    public function query(): Builder
    {
        return $this->repository->getQueryBuilderOrderBy('position', 'asc');
    }

    protected function setCustomColumns(): void
    {
        $this->customColumns = config('datatables_columns.store_category', []);
    }

    protected function setCustomEditColumns(): void
    {
        $this->customEditColumns = [
            'name' => $this->view['name'],
            'status' => $this->view['status'],
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
        $this->customRawColumns = ['name', 'status', 'action'];
    }
}
