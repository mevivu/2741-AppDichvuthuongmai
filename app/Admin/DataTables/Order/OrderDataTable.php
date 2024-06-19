<?php

namespace App\Admin\DataTables\Order;

use App\Admin\DataTables\BaseDataTable;
use App\Admin\Repositories\Order\OrderRepositoryInterface;
use App\Admin\Traits\GetConfig;

class OrderDataTable extends BaseDataTable
{

    use GetConfig;
    /**
     * Available button actions. When calling an action, the value will be used
     * as the function name (so it should be available)
     * If you want to add or disable an action, overload and modify this property.
     *
     * @var array
     */
    // protected array $actions = ['pageLength', 'excel', 'reset', 'reload'];
    protected array $actions = ['excel', 'reset', 'reload'];

    public function __construct(
        OrderRepositoryInterface $repository
    ){
        parent::__construct();

        $this->repository = $repository;
    }

    public function setView(){
        $this->view = [
            'action' => 'admin.orders.datatable.action',
            'editlink' => 'admin.orders.datatable.editlink',
            'status' => 'admin.orders.datatable.status',
            'user' => 'admin.orders.datatable.user',
        ];
    }

    protected function setCustomEditColumns()
    {
        $this->customEditColumns = [
            'id' => $this->view['editlink'],
            'status' => $this->view['status'],
            'total' => '{{ format_price($total) }}',
            'user' => $this->view['user'],
            'created_at' => '{{ date("d-m-Y", strtotime($created_at)) }}',
        ];
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        return $this->repository->getQueryBuilderWithRelations();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */

    /**
     * Get columns.
     *
     * @return array
     */
    protected function setCustomColumns(): void
    {
        $this->customColumns = config('datatables_columns.order', []);
    }
    protected function setCustomAddColumns()
    {
        $this->customAddColumns = [
            'action' => $this->view['action'],
        ];
    }

    protected function filename(): string
    {
        return 'order_' . date('YmdHis');
    }
    protected function setCustomRawColumns(){
        $this->customRawColumns = ['id', 'status', 'user', 'action'];
    }


    protected function setColumnSearch()
    {
        // TODO: Implement setColumnSearch() method.
    }
}
