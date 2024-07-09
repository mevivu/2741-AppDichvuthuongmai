<?php

namespace App\Admin\DataTables\Topping;

use App\Admin\DataTables\BaseDataTable;
use App\Admin\Repositories\Topping\ToppingRepositoryInterface;
use App\Enums\Product\Type;

//use App\Enums\Product\Type;

class ToppingDataTable extends BaseDataTable
{

    protected $nameTable = 'toppingTable';

    public function __construct(
        ToppingRepositoryInterface $repository
    ){
        $this->repository = $repository;

        parent::__construct();

    }

    public function setView(){
        $this->view = [
            'action' => 'stores.toppings.datatable.action',
            'edit_link' => 'stores.toppings.datatable.edit-link',
            'avatar' => 'stores.toppings.datatable.avatar',
            'price' => 'stores.toppings.datatable.price',
        ];
    }

    public function setColumnSearch(){

        $this->columnAllSearch = [0,1];

        $this->columnSearchSelect = [

        ];

    }

    /**
     * Get query source of dataTable.
     *return $this->repository->getByQueryBuilder(['store_id' => $this->slider->id]); items
     * @param \App\Models\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        return $this->repository->getQueryBuilder();
    }

    protected function setCustomColumns(){
        $this->customColumns = config('datatables_columns.topping', []);
    }

    protected function setCustomEditColumns(){
        $this->customEditColumns = [
            'name' => $this->view['edit_link'],
            'avatar' => $this->view['avatar'],
            'created_at' => '{{ format_date($created_at) }}',
        ];
    }

    protected function setCustomAddColumns(){
        $this->customAddColumns = [
            'action' => $this->view['action'],
        ];
    }

    protected function setCustomRawColumns(){
        $this->customRawColumns = ['action','name','avatar', 'price'];
    }
}

