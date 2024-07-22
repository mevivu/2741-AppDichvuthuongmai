<?php

namespace App\Store\Http\Controllers\Product;

use App\Admin\Http\Controllers\Controller;
use App\Admin\Repositories\Product\ToppingRepositoryInterface;
use App\Admin\Services\Product\ToppingServiceInterface;
use App\Admin\Repositories\Product\ToppingProductRepositoryInterface;
use App\Store\DataTables\Topping\ToppingDataTable;
use App\Store\Http\Requests\Topping\ToppingRequest;
use App\Traits\AuthService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;


class ToppingController extends Controller
{
    use AuthService;

    public ToppingProductRepositoryInterface $repositoryTP;

    public function __construct(
        ToppingRepositoryInterface        $repository,
        ToppingServiceInterface           $service,
        ToppingProductRepositoryInterface $repositoryTP,
    )
    {
        parent::__construct();

        $this->repository = $repository;
        $this->service = $service;
        $this->repositoryTP = $repositoryTP;
    }

    public function getView(): array
    {

        return [
            'index' => 'stores.toppings.index',
            'create' => 'stores.toppings.create',
            'edit' => 'stores.toppings.edit'
        ];
    }

    public function getRoute(): array
    {

        return [
            'index' => 'store.topping.index',
            'create' => 'store.topping.create',
            'edit' => 'store.topping.edit',
            'delete' => 'store.topping.delete'
        ];
    }

    public function index(ToppingDataTable $dataTable)
    {
        return $dataTable->render($this->view['index'], [

            'breadcrums' => $this->crums->add(__('listtopping'), route($this->route['index']))
        ]);

    }

    public function create(): Factory|View|Application|RedirectResponse
    {
        $storeId = $this->getCurrentStoreId();
        $countTopping = $this->service->countTopping($storeId);
        if (count($countTopping) <= 100) {
            return view($this->view['create'], [
                'breadcrums' => $this->crums->add(__('listtopping'), route($this->route['index']))->add(__('add')),
                'store' => $this->getCurrentStoreUser(),
            ]);
        } else {
            return to_route($this->route['index'])->with('warning', __('Bạn đã đủ 100 topping'));
        }

    }

    public function store(ToppingRequest $request): RedirectResponse
    {
        $response = $this->service->store($request);

        if ($response) {
            return $request->input('submitter') == 'save'
                ? to_route($this->route['edit'], $response->id)->with('success', __('notifySuccess'))
                : to_route($this->route['index'])->with('success', __('notifySuccess'));
        }

        return back()->with('error', __('notifyFail'))->withInput();
    }

    public function edit($id): Factory|View|Application
    {
        $store = $this->getCurrentStoreUser();
        $topping = $this->repository->findOrFail($id);
        $products = $topping->products;
        return view(
            $this->view['edit'],
            [
                'products' => $products,
                'store' => $store,
                'topping' => $topping,
                'breadcrums' => $this->crums->add(__('topping'), route($this->route['index']))->add(__('edit')),
            ],
        );
    }

    public function update(ToppingRequest $request): RedirectResponse
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
