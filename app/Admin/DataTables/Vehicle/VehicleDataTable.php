<?php

namespace App\Admin\DataTables\Vehicle;

use App\Admin\DataTables\BaseDataTable;
use App\Admin\Repositories\Vehicle\VehicleRepositoryInterface;
use App\Admin\Traits\GetConfig;
use App\Enums\Vehicle\VehicleStatus;
use App\Enums\Vehicle\VehicleType;
use Illuminate\Database\Eloquent\Builder;
use Yajra\DataTables\DataTableAbstract;


class VehicleDataTable extends BaseDataTable
{

    use GetConfig;

    protected $nameTable = 'vehicleTable';


    protected array $actions = ['reset', 'reload'];

    public function __construct(
        VehicleRepositoryInterface $repository
    ) {
        parent::__construct();

        $this->repository = $repository;
    }

    public function setView(): void
    {
        $this->view = [
            'type' => 'admin.vehicle.datatable.type',
            'action' => 'admin.vehicle.datatable.action',
            'editlink' => 'admin.vehicle.datatable.editlink',
            'desc' => 'admin.vehicle.datatable.desc',
            'vehicle_owner' => 'admin.vehicle.datatable.vehicle_owner',
            'driver' => 'admin.vehicle.datatable.driver',
            'status' => 'admin.vehicle.datatable.status',
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
        return $this->repository->getByQueryBuilder([], ['vehicle_owner']);
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

    public function setColumnSearch(): void
    {

        $this->columnAllSearch = [0,1,2,3,4,5,6,7,8,9];

        $this->columnSearchDate = [9];
        $this->columnSearchSelect = [
            [
                'column' => 7,
                'data' => VehicleType::asSelectArray()
            ],
            [
                'column' => 5,
                'data' => VehicleStatus::asSelectArray()
            ]
        ];
    }

    protected function setCustomEditColumns(): void
    {
        $this->customEditColumns = [
            'type' => $this->view['type'],
            'id' => $this->view['editlink'],
            'desc' => $this->view['desc'],
            'status' => $this->view['status'],
            'vehicle_owner' => function ($vehicle) {
                return view($this->view['vehicle_owner'], [
                    'vehicle' => $vehicle,
                ])->render();
            },
            'driver' => function ($vehicle) {
                return view($this->view['driver'], [
                    'vehicle' => $vehicle,
                ])->render();
            },
        ];
    }

    protected function setCustomRawColumns(): void
    {
        $this->customRawColumns = ['id', 'vehicle_owner', 'type', 'action', 'desc', 'driver', 'status'];
    }

    protected function setCustomFilterColumns(): void
    {
        $this->customFilterColumns = [
            'vehicle_owner' => function ($query, $keyword) {
                $query->whereHas('vehicle_owner', function ($subQuery) use ($keyword) {
                    $subQuery->where('fullname', 'like', '%' . $keyword . '%');
                });
            },
            'driver' => function ($query, $keyword) {
                $query->whereHas('driver.user', function ($subQuery) use ($keyword) {
                    $subQuery->where('fullname', 'like', '%' . $keyword . '%');
                });
            },
        ];
    }
}
