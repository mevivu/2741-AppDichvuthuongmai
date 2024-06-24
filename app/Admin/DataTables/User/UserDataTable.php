<?php

namespace App\Admin\DataTables\User;

use App\Admin\DataTables\BaseDataTable;
use App\Admin\Repositories\User\UserRepositoryInterface;
use App\Admin\Traits\Roles;
use App\Enums\User\Gender;
use Illuminate\Database\Eloquent\Builder;

class UserDataTable extends BaseDataTable
{
    use Roles;

    protected $nameTable = 'userTable';

    public function __construct(
        UserRepositoryInterface $repository
    )
    {
        $this->repository = $repository;

        parent::__construct();
    }

    public function setView(): void
    {
        $this->view = [
            'action' => 'admin.users.datatable.action',
            'fullname' => 'admin.users.datatable.fullname',
            'role' => 'admin.users.datatable.role',

        ];
    }

    public function setColumnSearch(): void
    {

        $this->columnAllSearch = [0, 1, 2, 3,4];

        $this->columnSearchDate = [4];

        $this->columnSearchSelect = [
            [
                'column' => 3,
                'data' => Gender::asSelectArray()
            ],

        ];
    }

    /**
     * Get query source of dataTable.
     *
     * @return Builder
     */
    public function query(): Builder
    {
        return $this->repository->getQueryBuilderOrderBy()->whereHas('roles', function ($query) {
            $query->where('name', $this->getRoleCustomer());
        });
    }

    protected function setCustomColumns(): void
    {
        $this->customColumns = config('datatables_columns.user', []);
    }

    protected function setCustomEditColumns(): void
    {
        $this->customEditColumns = [
            'fullname' => $this->view['fullname'],
            'gender' => function ($user) {
                return $user->gender->description();
            },

            'created_at' => '{{ format_date($created_at) }}'
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
        $this->customRawColumns = ['fullname', 'area_id', 'action', ];
    }

    public function setCustomFilterColumns(): void
    {
        $this->customFilterColumns = [
//            'area_id' => function ($query, $keyword) {
//                $query->whereHas('area', function ($subQuery) use ($keyword) {
//                    $subQuery->where('name', 'like', '%' . $keyword . '%');
//                });
//            },
        ];
    }


}
