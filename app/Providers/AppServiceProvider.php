<?php

namespace App\Providers;
use Carbon\Carbon;

use App\Models\Plan;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Carbon::setLocale('es');

        // La página de QuickWeb muestra siempre los planes vigentes del panel
        View::composer('welcome', function ($view) {
            $view->with('plans', Plan::where('active', true)->ordered()->get());
        });
    }
}
