<?php

namespace App\Admin\DataTables\Store;

use App\Admin\DataTables\BaseDataTable;
use App\Admin\Repositories\Store\StoreRepositoryInterface;
use App\Enums\Store\StoreStatus;

class StoreDataTable extends BaseDataTable
{

    protected $nameTable = 'storeTable';

    public function __construct(
        StoreRepositoryInterface $repository
    ){
        $this->repository = $repository;

        parent::__construct();
    }

    public function setView(){
        $this->view = [
            'action' => 'admin.stores.datatable.action',
            'store_name' => 'admin.stores.datatable.store-name',
            'operating_time' => 'admin.stores.datatable.operating-time',
            'status' => 'admin.stores.datatable.status',
            'category' => 'admin.stores.datatable.category',
            'area' => 'admin.stores.datatable.area',
        ];
    }

    public function setColumnSearch(){

        $this->columnAllSearch = [0, 1, 2, 3, 5, 6];

        $this->columnSearchDate = [6];

        $this->columnSearchSelect = [
            [
                'column' => 5,
                'data' => StoreStatus::asSelectArray()
            ]
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
        return $this->repository->getByQueryBuilder([], ['category', 'area'], ['priority', 'desc'])->get();
    }

    protected function setCustomColumns(){
        $this->customColumns = config('datatables_columns.store', []);
    }

    protected function setCustomEditColumns(){
        $this->customEditColumns = [
            'store_name' => $this->view['store_name'],
            'status' => $this->view['status'],
            'category_id' => $this->view['category'],
            'area_id' => $this->view['area'],
            'open_hours_1' => fn($store) => view($this->view['operating_time'], compact('store')),
            'created_at' => '{{ format_date($created_at) }}'
        ];
    }

    protected function setCustomAddColumns(){
        $this->customAddColumns = [
            'action' => $this->view['action'],
        ];
    }

    protected function setCustomRawColumns(){
        $this->customRawColumns = ['store_name', 'category_id', 'area_id', 'open_hours_1', 'status', 'action'];
    }
}
