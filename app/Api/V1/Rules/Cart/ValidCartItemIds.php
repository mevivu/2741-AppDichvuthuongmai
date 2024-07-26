<?php

namespace App\Api\V1\Rules\Cart;

use App\Models\CartItem;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Database\Eloquent\Builder;


class ValidCartItemIds implements Rule
{
    protected $cartId;
    protected $errorMessage = '';
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($cartId)
    {
        $this->cartId = $cartId;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        // Đảm bảo tất cả cart item IDs đều thuộc về giỏ hàng được chỉ định
        $cartItemsCount = CartItem::where('cart_id', $this->cartId)
            ->whereIn('id', $value)
            ->count();
        if ($cartItemsCount !== count($value)) {
            $this->errorMessage = 'One or more cart item IDs do not belong to the specified cart.';
            return false;
        }

        // Kiểm tra xem tất cả các mục có thuộc về cùng một cửa hàng hay không
        $storeCount = CartItem::whereHas('product', function (Builder $query) {
            $query->select('store_id');
        })
            ->whereIn('id', $value)
            ->with('product')
            ->get()
            ->groupBy('product.store_id')
            ->count();

        if ($storeCount > 1) {
            $this->errorMessage = 'All cart items must belong to the same store.';
            return false;
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return $this->errorMessage;
    }
}
