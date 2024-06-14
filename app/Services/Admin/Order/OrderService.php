<?php

namespace App\Services\Admin\Order;

use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Modules\Currency\Entities\Currency;
use Modules\Plan\Entities\Plan;

class OrderService
{
    public function create(): array
    {
        $data['plans'] = Plan::latest()->get();
        $data['users'] = User::latest()->with('userPlan')->get();
        $data['currencies'] = Currency::latest()->get();

        return $data;
    }

    public function store(object $request): object
    {
        $transaction = Transaction::create([
            'order_id' => rand(1000, 999999999),
            'transaction_id' => uniqid('tr_'),
            'plan_id' => $request->plan,
            'user_id' => $request->user,
            'payment_provider' => $request->payment_provider,
            'amount' => $request->amount,
            'currency_symbol' => $request->currency_symbol,
            'usd_amount' => $request->usd_amount,
            'payment_status' => $request->payment_status,
            'manual_payment_id' => null,
        ]);

        return $transaction;
    }

    public function update(object $request, object $transaction): object
    {
        $transaction->update([
            'plan_id' => $request->plan,
            'user_id' => $request->user,
            'payment_provider' => $request->payment_provider,
            'amount' => $request->amount,
            'currency_symbol' => $request->currency_symbol,
            'usd_amount' => $request->usd_amount,
            'payment_status' => $request->payment_status,
        ]);

        return $transaction;
    }

    public function edit(object $transaction): array
    {
        $data['plans'] = Plan::latest()->get();
        $data['users'] = User::latest()->get();
        $data['currencies'] = Currency::latest()->get();
        $data['transaction'] = $transaction;

        return $data;
    }

    public function updatePlan(object $transaction): array
    {
        $data['plans'] = Plan::latest()->get();
        $data['user'] = User::where('id', $transaction->user_id)->with('userPlan')->first();
        $data['plan'] = Plan::where('id', $transaction->plan_id)->first();
        $data['date'] = Carbon::now();

        return $data;
    }

    public function updatePlanData(object $request, object $user): object
    {
        $date = date('Y-m-d', strtotime($request->expired_date));
        $user->userPlan->update([
            'ad_limit' => $request->ad_limit,
            'current_plan_id' => $request->user_plan,
            'featured_limit' => $request->featured_limit,
            'badge' => $request->badge == '1' ? true : false,
            'expired_date' => $date,
        ]);

        $plan = Plan::where('id', $user->userPlan->current_plan_id)->first();

        return $plan;
    }
}
