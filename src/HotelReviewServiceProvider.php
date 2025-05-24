<?php

namespace HotelReview;

use Illuminate\Support\ServiceProvider;

class HotelReviewServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->publishes([
            __DIR__.'/../config/hotelreview.php' => config_path('hotelreview.php'),
        ]);
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/hotelreview.php', 'hotelreview');
    }
}
