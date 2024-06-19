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
    protected function setCustomColumns(): void
    {
        $this->customColumns = config('datatables_columns.vehicle', []);
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
            'id' => $this->view['editlink'],
            'user' => $this->view['user'],
            'desc' => $this->view['desc'],
        ];
    }

    protected function setCustomRawColumns()
    {
        $this->customRawColumns = ['id', 'user', 'type', 'action', 'desc'];
    }

    protected function setColumnSearch()
    {
        // TODO: Implement setColumnSearch() method.
    }
}
