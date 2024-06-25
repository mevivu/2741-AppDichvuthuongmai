<?php

namespace App\Admin\DataTables\Discount;

use App\Admin\DataTables\BaseDataTable;
use App\Admin\Repositories\Discount\DiscountRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;

class DiscountDataTable extends BaseDataTable
{

    protected $nameTable = 'discountTable';

    public function __construct(
        DiscountRepositoryInterface $repository
    )
    {
        $this->repository = $repository;

        parent::__construct();

    }

    public function setView(): void
    {
        $this->view = [
            'action' => 'admin.discounts.datatable.action',
            'title' => 'admin.discounts.datatable.title',
            'edit_link' => 'admin.discounts.datatable.edit-link',
        ];
    }

    public function setColumnSearch(): void
    {

        $this->columnAllSearch = [0, 1, 2, 3, 4, 5, 6];

        $this->columnSearchDate = [5, 6];

        $this->columnSearchSelect = [

        ];

    }

    /**
     * Get query source of dataTable.
     *
     * @return Builder
     */
    public function query(): Builder
    {
        return $this->repository->getByQueryBuilder([], ['stores', 'users', 'products', 'drivers']);

    }

    protected function setCustomColumns(): void
    {
        $this->customColumns = config('datatables_columns.discount', []);
    }

    protected function setCustomEditColumns(): void
    {
        $this->customEditColumns = [

            'code' => $this->view['edit_link'],
            'date_end' => '{{ format_datetime($date_end) }}',
            'date_start' => '{{ format_datetime($date_start) }}',
            'min_order_amount' => '{{ format_price($min_order_amount) }}',
            'discount_value' => '{{ format_price($discount_value) }}',

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
        $this->customRawColumns = ['action', 'code',];
    }

    public function setCustomFilterColumns(): void
    {
        $this->customFilterColumns = [
            'code' => function ($query, $keyword) {
                $query->whereHas('discountCode', function ($subQuery) use ($keyword) {
                    $subQuery->where('code', 'like', '%' . $keyword . '%');
                });
            },
            'type' => function ($query, $keyword) {
                $query->whereHas('discountCode', function ($subQuery) use ($keyword) {
                    $subQuery->where('type', 'like', '%' . $keyword . '%');
                });
            },
        ];
    }
}
