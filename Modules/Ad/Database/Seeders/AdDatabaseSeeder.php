<?php

namespace Modules\Ad\Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Modules\Ad\Entities\Ad;
use Modules\Ad\Entities\AdFeature;
use Modules\Ad\Entities\AdGallery;
use Modules\Brand\Entities\Brand;
use Modules\Category\Entities\Category;

class AdDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $product_list = json_decode(file_get_contents(base_path('public/dummy/products.json')), true);
        $countries = json_decode(file_get_contents(resource_path('backend/dummy-data/country.json')), true);

        foreach ($countries as $countryKey => $country) {
            $randomKeys = array_rand($product_list, 5);
            $randomProducts = [];

            foreach ($randomKeys as $key) {
                $randomProducts[] = $product_list[$key];
            }
            for ($i = 0; $i < count($randomProducts); $i++) {
                $paragraph1 = fake()->paragraphs(3, true);
                $paragraph2 = fake()->paragraphs(4, true);
                $paragraph3 = fake()->paragraphs(5, true);
                $description = $paragraph1.'<br><br>'.$paragraph2.'<br><br>'.$paragraph3;

                $product_data = [
                    'title' => $randomProducts[$i]['title'].$countryKey,
                    'slug' => Str::slug($randomProducts[$i]['title']).$countryKey,
                    'thumbnail' => $randomProducts[$i]['image'],
                    'user_id' => User::inRandomOrder()->value('id'),
                    'category_id' => $randomProducts[$i]['category'],
                    'subcategory_id' => $randomProducts[$i]['subcategory'] ?? null,
                    'brand_id' => Brand::inRandomOrder()->value('id'),
                    'price' => rand(200, 6000),
                    'phone' => fake()->phoneNumber,
                    'status' => Arr::random(['active', 'sold', 'pending', 'declined', 'active', 'active', 'active', 'active', 'active']),
                    'featured' => Arr::random([false, true, false, false, false]),
                    'total_reports' => rand(1, 30),
                    'total_views' => rand(1, 300),
                    'is_blocked' => rand(true, false),
                    'country' => $country['name'],
                    'lat' => fake()->latitude(-90, 90),
                    'long' => fake()->longitude(-90, 90),
                    'whatsapp' => Arr::random(['', 'https://web.whatsapp.com']),
                    'description' => $description,

                    'featured' => Arr::random([false, true, false, true, false, true]),
                    'featured_at' => Arr::random([null, fake()->dateTime]),
                    'featured_till' => Arr::random([null, now()->addDays(30), null, now()->addDays(15), null, now()->addDays(7), null, now()->addDays(3), null, now()->addDays(1)]),

                    'urgent' => Arr::random([false, true, false, false, false, true]),
                    'urgent_at' => Arr::random([null, fake()->dateTime]),
                    'urgent_till' => Arr::random([null, now()->addDays(30), null, now()->addDays(15), null, now()->addDays(7), null, now()->addDays(3), null, now()->addDays(1)]),

                    'highlight' => Arr::random([false, true, false, true, false, true]),
                    'highlight_at' => Arr::random([null, fake()->dateTime]),
                    'highlight_till' => Arr::random([null, now()->addDays(30), null, now()->addDays(15), null, now()->addDays(7), null, now()->addDays(3), null, now()->addDays(1)]),

                    'top' => Arr::random([false, true, false, false, false, true]),
                    'top_at' => Arr::random([null, fake()->dateTime]),
                    'top_till' => Arr::random([null, now()->addDays(30), null, now()->addDays(15), null, now()->addDays(7), null, now()->addDays(3), null, now()->addDays(1)]),

                    'bump_up' => Arr::random([false, true, false, true, false, true]),
                    'bump_up_at' => Arr::random([null, fake()->dateTime]),
                    'bump_up_till' => Arr::random([null, now()->addDays(30), null, now()->addDays(15), null, now()->addDays(7), null, now()->addDays(3), null, now()->addDays(1)]),

                    'created_at' => fake()->dateTimeBetween('-1 year', 'now'),
                ];
                $product = Ad::create($product_data);

                // Associate features with the product
                $this->associateFeatures($product, $randomProducts[$i]['category']);

                // Associate gallery images with the product
                $this->associateGalleryImages($product, $randomProducts[$i]['gallery']);
            }
        }
    }

    private function associateFeatures(Ad $product, $categoryId)
    {
        $featureNames = [
            'electronics' => [
                'High Resolution Display',
                'Advanced Camera Technology',
                'Long Battery Life',
                'Wireless Connectivity',
                'Sleek Design',
                'Fast Performance',
            ],
            'mobile-phone' => [
                'Fast Processor',
                'High-Quality Camera',
                'Large Screen',
                'Long Battery Life',
                '5G Connectivity',
                'Slim Design',
            ],
            'vehicles' => [
                'Fuel Efficiency',
                'Advanced Safety Features',
                'Spacious Interior',
                'Powerful Engine',
                'Off-Road Capability',
                'Luxurious Features',
            ],
            'sports-&-kids' => [
                'Durable Materials',
                'Interactive Features',
                'Safety Standards',
                'Fun Design',
            ],
            'home-&-living' => [
                'Modern Design',
                'Comfortable Seating',
                'Durable Construction',
                'Eco-Friendly Materials',
            ],
            'business-&-industry' => [
                'Prime Location',
                'Spacious Layout',
                'Modern Amenities',
                'Scenic Views',
            ],
            'property' => [
                'Exclusive Locations',
                'Contemporary Design',
                'Luxurious Amenities',
                'Panoramic Views',
            ],
            'women-fashion-&-beauty' => [
                'Stylish Designs',
                'Quality Fabrics',
                'Variety of Colors',
                'Comfortable Fit',
            ],
            'mens-fashion-&-grooming' => [
                'Sophisticated Styles',
                'Quality Materials',
                'Versatile Options',
                'Comfortable Fit',
            ],
            'essentials' => [
                'Basic Necessities',
                'Affordable Prices',
                'Durable Quality',
                'Functional Design',
            ],
            'education' => [
                'Quality Education',
                'Experienced Instructors',
                'Modern Facilities',
                'Engaging Curriculum',
            ],
        ];

        // Assuming $categoryId is the actual category ID from product data
        $category = Category::find($categoryId);

        $featureNamesForCategory = $featureNames[$category->slug] ?? [];

        foreach ($featureNamesForCategory as $featureName) {
            AdFeature::create([
                'ad_id' => $product->id,
                'name' => $featureName,
            ]);
        }
    }

    private function associateGalleryImages(Ad $product, $galleryImages)
    {
        foreach ($galleryImages as $galleryImage) {
            AdGallery::create([
                'ad_id' => $product->id,
                'image' => $galleryImage,
            ]);
        }
    }
}
