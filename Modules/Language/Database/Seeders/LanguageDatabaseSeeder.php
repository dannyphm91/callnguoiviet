<?php

namespace Modules\Language\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Modules\Language\Entities\Language;

class LanguageDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        Language::create([
            'name' => 'English',
            'code' => 'en',
            'icon' => 'flag-icon-gb',
            'direction' => 'ltr',
        ]);

        Language::create([
            'name' => 'Bangla',
            'code' => 'bn',
            'icon' => 'flag-icon-bd',
            'direction' => 'ltr',
        ]);

        Language::create([
            'name' => 'Arabic',
            'code' => 'ar',
            'icon' => 'flag-icon-sa',
            'direction' => 'rtl',
        ]);
    }
}
