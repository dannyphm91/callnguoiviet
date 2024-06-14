<?php

use App\Models\Admin;
use App\Models\Cms;
use App\Models\Country;
use App\Models\ModuleSetting;
use App\Models\UserDocumentVerification;
use Database\Seeders\ImportTestingTableSeeder;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Modules\Category\Entities\Category;
use Modules\Category\Transformers\CategoryResource;
use Modules\Currency\Entities\Currency;
use Modules\MobileApp\Entities\MobileAppConfig;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class)
    ->beforeEach(function () {
        // $this->withoutExceptionHandling();
        $this->withoutVite();
        $this->seed([
            ImportTestingTableSeeder::class,
        ]);
        Artisan::call('cache:clear');
        view()->share('setting', loadSetting());
        view()->share('settings', loadSetting());
        view()->share('languages', loadLanguage());
        view()->share('language_enable', true);
        view()->share('appearance_enable', true);
        view()->share('priceplan_enable', true);
        view()->share('newsletter_enable', true);
        view()->share('blog_enable', true);
        view()->share('testimonial_enable', true);
        view()->share('faq_enable', true);
        view()->share('cms', Cms::first());
        view()->share('categories', Category::get());
        view()->share('document_verification_requests', UserDocumentVerification::approved()->count());
        view()->share('headerCurrencies', Currency::all());
        view()->share('top_categories', CategoryResource::collection(Category::active()->withCount('ads as ad_count')->latest('ad_count')->take(8)->get()));
        view()->share('headerCountries', Country::select('id', 'name', 'slug', 'icon')->get());
        view()->share('mobile_setting', MobileAppConfig::first());

        ModuleSetting::create([
            'blog' => true,
            'newsletter' => true,
            'language' => true,
            'contact' => true,
            'faq' => true,
            'testimonial' => true,
            'price_plan' => true,
            'appearance' => true,
        ]);
        MobileAppConfig::create([
            'android_download_url' => 'ok',
            'ios_download_url' => 'ok',
            'privacy_url' => 'ok',
            'refund_url' => 'ok',
            'support_url' => 'ok',
            'terms_and_condition_url' => 'ok',
        ]);
        $moduleSetting = ModuleSetting::first();
        if ($moduleSetting) {
            view()->share('blog_enable', $moduleSetting->blog);
            view()->share('newsletter_enable', $moduleSetting->newsletter);
            view()->share('contact_enable', $moduleSetting->contact);
            view()->share('faq_enable', $moduleSetting->faq);
            view()->share('testimonial_enable', $moduleSetting->testimonial);
            view()->share('priceplan_enable', $moduleSetting->price_plan);
            view()->share('language_enable', $moduleSetting->language);
            view()->share('appearance_enable', $moduleSetting->appearance);
            view()->share('mobile_setting', MobileAppConfig::first());
        }
    })
    ->in('Feature');

function createAdmin(): Admin
{
    $admin = Admin::factory()->create();
    $roleSuperAdmin = Role::first();
    $admin->assignRole($roleSuperAdmin);

    return $admin;
}

function actingAs(Authenticatable $user, ?string $driver = null)
{
    return test()->actingAs($user, $driver);
}
