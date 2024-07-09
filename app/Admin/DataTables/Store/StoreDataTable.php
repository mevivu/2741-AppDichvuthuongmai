<?php

namespace App\Admin\DataTables\Store;

use App\Admin\DataTables\BaseDataTable;
use App\Admin\Repositories\Area\AreaRepositoryInterface;
use App\Admin\Repositories\Store\StoreRepositoryInterface;
use App\Admin\Repositories\StoreCategory\StoreCategoryRepositoryInterface;
use App\Enums\Store\StoreStatus;
use Illuminate\Database\Eloquent\Builder;

class StoreDataTable extends BaseDataTable
{

    protected $nameTable = 'storeTable';

    protected AreaRepositoryInterface $areaRepository;
    protected StoreCategoryRepositoryInterface $storeCategoryRepository;
    public function __construct(
        StoreRepositoryInterface $repository,
        AreaRepositoryInterface $areaRepository,
        StoreCategoryRepositoryInterface $storeCategoryRepository
    ){
        $this->repository = $repository;
        $this->areaRepository = $areaRepository;
        $this->storeCategoryRepository = $storeCategoryRepository;

        parent::__construct();
    }

    public function setView(): void
    {
        $this->view = [
            'action' => 'admin.stores.datatable.action',
            'store_name' => 'admin.stores.datatable.store-name',
            'operating_time' => 'admin.stores.datatable.operating-time',
            'status' => 'admin.stores.datatable.status',
            'category' => 'admin.stores.datatable.category',
            'area' => 'admin.stores.datatable.area',
        ];
    }

    public function setColumnSearch(): void
    {

        $this->columnAllSearch = [1, 2, 3, 5, 6];

        $this->columnSearchDate = [7];

        $this->columnSearchSelect = [
            [
                'column' => 5,
                'data' => StoreStatus::asSelectArray()
            ],
        ];

        $this->columnSearchSelect2 = [
            [
                'column' => 3,
                'data' => $this->areaRepository->getAll()->map(function($area){
                    return [$area->id => $area->name];
                })
            ],
            [
                'column' => 2,
                'data' => $this->storeCategoryRepository->getAll()->map(function($store){
                    return [$store->id => $store->name];
                })
            ],
        ];
    }

    protected function setCustomFilterColumns()
    {
        $this->customFilterColumns = [
            'area' => function($query, $keyword) {
                $query->whereHas('area', function($q) use($keyword) {
                    $q->whereIn('id', explode(',', $keyword));
                });
            },
            'category' => function($query, $keyword) {
                $query->whereHas('category', function($q) use($keyword) {
                    $q->whereIn('id', explode(',', $keyword));
                });
            }
        ];
    }

    /**
     * Get query source of dataTable.
     *
     * @return Builder
     */
    public function query(): Builder
    {
        return $this->repository->getByQueryBuilder([], ['category', 'area'], ['priority', 'desc']);
    }

    protected function setCustomColumns(): void
    {
        $this->customColumns = config('datatables_columns.store', []);
    }

    protected function setCustomEditColumns(): void
    {
        $this->customEditColumns = [
            'store_name' => $this->view['store_name'],
            'status' => $this->view['status'],
            'category' => $this->view['category'],
            'area' => $this->view['area'],
            'open_hours_1' => fn($store) => view($this->view['operating_time'], compact('store')),
            'created_at' => '{{ format_date($created_at) }}'
        ];
    }

    protected function setCustomAddColumns(): void
    {
        $this->customAddColumns = [
            'action' => $this->view['action'],
        ];
    }

    protected function setCustomRawColumns()
    {
        $this->customRawColumns = ['store_name', 'category', 'area', 'open_hours_1', 'status', 'action', 'view-product'];

    }

}
