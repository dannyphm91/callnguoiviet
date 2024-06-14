<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        if (! app()->runningInConsole()) {
            // Load data from helper with caching
            if (Schema::hasTable('countries') && DB::table('countries')->count() > 0) {
                $headerCountries = loadCountries();
            } else {
                $headerCountries = [];
            }

            if (Schema::hasTable('user_document_verifications')) {
                $document_verification_requests = loadDocumentVerificationRequests();
            } else {
                $document_verification_requests = 0;
            }

            $load_setting = loadSetting();
            $load_languages = loadLanguage();
            $module_setting = loadModuleSetting();
            $cookies_setting = loadCookiesSetting();
            $cms_setting = loadCmsSetting();
            $load_currencies = loadHeaderCurrency();
            $load_mobile_app_config = loadMobileAppConfig();
            $load_footer_categories = loadFooterCategories();
            $load_top_categories = loadTopCategories();
            $load_report_categories = loadReportCategories();

            // Share data to all views
            view()->share('setting', $load_setting);
            view()->share('languages', $load_languages);
            view()->share('headerCountries', $headerCountries);
            view()->share('cookies', $cookies_setting);
            view()->share('cms', $cms_setting);
            view()->share('mobile_setting', $load_mobile_app_config);
            view()->share('headerCurrencies', $load_currencies);
            view()->share('document_verification_requests', $document_verification_requests);
            view()->share('footer_categories', $load_footer_categories);
            view()->share('top_categories', $load_top_categories);
            view()->share('ad_report_categories', $load_report_categories);

            if ($module_setting) {
                view()->share('blog_enable', $module_setting->blog);
                view()->share('newsletter_enable', $module_setting->newsletter);
                view()->share('contact_enable', $module_setting->contact);
                view()->share('faq_enable', $module_setting->faq);
                view()->share('testimonial_enable', $module_setting->testimonial);
                view()->share('priceplan_enable', $module_setting->price_plan);
                view()->share('language_enable', $module_setting->language);
                view()->share('appearance_enable', $module_setting->appearance);
            }
        }
    }
}
