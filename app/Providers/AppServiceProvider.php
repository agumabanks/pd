<?php
namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Example: Register view composers or share data with views
    }

    public function register()
    {
        // Optional: Bind services to the container
        $this->app->singleton(UnsdgValidationService::class, function ($app) {
            return new UnsdgValidationService();
        });
    }

    
}