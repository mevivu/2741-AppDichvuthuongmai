<?php

namespace App\Store\Http\Controllers\Discount;

use App\Admin\Http\Controllers\Controller;
use App\Admin\Http\Requests\Store\Discount\DiscountRequests;
use App\Admin\Repositories\Discount\DiscountRepository;
use App\Admin\Services\Discount\DiscountService;
use App\Admin\Repositories\Discount\DiscountApplicationRepositoryInterface;
use App\Store\DataTables\Discount\DiscountDataTable;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;


class DiscountController extends Controller
{
    public DiscountApplicationRepositoryInterface $repositoryUSP;

    public function __construct(
        DiscountRepository                     $repository,
        DiscountService                        $service,
        DiscountApplicationRepositoryInterface $repositoryUSP,
    )
    {

        parent::__construct();
        $this->repository = $repository;
        $this->service = $service;
        $this->repositoryUSP = $repositoryUSP;
    }

    public function getView(): array
    {

        return [
            'index' => 'stores.discounts.index',
            'create' => 'stores.discounts.create',
            'edit' => 'stores.discounts.edit'
        ];
    }

    public function getRoute(): array
    {

        return [
            'index' => 'store.discount.index',
            'create' => 'store.discount.create',
            'edit' => 'store.discount.edit',
            'delete' => 'store.discount.delete'
        ];
    }

    public function index(DiscountDataTable $dataTable)
    {
        return $dataTable->render($this->view['index'], [
            'breadcrums' => $this->crums->add(__('list'),
                route($this->route['index']))
        ]);

    }

    public function create(): Factory|View|Application
    {
        $store_id = auth('store')->user();
        return view($this->view['create'], [
            'store_id' => $store_id,
            'breadcrums' => $this->crums->add(__('listdiscount'), route($this->route['index']))->add(__('add')),
        ]);
    }


    public function store(DiscountRequests $request): RedirectResponse
    {

        $response = $this->service->storeStore($request);

        if ($response) {
            return $request->input('submitter') == 'save'
                ? to_route($this->route['edit'], $response->id)->with('success', __('notifySuccess'))
                : to_route($this->route['index'])->with('success', __('notifySuccess'));
        }

        return back()->with('error', __('notifyFail'))->withInput();
    }

    /**
     * @throws \Exception
     */
    public function edit($id): Factory|View|Application
    {
        $discount = $this->repository->findOrFail($id);
        $products = $discount->products;
        return view(
            $this->view['edit'],
            [
                'products' => $products,
                'discount' => $discount,
                'breadcrums' => $this->crums->add(__('Sửa mã giảm giá'), route($this->route['index']))->add(__('edit'))
            ],
        );
    }

    public function update(DiscountRequests $request): RedirectResponse
    {

        $response = $this->service->updateStore($request);

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
