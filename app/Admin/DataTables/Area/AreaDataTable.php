<?php

namespace App\Admin\DataTables\Area;

use App\Admin\DataTables\BaseDataTable;
use App\Admin\Repositories\Area\AreaRepositoryInterface;
use App\Admin\Traits\GetConfig;


class AreaDataTable extends BaseDataTable
{

    use GetConfig;

    protected $nameTable = 'areaTable';


    protected array $actions = ['reset', 'reload'];

    public function __construct(
        AreaRepositoryInterface $repository
    ){
        parent::__construct();

        $this->repository = $repository;
    }

    public function getView(): array
    {
        return [

            'name' => 'admin.areas.datatable.name',
            'action' => 'admin.areas.datatable.name',
        ];
    }


    public function query()
    {
        return $this->repository->getAll();
    }




    protected function setCustomColumns(): void
    {
        $this->customColumns = $this->traitGetConfigDatatableColumns('area');
    }



    protected function setCustomEditColumns(): void
    {
        $this->customEditColumns = [
            'name' => $this->view['name'],
            'created_at' => '{{ format_date($created_at) }}',
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
        $this->customRawColumns = ['action', 'name'];
    }
    public function setCustomFilterColumns(): void
    {
        $this->customFilterColumns = [


        ];
    }


}
