<?php

namespace App\Admin\DataTables\Notification;

use App\Admin\DataTables\BaseDataTable;
use App\Admin\Repositories\Notification\NotificationRepositoryInterface;
use App\Admin\Repositories\User\UserRepositoryInterface;
use App\Admin\Traits\GetConfig;
use App\Enums\DefaultStatus;
use App\Enums\Notification\NotificationStatus;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTableAbstract;
use Yajra\DataTables\Html\Builder;


class NotificationDataTable extends BaseDataTable
{
    use GetConfig;

    protected $nameTable = 'notificationTable';

    protected $userRepository;

    public function __construct(
        NotificationRepositoryInterface $repository,
        UserRepositoryInterface $userRepository,
    ) {
        $this->repository = $repository;

        $this->userRepository = $userRepository;

        parent::__construct();
    }

    public function getView()
    {
        $this->view = [
            'action' => 'admin.notifications.datatable.action',
            'title' => 'admin.notifications.datatable.title',
            'edit_link' => 'admin.notifications.datatable.edit-link',
            'status' => 'admin.notifications.datatable.status',
            'checkbox' => 'admin.notifications.datatable.checkbox',
        ];
    }

    public function dataTable($query): DataTableAbstract
    {
        $this->instanceDataTable = datatables()->collection($query);
        $this->editColumnTitle();
        $this->editColumnEditLink();
        $this->editColumnCreatedAt();
        $this->addColumnAction();
        $this->rawColumnsNew();
        return $this->instanceDataTable;
    }

    public function html(): Builder
    {
        $this->instanceHtml = $this->builder()
            ->setTableId($this->nameTable)
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtip')
            ->orderBy(0)
            ->selectStyleSingle();

        $this->htmlParameters();

        return $this->instanceHtml;
    }

    public function query()
    {
        $admin_id = Auth::guard('admin')->user()->id;
        return $this->repository->getByAdminId($admin_id);
    }

    protected function setCustomColumns(): void
    {
        $this->customColumns = $this->traitGetConfigDatatableColumns('notification');
    }


    protected function editColumnTitle(): void
    {
        $this->instanceDataTable = $this->instanceDataTable->editColumn('title', $this->view['title']);
    }
    protected function editColumnEditLink(): void
    {
        $this->instanceDataTable = $this->instanceDataTable->editColumn('id', $this->view['edit-link']);
    }
    protected function editColumnCreatedAt(): void
    {
        $this->instanceDataTable = $this->instanceDataTable->editColumn('created_at', '{{ date("d-m-Y", strtotime($created_at)) }}');
    }
    protected function addColumnAction(): void
    {
        $this->instanceDataTable = $this->instanceDataTable->addColumn('action', $this->view['action']);
    }
    protected function rawColumnsNew(): void
    {
        $this->instanceDataTable = $this->instanceDataTable->rawColumns(['name', 'action']);
    }
    protected function htmlParameters(): void
    {

        $this->parameters['buttons'] = $this->actions;

        $this->parameters['initComplete'] = "function () {

             moveSearchColumnsDatatable('#{$this->nameTable}');

            searchColumsDataTable(this);
        }";

        $this->instanceHtml = $this->instanceHtml
            ->parameters($this->parameters);
    }
}
