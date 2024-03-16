<?php

namespace App\Providers;

use App\Interfaces\RepositoryInterface;
use App\Repository\CartItemsRepository;
use App\Repository\CustomerRepository;
use App\Repository\ProductRepository;
use App\Repository\UserRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(RepositoryInterface::class, UserRepository::class);
        $this->app->bind(RepositoryInterface::class, ProductRepository::class);
        $this->app->bind(RepositoryInterface::class, CustomerRepository::class);
        $this->app->bind(RepositoryInterface::class, CartItemsRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
