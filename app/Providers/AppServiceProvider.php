<?php

namespace App\Providers;

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
        $siteViews = [
            'partials.site-head',
            'home',
            'register',
            'registration-success',
            'segment',
            'payment',
            'payment-status',
        ];

        view()->composer($siteViews, \App\View\Composers\SiteComposer::class);
    }
}
