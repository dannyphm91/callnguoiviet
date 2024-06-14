<?php

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Category\Entities\Category;
use Modules\Category\Entities\CategoryTranslation;

class CategoryTranslationFactory extends Factory
{
    protected $model = CategoryTranslation::class;

    public function definition()
    {
        $locales = ['en', 'bn'];
        $category = Category::factory()->create();
        $name = $this->faker->sentence();

        return [
            'category_id' => $category->id,
            'name' => $name,
            'locale' => $this->faker->randomElement($locales),
        ];
    }
}
