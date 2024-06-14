<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Category\Entities\SubCategory;
use Modules\Category\Entities\SubCategoryTranslation;
use Modules\Language\Entities\Language;

class SubCategoryTranslationSeeder extends Seeder
{
    public function run()
    {
        $languages = Language::pluck('code')->toArray();
        $sub_categories = SubCategory::all();

        if ($sub_categories->count() > 0) {
            foreach ($sub_categories as $sub_category) {

                foreach ($languages as $locale) {
                    $name = $sub_category->name ?? "{$locale} name";
                    SubCategoryTranslation::create([
                        'sub_category_id' => $sub_category->id,
                        'locale' => $locale,
                        'name' => $name,
                    ]);
                }
            }
        }
    }
}
