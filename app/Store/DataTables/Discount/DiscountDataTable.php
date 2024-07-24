<?php

namespace App\Store\DataTables\Discount;

use App\Admin\DataTables\BaseDataTable;
use App\Admin\Repositories\Discount\DiscountApplicationRepositoryInterface;
use App\Enums\DiscountType;
use App\Traits\AuthService;
use Illuminate\Database\Eloquent\Builder;

class DiscountDataTable extends BaseDataTable
{
    use AuthService;
    protected $nameTable = 'discountTable';

    public function __construct(
        DiscountApplicationRepositoryInterface $repository
    ){
        $this->repository = $repository;

        parent::__construct();

    }

    public function setView(): void
    {
        $this->view = [
            'action' => 'stores.discounts.datatable.action',
            'title'=>'stores.discounts.datatable.title',
            'edit_link' => 'stores.discounts.datatable.edit-link',
            'type' => 'stores.discounts.datatable.type',
            'startday' => 'stores.discounts.datatable.startday',
            'date_end' => 'stores.discounts.datatable.date_end',
            'min_order_amount' => 'stores.discounts.datatable.min_order_amount',
            'discount_value' => 'stores.discounts.datatable.discount_value',
            'max_usage' => 'stores.discounts.datatable.max_usage',
        ];
    }

    public function setColumnSearch(): void
    {

        $this->columnAllSearch = [0,5];

        $this->columnSearchSelect = [
            [
                'column' => 5,
                'data' => DiscountType::asSelectArray()
            ]
        ];

    }

    /**
     * Get query source of dataTable.
     *
     * @return Builder
     */
    public function query(): Builder
    {
        $query = $this->repository->getByQueryBuilder(['store_id' => $this->getCurrentStoreId()]);
          return $query->whereHas('discountCode', function ($query) {
        });
    }

    protected function setCustomColumns(): void
    {
        $this->customColumns = config('datatables_columns.discountStore', []);
    }

    protected function setCustomEditColumns(): void
    {
        $this->customEditColumns = [
            'code' => function ($stores) {
                return view($this->view['edit_link'],
                    [
                        'code' => $stores->discountCode->code,
                        'id' => $stores->discount_code_id,
                    ]
                )->render();
            },
            'date_start' => function ($stores) {
                return view($this->view['startday'],
                    [
                        'startday'=>format_date($stores->discountCode->date_start),
                    ]
                )->render();
            },
            'date_end' => function ($stores) {
                return view($this->view['date_end'],
                    [
                        'date_end'=>format_date($stores->discountCode->date_end),
                    ]
                )->render();
            },
            'max_usage' => function ($stores) {
                return view($this->view['max_usage'],
                    [
                        'max_usage'=>$stores->discountCode->max_usage,
                    ]
                )->render();
            },
            'min_order_amount' => function ($stores) {
                return view($this->view['min_order_amount'],
                    [
                        'min_order_amount'=>format_price($stores->discountCode->min_order_amount),
                    ]
                )->render();
            },
            'type' => function ($stores) {
                return view($this->view['type'],
                    [
                        'type'=>$stores->discountCode->type,
                    ]
                )->render();
            },
            'discount_value' => function ($stores) {
                return view($this->view['discount_value'],
                    [
                        'discount_value'=>format_price($stores->discountCode->discount_value),
                    ]
                )->render();
            },
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
        $this->customRawColumns = ['action', 'code','date_start','date_end','max_usage','min_order_amount','type','discount_value'];
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
