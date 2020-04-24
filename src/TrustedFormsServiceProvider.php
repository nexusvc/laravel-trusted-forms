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

    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->app->bind('trusted-forms', TrustedFormsService::class);
    }
}
