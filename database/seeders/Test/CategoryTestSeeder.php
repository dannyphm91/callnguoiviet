<?php

namespace Database\Seeders\Test;

use Illuminate\Database\Seeder;
use Modules\Category\Entities\Category;
use Modules\Category\Entities\CategoryTranslation;
use Modules\Category\Entities\SubCategory;
use Modules\Category\Entities\SubCategoryTranslation;
use Modules\Language\Entities\Language;

class CategoryTestSeeder extends Seeder
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
                'image' => 'dummy/category/electronics.png',
                'icon' => 'fas fa-tv',
                'order' => 1,
                'slug' => 'electronics',
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
