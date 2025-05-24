<?php

namespace HotelReview;

use Illuminate\Support\ServiceProvider;

class HotelReviewServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/routes.php');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
    }

    public function register()
    {
    }
}
