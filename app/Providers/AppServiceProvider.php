<?php

namespace App\Providers;

use App\Services\RZDatabaseService;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {

        Blade::component('admin.components.parts-modal', 'part-modal');

        $this->app->singleton(RZDatabaseService::class, function ($app) {
            return RZDatabaseService::getInstance();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
