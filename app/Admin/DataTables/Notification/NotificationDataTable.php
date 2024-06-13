<?php

namespace App\Admin\DataTables\Notification;

use App\Admin\DataTables\BaseDataTable;
use App\Admin\Repositories\Notification\NotificationRepositoryInterface;
use App\Admin\Repositories\User\UserRepositoryInterface;
use App\Enums\DefaultStatus;
use App\Enums\Notification\NotificationStatus;
use Illuminate\Support\Facades\Auth;


class NotificationDataTable extends BaseDataTable
{
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

    public function setView()
    {
        $this->view = [
            'action' => 'admin.notifications.datatable.action',
            'title' => 'admin.notifications.datatable.title',
            'edit_link' => 'admin.notifications.datatable.edit-link',
            'status' => 'admin.notifications.datatable.status',
            'checkbox' => 'admin.notifications.datatable.checkbox',
        ];
    }

    public function setColumnSearch()
    {
        $this->columnAllSearch = [1,2, 3, 4];
        $this->columnSearchDate = [4];

        $this->columnSearchSelect = [
            [
                'column' => 3,
                'data' => NotificationStatus::asSelectArray(),
            ],
        ];

    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Customer $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $admin_id = Auth::guard('admin')->user()->id;
        return $this->repository->getByAdminId($admin_id);
    }

    protected function setCustomColumns()
    {
        $this->customColumns = config('datatables_columns.notifications', ['user']);
    }

    protected function setCustomEditColumns()
    {
        $this->customEditColumns = [
            'title' => $this->view['title'],
            'user_id' => $this->view['edit_link'],
            'status' => $this->view['status'],
            'created_at' => '{{ format_date($created_at) }}',
        ];
    }

    protected function setCustomAddColumns()
    {
        $this->customAddColumns = [
            'action' => $this->view['action'],
            'checkbox' => $this->view['checkbox'],
        ];
    }

    protected function setCustomRawColumns()
    {
        $this->customRawColumns = ['action', 'status', 'checkbox', 'user_id', 'title'];
    }

    protected function startBuilderDataTable($query)
    {
        $this->instanceDataTable = datatables()->eloquent($query)->addIndexColumn();
    }
}
