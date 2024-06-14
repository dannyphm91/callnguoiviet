<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ImportTestingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            SettingSeeder::class,
        ]);
    }
}
