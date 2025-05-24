<?php

use Illuminate\Support\Facades\Route;
use HotelReview\Http\Controllers\ReviewController;

Route::post('/hotel-review', [ReviewController::class, 'store']);

