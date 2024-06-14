<?php

use App\Http\Controllers\Admin\AboutPageSliderController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdReportCategoryController;
use App\Http\Controllers\Admin\AdReportController;
use App\Http\Controllers\Admin\AffiliateController;
use App\Http\Controllers\Admin\AffiliateSettingController;
use App\Http\Controllers\Admin\Auth\ForgotPasswordController;
use App\Http\Controllers\Admin\Auth\ResetPasswordController;
use App\Http\Controllers\Admin\CmsSettingController;
use App\Http\Controllers\Admin\HomePageSliderController;
use App\Http\Controllers\Admin\ManageAdController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\RedeemPointController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\RolesController;
use App\Http\Controllers\Admin\Setting\GeneralSettingController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\SocialiteController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\SearchCountryController;
use App\Http\Controllers\StateController;
use App\Http\Controllers\ThemeController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->group(function () {
    Route::middleware(['guest:admin'])->group(function () {
        // reset password
        Route::controller(ForgotPasswordController::class)->group(function () {
            Route::post('/password/email', 'sendResetLinkEmail')->name('admin.password.email');
            Route::get('/password/reset', 'showLinkRequestForm')->name('admin.password.request');
        });
        Route::controller(ResetPasswordController::class)->group(function () {
            Route::post('/password/reset', 'reset')->name('admin.password.update');
            Route::get('/password/reset/{token}', 'showResetForm')->name('admin.password.reset');
        });
    });

    Route::middleware(['auth:admin'])->group(function () {
        //Dashboard Route
        Route::controller(AdminController::class)->group(function () {
            Route::get('/', 'dashboard');
            Route::get('/dashboard', 'dashboard')->name('admin.dashboard');
            Route::post('/admin/search', 'search')->name('admin.search');
        });

        //Profile Route
        Route::controller(ProfileController::class)->group(function () {
            Route::get('/profile/settings', 'setting')->name('profile.setting');
            Route::get('/profile', 'profile')->name('profile');
            Route::put('/profile', 'profile_update')->name('profile.update');
        });

        //Roles Route
        Route::resource('role', RolesController::class);

        //Users Route
        Route::resource('user', UserController::class);

        // Report
        Route::get('/report', [ReportController::class, 'index'])->name('report.index');

        // Order Route
        Route::controller(OrderController::class)->group(function () {
            Route::get('/order/create', 'createNew')->name('order.create');
            Route::get('/orders', 'index')->name('order.index');
            Route::get('/orders/{transaction}', 'show')->name('order.show');
            Route::post('/order/store', 'store')->name('order.store');
            Route::get('/order/edit/{transaction}', 'edit')->name('order.edit');
            Route::put('/order/update/{transaction}', 'update')->name('order.update');
            Route::get('/order/user/plan/{transaction}', 'updateUserPlan')->name('order.user.plan.update');
            Route::put('/user/plan/update/{user}', 'UserPlanUpdate')->name('user.plan.update');
            Route::post('/admin/download/transaction/invoice/{transaction}', 'downloadTransactionInvoice')->name('admin.transaction.invoice.download');
            Route::delete('/order/destroy/{transaction}', 'destroy')->name('order.destroy');
        });

        // Ad Report Category
        Route::get('/ad-report-categories', [AdReportCategoryController::class, 'index'])->name('ad-report-category.index');
        Route::post('/ad-report-categories', [AdReportCategoryController::class, 'store'])->name('ad-report-category.store');
        Route::get('/ad-report-categories/{slug}', [AdReportCategoryController::class, 'edit'])->name('ad-report-category.edit');
        Route::put('/ad-report-categories/{slug}', [AdReportCategoryController::class, 'update'])->name('ad-report-category.update');
        Route::delete('/ad-report-categories/{slug}', [AdReportCategoryController::class, 'destroy'])->name('ad-report-category.destroy');

        // ========================================================
        // ====================Setting=============================
        // ========================================================
        Route::controller(GeneralSettingController::class)
            ->prefix('settings/general')
            ->name('settings.')
            ->group(function () {
                // brand Update
                Route::get('/brand', 'general')->name('general');
                Route::put('/brand', 'generalUpdate')->name('general.update');

                Route::get('/app', 'appConfig')->name('general.app.config');
                Route::put('/app', 'appConfigUpdate')->name('general.app.config.update');

                // website watermark update
                Route::get('/watermark', 'watermark')->name('general.watermark');
                Route::put('/watermark', 'watermarkUpdate')->name('general.watermark.update');

                // broadcasting update
                Route::get('/broadcast', 'broadcasting')->name('general.broadcasting');
                Route::put('/broadcast', 'broadcastingUpdate')->name('general.broadcasting.update');

                // recaptcha Update
                Route::get('/recaptcha', 'recaptcha')->name('general.recaptcha');
                Route::put('recaptcha/update', 'recaptchaUpdate')->name('general.recaptcha.update');

                // pwa option Update
                Route::get('/pwa', 'pwa')->name('general.pwa');
                Route::put('/pwa', 'pwaUpdate')->name('general.pwa.update');
            });

        Route::controller(SettingsController::class)
            ->prefix('settings')
            ->name('settings.')
            ->group(function () {
                Route::get('layout', 'layout')->name('layout');
                Route::put('layout', 'layoutUpdate')->name('layout.update');
                Route::put('mode', 'modeUpdate')->name('mode.update');
                Route::get('theme', 'theme')->name('theme');
                Route::put('theme', 'colorUpdate')->name('theme.update');
                Route::put('homepage/theme', 'themeUpdate')->name('homepage.theme.update');
                Route::get('custom', 'custom')->name('custom');
                Route::put('custom', 'customCssJSUpdate')->name('custom.update');
                Route::get('email', 'email')->name('email');
                Route::put('email', 'emailUpdate')->name('email.update');
                Route::post('test-email', 'testEmailSent')->name('email.test');

                // sytem update
                Route::get('system', 'system')->name('system');
                Route::put('system/update', 'systemUpdate')->name('system.update');
                Route::put('allowLangChanging', 'allowLaguageChanage')->name('allow.langChange');
                Route::put('change/timezone', 'timezone')->name('change.timezone');

                // cookies routes
                Route::get('cookies', 'cookies')->name('cookies');
                Route::put('cookies/update', 'cookiesUpdate')->name('cookies.update');

                // seo
                Route::get('seo/index', 'seoIndex')->name('seo.index');
                Route::get('seo/edit/{page}', 'seoEdit')->name('seo.edit');
                Route::post('seo/content/create', 'seoContentCreate')->name('seo.content.create');
                Route::put('seo/content/{content}', 'seoContentUpdate')->name('seo.content.update');

                // module routes
                Route::get('modules', 'modules')->name('module');
                Route::put('module/update', 'moduleUpdate')->name('module.update');

                // website configuration
                Route::put('website/configuration/update', 'websiteConfigurationUpdate')->name('website.configuration.update');

                // payperadsUpdate
                Route::put('payperads/update', 'payperadsUpdate')->name('payperads.update');

                // pusher configuration
                Route::put('pusher/configuration/update', 'pusherConfigurationUpdate')->name('pusher.configuration.update');

                // website watermark update
                Route::put('website/watermark/update', 'websiteWatermarkUpdate')->name('website.watermark.update');

                // sitemap
                Route::get('generate/sitemap', 'generateSitemap')->name('generateSitemap');

                // upgrade application
                Route::get('upgrade', 'upgrade')->name('upgrade');
                Route::post('upgrade/apply', 'upgradeApply')->name('upgrade.apply');
            });

        Route::controller(SocialiteController::class)->group(function () {
            Route::get('settings/social-login', 'index')->name('settings.social.login');
            Route::put('settings/social-login', 'update')->name('settings.social.login.update');
            Route::post('settings/social-login/status', 'updateStatus')->name('settings.social.login.status.update');
        });

        Route::controller(PaymentController::class)
            ->prefix('settings/payment')
            ->name('settings.')
            ->group(function () {
                Route::get('/', 'index')->name('payment');
                Route::put('/', 'update')->name('payment.update');
                Route::post('/status', 'updateStatus')->name('payment.status.update');

                // Manual Payment
                Route::get('/manual', 'manualPayment')->name('payment.manual');
                Route::post('/manual/store', 'manualPaymentStore')->name('payment.manual.store');
                Route::get('/manual/{manual_payment}/edit', 'manualPaymentEdit')->name('payment.manual.edit');
                Route::put('/manual/{manual_payment}/update', 'manualPaymentUpdate')->name('payment.manual.update');
                Route::delete('/manual/{manual_payment}/delete', 'manualPaymentDelete')->name('payment.manual.delete');
                Route::get('/manual/status/change', 'manualPaymentStatus')->name('payment.manual.status');
                Route::controller(SearchCountryController::class)
                    ->prefix('settings/location/country')
                    ->name('location.country.')
                    ->group(function () {
                        Route::get('/', 'index')->name('country');
                        Route::get('/add', 'create')->name('create');
                        Route::post('/add', 'store')->name('store');
                        Route::get('/edit/{id}', 'edit')->name('edit');
                        Route::put('/edit/{id}', 'update')->name('update');
                        Route::delete('/delete/{id}', 'destroy')->name('destroy');
                    });
                Route::controller(StateController::class)
                    ->prefix('settings/location/state')
                    ->name('location.state.')
                    ->group(function () {
                        Route::get('/', 'index')->name('state');
                        Route::get('/add', 'create')->name('create');
                        Route::post('/add', 'store')->name('store');
                        Route::get('/edit/{id}', 'edit')->name('edit');
                        Route::put('/edit/{id}', 'update')->name('update');
                        Route::delete('/delete/{id}', 'destroy')->name('destroy');
                    });
                Route::controller(CityController::class)
                    ->prefix('settings/location/city')
                    ->name('location.')
                    ->group(function () {
                        Route::get('/', 'index')->name('city');
                        Route::get('/add', 'create')->name('create');
                        Route::post('/add', 'store')->name('store');
                        Route::get('/edit/{id}', 'edit')->name('edit');
                        Route::put('/edit/{id}', 'update')->name('update');
                        Route::delete('/delete/{id}', 'destroy')->name('destroy');
                    });
            });

        // ==================== Skin System =====================
        Route::controller(ThemeController::class)->group(function () {
            Route::get('/skins', 'index')->name('module.themes.index');
            Route::put('/skins', 'update')->name('module.themes');
        });

        //====================Website Page Setting==============================
        Route::controller(SettingsController::class)->group(function () {
            Route::put('/posting-rules', 'postingRulesUpdate')->name('admin.posting.rules.upadte');
            Route::put('/about', 'updateAbout')->name('admin.about.upadte');
            Route::put('/terms', 'updateTerms')->name('admin.terms.upadte');
            Route::put('/privacy', 'updatePrivacy')->name('admin.privacy.upadte');
            Route::put('/refund', 'updateRefund')->name('admin.refund.update');
        });

        //====================Website SEO Setting==============================
        Route::put('/seo', [SettingsController::class, 'updateSeo'])->name('admin.seo.update');

        //====================Advertisement==============================
        Route::resource('settings/advertisement', ManageAdController::class);
        Route::put('/update_ad_status', [ManageAdController::class, 'update_ad_status'])->name('admin.adstatus.update');
        //====================Affiliate==========================
        Route::resource('redeem-points', RedeemPointController::class);
        Route::resource('affiliate-settings', AffiliateSettingController::class);
        Route::get('affiliate/partners', [AffiliateController::class, 'getPartners'])->name('affiliate.partners');
        Route::get('affiliate/balance/requests', [AffiliateController::class, 'getBalanceRequests'])->name('affiliate.balance.request');
        Route::get('affiliate/balance/request/confirm/{id}', [AffiliateController::class, 'balanceRequestConfirm'])->name('affiliate.balance.request.confirm');

        // Report Ads
        Route::get('/report-ad', [AdReportController::class, 'index'])->name('report-ad');
        Route::delete('/report-ad/{singleAdReport}', [AdReportController::class, 'destroy'])->name('report-ad.destroy');

        //====================Website CMS Setting==============================
        Route::controller(CmsSettingController::class)
            ->prefix('settings')
            ->group(function () {
                Route::get('/cms', 'index')->name('settings.cms');
                // Route::put('/home', 'updateHome')->name('admin.home.update');
                Route::post('/home/slider/sorting', 'sortingHome')->name('admin.home.slider.sorting');
                Route::put('/about', 'updateAbout')->name('admin.about.update');
                Route::post('/about/slider/sorting', 'sortingAbout')->name('admin.about.slider.sorting');
                Route::delete('/about/video', 'aboutVideoThumbDelete')->name('about_video_thumb_delete');
                Route::put('/terms', 'updateTerms')->name('admin.terms.update');
                Route::get('/terms/store', 'updateTermsStore')->name('admin.terms.store');

                Route::put('/promotions', 'updatePromotions')->name('admin.promotions.update');
                Route::get('/promotions/store', 'updatePromotionsStore')->name('admin.promotions.store');

                Route::put('/privacy', 'updatePrivacy')->name('admin.privacy.update');
                Route::get('/privacy/store', 'updatePrivacyStore')->name('admin.privacy.store');
                Route::put('/refund', 'updateRefund')->name('admin.refund.update');
                Route::get('/refund/store', 'updateRefundStore')->name('admin.refund.store');
                Route::put('/posting-rules', 'postingRulesUpdate')->name('admin.posting.rules.update');
                Route::put('/get-membership', 'updateGetMembership')->name('admin.getmembership.update');
                Route::put('/pricing-plan', 'updatePricingPlan')->name('admin.pricingplan.update');
                Route::put('/pricing-plan/Image', 'updatePricingPlanImage')->name('admin.pricingplanimage.update');
                Route::post('/pricing-plan/Service', 'postPricingPlanService')->name('admin.pricingplanservice.store');
                Route::delete('/pricing-plan/Service/{id}', 'deletePricingPlanService')->name('admin.pricingplanservice.delete');
                Route::get('/pricing-plan-service/edit/{id}', 'editPricingPlanService')->name('admin.pricingplanservice.edit');
                Route::put('/pricing-plan-service/update/{id}', 'updatePricingPlanService')->name('admin.pricingplanservice.update');
                Route::post('/pricing-plan/sorting', 'sortingPricingPlan')->name('admin.pricePlan.sorting');
                Route::put('/blog', 'updateBlog')->name('admin.blog.update');
                Route::put('/ads', 'updateAds')->name('admin.ads.update');
                Route::put('/contact', 'updateContact')->name('admin.contact.update');
                Route::put('/faq', 'updateFaq')->name('admin.faq.update');
                Route::put('/dashboard', 'updateDashboard')->name('admin.dashboard.update');
                Route::put('/auth-content', 'updateAuthContent')->name('admin.authcontent.update');
                Route::put('/coming-soon', 'updateComingSoon')->name('admin.comingsoon.update');
                Route::put('/maintenance', 'updateMaintenance')->name('admin.maintenance.update');
                Route::put('/errorpages', 'updateErrorPages')->name('admin.errorpages.update');
                Route::put('/footer-text', 'footerText')->name('admin.footer.text.update');
            });

        Route::controller(HomePageSliderController::class)
            ->prefix('settings')
            ->group(function () {
                Route::post('/slider/store', 'storeGallery')->name('store_gallery');
                Route::delete('/slider/{image}', 'deleteGallery')->name('delete_gallery');
            });

        Route::controller(AboutPageSliderController::class)
            ->prefix('settings')
            ->group(function () {
                Route::post('/about/slider/store', 'aboutStoreGallery')->name('about_store_gallery');
                Route::delete('/about/slider/{image}', 'aboutDeleteGallery')->name('about_delete_gallery');
            });
    });
});
