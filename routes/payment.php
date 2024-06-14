<?php

use App\Http\Controllers\Payment\FlutterwaveController;
use App\Http\Controllers\Payment\FreePlanPurchaseController;
use App\Http\Controllers\Payment\InstamojoController;
use App\Http\Controllers\Payment\ManualPaymentController;
use App\Http\Controllers\Payment\MidtransController;
use App\Http\Controllers\Payment\MollieController;
use App\Http\Controllers\Payment\PayPalController;
use App\Http\Controllers\Payment\PaystackController;
use App\Http\Controllers\Payment\RazorpayController;
use App\Http\Controllers\Payment\SslCommerzPaymentController;
use App\Http\Controllers\Payment\StripeController;
use App\Http\Controllers\Payment\SubscriptionPaymentController;
use Illuminate\Support\Facades\Route;

//Paypal
Route::controller(PayPalController::class)->group(function () {
    Route::post('paypal/payment', 'processTransaction')->name('paypal.post');
    Route::get('success-transaction', 'successTransaction')->name('paypal.successTransaction');
    Route::get('cancel-transaction', 'cancelTransaction')->name('paypal.cancelTransaction');
});

// Paystack
Route::controller(PaystackController::class)->group(function () {
    Route::post('paystack/payment', 'redirectToGateway')->name('paystack.post');
    Route::get('/paystack/success', 'successPaystack')->name('paystack.success');
});

// SSLCOMMERZ
Route::controller(SslCommerzPaymentController::class)->prefix('payment')->group(function () {
    Route::post('/pay-via-ajax', 'payViaAjax')->name('ssl.pay');
    Route::post('/success', 'success');
    Route::post('/fail', 'fail');
    Route::post('/cancel', 'cancel');
    Route::post('/ipn', 'ipn');
});

// Stripe
Route::post('stripe', [StripeController::class, 'stripePost'])->name('stripe.post');

// Razorpay
Route::post('payment', [RazorpayController::class, 'payment'])->name('razorpay.post');

// Flutterwave
Route::controller(FlutterwaveController::class)->group(function () {
    Route::post('/flutterwave/pay', 'initialize')->name('flutterwave.pay');
    Route::get('/rave/callback', 'callback')->name('flutterwave.callback');
});

// Instamojo
Route::controller(InstamojoController::class)->group(function () {
    Route::post('/instamojo/pay', 'pay')->name('instamojo.pay');
    Route::get('/instamojo/success', 'success')->name('instamojo.success');
});

// Midtrans
Route::controller(MidtransController::class)->group(function () {
    Route::post('/midtrans/success', 'success')->name('midtrans.success');
});

// Mollie
Route::controller(MollieController::class)->group(function () {
    Route::post('mollie-paymnet', 'preparePayment')->name('mollie.payment');
    Route::get('payment-success', 'paymentSuccess')->name('mollie.success');
});

// Manual Payment
Route::controller(ManualPaymentController::class)->group(function () {
    Route::post('/manual/payment', 'paymentPlace')->name('manual.payment');
    Route::get('/manual/payment/{order}/mark-paid', 'markPaid')->name('manual.payment.mark.paid');
    Route::post('/wallet/payment', 'walletPaymentPlace')->name('wallet.plan.payment');
    // Route::get('/stripe/plan', 'stripePlan')->middleware('auth');
    // Route::post('/stripe/plan', 'stripePlanSubscribe')->name('stripe.subscribe');
    // Route::post('/stripe/plan/cancel', 'stripeCancelSubscription')->name('stripe.subscribe.cancel');
    // Route::post('/stripe/plan/resume', 'stripeResumeSubscription')->name('stripe.subscribe.resume');
});

// Subscription Payment
Route::controller(SubscriptionPaymentController::class)->group(function () {
    Route::post('/subscribe/plan', 'subscribePlan')->name('subscribe.plan');
    Route::post('/subscribe/plan/cancel', 'cancelSubscribePlan')->name('subscribe.plan.cancel');
    Route::post('/subscribe/plan/resume', 'resumeSubscribePlan')->name('subscribe.plan.resume');
});

// Free Plan Purchase
Route::controller(FreePlanPurchaseController::class)->group(function () {
    Route::post('/free/plan/purchase', 'purchaseFreePlan')->name('purchase.free.plan');
    Route::get('/zero/pricing/job/{code}', 'purchaseZeroPricing')->name('purchase.zero.pricing.job');
});
