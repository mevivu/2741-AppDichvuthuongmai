<?php

namespace App\Admin\Repositories\Order;
use App\Admin\Repositories\EloquentRepositoryInterface;

interface OrderItemRepositoryInterface extends EloquentRepositoryInterface
{
    public function getitem($id);
}
