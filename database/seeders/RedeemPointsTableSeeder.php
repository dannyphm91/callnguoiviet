<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RedeemPointsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'id' => 1,
                'points' => 1200,
                'redeem_balance' => 1.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'points' => 3000,
                'redeem_balance' => 1.20,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'points' => 5000,
                'redeem_balance' => 2.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 4,
                'points' => 8000,
                'redeem_balance' => 2.50,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 5,
                'points' => 10000,
                'redeem_balance' => 5.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ];

        // Insert data into redeem_points table
        DB::table('redeem_points')->insert($data);
    }
}
