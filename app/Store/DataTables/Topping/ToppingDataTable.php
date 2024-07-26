<?php

namespace App\Store\DataTables\Topping;

use App\Admin\DataTables\BaseDataTable;
use App\Admin\Repositories\Product\ToppingRepositoryInterface;
use App\Enums\Product\Type;
use App\Traits\AuthService;
use Illuminate\Database\Eloquent\Builder;

class ToppingDataTable extends BaseDataTable
{
    use AuthService;

    protected $nameTable = 'toppingTable';

    public function __construct(
        ToppingRepositoryInterface $repository
    )
    {
        $this->repository = $repository;

        parent::__construct();

    }

    public function setView(): void
    {
        $this->view = [
            'action' => 'stores.toppings.datatable.action',
            'edit_link' => 'stores.toppings.datatable.edit-link',
            'type' => 'stores.toppings.datatable.type',
            'obligatory' => 'stores.toppings.datatable.obligatory',
        ];
    }

    public function setColumnSearch(): void
    {

        $this->columnAllSearch = [0,1];

        $this->columnSearchSelect = [

        ];

    }

    /**
     * Get query source of dataTable.
     * @return Builder
     */
    public function query(): Builder
    {
        return $this->repository->getByQueryBuilder(['store_id' => $this->getCurrentStoreId()]);
    }

    protected function setCustomColumns(): void
    {
        $this->customColumns = config('datatables_columns.topping', []);
    }

    protected function setCustomEditColumns(): void
    {
        $this->customEditColumns = [
            'name' => $this->view['edit_link'],
            'created_at' => '{{ format_date($created_at) }}',
            'type' => $this->view['type'],
            'obligatory' => $this->view['obligatory'],
            'price' => '{{ format_price($price) }}',
        ];
    }

    protected function setCustomAddColumns(): void
    {
        $this->customAddColumns = [
            'action' => $this->view['action'],
        ];
    }

    protected function setCustomRawColumns(): void
    {
        $this->customRawColumns = ['action', 'type', 'obligatory', 'name'];
    }
}

