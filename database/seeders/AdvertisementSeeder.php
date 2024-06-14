<?php

namespace Database\Seeders;

use App\Models\Advertisement;
use Illuminate\Database\Seeder;

class AdvertisementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ads = [
            [
                'page_slug' => 'home_page_inside_ad',
                'ad_code' => '<img class="max-h-[400px] !w-[100%]" width="100%" height="100%" src="dummy/adsense/300x500.webp" alt="">',

                'place_example_image' => 'frontend/images/advertisement_place/p1.webp',
            ],
            [
                'page_slug' => 'home_page_center',
                'ad_code' => '<img width="100%" height="100%" src="dummy/adsense/1300x230.webp" alt="">',
                'place_example_image' => 'frontend/images/advertisement_place/p2.webp',
            ],
            [
                'page_slug' => 'ad_listing_page_left',
                'ad_code' => '<img class="max-h-[400px] !w-[100%]" width="100%" height="100%" src="dummy/adsense/300x500.webp" alt="">',
                'place_example_image' => 'frontend/images/advertisement_place/p3.webp',
            ],
            [
                'page_slug' => 'ad_listing_page_inside_ad',
                'ad_code' => '<img class="max-h-[400px] !w-[100%]" width="100%" height="100%" src="dummy/adsense/300x500.webp" alt="">',
                'place_example_image' => 'frontend/images/advertisement_place/p4.webp',
            ],
            [
                'page_slug' => 'ad_listing_page_right',
                'ad_code' => '<img class="max-h-[400px] !w-[100%]" width="100%" height="100%" src="dummy/adsense/300x500.webp" alt="">',
                'place_example_image' => 'frontend/images/advertisement_place/p5.webp',
            ],
            [
                'page_slug' => 'blog_page_left',
                'ad_code' => '<img width="100%" height="100%" src="dummy/adsense/300x500.webp" alt="">',
                'place_example_image' => 'frontend/images/advertisement_place/p7.webp',
            ],
            [
                'page_slug' => 'blog_page_inside_blog',
                'ad_code' => '<img width="100%" height="100%" src="dummy/adsense/585x250.webp" alt="">',
                'place_example_image' => 'frontend/images/advertisement_place/p8.webp',
            ],
            [
                'page_slug' => 'blog_detail_page_right',
                'ad_code' => '<img width="100%" height="100%" src="dummy/adsense/300x500.webp" alt="">',
                'place_example_image' => 'frontend/images/advertisement_place/p9.webp',
            ],
        ];

        foreach ($ads as $key => $ad) {
            Advertisement::create([
                'page_slug' => $ad['page_slug'],
                'ad_code' => $ad['ad_code'],
                'place_example_image' => $ad['place_example_image'],
            ]);
        }
    }
}
