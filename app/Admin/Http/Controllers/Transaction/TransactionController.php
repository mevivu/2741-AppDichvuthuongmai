<?php

namespace App\Admin\Http\Controllers\Transaction;

use App\Admin\DataTables\Transaction\TransactionDataTable;
use App\Admin\DataTables\Transaction\TransactionIncomeDataTable;
use App\Admin\Http\Controllers\Controller;
use App\Admin\Http\Requests\Transaction\TransactionRequest;
use App\Admin\Repositories\DriverTransaction\TransactionRepositoryInterface;
use App\Admin\Services\DriverTransaction\TransactionServiceInterface;
use App\Enums\Driver\DriverTransactionStatus;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TransactionController extends Controller
{
    public function __construct(
        TransactionRepositoryInterface $repository,
        TransactionServiceInterface    $service
    )
    {

        parent::__construct();

        $this->repository = $repository;
        $this->service = $service;
    }

    public function getView(): array
    {

        return [
            'index' => 'admin.transactions.index',
            'income' => 'admin.transactions.income',
            'edit' => 'admin.transactions.edit'
        ];
    }

    public function getRoute(): array
    {

        return [
            'index' => 'admin.transaction.index',
            'edit' => 'admin.transaction.edit',
            'income' => 'admin.transaction.income',
        ];
    }

    public function index(TransactionDataTable $dataTable)
    {
        return $dataTable->render($this->view['index'], [
            'breadcrums' => $this->crums->add(__('transactions'))
        ]);
    }

    public function income(TransactionIncomeDataTable $dataTable)
    {
        $totalIncome = $this->repository->getTotalIncomeExcludePending();

        return $dataTable->render($this->view['income'], [
            'totalIncome' => $totalIncome,
            'breadcrums' => $this->crums->add(__('transactions'))
        ]);
    }

    public function getTotalIncome(Request $request): JsonResponse
    {
        $month = $request->input('month');
        $totalIncome = 0;

        if ($month) {
            list($year, $month) = explode('-', $month);

            $totalIncome = $this->repository->getTotalIncome($month, $year);
        } else {
            $totalIncome = $this->repository->getTotalIncomeExcludePending();
        }

        return response()->json($totalIncome);
    }


    /**
     * @throws Exception
     */
    public function edit($id): View|Application
    {

        $response = $this->repository->findOrFail($id);

        return view(
            $this->view['edit'],
            [
                'status' => DriverTransactionStatus::asSelectArray(),
                'transaction' => $response,
                'breadcrums' => $this->crums->add(__('transactions'), route($this->route['index']))->add(__('edit'))
            ],
        );
    }

    public function update(TransactionRequest $request): RedirectResponse
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
