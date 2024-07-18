<?php

namespace App\Api\V1\Repositories\CartItem;

use \App\Admin\Repositories\CartItem\CartItemRepository as AdminArea;
use App\Models\CartItem;

class CartItemRepository extends AdminArea implements CartItemRepositoryInterface
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

    public function getCartsByUserId($userId, $page = 1, $limit = 10)
    {
        return $this->getByQueryBuilder(['user_id' => $userId])
            ->paginate($limit, ['*'], 'page', $page);
    }

    public function getCartItemsByIdsAndCartId(array $cartItemIds, $cartId)
    {
        return $this->model
            ->whereIn('id', $cartItemIds)
            ->where('cart_id', $cartId)
            ->get();
    }

    public function getCartItemsByIds(array $cartItemIds)
    {
        return CartItem::whereIn('id', $cartItemIds)->get();
    }

    /**
     * Lấy  danh sách cart_item có sản phẩm cùng 1 cửa hàng
     * @param $storeId
     * @return mixed
     */
    public function getCartItemsByStoreId($storeId): mixed
    {
        return $this->model->whereHas('product.store', function ($query) use ($storeId) {
            $query->where('id', $storeId);
        })->with('product.store')->get();
    }


}
