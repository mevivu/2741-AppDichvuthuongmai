<?php

namespace App\Api\V1\Repositories\CartItem;
use App\Admin\Repositories\EloquentRepositoryInterface;

interface CartItemRepositoryInterface extends EloquentRepositoryInterface
{
    public function paginate($page = 1, $limit = 10);
    public function getCartsByUserId($userId, $page = 1, $limit = 10);
    public function getCartItemsByIdsAndCartId(array $cartItemIds, $cartId);
    public function getCartItemsByIds(array $cartItemIds);
    public function getCartItemsByStoreId($storeId);


}
