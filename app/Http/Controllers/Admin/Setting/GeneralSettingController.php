<?php

namespace App\Http\Controllers\Admin\Setting;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\Timezone;
use App\Services\Admin\Settings\AppConfigService;
use App\Services\Admin\Settings\BroadcastUpdateService;
use App\Services\Admin\Settings\RecaptchaUpdateService;
use App\Services\Admin\Settings\WatermarkUpdateService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Modules\Currency\Entities\Currency;
use Modules\SetupGuide\Entities\SetupGuide;

class GeneralSettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('access_limitation')->only([
            'appConfigUpdate',
            'watermarkUpdate',
            'recaptchaUpdate',
            'broadcastingUpdate',
        ]);
    }

    /**
     * General Settings View
     *
     * @return void
     */
    public function general()
    {
        $setting = Setting::first();

        return view('admin.settings.pages.general.basic', compact('setting'));
    }

    /**
     * Website Data Update.
     *
     * @return RedirectResponse
     */
    public function generalUpdate(Request $request)
    {
        $request->validate([
            'name' => ['required'],
            'logo_image' => ['nullable', 'mimes:png,jpg,svg,jpeg', 'max:3072'],
            'white_logo' => ['nullable', 'mimes:png,jpg,svg,jpeg', 'max:3072'],
            'favicon_image' => ['nullable', 'mimes:png,ico', 'max:1024'],
            // 'app_pwa_icon' => ['nullable', 'mimes:png,jpg,jpeg'],
        ]);
        try {
            if ($request->name && $request->name != config('app.name')) {
                replaceAppName('APP_NAME', $request->name);
            }

            $setting = Setting::first();
            if ($request->hasFile('logo_image')) {
                $setting['logo_image'] = uploadFileToPublic($request->logo_image, 'app/logo');
                deleteFile($setting->logo_image);
            }

            if ($request->hasFile('white_logo')) {
                $setting['white_logo'] = uploadFileToPublic($request->white_logo, 'app/logo');
                deleteFile($setting->white_logo);
            }

            if ($request->hasFile('favicon_image')) {
                $setting['favicon_image'] = uploadFileToPublic($request->favicon_image, 'app/logo');
                deleteFile($setting->favicon_image);
            }

            if ($request->hasFile('app_pwa_icon')) {
                $setting['app_pwa_icon'] = uploadFileToPublic($request->app_pwa_icon, 'app/logo');
                deleteFile($setting->app_pwa_icon);
            }

            $setting->save();
            SetupGuide::where('task_name', 'app_setting')->update(['status' => 1]);

            return back()->with('success', 'Website setting updated successfully!');
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    /**
     * App Configuration Settings View
     *
     * @return void
     */
    public function appConfig()
    {
        try {
            $timezones = Timezone::all();
            $setting = Setting::first();
            $currencies = Currency::all();

            return view('admin.settings.pages.general.app', compact('timezones', 'setting', 'currencies'));
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    /**
     * App Configuration Settings Update
     *
     * @return RedirectResponse
     */
    public function appConfigUpdate(Request $request, AppConfigService $appConfigService)
    {
        try {
            $appConfigService->update($request);

            flashSuccess('App Configuration Updated!');

            return redirect()->back();
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    /**
     * Watermark Configuration Settings View
     *
     * @return void
     */
    public function watermark()
    {
        try {
            return view('admin.settings.pages.general.watermark-ads');
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    /**
     * Watermark Configuration Settings Update
     *
     * @return void
     */
    public function watermarkUpdate(Request $request, WatermarkUpdateService $watermarkUpdateService)
    {
        try {
            $watermarkUpdateService->update($request);

            flashSuccess('Watermark data updated !');

            return redirect()->back();
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    /**
     * App Configuration Settings View
     *
     * @return void
     */
    public function recaptcha()
    {
        try {
            return view('admin.settings.pages.general.recaptcha');
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    public function recaptchaUpdate(Request $request, RecaptchaUpdateService $recaptchaUpdateService)
    {
        try {
            $recaptchaUpdateService->update($request);

            sleep(2);
            Artisan::call('cache:clear');

            flashSuccess('Recaptcha Configuration updated!');

            return back();
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    /**
     * Broadcast Settings View
     *
     * @return void
     */
    public function broadcasting()
    {
        try {
            return view('admin.settings.pages.general.broadcast');
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    /**
     * Broadcast Settings Update
     *
     * @return RedirectResponse
     */
    public function broadcastingUpdate(Request $request, BroadcastUpdateService $broadcastUpdateService)
    {
        try {
            $broadcastUpdateService->update($request);

            SetupGuide::where('task_name', 'pusher_setting')->update(['status' => 1]);

            flashSuccess('Pusher Configuration updated!');

            return back();
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    /**
     * PWA Settings View
     *
     * @return void
     */
    public function pwa()
    {
        try {
            $setting = Setting::first();

            return view('admin.settings.pages.general.pwa', compact('setting'));
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    /**
     * PWA Settings Data Update.
     *
     * @return RedirectResponse
     */
    public function pwaUpdate(Request $request)
    {
        $request->validate([
            'app_pwa_icon' => ['nullable', 'mimes:png,jpg,jpeg'],
        ]);
        try {
            $setting = Setting::first();

            if ($request->hasFile('app_pwa_icon')) {
                $setting['app_pwa_icon'] = uploadFileToPublic($request->app_pwa_icon, 'app/logo');
                deleteFile($setting->app_pwa_icon);
            }

            // for pwa_enable
            $setting['pwa_enable'] = $request->pwa_enable;

            if ($request->pwa_enable) {
                $this->updateManifest($setting);
            }

            $setting->save();
            SetupGuide::where('task_name', 'app_setting')->update(['status' => 1]);

            return back()->with('success', 'PWA setting updated successfully!');
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    /**
     * Update manifest.json file
     *
     * @return void
     */
    private function updateManifest($setting)
    {
        $manifest = [

            'name' => config('app.name'),
            'short_name' => config('app.name'),
            'start_url' => route('frontend.index'),
            'background_color' => $setting->frontend_primary_color,
            'description' => config('app.name'),
            'display' => 'fullscreen',
            'theme_color' => $setting->frontend_primary_color,
            'icons' => [
                [
                    'src' => $setting->app_pwa_icon_url,
                    'sizes' => '512x512',
                    'type' => 'image/png',
                    'purpose' => 'any maskable',
                ],
            ],
        ];

        file_put_contents(public_path('manifest.json'), json_encode($manifest));
    }
}
