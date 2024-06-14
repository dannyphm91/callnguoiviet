<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Affiliate;
use App\Models\AffiliatePointHistory;

class AffiliateController extends Controller
{
    public function getPartners()
    {
        try {
            $partners = Affiliate::with('user', 'user.affiliateInvites')->latest()->paginate(10);

            return view('admin.affiliate.partners', compact('partners'));

        } catch (\Throwable $th) {
            flashError('Error Occurred:'.$th->getMessage());

            return back();
        }
    }

    public function getBalanceRequests()
    {
        try {

            $balanceRequests = AffiliatePointHistory::with('user')->latest()->paginate(10); // Set your desired pagination limit

            return view('admin.affiliate.balance-request', compact('balanceRequests'));

        } catch (\Throwable $th) {
            flashError('Error Occurred:'.$th->getMessage());

            return back();
        }
    }

    public function balanceRequestConfirm($id)
    {
        try {

            $requestBalance = AffiliatePointHistory::find($id);
            $partnerWallet = Affiliate::where('user_id', $requestBalance->user_id)->first();

            $partnerWallet->balance = (float) $partnerWallet->balance + (float) $requestBalance->pricing;
            $partnerWallet->save();

            $requestBalance->status = 1;
            $requestBalance->save();

            flashSuccess('Balance Add to Partner Wallet');

            return back();

        } catch (\Throwable $th) {
            flashError('Error Occurred:'.$th->getMessage());

            return back();
        }
    }
}
