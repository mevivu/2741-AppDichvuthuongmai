<?php

namespace App\Api\V1\Services\CartItem;

use App\Api\V1\Repositories\Cart\CartRepositoryInterface;
use App\Api\V1\Repositories\CartItem\CartItemRepositoryInterface;
use App\Api\V1\Repositories\CartItemTopping\CartItemToppingRepository;
use App\Traits\AuthServiceApi;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class CartItemService implements CartItemServiceInterface
{
    use AuthServiceApi;

    /**
     * Current Object instance
     *
     * @var array
     */
    protected $data;

    protected $repository;

    protected $instance;

    protected CartItemRepositoryInterface $cartItemRepository;

    protected CartItemToppingRepository $cartItemToppingRepository;

    public function __construct(CartRepositoryInterface     $repository,
                                CartItemToppingRepository   $cartItemToppingRepository,
                                CartItemRepositoryInterface $cartItemRepository)
    {
        $this->repository = $repository;
        $this->cartItemRepository = $cartItemRepository;
        $this->cartItemToppingRepository = $cartItemToppingRepository;
    }

    public function store(Request $request)
    {
        try {
            $data = $request->validated();

            $toppingIds = $data['topping_ids'] ?? [];
            unset($data['topping_ids']);

            $filter = [
                'cart_id' => $this->getCartId($request),
                'product_id' => $data['product_id']
            ];
            $cartItem = $this->cartItemRepository->findByOrFail($filter);

            $newQty = $cartItem->qty + $data['qty'];
            $this->cartItemRepository->updateAttribute($cartItem->id, 'qty', $newQty);

            // Attach toppings if any
            if (!empty($toppingIds)) {
                $this->attachToppingsToCartItem($cartItem, $toppingIds);
            }

            return $cartItem->refresh();
        } catch (ModelNotFoundException $e) {
            $cartItem = $this->cartItemRepository->create($data);

            if (!empty($toppingIds)) {
                $this->attachToppingsToCartItem($cartItem, $toppingIds);
            }

            return $cartItem;
        }
    }

    /**
     * Attach an array of topping IDs to the given cart item.
     *
     * @param $cartItem
     * @param array $toppingIds Array of topping IDs.
     */
    protected function attachToppingsToCartItem($cartItem, array $toppingIds): void
    {
        $toppings = [];
        foreach ($toppingIds as $topping) {
            $toppings[$topping['id']] = ['quantity' => $topping['quantity']];
        }
        $cartItem->toppings()->syncWithoutDetaching($toppings);
    }


    public function update(Request $request): object|bool
    {

        $this->data = $request->validated();

        return $this->cartItemRepository->update($this->data['id'], $this->data);

    }

    public function delete($id): object|bool
    {
        return $this->cartItemRepository->delete($id);

    }

    public function getInstance()
    {
        return $this->instance;
    }


}
