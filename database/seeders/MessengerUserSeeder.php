<?php

namespace Database\Seeders;

use App\Models\MessengerUser;
use Illuminate\Database\Seeder;
use Modules\Ad\Entities\Ad;

class MessengerUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MessengerUser::create([
            'from_id' => 2,
            'to_id' => 1,
            'ad_id' => Ad::where('user_id', 1)->orWhere('user_id', 2)->first()->id,
        ]);

        MessengerUser::create([
            'from_id' => 3,
            'to_id' => 1,
            'ad_id' => Ad::where('user_id', 1)->orWhere('user_id', 3)->first()->id,
        ]);

        MessengerUser::create([
            'from_id' => 2,
            'to_id' => 3,
            'ad_id' => Ad::where('user_id', 2)->orWhere('user_id', 3)->first()->id,
        ]);
    }
}
