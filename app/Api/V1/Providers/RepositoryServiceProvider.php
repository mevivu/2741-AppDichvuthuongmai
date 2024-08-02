<?php

namespace App\Api\V1\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    protected array $repositories = [
        'App\Api\V1\Repositories\CategorySystem\CategorySystemRepositoryInterface' => 'App\Api\V1\Repositories\CategorySystem\CategorySystemRepository',
        'App\Api\V1\Repositories\Topping\ToppingRepositoryInterface' => 'App\Api\V1\Repositories\Topping\ToppingRepository',
        'App\Api\V1\Repositories\User\UserRepositoryInterface' => 'App\Api\V1\Repositories\User\UserRepository',
        'App\Api\V1\Repositories\Driver\DriverRepositoryInterface' => 'App\Api\V1\Repositories\Driver\DriverRepository',
        'App\Api\V1\Repositories\Product\ProductRepositoryInterface' => 'App\Api\V1\Repositories\Product\ProductRepository',
        'App\Api\V1\Repositories\Product\ProductVariationRepositoryInterface' => 'App\Api\V1\Repositories\Product\ProductVariationRepository',
        'App\Api\V1\Repositories\Category\CategoryRepositoryInterface' => 'App\Api\V1\Repositories\Category\CategoryRepository',
        'App\Api\V1\Repositories\ShoppingCart\ShoppingCartRepositoryInterface' => 'App\Api\V1\Repositories\ShoppingCart\ShoppingCartRepository',
        'App\Api\V1\Repositories\Cart\CartRepositoryInterface' => 'App\Api\V1\Repositories\Cart\CartRepository',
        'App\Api\V1\Repositories\CartItem\CartItemRepositoryInterface' => 'App\Api\V1\Repositories\CartItem\CartItemRepository',
        'App\Api\V1\Repositories\CartItemTopping\CartItemToppingRepositoryInterface' => 'App\Api\V1\Repositories\CartItemTopping\CartItemToppingRepository',
        'App\Api\V1\Repositories\Order\OrderRepositoryInterface' => 'App\Api\V1\Repositories\Order\OrderRepository',
        'App\Api\V1\Repositories\Order\OrderDetailRepositoryInterface' => 'App\Api\V1\Repositories\Order\OrderDetailRepository',
        'App\Api\V1\Repositories\Slider\SliderRepositoryInterface' => 'App\Api\V1\Repositories\Slider\SliderRepository',
        'App\Api\V1\Repositories\Slider\SliderItemRepositoryInterface' => 'App\Api\V1\Repositories\Slider\SliderItemRepository',
        'App\Api\V1\Repositories\Post\PostRepositoryInterface' => 'App\Api\V1\Repositories\Post\PostRepository',
        'App\Api\V1\Repositories\PostCategory\PostCategoryRepositoryInterface' => 'App\Api\V1\Repositories\PostCategory\PostCategoryRepository',
        'App\Api\V1\Repositories\Review\ReviewRepositoryInterface' => 'App\Api\V1\Repositories\Review\ReviewRepository',
        'App\Api\V1\Repositories\Discount\DiscountRepositoryInterface' => 'App\Api\V1\Repositories\Discount\DiscountRepository',
        'App\Api\V1\Repositories\Area\AreaRepositoryInterface' => 'App\Api\V1\Repositories\Area\AreaRepository',
        'App\Api\V1\Repositories\Vehicle\VehicleRepositoryInterface' => 'App\Api\V1\Repositories\Vehicle\VehicleRepository',
        'App\Api\V1\Repositories\Notification\NotificationRepositoryInterface' => 'App\Api\V1\Repositories\Notification\NotificationRepository',


    ];
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        //
        foreach ($this->repositories as $interface => $implement) {
            $this->app->singleton($interface, $implement);
        }
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
