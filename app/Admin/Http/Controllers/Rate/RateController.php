<?php

namespace App\Admin\Http\Controllers\Rate;

use App\Admin\Http\Controllers\Controller;
use App\Admin\DataTables\Rates\RatesDataTable;
use App\Admin\Repositories\Rate\RateRepositoryInterface;
use App\Admin\Services\Rate\RateServiceInterface;

class RateController extends Controller
{
    protected $repository;
    protected $service;

    public function __construct(
        RateRepositoryInterface $repository,
        RateServiceInterface $service
    ){
        parent::__construct();

        $this->repository = $repository;
        $this->service = $service;
    }

    public function getView(){
        return [
            'index' => 'admin.rates.index',
        ];
    }

    public function getRoute(){
        return [
            'index' => 'admin.rates.index',
        ];
    }

    public function index(RatesDataTable $dataTable){
        return $dataTable->render($this->getView()['index'], [
            // 'breadcrums' => $this->crumbs->add(__('rates'))
        ]);
    }
}
