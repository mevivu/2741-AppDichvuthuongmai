<?php

namespace App\Admin\DataTables\Notification;

use App\Admin\DataTables\BaseDataTable;
use App\Admin\Repositories\Notification\NotificationRepositoryInterface;
use App\Admin\Repositories\User\UserRepositoryInterface;
use App\Enums\Notification\NotificationStatus;

class NotificationDataTable extends BaseDataTable
{

    protected $nameTable = 'notificationTable';

    protected $userRepository;

    public function __construct(
        NotificationRepositoryInterface $repository,
        UserRepositoryInterface         $userRepository,
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
            'edit_link_store' => 'admin.notifications.datatable.edit-link-store',
            'edit_link_driver' => 'admin.notifications.datatable.edit-link-driver',
            'edit_link_customer' => 'admin.notifications.datatable.edit-link-customer',
            'status' => 'admin.notifications.datatable.status',
            'checkbox' => 'admin.notifications.datatable.checkbox',
        ];
    }

    public function setColumnSearch()
    {
        $this->columnAllSearch = [4, 5, 6];
        $this->columnSearchDate = [6];

        $this->columnSearchSelect = [
            [
                'column' => 5,
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
        // return $this->repository->getQueryBuilderOrderBy();
        $result = $this->repository->getQueryBuilderOrderBy()
            ->select('notifications.*')
            ->with(['driver.user', 'user', 'store']);
        return $result;
    }

    protected function setCustomColumns()
    {
        $this->customColumns = config('datatables_columns.notifications', ['driver']);
    }

    protected function setCustomEditColumns()
    {
        $this->customEditColumns = [
            'title' => $this->view['title'],
            'status' => $this->view['status'],
            'store_id' => $this->view['edit_link_store'],
            'driver_id' => $this->view['edit_link_driver'],
            'user_id' => $this->view['edit_link_customer'],
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
        $this->customRawColumns = ['action', 'status', 'checkbox', 'store_id', 'user_id', 'driver_id', 'title'];
    }

    protected function startBuilderDataTable($query)
    {
        $this->instanceDataTable = datatables()->eloquent($query)->addIndexColumn();
    }
}
