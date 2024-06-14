<?php

namespace Database\Seeders\Test;

use Illuminate\Database\Seeder;
use Modules\Plan\Entities\Plan;

class PlanTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Plan::create([
            'label' => 'Free',
            'price' => 0.00,
            'ad_limit' => 1,

            'featured_limit' => 0,
            'featured_duration' => 0,

            'urgent_limit' => 0,
            'urgent_duration' => 0,

            'highlight_limit' => 0,
            'highlight_duration' => 0,

            'top_limit' => 0,
            'top_duration' => 0,

            'bump_up_limit' => 0,
            'bump_up_duration' => 0,

            'badge' => false,
            'premium_member' => false,

            'recommended' => false,
            'interval' => 'monthly',
            'plan_payment_type' => 'recurring',
            'custom_interval_days' => 15,
            'stripe_id' => 'price_1OUoNnDHsbz9CBNMyNPBdF7W',
        ]);
    }
}
