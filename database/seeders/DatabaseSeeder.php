<?php

namespace Database\Seeders;

use App\Models\ModuleSetting;
use Illuminate\Database\Seeder;
// migrated from adlisting
use Modules\Ad\Database\Seeders\AdDatabaseSeeder;
use Modules\Blog\Database\Seeders\BlogDatabaseSeeder;
use Modules\Brand\Database\Seeders\BrandDatabaseSeeder;
use Modules\Category\Database\Seeders\CategoryDatabaseSeeder;
use Modules\Currency\Database\Seeders\CurrencyDatabaseSeeder;
use Modules\CustomField\Database\Seeders\CustomFieldDatabaseSeeder;
use Modules\Faq\Database\Seeders\FaqCategorySeeder;
use Modules\Faq\Database\Seeders\FaqDatabaseSeeder;
use Modules\Language\Database\Seeders\LanguageDatabaseSeeder;
use Modules\MobileApp\Database\Seeders\MobileAppConfigSeeder;
use Modules\Newsletter\Database\Seeders\NewsletterDatabaseSeeder;
use Modules\Plan\Database\Seeders\PlanDatabaseSeeder;
use Modules\Review\Database\Seeders\ReviewDatabaseSeeder;
use Modules\SetupGuide\Database\Seeders\SetupGuideDatabaseSeeder;
use Modules\Testimonial\Database\Seeders\TestimonialDatabaseSeeder;
use Modules\Wishlist\Database\Seeders\WishlistDatabaseSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            SettingSeeder::class,
            UserSeeder::class,
            MobileAppConfigSeeder::class,
            CurrencyDatabaseSeeder::class,
            LanguageDatabaseSeeder::class,
            SetupGuideDatabaseSeeder::class,
            CookiesSeeder::class,
            LocationDatabaseSeeder::class,
            HomePageSliderSeeder::class,
            AboutPageSliderSeeder::class,

            // Messenger
            MessengerSeeder::class,

            // Promotions
            PromotionsPageCmsSeeder::class,

            //Affiliate
            AffiliatesTableSeeder::class,
            AffiliatePointSeeder::class,
        ]);

        // Module Setting
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
    }
}
