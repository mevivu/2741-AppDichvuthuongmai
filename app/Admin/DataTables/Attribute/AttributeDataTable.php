<?php

namespace App\Admin\DataTables\Attribute;

use App\Admin\DataTables\BaseDataTable;
use App\Admin\Repositories\Attribute\AttributeRepositoryInterface;


class AttributeDataTable extends BaseDataTable
{


    protected $nameTable = 'attributeTable';


    public function __construct(
        AttributeRepositoryInterface $repository
    )
    {
        $this->repository = $repository;

        parent::__construct();

    }

    public function setView(): void
    {
        $this->view = [
            'action' => 'admin.attributes.datatable.action',
            'editlink' => 'admin.attributes.datatable.editlink',
            'variations' => 'admin.attributes.datatable.variations',
        ];
    }

    public function setColumnSearch(): void
    {

        $this->columnAllSearch = [0, 1, 2];


    }

    public function query()
    {
        return $this->repository->getQueryBuilderWithRelations();
    }

    protected function setCustomColumns(): void
    {
        $this->customColumns = config('datatables_columns.attribute', []);

    }

    protected function setCustomEditColumns(): void
    {
        $this->customEditColumns = [
            'created_at' => '{{ format_date($created_at) }}',
            'name' => $this->view['editlink'],
            'variations' => $this->view['variations'],
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
        $this->customRawColumns = ['name', 'action', 'variations'];
    }


}
