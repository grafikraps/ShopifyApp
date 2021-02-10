<?php

namespace Grafikr\ShopifyApp;

use Illuminate\Support\ServiceProvider as Provider;

class ServiceProvider extends Provider
{
    /**
     * Bootstrap any package services.
     */
    public function boot(): void
    {
        $this->mergeConfigFrom(dirname(__DIR__) . '/config/shopify.php', 'shopify');
        $this->loadRoutesFrom(dirname(__DIR__) . '/routes/app.php');
        $this->loadMigrationsFrom(dirname(__DIR__) . '/migrations');

        $this->publishes([
            dirname(__DIR__) . '/public' => public_path('vendor/shopify-app'),
        ], 'shopify-app');

        $this->loadViewsFrom(dirname(__DIR__) . '/resources/views', 'shopify-app');
    }
}
