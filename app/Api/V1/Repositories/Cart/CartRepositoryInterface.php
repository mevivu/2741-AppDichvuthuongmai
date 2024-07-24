<?php

namespace App\Api\V1\Repositories\Cart;
use App\Admin\Repositories\EloquentRepositoryInterface;

interface CartRepositoryInterface extends EloquentRepositoryInterface
{
    public function paginate($page = 1, $limit = 10);
}
