<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Auth\AdminLoginController;
use App\Http\Controllers\DepositController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WithdrawalController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\VerificationController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SellerController;

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

// Redirect to the dashboard if authenticated, otherwise show login
Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }

    return redirect()->route('login');
})->name('home');

// Admin routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminLoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminLoginController::class, 'login']);
    Route::post('/logout', [AdminLoginController::class, 'logout'])->name('logout');
    // Route::get('/register', [AdminRegisterController::class, 'showRegistrationForm'])->name('register');
    // Route::post('/register', [AdminRegisterController::class, 'register']);
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->middleware(['auth:admin'])->name('dashboard');
});

// Authenticated user routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Deposit routes
    Route::resource('deposits', DepositController::class)->only(['index', 'create', 'store']);

    // Withdrawal routes
    Route::resource('withdrawals', WithdrawalController::class)->only(['index', 'create', 'store']);

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Order routes
    Route::resource('orders', OrderController::class)->only(['index', 'create', 'store', 'show']);


    //services routes
    Route::resource('services', ServiceController::class)->except(['show']);
    Route::get('/services/{id}', [ServiceController::class, 'show'])->name('services.show');




    //verification routes
    Route::post('/verification/submit', [VerificationController::class, 'submit'])->name('verification.submit');



    //seller views 
    Route::get('/seller/{username}', [SellerController::class, 'show'])->name('sellers.show');





    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
    Route::delete('/notifications/{id}', [NotificationController::class, 'destroy'])->name('notifications.destroy');



    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/verify', [ProfileController::class, 'verify'])->name('profile.verify');



    //market 
    Route::get('/market', [ServiceController::class, 'exploreMarket'])->name('market.explore');



    Route::get('/order/create/{serviceId}', [OrderController::class, 'create'])->name('order.create');
    Route::post('/order/store/{serviceId}', [OrderController::class, 'store'])->name('order.store');
    Route::get('/order/{orderid}',[OrderController::class, 'show'])->name('orders.show');




});

// Logout route (POST)
Route::post('/logout', [App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'destroy'])->name('logout');

// Authentication routes
require __DIR__.'/auth.php';
