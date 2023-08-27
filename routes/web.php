<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebsiteController;
use App\Http\Controllers\ScrapedlinkController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect('login');
});




Auth::routes([

    'register' => false, // Register Routes...
  
    'reset' => false, // Reset Password Routes...
  
    'verify' => false, // Email Verification Routes...
  
  ]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::get('/websites', [WebsiteController::class, 'index'])->name('websites.index');
Route::get('/websites/create', [WebsiteController::class, 'create'])->name('websites.create');
Route::post('/websites', [WebsiteController::class, 'store'])->name('websites.store');
Route::delete('/websites/{id}', [WebsiteController::class, 'destroy'])->name('websites.destroy');

Route::get('/product_links/{id}', [ScrapedlinkController::class, 'show'])->name('scraped.links');
Route::get('/scrape_products/{id}', [ScrapedlinkController::class, 'scrape_products'])->name('scrape.products');


