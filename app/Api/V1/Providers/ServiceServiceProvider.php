<?php

namespace App\Api\V1\Providers;

use Illuminate\Support\ServiceProvider;

class ServiceServiceProvider extends ServiceProvider
{
    protected array $services = [
        'App\Api\V1\Services\User\UserServiceInterface' => 'App\Api\V1\Services\User\UserService',
        'App\Api\V1\Services\Auth\StoreServiceInterface' => 'App\Api\V1\Services\Auth\StoreService',
        'App\Api\V1\Services\Driver\DriverServiceInterface' => 'App\Api\V1\Services\Driver\DriverService',
        'App\Api\V1\Services\ShoppingCart\ShoppingCartServiceInterface' => 'App\Api\V1\Services\ShoppingCart\ShoppingCartService',
        'App\Api\V1\Services\Order\OrderServiceInterface' => 'App\Api\V1\Services\Order\OrderService',
        'App\Api\V1\Services\Store\StoreServiceInterface' => 'App\Api\V1\Services\Store\StoreService',
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
