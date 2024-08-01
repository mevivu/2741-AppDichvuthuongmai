<?php

namespace App\Admin\DataTables\Product;

use App\Admin\DataTables\BaseDataTable;
use App\Admin\Repositories\Category\CategoryRepositoryInterface;
use App\Admin\Repositories\Product\ProductRepositoryInterface;
use App\Admin\Repositories\Topping\ToppingRepositoryInterface;

class ProductDataTable extends BaseDataTable
{


    protected $nameTable = 'productTable';
    protected CategoryRepositoryInterface $repoCat;
    protected ToppingRepositoryInterface $toppingRepository;


    public function __construct(
        ProductRepositoryInterface $repository,
        CategoryRepositoryInterface $repoCat,
        ToppingRepositoryInterface $toppingRepository
    ) {
        $this->repository = $repository;
        $this->repoCat = $repoCat;
        $this->toppingRepository = $toppingRepository;
        parent::__construct();
    }

    public function setView(): void
    {
        $this->view = [
            'action' => 'admin.products.datatable.action',
            'avatar' => 'admin.products.datatable.avatar',
            'edit_link' => 'admin.products.datatable.editlink',
            'instock' => 'admin.products.datatable.instock',
            'price' => 'admin.products.datatable.price',
            'categories' => 'admin.products.datatable.categories',
            'toppings' => 'admin.products.datatable.toppings'



        ];
    }

    public function setColumnSearch(): void
    {

        $this->columnAllSearch = [1, 2, 4, 5, 6];

        $this->columnSearchDate = [6];
        $this->columnSearchSelect = [
            [
                'column' => 2,
                'data' => [1 => __('Còn hàng'), 0 => __('Hết hàng')]
            ]
        ];
        $this->columnSearchSelect2 = [
            [
                'column' => 4,
                'data' => $this->repoCat->getFlatTree()->map(function ($category) {
                    return [$category->id => $category->name];
                })
            ],
            [
                'column' => 5,
                'data' => $this->toppingRepository->getFlatTree()->map(function ($item) {
                    return [$item->id => $item->name];
                })
            ]
        ];


    }

    public function query()
    {
        return $this->repository->getQueryBuilderWithRelations();
    }

    protected function setCustomColumns(): void
    {
        $this->customColumns = config('datatables_columns.product', []);
    }

    protected function setCustomEditColumns(): void
    {
        $this->customEditColumns = [
            'name' => $this->view['edit_link'],
            'avatar' => $this->view['avatar'],
            'in_stock' => $this->view['instock'],
            'categories' => $this->view['categories'],
            'toppings' => $this->view['toppings'],
            'created_at' => '{{ format_date($created_at) }}',
        ];
    }

    protected function setCustomAddColumns(): void
    {
        $this->customAddColumns = [
            'action' => $this->view['action'],
            'price' => $this->view['price'],
        ];
    }

    protected function setCustomRawColumns(): void
    {
        $this->customRawColumns = ['action', 'avatar', 'name', 'in_stock', 'price', 'categories', 'toppings'];
    }

    protected function setCustomFilterColumns(): void
    {
        $this->customFilterColumns = [
            'categories' => fn($query, $keyword) => $query->whereRelation('categories', fn($q) => $q->whereIn('id', explode(',', $keyword))),
            'toppings' => fn($query, $keyword) => $query->whereRelation('toppings', fn($q) => $q->whereIn('id', explode(',', $keyword)))
        ];
    }


}
