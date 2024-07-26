<?php

namespace App\Api\V1\Repositories\Cart;

use \App\Admin\Repositories\Cart\CartRepository as AdminArea;

class CartRepository extends AdminArea implements CartRepositoryInterface
{

    public function paginate($page = 1, $limit = 10)
    {
        $page = $page ? $page - 1 : 0;
        $this->instance = $this->model
            ->offset($page * $limit)
            ->limit($limit)
            ->orderBy('id', 'desc')
            ->get();
        return $this->instance;
    }



}
