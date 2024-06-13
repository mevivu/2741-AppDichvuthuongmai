<?php

namespace App\Admin\Repositories\DriverTransaction;
use App\Admin\Repositories\EloquentRepositoryInterface;

interface TransactionRepositoryInterface extends EloquentRepositoryInterface
{
    public function getByOrder(array $filter, array $relations = [], $sort = ['id', 'desc']);

    public function searchAllLimit($keySearch = '', $meta = [], $limit = 10);

    public function getTransactionsByMonthAndYear($month, $year, array $relations = []);

    public function getTotalIncome($month, $year);

    public function getTotalIncomeExcludePending();


}
