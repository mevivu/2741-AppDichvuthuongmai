<?php

namespace App\Admin\DataTables\Area;

use App\Admin\DataTables\BaseDataTable;
use App\Admin\Repositories\Area\AreaRepositoryInterface;
use App\Admin\Traits\GetConfig;
use Illuminate\Database\Eloquent\Collection;
use Yajra\DataTables\DataTableAbstract;
use Yajra\DataTables\Exceptions\Exception;
use Yajra\DataTables\Html\Builder;

class AreaDataTable extends BaseDataTable
{

    use GetConfig;
    protected $nameTable = "areaTable";
    protected array $actions = ['reset', 'reload'];

    public function __construct(
        AreaRepositoryInterface $repository
    ){
        parent::__construct();

        $this->repository = $repository;
    }

    public function getView(): array
    {
        return [
            'action' => 'admin.areas.datatable.action',
            'name' => 'admin.areas.datatable.name',
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
        $this->instanceDataTable = datatables()->collection($query);
        $this->editColumnName();
        $this->editColumnStatus();
        $this->editColumnCreatedAt();
        $this->addColumnAction();
        $this->rawColumnsNew();
        return $this->instanceDataTable;
    }

    /**
     * Get query source of dataTable.
     *
     * @return Collection
     */
    public function query(): Collection
    {
        return $this->repository->getQueryBuilderOrderBy()->get();
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
            ->minifiedAjax()
            ->dom('Bfrtip')
            ->orderBy(0)
            ->selectStyleSingle();

        $this->htmlParameters();

        return $this->instanceHtml;
    }

    protected function setCustomColumns(): void
    {
        $this->customColumns = $this->traitGetConfigDatatableColumns('area');
    }


    protected function editColumnName(): void
    {
        $this->instanceDataTable = $this->instanceDataTable->editColumn('name', $this->view['name']);
    }
    protected function editColumnStatus(): void
    {
        $this->instanceDataTable = $this->instanceDataTable->editColumn('status', function($area){
            return $area->status;
        });
    }
    protected function editColumnCreatedAt(): void
    {
        $this->instanceDataTable = $this->instanceDataTable->editColumn('created_at', '{{ date("d-m-Y", strtotime($created_at)) }}');
    }
    protected function addColumnAction(): void
    {
        $this->instanceDataTable = $this->instanceDataTable->addColumn('action', $this->view['action']);
    }
    protected function rawColumnsNew(): void
    {
        $this->instanceDataTable = $this->instanceDataTable->rawColumns(['name', 'action']);
    }
    protected function htmlParameters(): void
    {

        $this->parameters['buttons'] = $this->actions;

        $this->parameters['initComplete'] = "function () {

             moveSearchColumnsDatatable('#{$this->nameTable}');

            searchColumsDataTable(this);
        }";

        $this->instanceHtml = $this->instanceHtml
            ->parameters($this->parameters);
    }


}
