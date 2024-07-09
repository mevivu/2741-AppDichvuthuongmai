<?php

namespace App\Admin\Http\Controllers\Discount;

use App\Admin\DataTables\Discount\DiscountDataTable;
use App\Admin\Http\Controllers\Controller;
use App\Admin\Http\Requests\Discount\DiscountRequest;
use App\Admin\Repositories\Discount\DiscountRepositoryInterface;
use App\Admin\Services\Discount\DiscountServiceInterface;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class DiscountController extends Controller
{
    protected $repository;

    public function __construct(
        DiscountRepositoryInterface $repository,
        DiscountServiceInterface    $service,
    )
    {

        parent::__construct();
        $this->repository = $repository;
        $this->service = $service;

    }

    public function getView(): array
    {

        return [
            'index' => 'admin.discounts.index',
            'create' => 'admin.discounts.create',
            'edit' => 'admin.discounts.edit'
        ];
    }

    public function getRoute(): array
    {

        return [
            'index' => 'admin.discount.index',
            'create' => 'admin.discount.create',
            'edit' => 'admin.discount.edit',
        ];
    }

    public function index(DiscountDataTable $dataTable)
    {

        return $dataTable->render($this->view['index'], [
            'breadcrumbs' => $this->crums->add(__('listDiscount'))
        ]);
    }


    public function create(): Factory|View|Application
    {

        return view($this->view['create'], [
            'breadcrumbs' => $this->crums->add(__('listDiscount'),
                route($this->route['index']))->add(__('add')),
        ]);
    }


    public function store(DiscountRequest $request): RedirectResponse
    {

        $response = $this->service->store($request);

        if ($response) {
            return to_route($this->route['index'])->with('success', __('notifySuccess'));
        }

        return back()->with('error', __('notifyFail'))->withInput();
    }

    /**
     * @throws Exception
     */
    public function edit($id): Factory|View|Application
    {
        $discount = $this->repository->findOrFail($id);

        return view(
            $this->view['edit'],
            [
                'discount' => $discount,
                'breadcrumbs' => $this->crums->add(__('Trang chủ'),
                    route($this->route['index']))->add(__('edit'))
            ],
        );
    }

    public function update(DiscountRequest $request): RedirectResponse
    {
        $response = $this->service->update($request);

        if ($response) {
            return $request->input('submitter') == 'save'
                ? back()->with('success', __('notifySuccess'))
                : to_route($this->route['index'])->with('success', __('notifySuccess'));
        }

        return back()->with('error', __('notifyFail'));
    }

    public function delete($id): RedirectResponse
    {

        $this->service->delete($id);

        return to_route($this->route['index'])->with('success', __('notifySuccess'));
    }


}
