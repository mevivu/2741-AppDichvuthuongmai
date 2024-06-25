<?php

namespace App\Admin\DataTables\PostCategory;

use App\Admin\DataTables\BaseDataTable;
use App\Admin\Repositories\PostCategory\PostCategoryRepositoryInterface;
use App\Enums\DefaultStatus;
use App\Models\PostCategory;


class PostCategoryDataTable extends BaseDataTable
{


    protected $nameTable = 'postCategoryTable';


    public function __construct(
        PostCategoryRepositoryInterface $repository
    )
    {
        $this->repository = $repository;

        parent::__construct();

    }

    public function setView(): void
    {
        $this->view = [
            'action' => 'admin.areas.datatable.action',
            'name' => 'admin.areas.datatable.name',
            'status' => 'admin.areas.datatable.status',
        ];
    }

    public function setColumnSearch(): void
    {

        $this->columnAllSearch = [0, 1, 2];

        $this->columnSearchDate = [2];

        $this->columnSearchSelect = [

            [
                'column' => 1,
                'data' => DefaultStatus::asSelectArray()
            ],
        ];
    }

    public function query()
    {
        $ids = $this->repository->getFlatTree()->pluck('id');
        return PostCategory::whereIn('id', $ids);
    }

    protected function setCustomColumns(): void
    {
        $this->customColumns = config('datatables_columns.post_category', []);
    }

    protected function setCustomEditColumns(): void
    {
        $this->customEditColumns = [
            'name' => $this->view['name'],
            'created_at' => '{{ format_date($created_at) }}',
            'status' => $this->view['status'],
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
        $this->customRawColumns = ['name', 'action', 'status'];
    }



}
