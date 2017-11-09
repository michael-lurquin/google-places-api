<?php

namespace MichaelLurquin\GooglePlaces;

use Illuminate\Support\ServiceProvider;

class GooglePlacesServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/config.php', 'google_places_api');

        $this->app->singleton(GooglePlaces::class, function($app) {
            return new GooglePlaces($app['config']);
        });

        $this->app->alias(GooglePlaces::class, 'googleplaces');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [GooglePlaces::class];
    }
}