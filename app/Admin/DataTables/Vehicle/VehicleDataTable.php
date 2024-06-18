<?php

namespace App\Admin\DataTables\Vehicle;

use App\Admin\DataTables\BaseDataTable;
use App\Admin\Repositories\Vehicle\VehicleRepositoryInterface;
use App\Admin\Traits\GetConfig;


class VehicleDataTable extends BaseDataTable
{

    use GetConfig;

    // ID ( Client ) của bảng DataTable
    protected $nameTable = 'vehicleTable';

    /**
     * Available button actions. When calling an action, the value will be used
     * as the function name (so it should be available)
     * If you want to add or disable an action, overload and modify this property.
     *
     * @var array
     */
    // protected array $actions = ['pageLength', 'excel', 'reset', 'reload'];
    protected array $actions = ['reset', 'reload'];

    public function __construct(
        VehicleRepositoryInterface $repository
    ) {
        parent::__construct();

        $this->repository = $repository;
    }

    public function setView()
    {
        $this->view = [
            'type' => 'admin.vehicle.datatable.status',
            'action' => 'admin.vehicle.datatable.action',
            'editlink' => 'admin.vehicle.datatable.editlink',
            'desc' => 'admin.vehicle.datatable.desc',
            'user' => 'admin.vehicle.datatable.user',
        ];
    }

    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $this->instanceDataTable = datatables()->eloquent($query)->addIndexColumn();
        $this->addColumnAction();
        $this->editColumnId();
        $this->editColumnType();
        $this->editColumnLicensePlate();
        $this->editColumnUser();
        $this->rawColumnsNew();
        return $this->instanceDataTable;
    }
    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     * Hàm thực thi gọi lệnh truy xuất từ Database ( Repository )
     */
    public function query()
    {
        return $this->repository->getQueryBuilderWithRelations();
    }

    /**
     * Get columns.
     *
     * @return array
     * Hàm kết nối tới datatable_columns Config
     */
    protected function setCustomColumns()
    {
        $this->customColumns = $this->traitGetConfigDatatableColumns('vehicle');
    }

    protected function setCustomAddColumns()
    {
        $this->customAddColumns = [
            'action' => $this->view['action'],
        ];
    }
    protected function setCustomEditColumns()
    {
        $this->customEditColumns = [
            'type' => $this->view['type'],
        ];
    }
    protected function addColumnAction()
    {
        $this->instanceDataTable = $this->instanceDataTable->addColumn('action', $this->view['action']);
    }

    protected function editColumnId()
    {
        $this->instanceDataTable = $this->instanceDataTable->editColumn('id', $this->view['editlink']);
    }

    protected function editColumnUser()
    {
        $this->instanceDataTable = $this->instanceDataTable->editColumn('user', $this->view['user']);
    }

    protected function editColumnType()
    {
        $this->instanceDataTable = $this->instanceDataTable->editColumn('type', $this->view['type']);
    }

    protected function editColumnLicensePlate()
    {
        $this->instanceDataTable = $this->instanceDataTable->editColumn('license_plate', $this->view['desc']);
    }

    protected function rawColumnsNew()
    {
        $this->instanceDataTable = $this->instanceDataTable->rawColumns(['id', 'user', 'type', 'action', 'license_plate']);
    }

    public function html()
    {
        $this->instanceHtml = $this->builder()
            ->setTableId('vehicleTable')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtip')
            ->orderBy(0)
            ->selectStyleSingle();

        $this->htmlParameters();

        return $this->instanceHtml;
    }

    protected function htmlParameters()
    {

        $this->parameters['buttons'] = $this->actions;

        $this->parameters['initComplete'] = "function () {

            moveSearchColumnsDatatable('#vehicleTable');

            searchColumsDataTable(this);
        }";

        $this->instanceHtml = $this->instanceHtml
            ->parameters($this->parameters);
    }

    protected function setColumnSearch()
    {
        // TODO: Implement setColumnSearch() method.
    }
}
