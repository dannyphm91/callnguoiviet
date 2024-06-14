<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AffiliatePointSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (DB::table('users')->count() == 0) {
            $this->call(UserSeeder::class);
        }
        $users = DB::table('users')->get();
        foreach ($users as $user) {
            DB::table('affiliate_point_histories')->insert([
                'user_id' => $user->id,
                'order_id' => rand(10000, 999999),
                'points' => rand(10, 10000),
                'pricing' => rand(20 * 100, 50 * 100) / 100,
                'status' => rand(0, 1),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
