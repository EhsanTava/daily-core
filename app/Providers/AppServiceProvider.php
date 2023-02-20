<?php

namespace App\Providers;

use App\Processors\OrderProcessor;
use App\Processors\OrderProcessorInterface;
use App\Repositories\Contracts\SnapFoodServiceInterface;
use App\Repositories\SnapFoodServiceRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(SnapFoodServiceInterface::class, SnapFoodServiceRepository::class);
        $this->app->bind(OrderProcessorInterface::class, OrderProcessor::class); // TODO : make it's own provider
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
