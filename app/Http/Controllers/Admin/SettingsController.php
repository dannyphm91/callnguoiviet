<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Cookie\UpdateCookie;
use App\Actions\Module\UpdateModule;
use App\Http\Controllers\Controller;
use App\Mail\SmtpTestEmail;
use App\Models\Cookies;
use App\Models\ModuleSetting;
use App\Models\Seo;
use App\Models\SeoPageContent;
use App\Models\Setting;
use App\Models\Timezone;
use App\Services\Admin\Seo\SeoService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;
use Modules\Currency\Entities\Currency;
use Modules\Language\Entities\Language;
use Modules\SetupGuide\Entities\SetupGuide;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class SettingsController extends Controller
{
    public $setting;

    public function __construct()
    {
        $this->middleware(['permission:setting.view|setting.update'])->only(['website', 'layout', 'color', 'custom', 'email', 'system']);
        $this->middleware(['permission:setting.update'])->only(['websiteUpdate', 'layoutUpdate', 'colorUpdate', 'customCssJSUpdate', 'modeUpdate', 'emailUpdate', 'testEmailSent']);
        $this->setting = loadSetting();
        $this->middleware('access_limitation')->only(['layoutUpdate', 'colorUpdate', 'customCssJSUpdate', 'modeUpdate', 'emailUpdate', 'testEmailSent', 'systemUpdate', 'cookiesUpdate', 'seoContentUpdate', 'moduleUpdate', 'websiteConfigurationUpdate', 'generateSitemap', 'upgrade', 'upgradeApply']);
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function theme()
    {
        return view('admin.settings.pages.theme');
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function custom()
    {
        return view('admin.settings.pages.custom');
    }

    /**
     * Update website layout
     *
     * @return void
     */
    public function layoutUpdate()
    {
        try {
            Setting::first()->update(request()->only('default_layout'));

            return back()->with('success', 'Website layout updated successfully!');
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    /**
     * color Data Update.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    public function colorUpdate()
    {
        try {
            Setting::first()->update(request()->only(['sidebar_color', 'nav_color', 'sidebar_txt_color', 'nav_txt_color', 'main_color', 'accent_color', 'frontend_primary_color', 'frontend_secondary_color']));

            SetupGuide::where('task_name', 'theme_setting')->update(['status' => 1]);

            return back()->with('success', 'Color setting updated successfully!');
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    /**
     * custom js and css Data Update.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    public function customCssJSUpdate()
    {
        try {
            Setting::first()->update(request()->only(['header_css', 'header_script', 'body_script']));

            return back()->with('success', 'Custom css/js updated successfully!');
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    /**
     * Mode Update.
     *
     * @return bool
     */
    public function modeUpdate(Request $request)
    {
        try {
            $dark_mode = $request->only(['dark_mode']);
            Setting::first()->update($dark_mode);

            return back()->with('success', 'Theme updated successfully!');
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    public function email()
    {
        return view('admin.settings.pages.mail');
    }

    /**
     * Update mail configuration settings on .env file
     *
     * @return void
     */
    public function emailUpdate(Request $request)
    {
        $request->validate([
            'mail_host' => 'required',
            'mail_port' => 'required',
            'numeric',
            'mail_username' => 'required',
            'mail_password' => 'required',
            'mail_encryption' => 'required',
            'mail_from_name' => 'required',
            'mail_from_address' => 'required',
            'email',
        ]);
        try {
            envUpdate('MAIL_HOST', $request->mail_host);
            envUpdate('MAIL_PORT', $request->mail_port);
            envUpdate('MAIL_USERNAME', $request->mail_username);
            envUpdate('MAIL_PASSWORD', $request->mail_password);
            envUpdate('MAIL_ENCRYPTION', $request->mail_encryption);
            replaceAppName('MAIL_FROM_NAME', $request->mail_from_name);
            envUpdate('MAIL_FROM_ADDRESS', $request->mail_from_address);

            SetupGuide::where('task_name', 'smtp_setting')->update(['status' => 1]);

            return back()->with('success', 'Mail configuration update successfully');
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    /**
     * Send a test email for check mail configuration credentials
     *
     * @return void
     */
    public function testEmailSent()
    {
        request()->validate(['test_email' => ['required', 'email']]);
        try {
            Mail::to(request()->test_email)->send(new SmtpTestEmail());

            return back()->with('success', 'Test email sent successfully.');
        } catch (\Throwable $th) {
            return back()->with('error', 'Invalid email configuration. Mail send failed.');
        }
    }

    /**
     * View Website mode page
     *
     * @return void
     */
    public function system()
    {
        try {
            $timezones = Timezone::all();
            $currencies = Currency::all();

            return view('admin.settings.pages.preference', compact('timezones', 'currencies'));
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    public function systemUpdate(Request $request)
    {
        try {
            if ($request->app_mode == 'live') {
                envUpdate('APP_MODE', $request->app_mode);
                $message = 'App is now live mode';
            } elseif ($request->app_mode == 'maintenance') {
                envUpdate('APP_MODE', $request->app_mode);
                $message = 'App is in maintenance mode';
            } else {
                envUpdate('APP_MODE', $request->app_mode);
                $message = 'App is in coming soon mode!';
            }

            flashSuccess($message);

            return redirect()->back();
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    public function cookies()
    {
        try {
            $cookie = Cookies::firstOrFail();

            return view('admin.settings.pages.cookies', compact('cookie'));
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    public function cookiesUpdate(Request $request, UpdateCookie $updateCookie)
    {
        try {
            $updateCookie->handle($request);
            flashSuccess('Cookies settings successfully updated!');

            return back();
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    public function seoIndex(Request $request, SeoService $seoService)
    {
        try {
            $data = $seoService->index($request);

            return view('admin.settings.pages.seo.index', $data);
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    /**
     * Seo Content Create
     *
     * @return RedirectResponse
     */
    public function seoContentCreate(Request $request)
    {
        try {
            $seo = Seo::FindOrFail($request->page_id);
            $exist_content = $seo
                ->contents()
                ->where('language_code', $request->language_code)
                ->first();
            $en_content = $seo->contents()->where('language_code', 'en')->first();

            $content = '';
            if ($exist_content) {
                $content = $exist_content;
            } else {
                $new_content = $seo->contents()->create([
                    'language_code' => $request->language_code,
                    'title' => $en_content->title,
                    'description' => $en_content->description,
                    'image' => $en_content->image,
                ]);
                $content = $new_content;
            }

            return redirect()->route('settings.seo.edit', [$seo->id, 'lang_query' => $content->language_code]);
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    public function seoEdit($page)
    {
        try {
            $seo = Seo::FindOrFail($page);
            $en_content = $seo->contents()->where('language_code', 'en')->first();

            if (request('lang_query')) {
                $exist_content = $seo->contents()->where('language_code', request('lang_query'))->first();

                if (! $exist_content) {
                    $new_content = $seo->contents()->create([
                        'language_code' => request('lang_query'),
                        'title' => $en_content->title,
                        'description' => $en_content->description,
                        'image' => $en_content->image,
                    ]);
                }
            }

            if (request('lang_query')) {
                $content = $seo->contents()->where('language_code', request('lang_query'))->first();
            } else {
                $content = $seo->contents()->first();
            }

            $seo->load('contents');
            $languages = Language::get(['id', 'code', 'name']);

            $seo = Seo::FindOrFail($page);

            return view('admin.settings.pages.seo.edit', compact('seo', 'languages', 'content'));
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    /**
     * Seo Content Create
     *
     * @return RedirectResponse
     */
    public function seoContentUpdate(Request $request, SeoPageContent $content)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
        ]);
        try {
            $content->update([
                'title' => $request->title,
                'description' => $request->description,
            ]);

            if ($request->image != null && $request->hasFile('image')) {
                deleteFile($content->image);

                $path = 'images/seo';
                $image = uploadImage($request->image, $path);

                $content->update([
                    'image' => $image,
                ]);
            }
            flashSuccess('Page Meta Content Updated successfully');

            return redirect()->back();
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    public function modules()
    {
        try {
            $modulesetting = ModuleSetting::first();

            return view('admin.settings.pages.module', compact('modulesetting'));
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    public function moduleUpdate(Request $request, UpdateModule $updateModule)
    {
        try {
            $updateModule->handel($request);
            flashSuccess('Module settings updated!');

            return back();
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    public function websiteConfigurationUpdate(Request $request)
    {
        try {
            $setting = Setting::first();
            $setting->facebook = $request->facebook;
            $setting->twitter = $request->twitter;
            $setting->instagram = $request->instagram;
            $setting->youtube = $request->youtube;
            $setting->linkdin = $request->linkdin;
            $setting->whatsapp = $request->whatsapp;
            $setting->save();

            flashSuccess('Website configuration updated!');

            return back();
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    public function payperadsUpdate(Request $request)
    {
        $request->validate([
            [
                'per_ads_price' => 'nullable|numeric',
                'highlight_ads_price' => 'nullable|numeric',
                'highlight_ads_duration' => 'nullable|numeric',
                'featured_ads_price' => 'nullable|numeric',
                'featured_ads_duration' => 'nullable|numeric',
                'top_ads_price' => 'nullable|numeric',
                'top_ads_duration' => 'nullable|numeric',
                'bump_ads_price' => 'nullable|numeric',
                'bump_ads_duration' => 'nullable|numeric',
                'urgent_ads_price' => 'nullable|numeric',
                'urgent_ads_duration' => 'nullable|numeric',
            ],
        ]);
        try {
            // payper setting data
            $this->setting->update([
                'per_ads_active' => $request->status ?? 0,
                'per_ads_price' => $request->per_ads_price,
                'highlight_ads_price' => $request->highlight_ads_price,
                'highlight_ads_duration' => $request->highlight_ads_duration,
                'featured_ads_price' => $request->featured_ads_price,
                'featured_ads_duration' => $request->featured_ads_duration,
                'top_ads_price' => $request->top_ads_price,
                'top_ads_duration' => $request->top_ads_duration,
                'bump_ads_price' => $request->bump_ads_price,
                'bump_ads_duration' => $request->bump_ads_duration,
                'urgent_ads_price' => $request->urgent_ads_price,
                'urgent_ads_duration' => $request->urgent_ads_duration,
            ]);

            // forget session data
            cache()->forget('highlight_job_days');
            cache()->forget('featured_job_days');

            flashSuccess(__('payperads_setting_updated'));

            return back();
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    /**
     *  Sitemap generator for xml
     */
    public function generateSitemap()
    {
        try {
            $sitemap = Sitemap::create()->add(Url::create('/'))->add(Url::create('/ad-list'))->add(Url::create('/blog'))->add(Url::create('/price-plan'))->add(Url::create('/about'))->add(Url::create('/contact'))->add(Url::create('/login'))->add(Url::create('/sign-up'))->add(Url::create('/faq'))->add(Url::create('/terms-conditions'))->add(Url::create('/privacy'))->add(Url::create('/refund'));
            $sitemap->writeToFile(public_path('sitemap.xml'));

            flashSuccess('Sitemap successfully created !');

            return redirect()->back();
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    /**
     * Upgrade application
     */
    public function upgrade()
    {
        try {
            return view('admin.settings.pages.upgrade-guide');
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    /**
     * Upgrade applying
     *
     * @return RedirectResponse
     */
    public function upgradeApply()
    {
        try {
            Artisan::call('permission:cache-reset');
            // Fore plug added because in product mode migrate command is not run
            Artisan::call('migrate', ['--force' => true]);
            $this->moveSocialEnvValueToConfig();
            $this->moveEnvValueToConfig();
            $this->moveStripeConfigToCashierConfig();

            flashSuccess('Application Upgrade Successfully');

            return back();
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    public function moveEnvValueToConfig()
    {
        try {
            $allEmptyProperties = array_filter(Config::get('zakirsoft'), function ($value) {
                return $value === '';
            });

            foreach ($allEmptyProperties as $property => $value) {
                $envProperty = strtoupper($property);
                $envValue = env($envProperty);
                if ($envValue !== null && $envValue !== '') {
                    // Update the value in Config::get('zakirsoft') with the value from .env
                    checkSetConfig('templatecookie.'.$property, $envValue);
                }
            }
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    public function moveSocialEnvValueToConfig()
    {
        // Update social login config
        $google_client_id = env('GOOGLE_CLIENT_ID');
        $google_client_secret = env('GOOGLE_CLIENT_SECRET');
        $google_login_active = env('GOOGLE_LOGIN_ACTIVE');

        $facebook_client_id = env('FACEBOOK_CLIENT_ID');
        $facebook_client_secret = env('FACEBOOK_CLIENT_SECRET');
        $facebook_login_active = env('FACEBOOK_LOGIN_ACTIVE');

        $twitter_client_id = env('TWITTER_CLIENT_ID');
        $twitter_client_secret = env('TWITTER_CLIENT_SECRET');
        $twitter_login_active = env('TWITTER_LOGIN_ACTIVE');

        $linkedin_client_id = env('LINKEDIN_CLIENT_ID');
        $linkedin_client_secret = env('LINKEDIN_CLIENT_SECRET');
        $linkedin_login_active = env('LINKEDIN_LOGIN_ACTIVE');

        $github_client_id = env('GITHUB_CLIENT_ID');
        $github_client_secret = env('GITHUB_CLIENT_SECRET');
        $github_login_active = env('GITHUB_LOGIN_ACTIVE');

        checkSetConfig('services.google.client_id', $google_client_id);
        checkSetConfig('services.google.client_secret', $google_client_secret);
        checkSetConfig('services.google.active', $google_login_active ? true : false);

        checkSetConfig('services.facebook.client_id', $facebook_client_id);
        checkSetConfig('services.facebook.client_secret', $facebook_client_secret);
        checkSetConfig('services.facebook.active', $facebook_login_active ? true : false);

        checkSetConfig('services.twitter.client_id', $twitter_client_id);
        checkSetConfig('services.twitter.client_secret', $twitter_client_secret);
        checkSetConfig('services.twitter.active', $twitter_login_active ? true : false);

        checkSetConfig('services.linkedin.client_id', $linkedin_client_id);
        checkSetConfig('services.linkedin.client_secret', $linkedin_client_secret);
        checkSetConfig('services.linkedin.active', $linkedin_login_active ? true : false);

        checkSetConfig('services.github.client_id', $github_client_id);
        checkSetConfig('services.github.client_secret', $github_client_secret);
        checkSetConfig('services.github.active', $github_login_active ? true : false);
    }

    public function moveStripeConfigToCashierConfig()
    {
        try {
            $stripe_key = config('templatecookie.stripe_key') ?: env('STRIPE_KEY');
            $stripe_secret = config('templatecookie.stripe_secret') ?: env('STRIPE_SECRET');
            $stripe_webhook_secret = config('templatecookie.stripe_webhook_secret') ?: env('STRIPE_WEBHOOK_SECRET');

            checkSetConfig('cashier.key', $stripe_key);
            checkSetConfig('cashier.secret', $stripe_secret);
            checkSetConfig('cashier.webhook.secret', $stripe_webhook_secret);
            checkSetConfig('stripe-webhooks.signing_secret', $stripe_webhook_secret);
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    public function themeUpdate(Request $request)
    {
        // Validate the request data if needed
        $request->validate([
            'current_theme' => 'required|numeric', // Add any necessary validation rules
        ]);

        // Get the authenticated user
        $setting = Setting::first();

        // Update the user's theme preference
        $setting->update([
            'current_theme' => $request->input('current_theme'),
        ]);

        return back()->with('success', 'Theme updated successfully!');
    }
}
