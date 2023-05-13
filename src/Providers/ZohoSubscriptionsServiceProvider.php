<?php

namespace ZohoSubscriptions\Providers;

use Illuminate\Support\ServiceProvider;

class ZohoSubscriptionsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../../config/config.php' => config_path('zoho.php'),
            ], 'zoho-subscriptions-config');
        }
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../../config/config.php', 'zoho');

        // Register the main class to use with the facade
        $this->app->singleton('zoho-subscriptions', 'ZohoSubscriptions\Contracts\ZohoSubscriptions');
        $this->app->bind('ZohoSubscriptions\Contracts\ZohoSubscriptions', 'ZohoSubscriptions\Support\Entry');

        $this->app->bind('zoho-subscriptions.client', 'ZohoSubscriptions\Support\Client');
    }
}
