<?php

namespace App\Admin\DataTables\User;

use App\Admin\DataTables\BaseDataTable;
use App\Admin\Repositories\User\UserRepositoryInterface;
use App\Admin\Traits\GetConfig;

class UserDataTable extends BaseDataTable
{
    use GetConfig;

    protected array $actions = ['reset', 'reload'];

    public function __construct(UserRepositoryInterface $repository)
    {
        parent::__construct();
        $this->repository = $repository;
    }

    public function getView()
    {
        return [
            'action' => 'admin.users.datatable.action',
            'editlink' => 'admin.users.datatable.editlink',
        ];
    }

    public function dataTable($query)
    {
        $this->instanceDataTable = datatables()->eloquent($query)->addIndexColumn();
        $this->filterColumnCreatedAt();
        $this->filterColumnGender();
        $this->filterColumnVip();
        $this->editColumnFullname();
        $this->editColumnGender();
        $this->editColumnVip();
        $this->editColumnCreatedAt();
        $this->addColumnAction();
        $this->rawColumnsNew();
        return $this->instanceDataTable;
    }

    public function query()
    {
        return $this->repository->getQueryBuilderOrderBy();
    }

    public function html()
    {
        $this->instanceHtml = $this->builder()
            ->setTableId('userTable')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtip')
            ->orderBy(0)
            ->selectStyleSingle();

        $this->htmlParameters();

        return $this->instanceHtml;
    }

    protected function setCustomColumns()
    {
        $this->customColumns = $this->traitGetConfigDatatableColumns('user');
    }

    protected function filename(): string
    {
        return 'User_' . date('YmdHis');
    }

    protected function setColumnSearch()
    {
        // Implement your column search logic here
        // Example:
        // $query->where('column_name', 'like', '%' . $searchValue . '%');
    }

    protected function filterColumnGender()
    {
        $this->instanceDataTable = $this->instanceDataTable
            ->filterColumn('gender', function ($query, $keyword) {
                $query->where('gender', $keyword);
            });
    }

    protected function filterColumnVip()
    {
        $this->instanceDataTable = $this->instanceDataTable
            ->filterColumn('vip', function ($query, $keyword) {
                $query->where('vip', $keyword);
            });
    }

    protected function filterColumnCreatedAt()
    {
        $this->instanceDataTable = $this->instanceDataTable->filterColumn('created_at', function ($query, $keyword) {
            $query->whereDate('created_at', date('Y-m-d', strtotime($keyword)));
        });
    }

    protected function editColumnId()
    {
        $this->instanceDataTable = $this->instanceDataTable->editColumn('id', $this->view['editlink']);
    }

    protected function editColumnFullname()
    {
        $this->instanceDataTable = $this->instanceDataTable->editColumn('fullname', $this->view['editlink']);
    }

    protected function editColumnGender()
    {
        $this->instanceDataTable = $this->instanceDataTable->editColumn('gender', function ($admin) {
            return $admin->gender->description;
        });
    }

    protected function editColumnVip()
    {
        $this->instanceDataTable = $this->instanceDataTable->editColumn('vip', function ($admin) {
            return $admin->vip->description;
        });
    }

    protected function editColumnCreatedAt()
    {
        $this->instanceDataTable = $this->instanceDataTable->editColumn('created_at', '{{ date("d-m-Y", strtotime($created_at)) }}');
    }

    protected function addColumnAction()
    {
        $this->instanceDataTable = $this->instanceDataTable->addColumn('action', $this->view['action']);
    }

    protected function rawColumnsNew()
    {
        $this->instanceDataTable = $this->instanceDataTable->rawColumns(['fullname', 'action']);
    }

    protected function htmlParameters()
    {
        $this->parameters['buttons'] = $this->actions;

        $this->parameters['initComplete'] = "function () {
            moveSearchColumnsDatatable('#userTable');
            searchColumsDataTable(this);
        }";

        $this->instanceHtml = $this->instanceHtml
            ->parameters($this->parameters);

    protected function setColumnSearch()
    {
        // TODO: Implement setColumnSearch() method.
    }

}
