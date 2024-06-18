<?php

namespace App\Admin\DataTables\DiscountCode;

use App\Admin\DataTables\BaseDataTable;
use App\Admin\Repositories\DiscountCode\DiscountCodeRepositoryInterface;
use App\Admin\Traits\GetConfig;


class DiscountCodeDataTable extends BaseDataTable
{

    use GetConfig;

    // ID ( Client ) của bảng DataTable
    protected $nameTable = 'discountCodeTable';

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
        DiscountCodeRepositoryInterface $repository
    ) {
        parent::__construct();

        $this->repository = $repository;
    }

    public function setView()
    {
        $this->view = [
            'status' => 'admin.discount_code.datatable.status',
            'action' => 'admin.discount_code.datatable.action',
            'editlink' => 'admin.discount_code.datatable.editlink',
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
        $this->editColumnDateApply();
        $this->filterColumnDateApply();
        $this->editColumnExpirationDate();
        $this->filterColumnExpirationDatey();
        $this->addColumnAction();
        $this->editColumnName();
        $this->editColumnDiscount();
        $this->editColumnStatus();
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
        return $this->repository->getQueryBuilderOrderBy();
    }

    /**
     * Get columns.
     *
     * @return array
     * Hàm kết nối tới datatable_columns Config
     */
    protected function setCustomColumns()
    {
        $this->customColumns = $this->traitGetConfigDatatableColumns('discount_code');
    }

    protected function setCustomEditColumns()
    {
        $this->customEditColumns = [
            'status' => $this->view['status'],
        ];
    }
    protected function setCustomAddColumns()
    {
        $this->customAddColumns = [
            'action' => $this->view['action'],
        ];
    }

    protected function editColumnDateApply()
    {
        $this->instanceDataTable = $this->instanceDataTable->editColumn('apply_date', '{{ date("d-m-Y", strtotime($apply_date)) }}');
    }

    protected function filterColumnDateApply()
    {
        $this->instanceDataTable = $this->instanceDataTable->filterColumn('apply_date', function ($query, $keyword) {

            $query->whereDate('apply_date', date('Y-m-d', strtotime($keyword)));
        });
    }

    protected function editColumnExpirationDate()
    {
        $this->instanceDataTable = $this->instanceDataTable->editColumn('expiration_date', '{{ date("d-m-Y", strtotime($expiration_date)) }}');
    }

    protected function filterColumnExpirationDatey()
    {
        $this->instanceDataTable = $this->instanceDataTable->filterColumn('expiration_date', function ($query, $keyword) {

            $query->whereDate('expiration_date', date('Y-m-d', strtotime($keyword)));
        });
    }

    protected function addColumnAction()
    {
        $this->instanceDataTable = $this->instanceDataTable->addColumn('action', $this->view['action']);
    }

    protected function editColumnName()
    {
        $this->instanceDataTable = $this->instanceDataTable->editColumn('name', $this->view['editlink']);
    }

    protected function editColumnDiscount()
    {
        $this->instanceDataTable = $this->instanceDataTable->editColumn('discount', '{{ format_price($discount) }}');
    }

    protected function editColumnStatus()
    {
        $this->instanceDataTable = $this->instanceDataTable->editColumn('status', $this->view['status']);
    }

    protected function rawColumnsNew()
    {
        $this->instanceDataTable = $this->instanceDataTable->rawColumns(['name', 'action', 'status']);
    }

    public function html()
    {
        $this->instanceHtml = $this->builder()
            ->setTableId('discountCodeTable')
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

            moveSearchColumnsDatatable('#discountCodeTable');

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
