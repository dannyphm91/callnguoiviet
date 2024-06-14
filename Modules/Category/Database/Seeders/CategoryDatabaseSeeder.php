<?php

namespace Modules\Category\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Category\Entities\Category;
use Modules\Category\Entities\CategoryTranslation;
use Modules\Category\Entities\SubCategory;
use Modules\Category\Entities\SubCategoryTranslation;
use Modules\Language\Entities\Language;

class CategoryDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            [
                'name' => 'Electronics',
                'image' => 'dummy/category/electronics.webp',
                'icon' => 'fas fa-tv',
                'order' => 1,
                'slug' => 'electronics',
            ],
            [
                'name' => 'Mobile Phone',
                'image' => 'dummy/category/mobile.webp',
                'icon' => 'fas fa-mobile-alt',
                'order' => 2,
                'slug' => 'mobile-phone',
            ],
            [
                'name' => 'Vehicles',
                'image' => 'dummy/category/vehicles.webp',
                'icon' => 'fas fa-car-alt',
                'order' => 3,
                'slug' => 'vehicles',
            ],
            [
                'name' => 'Hobbies, Sports & Kids',
                'image' => 'dummy/category/sports.webp',
                'icon' => 'far fa-futbol',
                'order' => 4,
                'slug' => 'sports-&-kids',
            ],
            [
                'name' => 'Home & Living',
                'image' => 'dummy/category/home-living.webp',
                'icon' => 'fas fa-couch',
                'order' => 5,
                'slug' => 'home-&-living',
            ],
            [
                'name' => 'Business & Industry',
                'image' => 'dummy/category/real-estate.webp',
                'icon' => 'far fa-building',
                'order' => 6,
                'slug' => 'business-&-industry',
            ],
            [
                'name' => 'Property',
                'image' => 'dummy/category/property.webp',
                'icon' => 'far fa-building',
                'order' => 7,
                'slug' => 'property',
            ],
            [
                'name' => 'Women Fashion & Beauty',
                'image' => 'dummy/category/women-fashion.webp',
                'icon' => 'far fa-building',
                'order' => 8,
                'slug' => 'women-fashion-&-beauty',
            ],
            [
                'name' => 'Men\'s Fashion & Grooming',
                'image' => 'dummy/category/mens-fashion.webp',
                'icon' => 'far fa-building',
                'order' => 9,
                'slug' => 'mens-fashion-&-grooming',
            ],
            [
                'name' => 'Essentials',
                'image' => 'dummy/category/essentials.webp',
                'icon' => 'far fa-building',
                'order' => 10,
                'slug' => 'essentials',
            ],
            [
                'name' => 'Education',
                'image' => 'dummy/category/education.webp',
                'icon' => 'far fa-building',
                'order' => 11,
                'slug' => 'education',
            ],
        ];

        $languages = Language::pluck('code')->toArray();
        foreach ($categories as $category) {
            $cat = Category::create([
                'image' => $category['image'],
                'icon' => $category['icon'],
                'order' => $category['order'],
                'slug' => $category['slug'],
            ]);
            foreach ($languages as $language) {
                CategoryTranslation::create([
                    'category_id' => $cat->id,
                    'locale' => $language,
                    'name' => $category['name'],
                ]);
            }
        }

        $subcategories = [
            ['category_id' => 1, 'name' => 'Computer & Laptop', 'slug' => 'computer-laptop'],
            ['category_id' => 1, 'name' => 'TV', 'slug' => 'tv'],
            ['category_id' => 1, 'name' => 'Camera', 'slug' => 'camera'],

            // Mobile Phone
            ['category_id' => 2, 'name' => 'iPhone', 'slug' => 'iphone'],
            ['category_id' => 2, 'name' => 'Samsung', 'slug' => 'samsung'],
            ['category_id' => 2, 'name' => 'Tablet', 'slug' => 'tablet'],

            // Vehicles
            ['category_id' => 3, 'name' => 'Cycle', 'slug' => 'cycle'],
            ['category_id' => 3, 'name' => 'Car', 'slug' => 'car'],
            ['category_id' => 3, 'name' => 'Bike', 'slug' => 'bike'],

            // Sports & Kids
            ['category_id' => 4, 'name' => 'Toy', 'slug' => 'toy'],
            ['category_id' => 4, 'name' => 'Bat', 'slug' => 'bat'],
            ['category_id' => 4, 'name' => 'Football', 'slug' => 'football'],

            // Home & Living
            ['category_id' => 5, 'name' => 'Sofa', 'slug' => 'sofa'],
            ['category_id' => 5, 'name' => 'Chair', 'slug' => 'chair'],
            ['category_id' => 5, 'name' => 'Table', 'slug' => 'table'],

            // Real State
            ['category_id' => 6, 'name' => 'Apartments for Sale', 'slug' => 'apartments-for-sale'],
            ['category_id' => 6, 'name' => 'Houses for Sale', 'slug' => 'houses-for-sale'],
            ['category_id' => 6, 'name' => 'Office Space', 'slug' => 'office-space'],
        ];

        foreach ($subcategories as $subcategory) {
            $subCat = SubCategory::create([
                'category_id' => $subcategory['category_id'],
                'slug' => $subcategory['slug'],
            ]);
            foreach ($languages as $language) {
                SubCategoryTranslation::create([
                    'sub_category_id' => $subCat->id,
                    'locale' => $language,
                    'name' => $subcategory['name'],
                ]);
            }
        }
    }
}
