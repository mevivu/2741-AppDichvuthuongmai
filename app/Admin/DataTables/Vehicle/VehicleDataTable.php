<?php

namespace App\Admin\DataTables\Vehicle;

use App\Admin\DataTables\BaseDataTable;
use App\Admin\Repositories\Vehicle\VehicleRepositoryInterface;
use App\Admin\Traits\GetConfig;
use Illuminate\Database\Eloquent\Builder;
use Yajra\DataTables\DataTableAbstract;


class VehicleDataTable extends BaseDataTable
{

    use GetConfig;

    protected $nameTable = 'vehicleTable';


    protected array $actions = ['reset', 'reload'];

    public function __construct(
        VehicleRepositoryInterface $repository
    )
    {
        parent::__construct();

        $this->repository = $repository;
    }

    public function setView(): void
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
     * @return DataTableAbstract
     */
    /**
     * Get query source of dataTable.
     *
     * @return Builder
     * Hàm thực thi gọi lệnh truy xuất từ Database ( Repository )
     */
    public function query(): Builder
    {
        return $this->repository->getByQueryBuilder([], ['driver']);
    }


    protected function setCustomColumns(): void
    {
        $this->customColumns = config('datatables_columns.vehicle', []);
    }

    protected function setCustomAddColumns(): void
    {
        $this->customAddColumns = [
            'action' => $this->view['action'],
        ];
    }

    protected function setCustomEditColumns(): void
    {
        $this->customEditColumns = [
            'type' => $this->view['type'],
            'id' => $this->view['editlink'],
            'desc' => $this->view['desc'],
            'driver' => function ($vehicle) {
                return view($this->view['user'], [
                    'vehicle' => $vehicle,
                ])->render();
            },
        ];
    }

    protected function setCustomRawColumns(): void
    {
        $this->customRawColumns = ['id', 'driver', 'type', 'action', 'desc'];
    }

    protected function setColumnSearch(): void
    {
        $this->customFilterColumns = [
            'driver' => function ($query, $keyword) {
                $query->whereHas('driver.user', function ($subQuery) use ($keyword) {
                    $subQuery->where('fullname', 'like', '%' . $keyword . '%');
                });
            },


        ];
    }
}
