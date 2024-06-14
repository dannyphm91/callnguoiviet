<?php

namespace Database\Seeders;

use App\Models\HomePageSlider;
use Illuminate\Database\Seeder;

class HomePageSliderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $images = [
            'frontend/images/slider-img/hero-banner.png',
        ];

        foreach ($images as $image) {
            HomePageSlider::create([
                'url' => $image,
            ]);
        }

    }
}
