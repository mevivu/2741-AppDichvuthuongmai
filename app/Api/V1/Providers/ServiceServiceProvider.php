<?php

namespace App\Api\V1\Providers;

use Illuminate\Support\ServiceProvider;

class ServiceServiceProvider extends ServiceProvider
{
    protected array $services = [
        'App\Api\V1\Services\CategorySystem\CategorySystemServiceInterface' => 'App\Api\V1\Services\CategorySystem\CategorySystemService',
        'App\Api\V1\Services\Topping\ToppingServiceInterface' => 'App\Api\V1\Services\Topping\ToppingService',

        'App\Api\V1\Services\User\UserServiceInterface' => 'App\Api\V1\Services\User\UserService',
        'App\Api\V1\Services\Auth\StoreServiceInterface' => 'App\Api\V1\Services\Auth\StoreService',
        'App\Api\V1\Services\Driver\DriverServiceInterface' => 'App\Api\V1\Services\Driver\DriverService',
        'App\Api\V1\Services\ShoppingCart\ShoppingCartServiceInterface' => 'App\Api\V1\Services\ShoppingCart\ShoppingCartService',
        'App\Api\V1\Services\Cart\CartServiceInterface' => 'App\Api\V1\Services\Cart\CartService',
        'App\Api\V1\Services\CartItem\CartItemServiceInterface' => 'App\Api\V1\Services\CartItem\CartItemServiceInterface',
        'App\Api\V1\Services\Order\OrderServiceInterface' => 'App\Api\V1\Services\Order\OrderService',
        'App\Api\V1\Services\Review\ReviewServiceInterface' => 'App\Api\V1\Services\Review\ReviewService',
        'App\Api\V1\Services\Store\StoreServiceInterface' => 'App\Api\V1\Services\Store\StoreService',
        'App\Api\V1\Services\Vehicle\VehicleServiceInterface' => 'App\Api\V1\Services\Vehicle\VehicleService',
        'App\Api\V1\Services\Notification\NotificationServiceInterface' => 'App\Api\V1\Services\Notification\NotificationService',
    ];
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        //
        foreach ($this->services as $interface => $implement) {
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
