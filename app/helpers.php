<?php

use App\Models\AdReportCategory;
use App\Models\Advertisement;
use App\Models\Cms;
use App\Models\Cookies;
use App\Models\Country;
use App\Models\Messenger;
use App\Models\ModuleSetting;
use App\Models\SearchCountry;
use App\Models\Seo;
use App\Models\Setting;
use App\Models\Theme;
use App\Models\User;
use App\Models\UserDocumentVerification;
use App\Models\UserPlan;
use App\Notifications\LoginNotification;
use Carbon\Carbon;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\ViewErrorBag;
use Intervention\Image\Facades\Image;
use Modules\Ad\Entities\Ad;
use Modules\Category\Entities\Category;
use Modules\Category\Transformers\CategoryResource;
use Modules\Currency\Entities\Currency;
use Modules\Language\Entities\Language;
use Modules\MobileApp\Entities\MobileAppConfig;
use Modules\SetupGuide\Entities\SetupGuide;
use Modules\Wishlist\Entities\Wishlist;
use Stevebauman\Location\Facades\Location;
use Stichoza\GoogleTranslate\GoogleTranslate;

/*
|--------------------------------------------------------------------------
| Image Helpers
|--------------------------------------------------------------------------
*/

/**
 * Upload image to public folder
 *
 * @param  object  $file
 * @param  string  $path
 * @param  bool  $watermark
 * @return string
 */
if (! function_exists('uploadImage')) {
    function uploadImage(?object $file, string $path, $watermark = true): string
    {
        $pathCreate = public_path("/uploads/$path/");
        if (! File::isDirectory($pathCreate)) {
            File::makeDirectory($pathCreate, 0777, true, true);
        }

        if ($watermark && setting('watermark_status')) {

            $watermark_image = Image::make(setting('watermark_image'));
            $type = setting('watermark_type');
            $text = setting('watermark_text');

            $fileName = time().'_'.uniqid().'.'.$file->getClientOriginalExtension();
            $updated_img = Image::make($file);

            if ($type == 'text') {

                $updated_img->text($text, 300, 1000, function ($font) {
                    $font->file(public_path('RobotoMono-Bold.ttf'));
                    $font->size(50);
                    $font->color('#e1e1e1');
                    $font->valign('bottom-right');
                    $font->align('bottom-right');
                });
            } else {

                $imageWidth = $updated_img->width();
                $watermarkSize = round(10 * $imageWidth / 50);
                $watermark_image->resize($watermarkSize, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $updated_img->insert($watermark_image, 'bottom-right', 10, 10);
            }

            $updated_img->save(public_path('/uploads/'.$path.'/').$fileName);

            return "uploads/$path/".$fileName;
        } else {

            $fileName = time().'_'.uniqid().'.'.$file->getClientOriginalExtension();
            $file->move(public_path('/uploads/'.$path.'/'), $fileName);

            return "uploads/$path/".$fileName;
        }
    }
}

/**
 * Delete image from directory
 *
 * @param  string  $image
 * @return void
 */
if (! function_exists('deleteImage')) {
    function deleteImage(?string $image)
    {
        $imageExists = file_exists($image);
        if ($imageExists != 'backend/image/default.webp') {
            if ($imageExists) {
                @unlink($image);
            }
        }
    }
}

/**
 * image delete
 *
 * @param  string  $image
 * @return void
 */
if (! function_exists('deleteFile')) {
    function deleteFile(?string $image)
    {
        $imageExists = file_exists($image);

        if ($imageExists) {
            if ($imageExists != 'backend/image/default-user.png') {
                @unlink($image);
            }
        }
    }
}

/**
 * @param  UploadedFile  $file
 * @param  null  $folder
 * @param  string  $disk
 * @param  null  $filename
 * @return false|string
 */
if (! function_exists('uploadOne')) {
    function uploadOne(UploadedFile $file, $folder = null, $disk = 'public', $filename = null)
    {
        $name = ! is_null($filename) ? $filename : uniqid('FILE_').dechex(time());

        return $file->storeAs($folder, $name.'.'.$file->getClientOriginalExtension(), $disk);
    }
}

/**
 * @param  null  $path
 * @param  string  $disk
 */
if (! function_exists('deleteOne')) {
    function deleteOne($path = null, $disk = 'public')
    {
        Storage::disk($disk)->delete($path);
    }
}

/**
 * Uploads a file to the specified storage path and returns the file path.
 *
 * @param  \Illuminate\Http\UploadedFile  $file
 * @param  string  $path
 * @return string
 */
if (! function_exists('uploadFileToStorage')) {
    function uploadFileToStorage($file, string $path)
    {
        $file_name = $file->hashName();
        Storage::putFileAs($path, $file, $file_name);

        return $path.'/'.$file_name;
    }
}

/**
 * Uploads a file to the public directory and returns the file URL.
 *
 * @param  \Illuminate\Http\UploadedFile  $file
 * @param  string  $path
 * @return string|null
 */
if (! function_exists('uploadFileToPublic')) {
    function uploadFileToPublic($file, string $path)
    {
        if ($file && $path) {
            $url = $file->move('uploads/'.$path, $file->hashName());
        } else {
            $url = null;
        }

        return $url;
    }
}

/**
 * Checks if the 'getUnsplashImage' function exists, and if not, defines it.
 * The function fetches a random image from Unsplash with the tags nature, landscape, or mountains,
 * and returns the URL of the image.
 *
 * useCount: 0
 *
 * @return string The URL of the random Unsplash image.
 */

// if (!function_exists('getUnsplashImage')) {
//     function getUnsplashImage()
//     {
//         $url = 'https://source.unsplash.com/random/1920x1280/?nature,landscape,mountains';
//         $ch = curl_init();
//         curl_setopt($ch, CURLOPT_URL, $url);
//         curl_setopt($ch, CURLOPT_HEADER, true);
//         curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // Must be set to true so that PHP follows any "Location:" header
//         curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

//         $a = curl_exec($ch); // $a will contain all headers

//         $url = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);

//         return $url;
//     }
// }

// =====================================================
// ===================Env Function======================
// =====================================================
/**
 * Set config value
 *
 * @param  string  $key
 * @param  string  $value
 * @return void
 */
if (! function_exists('setConfig')) {
    function setConfig($key, $value)
    {
        Config::write($key, $value);

        if (file_exists(App::getCachedConfigPath())) {
            Artisan::call('config:cache');
        }
    }
}

/**
 * Check config value
 *
 * @param  string  $key
 * @param  string  $value
 * @return void
 */
if (! function_exists('checkSetConfig')) {
    function checkSetConfig($key, $value)
    {
        if ((config($key) != $value)) {
            setConfig($key, $value);
        }
    }
}

/**
 * Replace an environment variable value in the .env file and refresh the cached configuration.
 *
 * @param  string  $name  The name of the environment variable.
 * @param  mixed  $value  The new value to set for the environment variable.
 * @return void
 */
if (! function_exists('envReplace')) {
    function envReplace($name, $value)
    {
        $path = base_path('.env');
        if (file_exists($path)) {
            file_put_contents($path, str_replace(
                $name.'='.env($name),
                $name.'='.$value,
                file_get_contents($path)
            ));
        }

        if (file_exists(App::getCachedConfigPath())) {
            Artisan::call('config:cache');
        }
    }
}

/**
 * Replace the value of an environment variable in the .env file and clear the cached configuration.
 *
 * @param  string  $name  The name of the environment variable.
 * @param  string  $value  The new value to set for the environment variable.
 * @return void
 */
if (! function_exists('replaceAppName')) {
    function replaceAppName($name, $value)
    {
        $path = base_path('.env');
        if (file_exists($path)) {
            // Wrap the value in double quotes and replace the line
            $escapedValue = '"'.str_replace('"', '\"', $value).'"';
            file_put_contents($path, preg_replace(
                "/^$name=.*/m",
                "$name=$escapedValue",
                file_get_contents($path)
            ));
        }

        if (file_exists(App::getCachedConfigPath())) {
            Artisan::call('config:clear');
        }
    }
}

/**
 * Update an environment variable in the .env file and reset OPcache if available.
 *
 * @param  string  $key  The key of the environment variable.
 * @param  string  $value  The new value for the environment variable.
 * @return void
 */
function envUpdate($key, $value)
{
    $envFile = base_path('.env');
    $envContent = file_get_contents($envFile);

    $newLine = "$key=$value";

    if (strpos($envContent, "$key=") !== false) {
        $envContent = preg_replace("/$key=.*/", $newLine, $envContent);
    } else {
        $envContent .= "\n".$newLine;
    }

    file_put_contents($envFile, $envContent);

    if (function_exists('opcache_reset')) {
        opcache_reset();
    }
}

/*
|--------------------------------------------------------------------------
| Flash Helpers
|--------------------------------------------------------------------------
*/

/**
 * Response success flash message.
 *
 * @return \Illuminate\Http\Response
 */
if (! function_exists('flashSuccess')) {
    function flashSuccess(string $msg)
    {
        session()->flash('success', $msg);
    }
}

/**
 * Response error flash message.
 *
 * @param  string  $msg
 * @return \Illuminate\Http\Response
 */
if (! function_exists('flashError')) {
    function flashError(string $message = 'Something went wrong')
    {
        return session()->flash('error', $message);
    }
}

/**
 * Response warning flash message.
 *
 * @param  string  $msg
 * @return \Illuminate\Http\Response
 */
if (! function_exists('flashWarning')) {
    function flashWarning(string $message = 'Something went wrong')
    {
        return session()->flash('warning', $message);
    }
}

/*
|--------------------------------------------------------------------------
| Time Helpers
|--------------------------------------------------------------------------
*/

/**
 * Formats a given date using Carbon and returns the formatted time.
 *
 * @param  mixed  $date
 * @param  string  $format
 * @return string|null
 */
if (! function_exists('formatTime')) {
    function formatTime($date, $format = 'F d, Y H:i A')
    {
        if ($date) {
            return Carbon::parse($date)->format($format);
        }

        return null;
    }
}

/**
 * Converts a given date to a human-readable format using Carbon.
 *
 * @param  mixed  $date
 * @return string|null
 */
if (! function_exists('humanTime')) {
    function humanTime($date)
    {
        if ($date) {
            return Carbon::parse($date)->diffForHumans();
        }

        return null;
    }
}

/*
|--------------------------------------------------------------------------
| Caching Helpers
|--------------------------------------------------------------------------
*/

/**
 * Load setting from cache
 *
 * @return Setting
 */
if (! function_exists('loadSetting')) {
    function loadSetting()
    {
        return Cache::rememberForever('setting', function () {
            return Setting::first();
        });
    }
}

/**
 * Load languages from cache
 *
 * @return Language
 */
if (! function_exists('loadLanguage')) {
    function loadLanguage()
    {
        return Cache::rememberForever('languages', function () {
            return Language::all(['id', 'name', 'code', 'icon']);
        });
    }
}

/**
 * Load advertisement from cache
 *
 * @return Currency
 */
if (! function_exists('loadAdvertisements')) {
    function loadAdvertisements()
    {
        return Cache::remember('advertisements', now()->addDays(30), function () {
            return Advertisement::all();
        });
    }
}

/**
 * Load default language from cache
 *
 * @return Language
 */
if (! function_exists('loadDefaultLanguage')) {
    function loadDefaultLanguage()
    {
        return Cache::remember('default_language', now()->addDays(30), function () {
            return Language::where('code', env('APP_DEFAULT_LANGUAGE'))->first();
        });
    }
}

/**
 * Load current language from cache
 *
 * @return Language
 */
if (! function_exists('loadCurrentLanguage')) {
    function loadCurrentLanguage()
    {
        return Cache::remember('current_language', now()->addDays(30), function () {
            return Language::where('code', session('set_lang'))->first();
        });
    }
}

/**
 * Forget cache and load setting
 *
 * @return Currency
 */
if (! function_exists('forgetCache')) {
    function forgetCache($name)
    {
        Cache::forget($name);
        loadSetting();

        return true;
    }
}

/**
 * Checks if the 'loadCountries' function exists, and if not, defines it.
 * The function fetches all countries from the 'SearchCountry' model and caches the result forever.
 * The cached data includes the 'id', 'name', 'slug', and 'icon' of each country.
 *
 * @return Collection The collection of countries.
 */
if (! function_exists('loadCountries')) {
    function loadCountries()
    {
        return Cache::rememberForever('countries', function () {
            return SearchCountry::all(['id', 'name', 'slug', 'icon']);
        });
    }
}

/**
 * Checks if the 'loadAllCountries' function exists, and if not, defines it.
 * The function fetches all countries from the 'Country' model and caches the result forever.
 *
 * @return Collection The collection of all countries.
 */
if (! function_exists('loadAllCountries')) {
    function loadAllCountries()
    {
        return Cache::rememberForever('all_countries', function () {
            return Country::all();
        });
    }
}

/**
 * If 'loadModuleSetting' doesn't exist, define it.
 * It fetches the first 'ModuleSetting' record and caches it.
 *
 * @return ModuleSetting The first record.
 */
if (! function_exists('loadModuleSetting')) {
    function loadModuleSetting()
    {
        return Cache::rememberForever('modules', function () {
            return ModuleSetting::first();
        });
    }
}

/**
 * If 'loadCookiesSetting' doesn't exist, define it.
 * It fetches the first 'Cookies' record and caches it.
 *
 * @return Cookies The first record.
 */
if (! function_exists('loadCookiesSetting')) {
    function loadCookiesSetting()
    {
        return Cache::rememberForever('cookies', function () {
            return Cookies::first();
        });
    }
}

/**
 * If 'loadCmsSetting' doesn't exist, define it.
 * It fetches the first 'Cms' record and caches it.
 *
 * @return Cms The first record.
 */
if (! function_exists('loadCmsSetting')) {
    function loadCmsSetting()
    {
        return Cache::rememberForever('cms', function () {
            return Cms::first();
        });
    }
}

/**
 * If 'loadHeaderCurrency' doesn't exist, define it.
 * It fetches all 'Currency' records and caches them.
 *
 * @return Collection The collection of all currencies.
 */
if (! function_exists('loadHeaderCurrency')) {
    function loadHeaderCurrency()
    {
        return Cache::rememberForever('currencies', function () {
            return Currency::all();
        });
    }
}

/**
 * If 'loadMobileAppConfig' doesn't exist, define it.
 * It fetches the first 'MobileAppConfig' record and caches it.
 *
 * @return MobileAppConfig The first record.
 */
if (! function_exists('loadMobileAppConfig')) {
    function loadMobileAppConfig()
    {
        return Cache::rememberForever('mobile_app_config', function () {
            return MobileAppConfig::first();
        });
    }
}

/**
 * If 'loadDocumentVerificationRequests' doesn't exist, define it.
 * It fetches the count of approved 'UserDocumentVerification' records and caches it.
 *
 * @return int The count of approved document verification requests.
 */
if (! function_exists('loadDocumentVerificationRequests')) {
    function loadDocumentVerificationRequests()
    {
        return Cache::rememberForever('document_verification_request', function () {
            return UserDocumentVerification::approved()->count();
        });
    }
}

/**
 * If 'loadFooterCategories' doesn't exist, define it.
 * It fetches the latest 4 active 'Category' records and caches them.
 *
 * @return Collection The collection of the latest 4 active categories.
 */
if (! function_exists('loadFooterCategories')) {
    function loadFooterCategories()
    {
        return Cache::rememberForever('footer_categories', function () {
            return Category::active()
                ->latest()
                ->take(4)
                ->get();
        });
    }
}

/**
 * If 'loadTopCategories' doesn't exist, define it.
 * It fetches the top 8 active 'Category' records with the most ads and caches them.
 *
 * @return Collection The collection of the top 8 active categories with the most ads.
 */
if (! function_exists('loadTopCategories')) {
    function loadTopCategories()
    {
        return Cache::rememberForever('top_categories', function () {
            return CategoryResource::collection(
                Category::active()
                    ->withCount('ads as ad_count')
                    ->latest('ad_count')
                    ->take(8)
                    ->get(),
            );
        });
    }
}

/**
 * If 'loadCategoriesSubcategories' doesn't exist, define it.
 * It fetches all active 'Category' records along with their active 'Subcategory' records,
 * based on the current language, and caches them.
 *
 * @return Collection The collection of active categories and their active subcategories.
 */
if (! function_exists('loadCategoriesSubcategories')) {
    function loadCategoriesSubcategories()
    {
        return Cache::rememberForever('categories_subcategories', function () {
            $locale = currentLanguage()->code;
            $categories = Category::active()
                ->with([
                    'subcategories' => function ($q) use ($locale) {
                        $q->whereTranslation('locale', $locale)->where('status', 1);
                    },
                ])
                ->whereTranslation('locale', $locale)
                ->get();

            return $categories->map(function ($category) use ($locale) {
                return [
                    'id' => $category->id,
                    'name' => $category->translate($locale)->name,
                    'slug' => $category->slug,
                    'subcategories' => $category->subcategories->map(function ($subcategory) use ($locale) {
                        return [
                            'id' => $subcategory->id,
                            'name' => $subcategory->translate($locale)->name,
                            'slug' => $subcategory->slug,
                        ];
                    }),
                ];
            });
        });
    }
}

/**
 * If 'loadMinPrice' doesn't exist, define it.
 * It fetches the minimum price from all 'Ad' records and caches it.
 *
 * @return int The minimum price among all ads.
 */
if (! function_exists('loadMinPrice')) {
    function loadMinPrice()
    {
        return Cache::rememberForever('min_price', function () {
            return Ad::min('price');
        });
    }
}

/**
 * If 'loadMaxPrice' doesn't exist, define it.
 * It fetches the maximum price from all 'Ad' records and caches it.
 *
 * @return int The maximum price among all ads.
 */
if (! function_exists('loadMaxPrice')) {
    function loadMaxPrice()
    {
        return Cache::rememberForever('max_price', function () {
            return Ad::max('price');
        });
    }
}

if (! function_exists('loadReportCategories')) {
    function loadReportCategories()
    {
        return Cache::rememberForever('report_categories', function () {
            return AdReportCategory::all();
        });
    }
}

/*
|--------------------------------------------------------------------------
| Error Helpers
|--------------------------------------------------------------------------
*/

/**
 * Check if there are errors for a given form field in the session.
 * useCount: 0
 *
 * @param  string  $name  The name of the form field.
 * @return bool True if there are errors, false otherwise.
 */

// if (!function_exists('haveError')) {
//     function haveError($name): bool
//     {
//         $errors = session()->get('errors', app(ViewErrorBag::class));
//         if ($errors->has($name)) {
//             return true;
//         } else {
//             return false;
//         }
//     }
// }

/**
 * Check if there is an error for a given form field and return the appropriate CSS class.
 *
 * @param  string  $name  The name of the form field.
 * @return string The CSS class 'is-invalid' if there is an error, otherwise an empty string.
 */
if (! function_exists('error')) {
    function error($name)
    {
        $errors = session()->get('errors', app(ViewErrorBag::class));

        return $errors->has($name) ? 'is-invalid' : '';
    }
}

/*
|--------------------------------------------------------------------------
| Currency Helpers
|--------------------------------------------------------------------------
*/

/**
 * Get the default currency symbol from the environment configuration.
 * useCount: 0
 *
 * @return string The default currency symbol.
 */

// if (!function_exists('defaultCurrencySymbol'))
// {
//     function defaultCurrencySymbol(): string
//     {
//         return env('APP_CURRENCY_SYMBOL');
//     }
// }

/**
 * Convert an amount from one currency to another using the specified exchange rates.
 *
 * @param  float  $amount  The amount to be converted.
 * @param  string|null  $from  The source currency code (default is the template currency).
 * @param  string|null  $to  The target currency code (default is USD).
 * @param  int  $round  The number of decimal places to round the result to (default is 2).
 * @return int|null The converted amount or null if currency information is not available.
 */
if (! function_exists('currencyConversion')) {
    function currencyConversion($amount, $from = null, $to = null, $round = 2)
    {
        $from = $from ?? config('templatecookie.currency');
        $to = $to ?? 'USD';

        $fromCurrency = Currency::whereCode($from)->first();
        $toCurrency = Currency::whereCode($to)->first();

        if (! $fromCurrency || ! $toCurrency) {

            return null;
        }

        $fromRate = $fromCurrency->rate;
        $toRate = $toCurrency->rate;
        $rate = $toRate / $fromRate;

        return (int) round($amount * $rate, $round);
    }
}

/**
 * Get the current currency code based on the session setting or default template currency.
 * useCount: 1
 *
 * @return string The current currency code.
 */
if (! function_exists('currentCurrencyCode')) {
    function currentCurrencyCode()
    {
        if (session()->has('current_currency')) {
            $currency = session('current_currency');

            return $currency->code;
        }

        return config('templatecookie.currency');
    }
}

/**
 * Get current Currency symbol
 *
 * @return string
 */
if (! function_exists('currentCurrencySymbol')) {
    function currentCurrencySymbol()
    {
        if (session()->has('current_currency')) {
            $currency = session('current_currency');

            return $currency->symbol;
        }

        return config('templatecookie.currency_symbol');
    }
}

/**
 * Currency exchange
 * useCount: 0
 *
 * @param  $amount
 * @param  $from
 * @param  $to
 * @param  $round
 * @return number
 */

// if (! function_exists('currencyExchange')) {
//     function currencyExchange($amount, $from = null, $to = null, $round = 2)
//     {
//         $from = currentCurrencyCode();
//         $to = config('templatecookie.currency', 'USD');

//         $fromRate = Currency::whereCode($from)->first()->rate;
//         $toRate = Currency::whereCode($to)->first()->rate;
//         $rate = $toRate / $fromRate;

//         return round($amount * $rate);
//     }
// }

/**
 * Currency rate store in session
 * useCount: 1
 *
 * @return void
 */
if (! function_exists('currencyRateStore')) {
    function currencyRateStore()
    {
        if (session()->has('currency_rate')) {
            $currency_rate = session('currency_rate');
            $from = config('templatecookie.currency');
            $to = currentCurrencyCode();

            if ($currency_rate['from'] != $from || $currency_rate['to'] != $to) {
                $fromRate = Currency::whereCode($from)->first()->rate;
                $toRate = Currency::whereCode($to)->first()->rate;
                $rate = $toRate / $fromRate;
                session(['currency_rate' => ['from' => $from, 'to' => $to, 'rate' => $rate]]);
            }
        } else {
            $from = config('templatecookie.currency');
            $to = currentCurrencyCode();

            $fromRate = Currency::whereCode($from)->first()->rate;
            $toRate = Currency::whereCode($to)->first()->rate;
            $rate = $toRate / $fromRate;
            session(['currency_rate' => ['from' => $from, 'to' => $to, 'rate' => $rate]]);
        }
    }
}

/**
 * Get currency rate
 * useCount: only in the helper
 *
 * @return number
 */
if (! function_exists('getCurrencyRate')) {
    function getCurrencyRate()
    {
        if (session()->has('currency_rate')) {
            $currency_rate = session('currency_rate');
            $rate = $currency_rate['rate'];

            return $rate;
        } else {
            return 1;
        }
    }
}

/**
 * Currency amount short
 * useCount: 0
 *
 * @param  $amount
 * @return number
 */

// if (! function_exists('currencyAmountShort')) {
//     function currencyAmountShort($amount)
//     {
//         $num = $amount * getCurrencyRate();
//         $units = ['', 'K', 'M', 'B', 'T'];
//         for ($i = 0; $num >= 1000; $i++) {
//             $num /= 1000;
//         }

//         return round($num, 0).$units[$i];
//     }
// }

/**
 * Currency position
 *
 * @param  string  $date
 */
if (! function_exists('changeCurrency')) {
    function changeCurrency($amount)
    {
        if ($amount) {
            if (session()->has('current_currency')) {
                $current_currency = session('current_currency');
                $symbol = $current_currency->symbol;
                $position = $current_currency->symbol_position;
            } else {
                $symbol = config('templatecookie.currency_symbol');
                $position = config('templatecookie.currency_symbol_position');
            }

            $converted_amount = round($amount * getCurrencyRate(), 2);

            if ($position == 'left') {
                return $symbol.' '.$converted_amount;
            } else {
                return $converted_amount.' '.$symbol;
            }
        }

        return null;
    }
}

/**
 * Convert and format the given amount based on the current currency settings.
 *
 * @param  float  $amount  The amount to be converted and formatted.
 * @return string|null The formatted amount with currency symbol or null if $amount is not provided.
 */
if (! function_exists('minMAxCurrency')) {
    function minMAxCurrency($amount)
    {
        if ($amount) {
            if (session()->has('current_currency')) {
                $current_currency = session('current_currency');
                $position = $current_currency->symbol_position;
            } else {
                $position = config('templatecookie.currency_symbol_position');
            }

            $converted_amount = round($amount * getCurrencyRate(), 2);

            if ($position == 'left') {
                return $converted_amount;
            } else {
                return $converted_amount;
            }
        }

        return null;
    }
}

/**
 * Convert an amount to the configured currency and format it.
 * useCount: 0
 *
 * @param  float  $amount  The amount to be converted.
 * @param  int  $last_digit  The number of digits after the decimal point (default is 2).
 * @return string The formatted and converted amount.
 */

//  if (! function_exists('convertCurrency')) {
//     function convertCurrency($amount, $last_digit = 2)
//     {
//         if ($amount) {
//             $amount = Currency::where('code', config('adlisting.currency'))->value('exchange_rate') * $amount;
//         }

//         return number_format($amount, $last_digit, '.', ',');
//     }
// }

/**
 * Convert an amount from USD to the configured currency using exchange rates.
 * useCount: 0
 *
 * @param  float  $amount  The amount to be converted.
 * @return int The converted amount rounded to 2 decimal places.
 */

// if (! function_exists('convertCurrency2')) {
//     function convertCurrency2($amount)
//     {
//         $fromRate = Currency::whereCode('USD')->first()->rate;
//         $toRate = Currency::whereCode('adlisting.currency')->first()->rate;
//         $rate = $toRate / $fromRate;

//         return (int) round($amount * $rate, 2);
//     }
// }

/**
 * Format an amount based on the current currency's symbol and symbol position.
 * useCount: 0
 *
 * @param  float  $amount  The amount to be formatted.
 * @return string The formatted amount with currency symbol.
 */

// if (! function_exists('currencyFormatting')) {
//     function currencyFormatting($amount)
//     {
//         $currency = session('current_currency');
//         $converted_amount = $amount;

//         if ($currency->symbol_position == 'left') {
//             return "$currency->symbol$converted_amount";
//         } else {
//             return "$converted_amount$currency->symbol";
//         }
//     }
// }

/*
|--------------------------------------------------------------------------
| Language Helpers
|--------------------------------------------------------------------------
*/

/**
 * Get the current language based on the session setting or default language.
 *
 * @return \App\Models\Language|null The current language model or null if not found.
 */
if (! function_exists('currentLanguage')) {
    function currentLanguage()
    {
        forgetCache('categories_subcategories');
        if (session()->has('set_lang')) {
            $lang = loadCurrentLanguage();
        } else {
            $lang = loadDefaultLanguage();
        }

        if ($lang) {
            return $lang;
        } else {
            $assign_default = 'en';
            session()->put('set_lang', $assign_default);

            return Language::where('code', $assign_default)->first();
        }
    }
}

/**
 * Check if language change is allowed based on the application settings.
 *
 * @return bool True if language change is allowed, false otherwise.
 */
if (! function_exists('allowLaguageChanage')) {
    function allowLaguageChanage()
    {
        $status = Setting::first()->pluck('language_changing');
        if ($status == '[1]') {
            return true;
        } else {
            return false;
        }
    }
}

/**
 * Perform automatic translation of text using the specified language.
 *
 * @param  string  $lang  The target language code.
 * @param  string  $text  The text to be translated.
 * @return string The translated text.
 */
if (! function_exists('autoTransLation')) {
    function autoTransLation($lang, $text)
    {
        $tr = new GoogleTranslate($lang);
        $afterTrans = $tr->translate($text);

        return $afterTrans;
    }
}

/**
 * Get the current language code.
 *
 * @return string The current language code.
 */
if (! function_exists('currentLangCode')) {
    function currentLangCode()
    {
        if (session()->has('set_lang')) {
            return Language::where('code', session('set_lang'))->value('code');
        } else {
            return Language::where('code', env('APP_DEFAULT_LANGUAGE'))->value('code');
        }
    }
}

/**
 * Get the language name based on the language code.
 *
 * @param  string  $code  The language code.
 * @return string|null The language name or null if not found.
 */
if (! function_exists('getLanguageByCode')) {
    function getLanguageByCode($code)
    {
        return Language::where('code', $code)->value('name');
    }
}

/**
 * Get the text direction ('ltr' or 'rtl') for the current language.
 *
 * @return string The text direction for the current language.
 */
if (! function_exists('langDirection')) {
    function langDirection()
    {
        $lang_code = app()->getLocale();
        $lang_direction = Language::where('code', $lang_code)->value('direction');

        return $lang_direction;
    }
}

/*
|--------------------------------------------------------------------------
| Cookies Helpers
|--------------------------------------------------------------------------
*/

/**
 * Get the first record from the 'cookies' table.
 *
 * @return \App\Models\Cookies|null The first cookies record or null if not found.
 */
if (! function_exists('cookies')) {
    function cookies()
    {
        return Cookies::first();
    }
}

/*
|--------------------------------------------------------------------------
| Date Helpers
|--------------------------------------------------------------------------
*/

/**
 * Format a date using Carbon with the specified format.
 *
 * @param  string  $date  The date to be formatted.
 * @param  string  $format  The desired date format (default is 'Y-m-d').
 * @return string The formatted date string.
 */
if (! function_exists('formatDate')) {
    function formatDate($date, $format = 'Y-m-d')
    {
        return Carbon::parse($date)->format($format);
    }
}

/**
 * Format a date using Carbon with the specified format.
 *
 * @param  string  $date  The date to be formatted.
 * @param  string  $format  The desired date format (default is 'Y-m-d').
 * @return string|null The formatted date string or null if the provided date is empty.
 */
if (! function_exists('formatDateTime')) {
    function formatDateTime($date, $format = 'Y-m-d')
    {
        if ($date) {
            return Carbon::createFromFormat($format, $date);
        }

        return null;
    }
}

/*
|--------------------------------------------------------------------------
| WishList Helpers
|--------------------------------------------------------------------------
*/

/**
 * Check ad is wishlisted
 *
 * @param  int  $adId
 * @return bool
 */
if (! function_exists('isWishlisted')) {
    function isWishlisted($adId)
    {
        if (auth()->guard('user')->check() && session()->has('wishlists') && in_array($adId, session('wishlists'))) {
            return true;
        }

        return false;
    }
}

/**
 * Store customer wishlists information to session storage
 *
 * @return void
 */
if (! function_exists('resetSessionWishlist')) {
    function resetSessionWishlist()
    {
        session()->forget('wishlists');
        $wishlists = Wishlist::select(['ad_id'])->where('user_id', auth()->guard('user')->id())->pluck('ad_id')->all();

        session()->put('wishlists', $wishlists);
    }
}

/*
|--------------------------------------------------------------------------
| inspire quote Helpers
|--------------------------------------------------------------------------
*/

/**
 * Get an inspirational quote or message using the Laravel 'inspire' command.
 *
 * @return string The output of the 'inspire' command.
 */
if (! function_exists('inspireMe')) {
    function inspireMe()
    {
        Artisan::call('inspire');

        return Artisan::output();
    }
}

/*
|--------------------------------------------------------------------------
| home page themes Helpers
|--------------------------------------------------------------------------
*/

/**
 * Get the home page themes from the first record of the 'Theme' model.
 *
 * @return mixed The home page themes from the 'Theme' model.
 */
if (! function_exists('homePageThemes')) {
    function homePageThemes()
    {
        return Theme::first()->home_page;
    }
}

/*
|--------------------------------------------------------------------------
|  module setting Helpers
|--------------------------------------------------------------------------
*/
/**
 * Check module is enabled or not
 *
 * @param  string  $module_name
 * @return bool
 */
if (! function_exists('enableModule')) {
    function enableModule(string $module_name)
    {
        try {
            return ModuleSetting::select($module_name)->value($module_name);
        } catch (\Exception $e) {
            return back()->with('error', 'Something went wrong!');
        }
    }
}

/*
|--------------------------------------------------------------------------
|  SEO Metadata Helpers
|--------------------------------------------------------------------------
*/
/**
 * Get metadata content for a specific page and language.
 *
 * @param  string  $page  The page slug for which metadata is requested.
 * @return \App\Models\SeoContent|null The metadata content for the specified page and language or null if not found.
 */
if (! function_exists('metaData')) {
    function metaData($page)
    {
        try {
            $current_language = currentLanguage(); // current session language
            $language_code = $current_language ? $current_language->code : 'en'; // language code or default one
            $page = Seo::where('page_slug', $page)->first(); // get page
            $exist_content = $page
                ->contents()
                ->where('language_code', $language_code)
                ->first(); // get page content orderBy page && language
            $content = '';

            if ($exist_content) {
                $content = $exist_content;
            } else {
                $content = $page
                    ->contents()
                    ->where('language_code', 'en')
                    ->first();
            }

            return $content; // return response
        } catch (\Throwable $th) {
            info($th->getMessage());

            return Seo::first()
                ->contents()
                ->first();
        }
    }
}

/*
|--------------------------------------------------------------------------
| URL-friendly "slug" generator Helpers
|--------------------------------------------------------------------------
*/
/**
 * Generate a URL-friendly "slug" from the given string.
 *
 * @param  string  $value  The string to generate a slug from.
 * @return string The generated slug.
 */
if (! function_exists('str_slug')) {
    function str_slug($value)
    {
        return Str::slug($value);
    }
}

/*
|--------------------------------------------------------------------------
| Mail configuration Helpers
|--------------------------------------------------------------------------
*/

/**
 * Check if the mail configuration is complete and display a flash message if not.
 *
 * @return int Returns 1 if the configuration is complete, 0 otherwise.
 */
if (! function_exists('checkMailConfig')) {
    function checkMailConfig()
    {
        $status = config('mail.mailers.smtp.transport') && config('mail.mailers.smtp.host') && config('mail.mailers.smtp.port') && config('mail.mailers.smtp.username') && config('mail.mailers.smtp.password') && config('mail.mailers.smtp.encryption') && config('mail.from.address') && config('mail.from.name');

        ! $status ? flashError('Mail not sent due to incomplete mail configuration') : '';

        return $status ? 1 : 0;
    }
}

/*
|--------------------------------------------------------------------------
| IP based country select Helpers
|--------------------------------------------------------------------------
*/

/**
 * Determine the user's selected country based on IP address and session.
 *
 * @return \App\Models\Country|null The user's selected country or null if not found.
 */
if (! function_exists('selected_country')) {
    function selected_country()
    {
        $ip = request()->ip();
        // $ip = '103.102.27.0'; // Bangladesh
        // $ip = '105.179.161.212'; // Mauritius
        // $ip = '197.246.60.160'; // Egypt
        // $ip = '107.29.65.61'; // United States"
        // $ip = '46.39.160.0'; // Czech Republic
        // $ip = "94.112.58.11"; // Czechia
        // Get user's IP address
        // $location = Location::get($ip);
        $selected_country = session()->get('selected_country');
        $all_countries = loadAllCountries();

        if ($ip != '127.0.0.1') {
            if ($selected_country) {
                $userCountry = $all_countries
                    ->where('name', $selected_country)
                    ->where('status', 1)
                    ->first();
            } else {
                $userCountry = '';
            }
        } else {
            $userCountry = $all_countries
                ->where('name', $selected_country)
                ->where('status', 1)
                ->first();
        }

        return $userCountry;
    }
}

/*
|--------------------------------------------------------------------------
|  Cms Helpers
|--------------------------------------------------------------------------
*/

/**
 * Cms get specific column data
 *
 * @param  $fields
 * @return object
 */
if (! function_exists('cms')) {
    function cms($fields = null, $append = false)
    {
        $cms = Cms::first();
        $column_exists = $cms->$fields;

        if ($column_exists) {
            $data = Cms::value($fields);
        }else {
            $data = '-';
        }

        return $data;
    }
}

/*
|--------------------------------------------------------------------------
|  Retrieve setting Helpers
|--------------------------------------------------------------------------
*/

/**
 * Retrieve setting data from the database.
 *
 * @param  string|array|null  $fields  The field(s) to retrieve. If null, retrieve all settings.
 * @param  bool  $append  Whether to append or hide certain fields (default is false).
 * @return \App\Models\Setting|\Illuminate\Support\Collection|null The retrieved setting data or null if not found.
 */
if (! function_exists('setting')) {
    function setting($fields = null, $append = false)
    {
        if ($fields) {
            $type = gettype($fields);

            if ($type == 'string') {
                $data = $append ? Setting::first($fields) : Setting::value($fields);
            } elseif ($type == 'array') {
                $data = Setting::first($fields);
            }
        } else {
            $data = loadSetting();
        }

        if ($append) {
            $data = $data->makeHidden(['logo_image_url', 'logo2_image_url', 'favicon_image_url', 'loader_image_url', 'app_pwa_icon_url']);
        }

        return $data;
    }
}

/*
|--------------------------------------------------------------------------
|  Customer Plan Helpers
|--------------------------------------------------------------------------
*/

/**
 * Store customer plan information to session storage
 *
 * @return void
 */
if (! function_exists('storePlanInformation')) {
    function storePlanInformation()
    {
        session()->forget('user_plan');
        session()->put('user_plan', authUser()?->userPlan ?? null);
    }
}

/*
|--------------------------------------------------------------------------
|  Social Media share link Generator Helpers
|--------------------------------------------------------------------------
*/

/**
 * Generate social media share links for a given path and social media provider.
 *
 * @param  string  $path  The path or content to be shared.
 * @param  string  $provider  The social media provider ('facebook', 'twitter', 'linkedin', 'gmail', 'whatsapp', 'skype', 'telegram').
 * @return string The generated social media share link.
 */
if (! function_exists('socialMediaShareLinks')) {
    function socialMediaShareLinks(string $path, string $provider)
    {
        switch ($provider) {
            case 'facebook':
                $share_link = 'https://www.facebook.com/sharer/sharer.php?u='.$path;
                break;
            case 'twitter':
                $share_link = 'https://twitter.com/intent/tweet?text='.$path;
                break;
            case 'linkedin':
                $share_link = 'https://www.linkedin.com/shareArticle?mini=true&url='.$path;
                break;
            case 'gmail':
                $share_link = 'https://mail.google.com/mail/u/0/?ui=2&fs=1&tf=cm&su='.$path;
                break;
            case 'whatsapp':
                $share_link = 'https://wa.me/?text='.$path;
                break;
            case 'skype':
                $share_link = 'https://web.skype.com/share?url='.$path;
                break;
            case 'telegram':
                $share_link = 'https://t.me/share/url?url='.$path;
                break;
        }

        return $share_link;
    }
}

/*
|--------------------------------------------------------------------------
|  category menu selection Helpers
|--------------------------------------------------------------------------
*/

/**
 * Get is category menu selected
 * useCount: 0
 *
 * @param  Category  $category
 * @return bool
 */

// if (! function_exists('isActiveCategorySidebar')) {
//     function isActiveCategorySidebar($category)
//     {
//         $found = false;

//         $categorySubcatategories = $category->subcategories->pluck('slug')->all();
//         $urlSubCategories = request('subcategory', []);

//         foreach ($categorySubcatategories as $category) {
//             if (in_array($category, $urlSubCategories)) {
//                 $found = true;
//                 break;
//             }
//         }

//         return $found;
//     }
// }

/*
|--------------------------------------------------------------------------
|  resource encoding and decoding Helpers
|--------------------------------------------------------------------------
*/

/**
 * Convert a collection to a resource by encoding and decoding it.
 *
 * @param  mixed  $data  The data (e.g., collection) to be converted to a resource.
 * @return mixed The converted resource.
 */
if (! function_exists('collectionToResource')) {
    function collectionToResource($data)
    {
        return json_decode(json_encode($data), false);
    }
}

/*
|--------------------------------------------------------------------------
|  notification Helpers
|--------------------------------------------------------------------------
*/
/**
 * Send logged in notification
 *
 * @return void
 */
if (! function_exists('loggedinNotification')) {
    function loggedinNotification()
    {
        $user = User::find(auth('user')->id());
        if (checkSetup('mail')) {
            $user->notify(new LoginNotification($user));
        }
    }
}

/*
|--------------------------------------------------------------------------
|  membership badge Helpers
|--------------------------------------------------------------------------
*/
/**
 * customer has membership badge or not
 *
 * @param  int  $user_id
 * @return bool
 */
if (! function_exists('hasMemberBadge')) {
    function hasMemberBadge($user_id)
    {
        return UserPlan::select('badge')->where('user_id', $user_id)->value('badge');
    }
}
/*
|--------------------------------------------------------------------------
|  user permission Helpers
|--------------------------------------------------------------------------
*/
/**
 * user permission check
 *
 * @param  string  $permission
 * @return bool
 */
if (! function_exists('userCan')) {
    function userCan($permission)
    {
        if (auth('admin')->check()) {
            return auth('admin')->user()->can($permission);
        }

        return false;
    }
}

/*
|--------------------------------------------------------------------------
|  file Helpers
|--------------------------------------------------------------------------
*/
/**
 * Get the size of a file.
 *
 * @param  string  $file  The path to the file.
 * @return int The file size in bytes, or 0 if the file doesn't exist.
 */
if (! function_exists('getFileSize')) {
    function getFileSize($file)
    {
        $file_exists = file_exists($file);

        if ($file_exists) {
            return File::size($file);
        }

        return 0;
    }
}

/*
|--------------------------------------------------------------------------
|  URL Slug Helpers
|--------------------------------------------------------------------------
*/
/**
 * Retrieve a setup guide by its slug.
 *
 * @param  string  $slug  The slug of the setup guide.
 * @return \App\Models\SetupGuide|null The setup guide or null if not found.
 */
if (! function_exists('setup_guide')) {
    function setup_guide($slug)
    {
        $guide = SetupGuide::where('slug', $slug)->first();

        return $guide;
    }
}

/*
|--------------------------------------------------------------------------
|  'mail-setup' Slug Helpers
|--------------------------------------------------------------------------
*/
/**
 * Retrieve all setup guides and update their status, especially for the 'mail-setup' slug.
 *
 * @return \Illuminate\Database\Eloquent\Collection The collection of setup guides.
 */
if (! function_exists('setup_guides')) {
    function setup_guides()
    {
        return SetupGuide::all()->each(function ($item) {
            if ($item->slug == 'mail-setup') {
                $mail_status = env('MAIL_MAILER') && env('MAIL_HOST') && env('MAIL_PORT') && env('MAIL_USERNAME') && env('MAIL_PASSWORD') && env('MAIL_ENCRYPTION') && env('MAIL_FROM_ADDRESS') && env('MAIL_FROM_NAME');

                $item->status = $mail_status ? 1 : 0;
            }
        });
    }
}

/*
|--------------------------------------------------------------------------
|  setup status Helpers
|--------------------------------------------------------------------------
*/
/**
 * Check the setup status for a specific type.
 *
 * @param  string  $type  The setup type to check (e.g., 'mail').
 * @return int The setup status (1 if setup is complete, 0 otherwise).
 */
if (! function_exists('checkSetup')) {
    function checkSetup($type)
    {
        if ($type == 'mail') {
            $status = env('MAIL_MAILER') && env('MAIL_HOST') && env('MAIL_PORT') && env('MAIL_USERNAME') && env('MAIL_PASSWORD') && env('MAIL_ENCRYPTION') && env('MAIL_FROM_ADDRESS') && env('MAIL_FROM_NAME');
        }

        return $status ? 1 : 0;
    }
}

/*
|--------------------------------------------------------------------------
|  advertisement item code Helpers
|--------------------------------------------------------------------------
*/
/**
 * get specific advertisement item code
 *
 * @param  string  $page_slug
 */
if (! function_exists('advertisementCode')) {
    function advertisementCode($page_slug)
    {

        $ads = loadAdvertisements();
        $code = '';
        $ad = $ads->where('page_slug', $page_slug)->where('status', 1)->first();
        if ($ad) {
            $code = $ad->ad_code;
        }

        return $code;
    }
}

/*
|--------------------------------------------------------------------------
| Response Helpers
|--------------------------------------------------------------------------
*/
/**
 * Response data collection
 *
 * @return \Illuminate\Http\Response
 */
if (! function_exists('responseData')) {
    function responseData(?object $data, string $responseName = 'data')
    {
        return response()->json([
            'success' => true,
            $responseName => $data,
        ], 200);
    }
}

/**
 * Response success data collection
 *
 * @return \Illuminate\Http\Response
 */
if (! function_exists('responseSuccess')) {
    function responseSuccess(string $msg = 'Success')
    {
        return response()->json([
            'success' => true,
            'message' => $msg,
        ], 200);
    }
}

/**
 * Response error data collection
 *
 * @return \Illuminate\Http\Response
 */
if (! function_exists('responseError')) {
    function responseError(string $msg = 'Something went wrong, please try again', int $code = 404)
    {
        return response()->json([
            'success' => false,
            'message' => $msg,
        ], $code);
    }
}

/*
|--------------------------------------------------------------------------
| User authenticated Helpers
|--------------------------------------------------------------------------
*/
/**
 * Current authenticated user
 *
 * @return string
 */
if (! function_exists('authUser')) {
    function authUser($guard = 'user')
    {
        if (auth($guard)->check()) {
            return auth($guard)->user();
        }

        return null;
    }
}

/**
 * To upper first character
 *
 * @return string
 */
if (! function_exists('ucf')) {
    function ucf($string)
    {
        return ucfirst(strtolower($string));
    }
}

/**
 * Retrieve the minimum and maximum prices from the 'Ad' model.
 *
 * @return array An associative array containing 'maxPrice' and 'minPrice' keys.
 */
if (! function_exists('minmax')) {
    function minmax()
    {
        $data['maxPrice'] = loadMaxPrice();
        $data['minPrice'] = loadMinPrice();

        return $data;
    }
}

if (! function_exists('activeAds')) {
    function activeAds()
    {
        $data = Ad::active()->count();

        return $data;
    }
}

if (! function_exists('activeCategory')) {
    function activeCategory()
    {
        $data = Category::active()->count();

        return $data;
    }
}

if (! function_exists('promotionCheckTime')) {
    function promotionCheckTime()
    {
        return Cache::rememberForever('promotion_check_time', function () {
            return now()->addDay();
        });
    }
}

/*
|--------------------------------------------------------------------------
| Messenger Helpers
|--------------------------------------------------------------------------
*/
/**
 * Count unread message
 *
 * @return int
 */
if (! function_exists('unreadMessageCount')) {
    function unreadMessageCount()
    {
        if (auth()->check()) {
            $unread_message = Messenger::where('to_id', auth('user')->id())
                ->where('read', 0)
                ->count();
        } else {
            $unread_message = 0;
        }

        return $unread_message;
    }
}
