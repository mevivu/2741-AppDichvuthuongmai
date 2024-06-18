<?php

namespace App\Admin\Http\Controllers\DiscountCode;

use App\Admin\Http\Controllers\BaseController;
use App\Admin\Http\Requests\DiscountCode\DiscountCodeRequest;
use App\Admin\DataTables\DiscountCode\DiscountCodeDataTable;
use App\Admin\Repositories\DiscountCode\DiscountCodeRepositoryInterface;
use App\Admin\Services\DiscountCode\DiscountCodeServiceInterface;
use App\Enums\DiscountCode\DiscountCodeStatus;

class DiscountCodeController extends BaseController
{

    protected $repository;
    protected $service;

    public function __construct(
        DiscountCodeRepositoryInterface $repository,
        DiscountCodeServiceInterface $service,
    ) {

        parent::__construct();

        $this->repository = $repository;

        $this->service = $service;
    }

    public function getView()
    {
        return [
            'index' => 'admin.discount_code.index',
            'create' => 'admin.discount_code.create',
            'edit' => 'admin.discount_code.edit'
        ];
    }

    public function getRoute()
    {
        return [
            'index' => 'admin.discount.index',
            'create' => 'admin.discount.create',
            'edit' => 'admin.discount.edit',
            'delete' => 'admin.discount.delete'
        ];
    }

    public function index(DiscountCodeDataTable $dataTable)
    {
        return $dataTable->render(
            $this->view['index'],
            [
                'status' => DiscountCodeStatus::asSelectArray(),
            ]
        );
    }

    public function create()
    {
        return view($this->view['create'], [
            'status' => DiscountCodeStatus::asSelectArray(),
        ]);
    }

    public function store(DiscountCodeRequest $request)
    {
        $instance = $this->service->store($request);

        return to_route($this->route['edit'], $instance->id)->with('success', __('notifySuccess'));
    }

    public function edit($id)
    {
        $instance = $this->repository->findOrFail($id);
        return view(
            $this->view['edit'],
            [
                'discounts' => $instance,
                'status' => DiscountCodeStatus::asSelectArray(),
            ],
        );
    }

    public function update(DiscountCodeRequest $request)
    {
        $this->service->update($request);

        return back()->with('success', __('notifySuccess'));
    }

    public function delete($id)
    {
        $this->service->delete($id);

        return to_route($this->route['index'])->with('success', __('notifySuccess'));
    }
}
