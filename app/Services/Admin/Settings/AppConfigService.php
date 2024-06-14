<?php

namespace App\Services\Admin\Settings;

use App\Models\Setting;
use Illuminate\Support\Facades\Config;
use Modules\Currency\Http\Controllers\CurrencyController;
// Add Config Facade to rewrite env
use Modules\Language\Http\Controllers\TranslationController;

class AppConfigService
{
    public function update($request)
    {

        $request->validate([
            'maximum_ad_image_limit' => 'required|numeric',
            'latest_ad_limit' => 'required|min:1',
            'featured_ad_limit' => 'required|min:1',
        ]);

        if ($request->has('timezone')) {
            $this->timezone($request);
        }

        if ($request->has('code')) {
            (new TranslationController())->setDefaultLanguage($request);
        }

        if ($request->app_debug) {
            envUpdate('APP_DEBUG', 'true');
        } else {
            envUpdate('APP_DEBUG', 'false');
        }

        if ($request->map_show == 1) {
            checkSetConfig('templatecookie.map_show', $request->map_show ? true : false);
        } else {
            checkSetConfig('templatecookie.map_show', $request->map_show ? true : false);
        }

        if ($request->has('currency')) {
            (new CurrencyController())->defaultCurrency($request);
        }
        $setting = Setting::first();
        $setting->website_loader = $request->website_loader ?? false;
        $setting->regular_ads_homepage = $request->regular_ads_homepage ?? false;
        $setting->featured_ads_homepage = $request->featured_ads_homepage ?? false;
        $setting->customer_email_verification = $request->customer_email_verification ?? false;
        $setting->ads_admin_approval = $request->ads_admin_approval ?? false;
        $setting->language_changing = $request->language_changing ?? false;
        $setting->currency_changing = $request->currency_changing ?? false;
        $setting->maximum_ad_image_limit = $request->maximum_ad_image_limit;
        $setting->latest_ad_limit = $request->latest_ad_limit;
        $setting->featured_ad_limit = $request->featured_ad_limit;

        $setting->save();
    }

    public function timezone($request)
    {
        $request->validate(['timezone' => 'required']);

        $timezone = $request->timezone;

        if ($timezone && $timezone != config('app.timezone')) {
            envReplace('APP_TIMEZONE', $timezone);

            flashSuccess('Timezone Updated Successfully!');
        }
    }
}
