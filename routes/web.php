<?php

use App\Http\Controllers\BidsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SellerProfileController;
use App\Http\Controllers\SellersController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/sellers', [SellersController::class, 'index'])->name('sellers.index');
Route::get('/sellers/{id}', [SellersController::class,'show'])->name('sellers.show');

Route::get('/bids/{sellers_id}/{bid_date}/{start_time}/{end_time}', [BidsController::class, 'show'])->name('bids.show');
Route::post('/bids', [BidsController::class, 'store'])
    ->middleware(['bids.seller', 'auth'])->name('bids.store');

//Seller Auth
Route::get('/seller', function () {
    return Inertia::render('Seller', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

// User Auth
Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

// Seller Dashboard
Route::get('/seller/dashboard', function () {
    return Inertia::render('SellerDashboard');
})->middleware(['auth.seller'])->name('seller.dashboard');

Route::middleware('auth.seller')->group(function () {
    Route::get('/seller/profile', [SellerProfileController::class, 'edit'])->name('seller.profile.edit');
});

// User Dashboard
Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
