<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Plan\Entities\Plan;

class Transaction extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Transaction customer
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     *  Customer scope
     *
     * @return mixed
     */
    public function scopeCustomerData($query, $api = false)
    {
        if ($api) {
            return $query->where('user_id', auth('api')->id());
        } else {
            return $query->where('user_id', auth('user')->id());
        }
    }

    /**
     * Transaction plan
     */
    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class);
    }

    /**
     * Manual payment
     */
    public function manualPayment(): BelongsTo
    {
        return $this->belongsTo(ManualPayment::class, 'manual_payment_id');
    }

    public function scopeAdminFilter($query)
    {
        $query->when(request()->has('customer') && request('customer') != null, function ($q) {
            $q->where('user_id', request('customer'));
        });
        $query->when(request()->has('plan') && request('plan') != null, function ($q) {
            $q->where('plan_id', request('plan'));
        });
        $query->when(request()->has('provider') && request('provider') != null, function ($q) {
            $q->where('payment_provider', request('provider'));
        });
        $query->when(request()->has('sort_by') && request('sort_by') != null, function ($q) {
            if (request('sort_by') == 'latest') {
                $q->latest();
            } else {
                $q->oldest();
            }
        });
    }
}
