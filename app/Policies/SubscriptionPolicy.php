<?php

namespace App\Policies;

use App\Models\User;
use Laravel\Cashier\Subscription;

class SubscriptionPolicy
{
    /**
     * Create a new policy instance.
     */
    public function cancel(User $user, Subscription $subscription): bool
    {
        return ! $subscription->cancelled();
    }

    public function resume(User $user, Subscription $subscription): bool
    {
        return $subscription->cancelled();
    }
}
