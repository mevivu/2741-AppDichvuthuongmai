<?php

namespace App\Admin\DataTables\Post;

use App\Admin\DataTables\BaseDataTable;
use App\Admin\Repositories\Post\PostRepositoryInterface;
use App\Admin\Traits\GetConfig;
use App\Enums\FeaturedStatus;
use App\Enums\Post\PostStatus;

class PostDataTable extends BaseDataTable
{

    use GetConfig;
    protected $nameTable = 'PostTable';
    protected array $actions = ['reset', 'reload'];

    public function __construct(
        PostRepositoryInterface $repository
    ) {
        parent::__construct();

        $this->repository = $repository;
    }

    public function setView()
    {
        $this->view = [
            'action' => 'admin.posts.datatable.action',
            'image' => 'admin.posts.datatable.image',
            'editlink' => 'admin.posts.datatable.editlink',
            'status' => 'admin.posts.datatable.status',
            'is_featured' => 'admin.posts.datatable.is-featured'
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
        return $this->repository->getQueryBuilderOrderBy();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */

    /**
     * Get columns.
     *
     * @return array
     */
    protected function setCustomColumns(): void
    {
        $this->customColumns = config('datatables_columns.post', []);
    }

    protected function setCustomEditColumns()
    {
        $this->customEditColumns = [
            'image' => $this->view['image'],
            'status' => $this->view['status'],
            'title' => $this->view['editlink'],
            'is_featured' => $this->view['is_featured'],
            'created_at' => '{{ date("d-m-Y", strtotime($created_at)) }}',
        ];
    }

    protected function setCustomAddColumns()
    {
        $this->customAddColumns = [
            'action' => $this->view['action'],
        ];
    }

    protected function filename(): string
    {
        return 'Posts_' . date('YmdHis');
    }


    protected function setCustomRawColumns()
    {
        $this->customRawColumns = ['image', 'title', 'status', 'is_featured', 'action'];
    }


    public function setColumnSearch(): void
    {

        $this->columnAllSearch = [1, 2, 3, 4];

        $this->columnSearchDate = [4];

        $this->columnSearchSelect = [
            [
                'column' => 2,
                'data' => PostStatus::asSelectArray()
            ],
            [
                'column' => 3,
                'data' => FeaturedStatus::asSelectArray()
            ],
        ];
    }
}
