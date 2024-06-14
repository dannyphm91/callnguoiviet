<?php

namespace App\Jobs;

use App\Http\Traits\PaymentTrait;
use App\Models\Transaction;
use App\Models\User;
use App\Notifications\MembershipUpgradeNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Modules\Currency\Entities\Currency;
use Modules\Plan\Entities\Plan;
use Spatie\WebhookClient\Models\WebhookCall;

class InvoicePaymentSucceededJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, PaymentTrait, Queueable, SerializesModels;

    public $webhookCall;

    public function __construct(WebhookCall $webhookCall)
    {
        $this->webhookCall = $webhookCall;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        dump('----InvoicePaymentSucceededJob-------');
        $response = $this->webhookCall->payload['data']['object'];

        dump($response);

        // Handle the event
        $customer_stripe_id = $response['customer'];
        $stripe_plan = $response['lines']['data'][0]['plan'];
        $invoice_url = $response['hosted_invoice_url'];
        $transaction_id = $response['payment_intent'];
        $amount_paid = $response['amount_paid'];
        $payment_currency = $response['currency'];

        $user = User::where('stripe_id', $customer_stripe_id)->first();
        $plan = Plan::where('stripe_id', $stripe_plan['id'])->first();
        $payment_provider = 'stripe';
        $usd_amount = $amount_paid / 100;
        $currency_symbol = Currency::where('code', $payment_currency)->value('symbol');
        $transaction_id = $transaction_id ?? uniqid('tr_');

        // Plan benefit attach to user
        $this->userPlanInfoUpdate($plan, $user->id);

        // Transaction create
        $transaction = Transaction::create([
            'order_id' => rand(1000, 999999999),
            'transaction_id' => $transaction_id,
            'plan_id' => $plan->id,
            'user_id' => $user->id,
            'payment_provider' => $payment_provider,
            'amount' => $usd_amount,
            'currency_symbol' => $currency_symbol,
            'usd_amount' => $usd_amount,
            'payment_status' => 'paid',
            'invoice_url' => $invoice_url,
        ]);

        // create notification and send mail to customer
        if (checkMailConfig()) {
            if (checkSetup('mail')) {
                $user->notify(new MembershipUpgradeNotification($user, $plan->label));
            }
        }

        dump($transaction);
        dump('------InvoicePaymentSucceededJob----------');
    }
}
