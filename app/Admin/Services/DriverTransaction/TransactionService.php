<?php

namespace App\Admin\Services\DriverTransaction;

use App\Admin\Repositories\DriverTransaction\TransactionRepositoryInterface;
use App\Enums\Driver\DriverTransactionStatus;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;

class TransactionService implements TransactionServiceInterface
{
    /**
     * Current Object instance
     *
     * @var array
     */
    protected $data;

    protected $repository;

    public function __construct(TransactionRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function store(Request $request)
    {

        $data = $request->validated();
        $currentDateTime = Carbon::now();
        if ($currentDateTime->hour >= 19) {
            $data['status'] = DriverTransactionStatus::Late;
        } else {
            $data['status'] = DriverTransactionStatus::Success;
        }

        return $this->repository->create($data);
    }

    /**
     * @throws Exception
     */
    public function update(Request $request)
    {

        $data = $request->validated();

        return $this->repository->update($data['id'], $data);
    }

    public function delete($id)
    {
        return $this->repository->delete($id);
    }
}
