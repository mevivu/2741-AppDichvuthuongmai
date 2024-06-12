<?php

namespace App\Admin\DataTables\Area;

use App\Admin\DataTables\BaseDataTable;
use App\Admin\Repositories\Area\AreaRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;

class AreaDataTable extends BaseDataTable
{

    protected $nameTable = 'areaTable';

    public function __construct(
        AreaRepositoryInterface $repository
    ){
        $this->repository = $repository;

        parent::__construct();

    }

    public function setView(): void
    {
        $this->view = [
            'action' => 'admin.areas.datatable.action',
            'name' => 'admin.areas.datatable.name'
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
        return $this->repository->getQueryBuilderOrderBy('position', 'asc')->get();
    }

    protected function setCustomColumns(): void
    {
        $this->customColumns = config('datatables_columns.area', []);
    }

    protected function setCustomEditColumns(): void
    {
        $this->customEditColumns = [
            'name' => $this->view['name'],
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
        $this->customRawColumns = ['name', 'action'];
    }
}
