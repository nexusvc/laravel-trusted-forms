<?php

namespace BayAreaWebPro\TrustedForms;

use Illuminate\Support\ServiceProvider;

class TrustedFormsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/config.php' => config_path('trusted-forms.php'),
        ], 'config');

        $this->mergeConfigFrom(__DIR__.'/../config/config.php','trusted-forms');
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->app->bind('trusted-forms', TrustedFormsService::class);
    }
}
