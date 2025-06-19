<?php

namespace HotelReviews;

use Illuminate\Support\ServiceProvider;

class HotelReviewsServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/routes.php');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/polygon.php', 'polygon');
    }
}
