<?php

namespace App\Api\V1\Rules\Discount;

use App\Api\V1\Repositories\Cart\CartRepositoryInterface;
use App\Api\V1\Repositories\Discount\DiscountRepositoryInterface;
use App\Api\V1\Repositories\CartItem\CartItemRepositoryInterface;
use App\Traits\CalculationsTrait;
use Illuminate\Contracts\Validation\Rule;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class ValidDiscountCode implements Rule
{
    use CalculationsTrait;

    protected string $message;


    public function __construct()
    {
        $this->message = __("invalid_discount");
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function passes($attribute, $value): bool
    {
        $discountRepository = app(DiscountRepositoryInterface::class);
        $cartItemRepository = app(CartItemRepositoryInterface::class);
        $cartRepository = app(CartRepositoryInterface::class);

        $discount = $discountRepository->findBy(['code' => $value]);

        if (!$discount) {
            $this->message = __("discount_not_exist");
            return false;
        }

        if (!$discount->isActive()) {
            return false;
        }
        $user = request()->user();
        $cart = $cartRepository->findByField('user_id',$user->id);

        $storeId = request()->get('store_id');
        $cartItems = $cartItemRepository->getCartItemsByStoreId($storeId);
        $cartItemIds = $cartItems->pluck('id')->toArray();

        $eligible = $cartItems->contains(function ($item) use ($discount) {
            return $discount->products->contains($item->product_id);
        });

        $cartItemsCollection = $this->getCartItems($cartItemIds, $cart->id);

        $subTotal = $this->calculateSubTotal($cartItemsCollection);

        if (isset($discount->min_order_amount) && $subTotal < $discount->min_order_amount) {
            $this->message = __("subtotal_below_min_order_amount" );
            return false;
        }

        if (!$eligible) {
            $this->message = __('no_applicable_products');
            return false;
        }

        return true;
    }

    public function message(): string
    {
        return $this->message;
    }
}
