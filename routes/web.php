<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\TenderController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\NewsEventController;

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


Route::get('/tenders', [TenderController::class, 'index'])->name('tenders.index');
Route::get('/tenders/create', [TenderController::class, 'create'])->name('tenders.create');
Route::post('/tenders', [TenderController::class, 'store'])->name('tenders.store');
Route::delete('/tenders/{id}', [TenderController::class, 'destroy'])->name('tenders.destroy');


