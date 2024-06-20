<?php

namespace App\Admin\DataTables\Rates;

use App\Admin\DataTables\BaseDataTable;
use App\Admin\Repositories\Rate\RateRepositoryInterface;
use App\Models\Rates;

class RatesDataTable extends BaseDataTable
{

    protected $nameTable = 'RatesTable';

    public function __construct(
        RateRepositoryInterface $repository
    ){
        $this->repository = $repository;

        parent::__construct();

    }

    public function setView(){
        $this->view = [
            'action' => 'admin.rates.datatable.action',
            'name' => 'admin.rates.datatable.name'
        ];
    }

    public function setColumnSearch(){

        $this->columnAllSearch = [0, 1, 2, 3];

        //$this->columnSearchDate = [2];
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        return $this->repository->getQueryBuilderOrderBy('id', 'asc');
    }

    protected function setCustomColumns(){
        $this->customColumns = config('datatables_columns.Rates', []);
    }

    protected function setCustomEditColumns(){
        $this->customEditColumns = [
            'name' => $this->view['name'],
            'created_at' => '{{ format_date($created_at) }}'
        ];
    }

    protected function setCustomAddColumns(){
        $this->customAddColumns = [
            'action' => $this->view['action'],
        ];
    }

    protected function setCustomRawColumns(){
        $this->customRawColumns = ['name', 'action'];
    }

    public function calculatePercentage()
    {
        // Gọi phương thức calculatePercentage từ DriversController và trả về kết quả
        return $this->driversController->calculatePercentage();
    }

    public function calculatePercentageajax()
    {
        $data = $this->query()->get();

        foreach ($data as $rate) {
            // Gọi calculatePercentage để tính phần trăm
            $percentage = $this->calculatePercentage();

            // Cập nhật trường order_acceptance_rate của bảng Rates bằng với kết quả phần trăm tính được
            Rates::where('id', $rate->id)->update(['order_acceptance_rate' => $percentage]);
        }

        return $this->jsonResponse($this->process($data));
    }
}
