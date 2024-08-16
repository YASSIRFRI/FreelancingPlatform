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
use App\Http\Controllers\OfferController;
use App\Http\Controllers\MarketController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ContactController;
use Flutterwave\Payments\Facades\Flutterwave;
use Flutterwave\Payments\Data\Status;

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
    }else{
        return redirect('/landing');
    }
})->name('home');


Route::get('/landing', function () {
    return view('landing');
})->name('landing');
        
Route::get('/next', function () {
    return view('next');
})->name('next');

// Admin routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminLoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminLoginController::class, 'login']);
    Route::post('/logout', [AdminLoginController::class, 'logout'])->name('logout');
    Route::get('/dashboard',[AdminController::class,'dashboard'])->middleware(['auth:admin'])->name('dashboard');
    Route::patch('/verify/{id}', [AdminController::class, 'verify'])->name('verify');
});





Route::middleware('auth:admin')->group(function () {
    Route::get('/admin/edit-content', [AdminController::class, 'editContent'])->name('admin.edit_content');
    Route::post('/admin/update-content', [AdminController::class, 'updateContent'])->name('admin.update_content');
    Route::patch('/admin/unverify-user/{id}', [AdminController::class, 'unverifyUser'])->name('admin.unverify_user');
    Route::patch('/admin/deny-verification/{id}', [AdminController::class, 'denyVerification'])->name('admin.deny_verification');
    Route::post('/admin/withdrawals/{id}/approve', [AdminController::class, 'approveWithdrawal'])->name('admin.withdrawals.approve');
    Route::post('/admin/withdrawals/{id}/deny', [AdminController::class, 'denyWithdrawal'])->name('admin.withdrawals.deny');
    Route::post('/admin/update_fees', [AdminController::class, 'updateFees'])->name('admin.update_fees');

});


Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');




Route::get('/terms-and-conditions', function () {
    return view('tc');
})->name('terms');

Route::get("/how-it-works",function(){
    return view('htw');
})->name('htw');

Route::get("/contact",function(){
    return view('contact');
})->name("contact");

// Authenticated user routes


Route::get('market/explore', [MarketController::class, 'explore'])->name('market.explore');
Route::get('/seller/{id}', [SellerController::class, 'show'])->name('sellers.show');


Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Deposit routes
    Route::resource('deposits', DepositController::class)->only(['index', 'create', 'store']);

    // Withdrawal routes
    Route::resource('withdrawals', WithdrawalController::class)->only(['index', 'create', 'store']);

    // Profile routesj
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





    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
    Route::delete('/notifications/{id}', [NotificationController::class, 'destroy'])->name('notifications.destroy');



    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/verify', [ProfileController::class, 'verify'])->name('profile.verify');







    //Route::get('/order/create/{serviceId}', [OrderController::class, 'create'])->name('order.create');
    //Route::post('/order/store/{serviceId}', [OrderController::class, 'store'])->name('order.store');
    Route::get('/order/{orderid}',[OrderController::class, 'show'])->name('orders.show');


    //offers
    Route::resource('offers', OfferController::class);
    Route::post('offers/{offer}/approve', [OrderController::class, 'approveOffer'])->name('offers.approve');
    Route::get('buying-dashboard', [OfferController::class, 'buyingDashboard'])->name('buying.dashboard');
    Route::get('selling-dashboard', [OfferController::class, 'sellingDashboard'])->name('selling.dashboard');



    Route::get('orders/{order}/submit', [OrderController::class, 'submitOrder'])->name('orders.submit');
    Route::post('orders/{order}/submit', [OrderController::class, 'storeSubmission'])->name('orders.storeSubmission');
    Route::post('/orders/{id}/approve', [OrderController::class, 'approve'])->name('orders.complete');
    Route::post('/orders/{id}/reject', [OrderController::class, 'reject'])->name('orders.reject');
    Route::post('/orders/{id}/request-revision', [OrderController::class, 'requestRevision'])->name('orders.request-revision');
    Route::get('/orders/download/{id}', [OrderController::class, 'download'])->name('orders.download');

    Route::get('offers/create/{seller}', [OfferController::class, 'create'])->name('offers.create');
    Route::post('offers/store', [OfferController::class, 'store'])->name('offers.store');


    Route::post('offers/{offer}/approve', [OfferController::class, 'approveOffer'])->name('offers.approve');
    Route::post('offers/{offer}/reject', [OfferController::class, 'rejectOffer'])->name('offers.reject');


    Route::get('offers/{offer}/edit', [OfferController::class, 'edit'])->name('offers.edit');
    Route::put('offers/{offer}', [OfferController::class, 'update'])->name('offers.update');
    Route::delete('offers/{offer}', [OfferController::class, 'destroy'])->name('offers.destroy');


    //payment routes 
    // Laravel 8 & 9
    Route::post('/pay', [PaymentController::class, 'redirectToGateway'])->name('pay');
    Route::get('/payment/callback', [PaymentController::class, 'handleGatewayCallback']);



    //reviews
    Route::get('/order/review/{id}', [ReviewController::class, 'create'])->name('reviews.create');
    Route::post('/order/review/{id}', [ReviewController::class, 'store'])->name('reviews.store');
    Route::get('/seller/reviews', [ReviewController::class, 'index'])->name('reviews.index');


    //notifications
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.read-all');

    //deposit routes
    Route::get('/deposits/callback', [DepositController::class, 'paymentCallback']);












});

// Logout route (POST)
Route::post('/logout', [App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'destroy'])->name('logout');

// Authentication routes
require __DIR__.'/auth.php';
