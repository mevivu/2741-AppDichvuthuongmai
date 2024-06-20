<?php

namespace App\Admin\Repositories\Order;
use App\Admin\Repositories\EloquentRepositoryInterface;

interface OrderRepositoryInterface extends EloquentRepositoryInterface
{
    public function getFlatTreeNotInNode(array $nodeId);

    public function getFlatTree();

    public function getOrdersByUserId($userId);

    public function getOrder($id);

    public function chartRevenue(array $dateBetween);

    public function getTotalDriverIncome($driverId,$month,$year);

    public function getOrderByMonthAndYear($userId,$month, $year);

}
