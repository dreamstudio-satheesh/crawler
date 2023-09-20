<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use App\Http\Controllers\Api\ProductController;

RateLimiter::for('search', function ($request) {
    return Limit::perMinute(60);  // Adjust the number as necessary
});


// Add the product search route
Route::get('/products/search',[ProductController::class, 'search'])->middleware('throttle:search');