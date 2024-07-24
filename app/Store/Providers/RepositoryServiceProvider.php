<?php

namespace App\Store\Providers;

use App\Store\Repositories\Discount\DiscountRepository;
use App\Store\Repositories\Discount\DiscountRepositoryInterface;
use App\Store\Repositories\Product\ProductRepository;
use App\Store\Repositories\Product\ProductRepositoryInterface;
use App\Store\Repositories\Topping\ToppingRepository;
use App\Store\Repositories\Topping\ToppingRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    protected array $repositories = [
        ProductRepositoryInterface::class => ProductRepository::class,
        DiscountRepositoryInterface::class => DiscountRepository::class,
        ToppingRepositoryInterface::class => ToppingRepository::class,
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
