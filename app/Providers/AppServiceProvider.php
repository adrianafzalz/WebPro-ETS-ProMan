<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

// app/Providers/AppServiceProvider.php

use Illuminate\Support\Facades\URL; 


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
        // Check if the application is running in a production environment
        if ($this->app->environment('production', 'staging')) {
            // Force all generated URLs to use the HTTPS scheme
            URL::forceScheme('https'); 
        }
    }
}
