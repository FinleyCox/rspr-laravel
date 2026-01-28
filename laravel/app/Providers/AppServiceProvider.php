<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use App\Services\VisitCounter;
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
        View::composer('partials.sidebar', function ($view) {
            $view->with('visitCount', app(VisitCounter::class)->current());
        });
    }
}
