<?php

namespace App\Admin\DataTables\Category;

use App\Admin\DataTables\BaseDataTable;
use App\Admin\Repositories\Category\CategoryRepositoryInterface;
use App\Admin\Traits\GetConfig;

class CategoryDataTable extends BaseDataTable
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
        CategoryRepositoryInterface $repository
    ){
        parent::__construct();

        $this->repository = $repository;
    }

    public function setView(){
        $this->view = [
            'action' => 'admin.categories.datatable.action',
            'editlink' => 'admin.categories.datatable.editlink',
            'avatar' => 'admin.categories.datatable.avatar',
            'is_active' => 'admin.categories.datatable.is_active',
        ];
    }


    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Category $model
     * @return \Illuminate\Database\Eloquent\Collection
     */

    public function query()
    {
        $query = $this->repository->getQueryBuilderOrderBy();
//        $query = $this->filterIsActive($query);
        return $query;
    }

    protected function setCustomEditColumns()
    {
        $this->customEditColumns = [
            'id' => $this->view['editlink'],
            'name' => $this->view['editlink'],
            'avatar' => $this->view['avatar'],
            'is_active' => $this->view['is_active'],
            'created_at' => '{{ date("d-m-Y", strtotime($created_at)) }}',
        ];
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function setCustomColumns(): void
    {
        $this->customColumns = config('datatables_columns.category', []);
    }

    protected function setCustomAddColumns()
    {
        $this->customAddColumns = [
            'action' => $this->view['action'],
        ];
    }

    protected function filename(): string
    {
        return 'Category_' . date('YmdHis');
    }

    protected function filterIsActive($query){
        $value = request('columns.2.search.value');
        if ($value !== null){
            $query = $query->where('is_active', 0);
        }
        return $query;
    }
    protected function setCustomRawColumns(){
        $this->customRawColumns = ['name', 'avatar', 'is_active', 'action'];
    }

    protected function setColumnSearch()
    {
        // TODO: Implement setColumnSearch() method.
    }
}
