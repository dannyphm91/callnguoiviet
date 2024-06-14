<?php

namespace Database\Seeders;

use App\Models\AboutPageSlider;
use Illuminate\Database\Seeder;

class AboutPageSliderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $images = [
            'frontend/images/about-slider-img/img-01.png',
            'frontend/images/about-slider-img/img-02.png',
            'frontend/images/about-slider-img/img-03.png',
            'frontend/images/about-slider-img/img-04.png',
            'frontend/images/about-slider-img/img-05.png',
            'frontend/images/about-slider-img/img-06.png',
            'frontend/images/about-slider-img/img-02.png',
            'frontend/images/about-slider-img/img-04.png',
        ];

        foreach ($images as $image) {
            AboutPageSlider::create([
                'url' => $image,
            ]);
        }

    }
}
