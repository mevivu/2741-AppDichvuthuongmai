<?php

namespace App\Admin\DataTables\Post;

use App\Admin\DataTables\BaseDataTable;
use App\Admin\Repositories\Post\PostRepositoryInterface;
use App\Admin\Traits\GetConfig;

class PostDataTable extends BaseDataTable
{

    use GetConfig;
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
        PostRepositoryInterface $repository
    ){
        parent::__construct();

        $this->repository = $repository;
    }

    public function getView(){
        $this->view = [
            'action' => 'admin.posts.datatable.action',
            'image' => 'admin.posts.datatable.image',
            'editlink' => 'admin.posts.datatable.editlink',
            'status' => 'admin.posts.datatable.status',
            'is_featured' => 'admin.posts.datatable.is-featured',
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


    protected function setCustomRawColumns(){
        $this->customRawColumns = ['image', 'title', 'status', 'is_featured', 'action'];
    }


    protected function setColumnSearch()
    {
        // TODO: Implement setColumnSearch() method.
    }
}
