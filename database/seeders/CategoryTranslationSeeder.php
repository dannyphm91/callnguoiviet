<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Category\Entities\Category;
use Modules\Category\Entities\CategoryTranslation;
use Modules\Language\Entities\Language;

class CategoryTranslationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    // public function run()
    // {
    //     $languages = Language::all();
    //     $categories = Category::all();
    //     if ($categories && count($categories) && count($categories) != 0) {
    //         foreach ($categories as $data) {
    //             foreach ($languages as $language) {
    //                 $name = $data->name ?? "{$language->code} name";
    //                 CategoryTranslation::create([
    //                     'category_id' => $data->id,
    //                     'locale' => $language->code,
    //                     'name' => $name,
    //                 ]);
    //             }
    //         }
    //     }
    // }

    public function run()
    {
        $languages = Language::pluck('code')->toArray();
        $categories = Category::all();

        if ($categories->count() > 0) {
            foreach ($categories as $category) {
                foreach ($languages as $locale) {
                    $name = $category->name ?? "{$locale} name";
                    CategoryTranslation::create([
                        'category_id' => $category->id,
                        'locale' => $locale,
                        'name' => $name,
                    ]);
                }
            }
        }
    }
}
