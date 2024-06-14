<?php

namespace Modules\Currency\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Modules\Currency\Entities\Currency;

class CurrencyDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $currencies = [
            [
                'name' => 'United State Dollar',
                'code' => 'USD',
                'symbol' => '$',
                'symbol_position' => 'left',
                'rate' => '1.0000',
            ]
        ];

        foreach ($currencies as $currency) {
            Currency::create($currency);
        }
    }
}
