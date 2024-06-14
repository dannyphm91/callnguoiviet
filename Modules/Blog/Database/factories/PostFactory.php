<?php

namespace Modules\Blog\Database\factories;

use App\Models\Admin;
use Faker\Factory as FakerFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Modules\Blog\Entities\PostCategory;

class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\Blog\Entities\Post::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $id = rand(30, 600);
        $faker = FakerFactory::create();
        $faker->addProvider(new \Smknstd\FakerPicsumImages\FakerPicsumImagesProvider($faker));
        $test = $this->withFaker();
        $title = $test->realText(50);
        $paragraph1 = $test->realText(500, true);
        $paragraph2 = $test->realText(1000, true);
        $description = $paragraph1.'<br><br>'.$paragraph2;

        return [
            'category_id' => PostCategory::inRandomOrder()->value('id'),
            'author_id' => Admin::inRandomOrder()->value('id'),
            'title' => $title,
            'slug' => Str::slug($title),
            'image' => $faker->imageUrl(width: 800, height: 600),
            'short_description' => $this->faker->sentence(40),
            'description' => $description,
        ];
    }
}
