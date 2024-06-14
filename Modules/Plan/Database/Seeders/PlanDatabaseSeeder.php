<?php

namespace Modules\Plan\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Modules\Plan\Entities\Plan;

class PlanDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $plans = [
            [
                'label' => 'Free',
                'price' => 0.00,
                'ad_limit' => 10,

                'featured_limit' => 10,
                'featured_duration' => 30,

                'urgent_limit' => 10,
                'urgent_duration' => 30,

                'highlight_limit' => 10,
                'highlight_duration' => 30,

                'top_limit' => 10,
                'top_duration' => 30,

                'bump_up_limit' => 10,
                'bump_up_duration' => 30,

                'badge' => true,
                'premium_member' => true,

                'recommended' => true,
                'interval' => 'monthly',
                'plan_payment_type' => 'recurring',
            ],
            [
                'label' => 'Basic',
                'price' => 10,
                'ad_limit' => 4,

                'featured_limit' => 2,
                'featured_duration' => 2,

                'urgent_limit' => 0,
                'urgent_duration' => 0,

                'highlight_limit' => 0,
                'highlight_duration' => 0,

                'top_limit' => 0,
                'top_duration' => 0,

                'bump_up_limit' => 0,
                'bump_up_duration' => 0,

                'badge' => true,
                'premium_member' => false,

                'recommended' => false,
                'interval' => 'monthly',
                'plan_payment_type' => 'recurring',
                'stripe_id' => 'price_1OUoNnDHsbz9CBNMyNPBdF7W',
            ],
            [
                'label' => 'Standard',
                'price' => 30,
                'ad_limit' => 12,

                'featured_limit' => 6,
                'featured_duration' => 20,

                'urgent_limit' => 1,
                'urgent_duration' => 2,

                'highlight_limit' => 1,
                'highlight_duration' => 1,

                'top_limit' => 1,
                'top_duration' => 1,

                'bump_up_limit' => 1,
                'bump_up_duration' => 1,

                'badge' => true,
                'premium_member' => false,

                'recommended' => true,
                'interval' => 'custom_date',
                'custom_interval_days' => '90',
                'plan_payment_type' => 'recurring',
                'stripe_id' => 'price_1OUoWwDHsbz9CBNMeEeuoVXp',
            ],
            [
                'label' => 'Premium',
                'price' => 100,
                'ad_limit' => 36,

                'featured_limit' => 12,
                'featured_duration' => 5,

                'urgent_limit' => 5,
                'urgent_duration' => 3,

                'highlight_limit' => 3,
                'highlight_duration' => 2,

                'top_limit' => 3,
                'top_duration' => 2,

                'bump_up_limit' => 3,
                'bump_up_duration' => 2,

                'badge' => true,
                'premium_member' => true,

                'recommended' => false,
                'interval' => 'yearly',
                'plan_payment_type' => 'recurring',
                'stripe_id' => 'price_1OUoPnDHsbz9CBNMYnKHlfFi',
            ],

            [
                'label' => 'Free',
                'price' => 0.00,
                'ad_limit' => 10,

                'featured_limit' => 10,
                'featured_duration' => 30,

                'urgent_limit' => 10,
                'urgent_duration' => 30,

                'highlight_limit' => 10,
                'highlight_duration' => 30,

                'top_limit' => 10,
                'top_duration' => 30,

                'bump_up_limit' => 10,
                'bump_up_duration' => 30,

                'badge' => true,
                'premium_member' => true,

                'recommended' => false,
                'plan_payment_type' => 'one_time',
            ],
            [
                'label' => 'Silver',
                'price' => 150,
                'ad_limit' => 50,

                'featured_limit' => 15,
                'featured_duration' => 15,

                'urgent_limit' => 10,
                'urgent_duration' => 4,

                'highlight_limit' => 10,
                'highlight_duration' => 3,

                'top_limit' => 10,
                'top_duration' => 2,

                'bump_up_limit' => 10,
                'bump_up_duration' => 2,

                'badge' => true,
                'premium_member' => true,

                'recommended' => false,
                'plan_payment_type' => 'one_time',
            ],
            [
                'label' => 'Gold',
                'price' => 200,
                'ad_limit' => 60,

                'featured_limit' => 20,
                'featured_duration' => 20,

                'urgent_limit' => 15,
                'urgent_duration' => 10,

                'highlight_limit' => 15,
                'highlight_duration' => 5,

                'top_limit' => 15,
                'top_duration' => 5,

                'bump_up_limit' => 15,
                'bump_up_duration' => 5,

                'badge' => true,
                'premium_member' => true,

                'recommended' => true,
                'plan_payment_type' => 'one_time',
            ],
            [
                'label' => 'Platinum',
                'price' => 250,
                'ad_limit' => 70,

                'featured_limit' => 30,
                'featured_duration' => 30,

                'urgent_limit' => 30,
                'urgent_duration' => 15,

                'highlight_limit' => 30,
                'highlight_duration' => 8,

                'top_limit' => 30,
                'top_duration' => 10,

                'bump_up_limit' => 30,
                'bump_up_duration' => 10,

                'badge' => true,
                'premium_member' => true,

                'recommended' => false,
                'plan_payment_type' => 'one_time',
            ],
        ];

        foreach ($plans as $plan) {
            Plan::create($plan);
        }
    }
}
