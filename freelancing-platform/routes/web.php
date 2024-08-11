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
    }
    return redirect()->route('login');
})->name('home');

// Admin routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminLoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminLoginController::class, 'login']);
    Route::post('/logout', [AdminLoginController::class, 'logout'])->name('logout');
    Route::get('/dashboard',[AdminController::class,'dashboard'])->middleware(['auth:admin'])->name('dashboard');
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
    Route::get('/seller/{id}', [SellerController::class, 'show'])->name('sellers.show');





    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
    Route::delete('/notifications/{id}', [NotificationController::class, 'destroy'])->name('notifications.destroy');



    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/verify', [ProfileController::class, 'verify'])->name('profile.verify');



    //market 
    Route::get('market/explore', [MarketController::class, 'explore'])->name('market.explore');




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
    //Route::get('payments', [PaymentController::class, 'initialize'])->name('payments.initialize');
    //Route::post('rave/callback', [PaymentController::class, 'callback'])->name('payments.callback');


    //reviews
    Route::get('/order/review/{id}', [ReviewController::class, 'create'])->name('reviews.create');
    Route::post('/order/review/{id}', [ReviewController::class, 'store'])->name('reviews.store');
    Route::get('/seller/reviews', [ReviewController::class, 'index'])->name('reviews.index');


    //notifications
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.read-all');

    //deposit routes
    Route::get('/deposits/callback', [DepositController::class, 'paymentCallback']);


    Route::post('/flutterwave/payment/webhook', function () {
        $method = request()->method();
        if ($method === 'POST') {
            $body = request()->getContent();
            $webhook = Flutterwave::use('webhooks');
            $transaction = Flutterwave::use('transactions');
            $signature = request()->header($webhook::SECURE_HEADER);
    
            $isVerified = $webhook->verifySignature($body, $signature);
    
            if ($isVerified) {
                [ 'tx_ref' => $tx_ref, 'id' => $id ] = $webhook->getHook();
                [ 'status' => $status, 'data' => $transactionData ] = $transaction->verifyTransactionReference($tx_ref);
    
                $responseData = ['tx_ref' => $tx_ref, 'id' => $id];
                if ($status === 'success') {
                    switch ($transactionData['status']) {
                        case Status::SUCCESSFUL:
                            // do something
                            //save to database
                            //send email
                            break;
                        case Status::PENDING:
                            // do something
                            //save to database
                            //send email
                            break;
                        case Status::FAILED:
                            // do something
                            //save to database
                            //send email
                            break;
                    }
                }
    
                return response()->json(['status' => 'success', 'message' => 'Webhook verified by Flutterwave Laravel Package', 'data' => $responseData]);
            }
    
            return response()->json(['status' => 'error', 'message' => 'Access denied. Hash invalid'])->setStatusCode(401);
        }
    
        return abort(404);
    })->name('flutterwave.webhook');












});

// Logout route (POST)
Route::post('/logout', [App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'destroy'])->name('logout');

// Authentication routes
require __DIR__.'/auth.php';
