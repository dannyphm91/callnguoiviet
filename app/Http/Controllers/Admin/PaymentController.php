<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ManualPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Modules\SetupGuide\Entities\SetupGuide;

class PaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('access_limitation')->only([
            'update',
            'updateStatus',
            'manualPaymentDelete',
            'manualPaymentStatus',
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.settings.pages.payment');
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        switch ($request->type) {
            case 'paypal':
                $this->paypalUpdate($request);
                break;
            case 'stripe':
                $this->stripeUpdate($request);
                break;
            case 'razorpay':
                $this->razorpayUpdate($request);
                break;
            case 'ssl_commerz':
                $this->sslcommerzUpdate($request);
                break;
            case 'paystack':
                $this->paystackUpdate($request);
                break;
            case 'flutterwave':
                $this->flutterwaveUpdate($request);
                break;
            case 'midtrans':
                $this->midtransUpdate($request);
                break;
            case 'mollie':
                $this->mollieUpdate($request);
                break;
            case 'instamojo':
                $this->instamojoUpdate($request);
                break;
        }

        SetupGuide::where('task_name', 'payment_setting')->update(['status' => 1]);
    }

    public function paypalUpdate(Request $request)
    {
        $request->validate([
            'paypal_client_id' => 'required',
            'paypal_client_secret' => 'required',
        ]);

        if ($request->paypal_live_mode) {
            checkSetConfig('templatecookie.paypal_live_client_id', $request->paypal_client_id);
            checkSetConfig('templatecookie.paypal_live_client_secret', $request->paypal_client_secret);
        } else {
            checkSetConfig('templatecookie.paypal_sandbox_client_id', $request->paypal_client_id);
            checkSetConfig('templatecookie.paypal_sandbox_client_secret', $request->paypal_client_secret);
        }

        setConfig('templatecookie.paypal_live_mode', $request->paypal_live_mode ? 'live' : 'sandbox');

        sleep(2);
        Artisan::call('cache:clear');

        flashSuccess('Paypal Setting Updated Successfully');

        return redirect()->route('settings.payment')->send();
    }

    public function stripeUpdate(Request $request)
    {
        $request->validate([
            'stripe_key' => 'required',
            'stripe_secret' => 'required',
            'stripe_webhook_secret' => 'required',
        ]);

        checkSetConfig('templatecookie.stripe_key', $request->stripe_key);
        checkSetConfig('templatecookie.stripe_secret', $request->stripe_secret);
        checkSetConfig('templatecookie.stripe_webhook_secret', $request->stripe_webhook_secret);
        checkSetConfig('cashier.key', $request->stripe_key);
        checkSetConfig('cashier.secret', $request->stripe_secret);
        checkSetConfig('cashier.webhook.secret', $request->stripe_webhook_secret);
        checkSetConfig('stripe-webhooks.signing_secret', $request->stripe_webhook_secret);

        flashSuccess('Stripe Setting Updated Successfully');

        return redirect()->route('settings.payment')->send();
    }

    public function razorpayUpdate(Request $request)
    {
        $request->validate([
            'razorpay_key' => 'required',
            'razorpay_secret' => 'required',
        ]);

        checkSetConfig('templatecookie.razorpay_key', $request->razorpay_key);
        checkSetConfig('templatecookie.razorpay_secret', $request->razorpay_secret);

        sleep(2);
        Artisan::call('cache:clear');

        flashSuccess('RazorPay Setting Updated Successfully');

        return redirect()->route('settings.payment')->send();
    }

    public function sslcommerzUpdate(Request $request)
    {
        $request->validate([
            'store_id' => 'required',
            'store_password' => 'required',
        ]);

        checkSetConfig('templatecookie.ssl_live_mode', $request->ssl_live_mode ? 'live' : 'sandbox');
        checkSetConfig('templatecookie.store_id', $request->store_id);
        checkSetConfig('templatecookie.store_password', $request->store_password);

        sleep(2);
        Artisan::call('cache:clear');

        flashSuccess('SSl Commerz Setting Updated Successfully');

        return redirect()->route('settings.payment')->send();
    }

    public function paystackUpdate(Request $request)
    {
        $request->validate([
            'paystack_public_key' => 'required',
            'paystack_secret_key' => 'required',
            'merchant_email' => 'required',
        ]);

        checkSetConfig('templatecookie.paystack_public_key', $request->paystack_public_key);
        checkSetConfig('templatecookie.paystack_secret_key', $request->paystack_secret_key);
        checkSetConfig('templatecookie.merchant_email', $request->merchant_email);

        sleep(2);
        Artisan::call('cache:clear');

        flashSuccess('Paystack Setting Updated Successfully');

        return redirect()->route('settings.payment')->send();
    }

    public function flutterwaveUpdate(Request $request)
    {
        $request->validate([
            'flw_public_key' => 'required',
            'flw_secret_key' => 'required',
            'flw_secret_hash' => 'required',
        ]);

        checkSetConfig('templatecookie.flw_public_key', $request->flw_public_key);
        checkSetConfig('templatecookie.flw_secret_key', $request->flw_secret_key);
        checkSetConfig('templatecookie.flw_secret_hash', $request->flw_secret_hash);

        sleep(2);
        Artisan::call('cache:clear');

        flashSuccess('Paystack Setting Updated Successfully');

        return redirect()->route('settings.payment')->send();
    }

    public function midtransUpdate(Request $request)
    {
        $request->validate([
            'midtrans_merchat_id' => 'required',
            'midtrans_client_key' => 'required',
            'midtrans_server_key' => 'required',
        ]);

        checkSetConfig('templatecookie.midtrans_merchat_id', $request->midtrans_merchat_id);
        checkSetConfig('templatecookie.midtrans_client_key', $request->midtrans_client_key);
        checkSetConfig('templatecookie.midtrans_server_key', $request->midtrans_server_key);

        sleep(2);
        Artisan::call('cache:clear');

        flashSuccess('Midtrans Setting Updated Successfully');

        return redirect()->route('settings.payment')->send();
    }

    public function mollieUpdate(Request $request)
    {
        $request->validate([
            'mollie_key' => 'required',
        ]);

        checkSetConfig('templatecookie.mollie_key', $request->mollie_key);

        sleep(2);
        Artisan::call('cache:clear');

        flashSuccess('Mollie Setting Updated Successfully');

        return redirect()->route('settings.payment')->send();
    }

    public function instamojoUpdate(Request $request)
    {
        $request->validate([
            'im_key' => 'required',
            'im_secret' => 'required',
        ], [
            'im_key.required' => 'Instamojo Key is required',
            'im_secret.required' => 'Instamojo Secret is required',
        ]);

        checkSetConfig('templatecookie.im_key', $request->im_key);
        checkSetConfig('templatecookie.im_secret', $request->im_secret);

        sleep(2);
        Artisan::call('cache:clear');

        flashSuccess('Instamojo Setting Updated Successfully');

        return redirect()->route('settings.payment')->send();
    }

    public function updateStatus(Request $request)
    {
        $type = $request->type;
        $status = $request->status;

        switch ($type) {
            case 'paypal':
                setConfig('templatecookie.paypal_active', $status ? true : false);
                break;
            case 'stripe':
                setConfig('templatecookie.stripe_active', $status ? true : false);
                break;
            case 'razorpay':
                setConfig('templatecookie.razorpay_active', $status ? true : false);
                break;
            case 'ssl_commerz':
                setConfig('templatecookie.ssl_active', $status ? true : false);
                break;
            case 'paystack':
                setConfig('templatecookie.paystack_active', $status ? true : false);
                break;
            case 'flutterwave':
                setConfig('templatecookie.flw_active', $status ? true : false);
                break;
            case 'midtrans':
                setConfig('templatecookie.midtrans_active', $status ? true : false);
                break;
            case 'mollie':
                setConfig('templatecookie.mollie_active', $status ? true : false);
                break;
            case 'instamojo':
                setConfig('templatecookie.im_active', $status ? true : false);
                break;
        }

        sleep(2);
        Artisan::call('cache:clear');

        return response()->json(['success' => true]);
    }

    public function manualPayment()
    {
        abort_if(! userCan('setting.view'), 403);

        $manual_payment_gateways = ManualPayment::all();

        return view('admin.settings.pages.payment-manual', compact('manual_payment_gateways'));
    }

    public function manualPaymentStore(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'type' => 'required',
            'description' => 'required',
        ]);

        ManualPayment::create([
            'name' => $request->name,
            'type' => $request->type,
            'description' => $request->description,
        ]);

        flashSuccess('Manual Payment Created Successfully');

        return back();
    }

    public function manualPaymentEdit(ManualPayment $manual_payment)
    {
        $manual_payment_gateways = ManualPayment::all();

        return view('admin.settings.pages.payment-manual', compact('manual_payment_gateways', 'manual_payment'));
    }

    public function manualPaymentUpdate(Request $request, ManualPayment $manual_payment)
    {
        $request->validate([
            'name' => 'required',
            'type' => 'required',
            'description' => 'required',
        ]);

        $manual_payment->update([
            'name' => $request->name,
            'type' => $request->type,
            'description' => $request->description,
        ]);

        flashSuccess('Manual Payment Updated Successfully');

        return back();
    }

    public function manualPaymentDelete(ManualPayment $manual_payment)
    {
        $manual_payment->delete();

        flashSuccess('Manual Payment Deleted Successfully');

        return redirect()->route('settings.payment.manual');
    }

    public function manualPaymentStatus(Request $request)
    {
        $manual_payment = ManualPayment::findOrFail($request->id);
        $manual_payment->update(['status' => $request->status]);

        return response()->json(['message' => 'Payment Status Updated Successfully']);
    }
}
