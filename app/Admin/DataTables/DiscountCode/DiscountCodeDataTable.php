<?php

namespace App\Admin\DataTables\DiscountCode;

use App\Admin\DataTables\BaseDataTable;
use App\Admin\Repositories\DiscountCode\DiscountCodeRepositoryInterface;
use App\Admin\Traits\GetConfig;


class DiscountCodeDataTable extends BaseDataTable
{

    use GetConfig;

    // ID ( Client ) của bảng DataTable
    protected $nameTable = 'discountCodeTable';

    /**
     * Available button actions. When calling an action, the value will be used
     * as the function name (so it should be available)
     * If you want to add or disable an action, overload and modify this property.
     *
     * @var array
     */
    // protected array $actions = ['pageLength', 'excel', 'reset', 'reload'];
    protected array $actions = ['reset', 'reload'];

    public function __construct(
        DiscountCodeRepositoryInterface $repository
    ) {
        parent::__construct();

        $this->repository = $repository;
    }

    public function setView()
    {
        $this->view = [
            'status' => 'admin.discount_code.datatable.status',
            'action' => 'admin.discount_code.datatable.action',
            'editlink' => 'admin.discount_code.datatable.editlink',
        ];
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     * Hàm thực thi gọi lệnh truy xuất từ Database ( Repository )
     */
    public function query()
    {
        return $this->repository->getQueryBuilderOrderBy();
    }

    /**
     * Get columns.
     *
     * @return array
     * Hàm kết nối tới datatable_columns Config
     */

    protected function setCustomColumns(): void
    {
        $this->customColumns = config('datatables_columns.discount_code', []);
    }

    protected function setCustomEditColumns()
    {
        $this->customEditColumns = [
            'status' => $this->view['status'],
            'apply_date' => '{{ date("d-m-Y", strtotime($apply_date)) }}',
            'expiration_date' => '{{ date("d-m-Y", strtotime($expiration_date)) }}',
            'name' => $this->view['editlink'],
            'discount' => '{{ format_price($discount) }}',
        ];
    }
    protected function setCustomAddColumns()
    {
        $this->customAddColumns = [
            'action' => $this->view['action'],
        ];
    }

    protected function setCustomRawColumns()
    {
        $this->customRawColumns = ['name', 'action', 'status', 'apply_date', 'expiration_date', 'discount'];
    }


    protected function setColumnSearch()
    {
        // TODO: Implement setColumnSearch() method.
    }
}
