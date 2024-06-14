<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AffiliatesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {

        if (DB::table('users')->count() == 0) {
            $this->call(UserSeeder::class);
        }
        $users = DB::table('users')->get();

        foreach ($users as $user) {
            DB::table('affiliates')->insert([
                'user_id' => $user->id,
                'affiliate_code' => Str::random(10),
                'total_points' => rand(0, 10000),
                'balance' => rand(0, 10000) / 100,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
