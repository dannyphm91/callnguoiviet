<?php

namespace Database\Seeders;

use App\Models\Messenger;
use Illuminate\Database\Seeder;

class MessengerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Messenger::factory()->count(20)->create();
    }
}
