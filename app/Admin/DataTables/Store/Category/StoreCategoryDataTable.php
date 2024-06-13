<?php

namespace App\Admin\DataTables\Store\Category;

use App\Admin\DataTables\BaseDataTable;
use App\Admin\Repositories\StoreCategory\StoreCategoryRepositoryInterface;
use App\Admin\Traits\GetConfig;
use Illuminate\Database\Eloquent\Collection;
use Yajra\DataTables\DataTableAbstract;
use Yajra\DataTables\Exceptions\Exception;
use Yajra\DataTables\Html\Builder;

class StoreCategoryDataTable extends BaseDataTable
{
    use GetConfig;

    protected $nameTable = 'storeCategoryTable';
    protected array $actions = ['reset', 'reload'];

    public function __construct(
        StoreCategoryRepositoryInterface $repository
    ) {
        $this->repository = $repository;

        parent::__construct();
    }

    public function getView(): array
    {
        return [
            'action' => 'admin.stores.categories.datatable.action',
            'status' => 'admin.stores.categories.datatable.status',
            'edit-link' => 'admin.stores.categories.datatable.edit-link',
        ];
    }

    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return DataTableAbstract
     * @throws Exception
     */
    public function dataTable($query): DataTableAbstract
    {

        $this->instanceDataTable = datatables()->eloquent($query)->addIndexColumn();
        $this->addColumnAction();
        $this->filterColumnCreatedAt();
        $this->editColumnCreatedAt();
        $this->rawColumnsNew();
        $this->editColumnStatus();
        $this->editColumnId();
        return $this->instanceDataTable;
    }

    /**
     * Get query source of dataTable.
     *
     * @return Collection
     */
    public function query()
    {
        return $this->repository->getQueryBuilderOrderBy();
    }



    protected function filterColumnCreatedAt()
    {
        $this->instanceDataTable = $this->instanceDataTable->filterColumn('created_at', function ($query, $keyword) {

            $query->whereDate('created_at', date('Y-m-d', strtotime($keyword)));
        });
    }

    protected function setCustomColumns()
    {
        $this->customColumns = $this->traitGetConfigDatatableColumns('store_category');
    }

    protected function editColumnId()
    {
        $this->instanceDataTable = $this->instanceDataTable->editColumn('name', $this->view['edit-link']);
    }

    protected function editColumnStatus()
    {
        $this->instanceDataTable = $this->instanceDataTable->editColumn('status', $this->view['status']);
    }

    protected function addColumnAction()
    {
        $this->instanceDataTable = $this->instanceDataTable->addColumn('action', $this->view['action']);
    }

    protected function editColumnCreatedAt()
    {
        $this->instanceDataTable = $this->instanceDataTable->editColumn('created_at', '{{ date("d-m-Y", strtotime($created_at)) }}');
    }

    protected function rawColumnsNew()
    {
        $this->instanceDataTable = $this->instanceDataTable->rawColumns(['status', 'action', 'name']);
    }

    protected function htmlParameters()
    {
        $this->parameters['buttons'] = $this->actions;

        $this->parameters['initComplete'] = "function () {
        moveSearchColumnsDatatable('#storeCategoryTable');
        searchColumsDataTable(this);
    }";

        $this->instanceHtml = $this->instanceHtml
            ->parameters($this->parameters);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return Builder
     */
    public function html(): Builder
    {
        $this->instanceHtml = $this->builder()
            ->setTableId($this->nameTable)
            ->columns($this->getColumns())
            ->dom('Bfrtip')
            ->orderBy(0)
            ->selectStyleSingle();

        $this->htmlParameters();

        return $this->instanceHtml;
    }

    protected function setColumnSearch()
    {
        // TODO: Implement setColumnSearch() method.
    }
}
