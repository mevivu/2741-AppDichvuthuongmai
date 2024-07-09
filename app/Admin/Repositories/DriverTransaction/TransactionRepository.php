<?php

namespace App\Admin\Repositories\DriverTransaction;

use App\Admin\Repositories\EloquentRepository;
use App\Enums\Driver\DriverTransactionStatus;
use App\Models\DriverTransaction;


class TransactionRepository extends EloquentRepository implements TransactionRepositoryInterface
{
    public function getModel(): string
    {
        return DriverTransaction::class;
    }

    public function getByOrder(array $filter, array $relations = [], $sort = ['id', 'desc'])
    {
        $this->getByQueryBuilder($filter, $relations, $sort);

        return $this->instance->get();
    }

    public function searchAllLimit($keySearch = '', $meta = [], $limit = 10)
    {

        $this->instance = $this->model->where('name', 'like', '%' . $keySearch . '%');

        $this->applyFilters($meta);

        return $this->instance->published()->orderBy('position', 'asc')->limit($limit)->get();
    }


    public function getTransactionsByMonthAndYear($month, $year, array $relations = [], $sort = ['created_at', 'desc'])
    {
        $filter = [
            ['created_at', '>=', "$year-$month-01"],
            ['created_at', '<=', "$year-$month-" . cal_days_in_month(CAL_GREGORIAN, $month, $year)]
        ];

        return $this->getByQueryBuilder($filter, $relations, $sort);
    }

    public function getTotalIncome($month, $year)
    {
        $this->instance = $this->model
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->sum('amount');
        return $this->instance;

    }

    public function getTotalIncomeExcludePending()
    {
        $this->instance = $this->model
            ->where('status', '!=', DriverTransactionStatus::Pending)
            ->sum('amount');
        return $this->instance;
    }
}
