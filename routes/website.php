<?php

use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\Frontend\AdPostController;
use App\Http\Controllers\Frontend\DashboardController;
use App\Http\Controllers\Frontend\FrontendController;
use App\Http\Controllers\Frontend\SellerDashboardController;
use App\Http\Controllers\MessengerController;
use Illuminate\Support\Facades\Route;
use Modules\Ad\Entities\Ad;

Route::get('/test', function () {
    abort(404);
});

Route::get('/company', function () {
    return view('frontend.company');
});

Route::get('/coming-soon', function () {
    return view('frontend.coming-soon');
});
Route::get('/maintenance', function () {
    return view('frontend.maintenance');
});

Route::get('logs', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index']);

// show website pages
Route::name('frontend.')->group(function () {
    Route::controller(FrontendController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/about', 'about')->name('about');
        Route::get('/faq', 'faq')->name('faq');
        Route::get('/privacy', 'privacy')->name('privacy');
        Route::get('/refund', 'refund')->name('refund');
        Route::get('/terms-conditions', 'terms')->name('terms');
        Route::get('/price-plan', 'pricePlan')->name('priceplan');
        Route::get('/price-plan-details/{plan_label}', 'pricePlanDetails')->name('priceplanDetails');
        Route::get('/contact', 'contact')->name('contact');
        Route::get('/ads', 'ads')->name('ads');
        Route::get('/ads/{slug}', 'adsCategory')->name('ads.category');
        Route::get('/ads/{slug}/{subslug}', 'adsSubCategory')->name('ads.sub.category');
        Route::get('/ads/{ad:slug}', 'adDetails')->name('addetails');
        Route::get('/ad-list', 'adList')->name('adlist');
        Route::get('/ad/details/{ad:slug}', 'adDetails')->name('addetails');
        Route::post('/ad/details/report-ad', 'adReport')->name('adReport');
        Route::get('/ad/gallery-details/{ad:slug}', 'adGalleryDetails')->name('ad.gallery.details');
        Route::get('/blog', 'blog')->name('blog');
        Route::get('/blog/{blog:slug}', 'singleBlog')->name('single.blog');
        Route::get('/blog/comments/count/{post_id}', 'commentsCount')->name('commentsCount');
        Route::post('/set/session', 'setSession')->name('set.session');
        Route::get('/selected/country', 'setSelectedCountry')->name('set.country');
        Route::get('/translated/texts', 'fetchCurrentTranslatedText');

        Route::get('/promotions', 'promotionsView')->name('promotions');
        Route::get('/transaction', 'transaction');
    });

    //seller dashboard
    Route::controller(SellerDashboardController::class)->group(function () {
        Route::get('/seller/{user:username}', 'profile')->name('seller.profile');
        Route::post('/seller/rate', 'rateReview')->name('seller.review');
        Route::post('/pre/signup', 'preSignup')->name('pre.signup');
        Route::post('/report', 'report')->name('seller.report');
        Route::get('/favorite-listing', 'favoriteList')->name('favorite.list');
        Route::get('/my-listing', 'myListing')->name('my.listing');

        // Route::post('/my-listing/{ad:slug}/update', 'promoteAsFeatured')->name('promote-as-featured');
        Route::post('/my-listing/{ad:slug}/update', 'promoteListing')->name('promote-listing');
        Route::get('/resubmission-list', 'resubmissionList')->name('resubmission.list');
        Route::delete('/seller/{user:username}', 'deleteProfile')->name('seller.delete');
    });

    // customer dashboard
    Route::prefix('dashboard')
        ->middleware(['auth:user', 'verified'])
        ->group(function () {
            Route::get('/', [DashboardController::class, 'dashboard'])->name('dashboard');

            Route::controller(AdPostController::class)
                ->prefix('post')
                ->group(function () {
                    // Ad Create
                    Route::middleware(['checkplan', 'check_subscription'])->group(function () {
                        Route::get('/', 'postStep1')->name('post');
                        Route::post('/', 'storePostStep1')->name('post.store');
                        Route::get('/step2', 'postStep2')->name('post.step2');
                        Route::post('/step2', 'storePostStep2')->name('post.step2.store');
                        Route::get('/step3', 'postStep3')->name('post.step3');
                        Route::post('/step3', 'storePostStep3')->name('post.step3.store');
                        Route::get('/step2/back/{slug?}', 'postStep2Back')->name('post.step2.back');
                        Route::get('/step1/back/{slug?}', 'postStep1Back')->name('post.step1.back');
                    });

                    // Ad Edit
                    Route::post('/gallery/images/{ad_gallery}', 'adGalleryDelete')->name('ad.gallery.delete');
                    Route::get('/{ad:slug}', 'editPostStep1')->name('post.edit');
                    Route::put('/{ad:slug}/update', 'UpdatePostStep1')->name('post.update');
                    Route::delete('/{ad:slug}/delete', 'PostDelete')->name('post.delete');
                    Route::get('/{ad:slug}/step2', 'editPostStep2')->name('post.edit.step2');
                    Route::put('/step2/{ad:slug}/update', 'updatePostStep2')->name('post.step2.update');
                    Route::get('/{ad:slug}/step3', 'editPostStep3')->name('post.edit.step3');
                    Route::put('/step3/{ad:slug}/update', 'updatePostStep3')->name('post.step3.update');
                    Route::get('/cancel/edit', 'cancelAdPostEdit')->name('post.cancel.edit');

                    // pay per ads
                    Route::get('/payper/ads', 'payperAdsPostStep1')->name('payper.ads.post');
                    Route::post('/payper/ads', 'payperAdsStorePostStep1')->name('payper.ads.post.store');
                    Route::get('/step2/payper/ads', 'PayperAdsPostStep2')->name('payper.ads.post.step2');
                    Route::post('/step2/payper/ads', 'PayperAdsStorePostStep2')->name('payper.ads.post.step2.store');
                    Route::get('/step3/payper/ads', 'PayperAdsPostStep3')->name('payper.ads.post.step3');
                    Route::post('/step3/payper/ads', 'PayperAdsStorePostStep3')->name('payper.ads.post.step3.store');
                    Route::get('/step2/payper/ads/back/{slug?}', 'PayperAdsPostStep2Back')->name('payper.ads.post.step2.back');
                    Route::get('/step1/payper/ads/back/{slug?}', 'PayperAdsPostStep1Back')->name('payper.ads.post.step1.back');
                    Route::get('/payper/ads/payment', 'pricePlanDetails')->name('payper.ads.payment');

                });

            Route::controller(DashboardController::class)->group(function () {
                Route::put('status-ads/{ad}', 'myAdStatus')->name('myad.status');
                Route::get('plans-billing', 'plansBilling')->name('plans-billing');
                Route::get('cancel/plan', 'cancelPlan')->name('cancel-plan');
                Route::get('account-setting', 'accountSetting')->name('account-setting');
                Route::put('profile', 'profileUpdate')->name('profile');
                Route::put('password', 'passwordUpdate')->name('password');
                Route::put('social', 'socialUpdate')->name('social.update');
                Route::post('wishlist', 'addToWishlist')->name('add.wishlist');
                Route::get('become-affiliate', 'affiliteReg')->name('become.affiliate');
                Route::get('affiliate', 'myWallet')->name('wallet');
                Route::post('redeem-points/{id}', 'redeemPoints')->name('wallet.redeemPoints');

                // customer document verification
                Route::get('verify-account', 'verifyAccount')->name('verify.account');
                Route::get('/resubmit/verify-account', 'resubmitVerifyAccount')->name('resubmit.verify.account');
            });

            // Messenger
            Route::controller(MessengerController::class)
                ->middleware('auth:user')
                ->group(function () {
                    Route::get('messages', 'index')->name('message');
                    Route::get('/get/messages/{username}', 'fetchMessages');
                    Route::post('/send/message', 'sendMessage');
                    Route::get('/sync/user-list', 'syncUserList');
                    Route::post('/send/message/website', 'sendMessageWebsite')->name('message.send');
                    // Route::post('message/markas/read/{username}', 'messageMarkasRead')->name('message.markas.read');
                });
        });
});

// Verification Routes
Route::controller(VerificationController::class)
    ->middleware('auth:user', 'set_lang')
    ->group(function () {
        Route::get('/email/verify', 'show')->name('verification.notice');
        Route::get('/email/verify/{id}/{hash}', 'verify')
            ->name('verification.verify')
            ->middleware(['signed']);
        Route::post('/email/resend', 'resend')->name('verification.resend');
    });

// Webhook Routes
Route::stripeWebhooks('stripe-webhook');
