<?php

namespace Database\Seeders;

use App\Models\AdReportCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AdReportCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define the ad report categories data
        $categories = [
            ['name' => 'Offensive content', 'slug' => Str::slug('Offensive content')],
            ['name' => 'Fraud', 'slug' => Str::slug('Fraud')],
            ['name' => 'Duplicate ad', 'slug' => Str::slug('Duplicate ad')],
            ['name' => 'Other', 'slug' => Str::slug('Other')],
        ];

        // Insert the categories into the database
        AdReportCategory::insert($categories);
    }
}
