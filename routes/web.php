<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderTrackingController;

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES (USER)
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/menu', [MenuController::class, 'index'])->name('menu.index');
Route::get('/menu/{slug}', [MenuController::class, 'show'])->name('menu.show');

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');

Route::get('/order/success/{code}', [OrderTrackingController::class, 'success'])->name('order.success');
Route::get('/order/track', [OrderTrackingController::class, 'trackForm'])->name('order.track.form');
Route::post('/order/track', [OrderTrackingController::class, 'trackResult'])->name('order.track.result');

/*
|--------------------------------------------------------------------------
| AUTH ROUTES (Breeze/Fortify)
|--------------------------------------------------------------------------
| Penting agar route('login') ada untuk middleware auth.
*/
if (file_exists(__DIR__ . '/auth.php')) {
    require __DIR__ . '/auth.php';
}

use App\Http\Controllers\ProfileController;

// Breeze tests expect route name "dashboard"
Route::middleware(['auth'])->get('/dashboard', function () {
    return redirect()->route('admin.dashboard');
})->name('dashboard');

// Breeze Profile routes (tests expect /profile exists)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/
require __DIR__ . '/admin.php';
