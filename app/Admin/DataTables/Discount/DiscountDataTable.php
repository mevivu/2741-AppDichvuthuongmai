<?php

namespace App\Admin\DataTables\Discount;

use App\Admin\DataTables\BaseDataTable;
use App\Admin\Repositories\Discount\DiscountRepositoryInterface;
use App\Enums\Discount\DiscountType;
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
            'stores' => 'admin.discounts.datatable.stores',
            'users' => 'admin.discounts.datatable.users',
            'drivers' => 'admin.discounts.datatable.drivers',
            'products' => 'admin.discounts.datatable.products',
            'type' => 'admin.discounts.datatable.type',
        ];
    }

    public function setColumnSearch(): void
    {

        $this->columnAllSearch = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10];

        $this->columnSearchDate = [5, 6];

        $this->columnSearchSelect = [
            [
                'column' => 9,
                'data' => DiscountType::asSelectArray()
            ],
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
            'stores' => function ($discount) {
                $stores = $discount->stores;
                return view($this->view['stores'], [
                    'stores' => $stores
                ])->render();
            },
            'drivers' => function ($discount) {
                $drivers = $discount->drivers;
                return view($this->view['drivers'], [
                    'drivers' => $drivers
                ])->render();
            },
            'products' => function ($discount) {
                $products = $discount->products;
                return view($this->view['products'], [
                    'products' => $products
                ])->render();
            },
            'users' => function ($discount) {
                $users = $discount->users;
                return view($this->view['users'], [
                    'users' => $users
                ])->render();
            }

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
        $this->customRawColumns = ['action', 'code', 'stores', 'users', 'drivers', 'products', 'type'];
    }

    public function setCustomFilterColumns(): void
    {
        $this->customFilterColumns = [
            'users' => function ($query, $keyword) {
                $query->whereHas('users', function ($subQuery) use ($keyword) {
                    $subQuery->where('fullname', 'like', '%' . $keyword . '%');
                });
            },
            'stores' => function ($query, $keyword) {
                $query->whereHas('stores', function ($subQuery) use ($keyword) {
                    $subQuery->where('store_name', 'like', '%' . $keyword . '%');
                });
            },
            'products' => function ($query, $keyword) {
                $query->whereHas('products', function ($subQuery) use ($keyword) {
                    $subQuery->where('name', 'like', '%' . $keyword . '%');
                });
            },
            'drivers' => function ($query, $keyword) {
                $query->whereHas('drivers.user', function ($subQuery) use ($keyword) {
                    $subQuery->where('fullname', 'like', '%' . $keyword . '%');
                });
            },
        ];
    }
}
