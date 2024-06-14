<?php

namespace App\Http\Controllers\Frontend;

use App\Actions\Frontend\ProfileUpdate;
use App\Http\Controllers\Controller;
use App\Models\Affiliate;
use App\Models\AffiliateInvite;
use App\Models\AffiliatePointHistory;
use App\Models\AffiliateSetting;
use App\Models\RedeemPoint;
use App\Models\Transaction;
use App\Models\User;
use App\Notifications\AdWishlistNotification;
use App\Rules\MatchOldPassword;
use App\Services\Frontend\CustomerAccountVerifyService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Modules\Ad\Entities\Ad;
use Modules\Plan\Entities\Plan;
use Modules\Wishlist\Entities\Wishlist;

class DashboardController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {
        try {
            storePlanInformation();

            $auth_user_plan = session('user_plan');
            $authUser = authUser();
            $ads = Ad::customerData()->get();
            $favourite_count = Wishlist::whereUserId($authUser->id)->count();
            $posted_ads_count = $ads->where('user_id', $authUser->id)->count();
            $expire_ads_count = $ads
                ->where('status', 'sold')
                ->where('user_id', $authUser->id)
                ->count();
            $activities = authUser()
                ->notifications()
                ->latest()
                ->limit(5)
                ->get();

            // bar chart by year
            $bar_chart_datas = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
            $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'July', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

            for ($i = 0; $i < 12; $i++) {
                $bar_chart_datas[$i] = (int) Ad::customerData()
                    ->select('total_views')
                    ->whereYear('created_at', date('Y'))
                    ->whereMonth('created_at', $i + 1)
                    ->sum('total_views');
            }

            $format_chart_data = [];

            foreach ($months as $key => $month) {
                $format_chart_data[] = [
                    'x' => $month,
                    'y' => $bar_chart_datas[$key],
                ];
            }

            return view('frontend.dashboard.index', [
                'activities' => $activities,
                'favouriteadcount' => $favourite_count,
                'posted_ads_count' => $posted_ads_count,
                'expire_ads_count' => $expire_ads_count,
                'bar_chart_datas' => $format_chart_data,
                'user_plan' => $auth_user_plan,
            ]);
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    public function myAdStatus(Ad $ad)
    {
        try {
            if ($ad->status == 'active') {
                $ad->status = 'sold';
            } elseif ($ad->status == 'sold') {
                $ad->status = 'active';
            } elseif ($ad->status == 'declined') {
                $ad->status = 'sold';
            }
            $ad->update();

            flashSuccess('Status updated successfully!');

            return back();
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    public function favourites()
    {
        try {
            $wishlistsIds = Wishlist::select('ad_id')
                ->customerData()
                ->pluck('ad_id')
                ->all();

            $query = Ad::select(['id', 'title', 'slug', 'thumbnail', 'price', 'status', 'category_id', 'created_at'])
                ->with('category')
                ->whereIn('id', $wishlistsIds);

            if (request()->has('keyword') && request()->keyword != null) {
                $keyword = request('keyword');
                $query->where('title', 'LIKE', "%$keyword%");
            }

            if (request()->has('category') && request()->category != null) {
                $query->whereHas('category', function ($q) {
                    $q->where('slug', request('category'));
                });
            }

            if (request()->has('sort_by') && request()->sort_by != null && request('sort_by') == 'oldest') {
                $query->orderBy('id', 'ASC');
            } else {
                $query->orderBy('id', 'DESC');
            }

            $data['wishlists'] = $query->paginate(5)->withQueryString();

            return view('frontend.favourite-ads', $data);
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    public function message()
    {
        try {
            $user['user'] = auth()->user();

            return view('frontend.message', $user);
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    public function plansBilling()
    {
        try {
            storePlanInformation();
            $data['user_plan'] = session('user_plan');

            if ($data['user_plan'] && $data['user_plan']?->current_plan_id) {
                $data['current_plan'] = Plan::find($data['user_plan']->current_plan_id);
                $data['plan_type'] = $data['current_plan']->plan_payment_type;
            } else {
                $data['current_plan'] = null;
            }

            $data['transactions'] = Transaction::with('plan')
                ->customerData()
                ->latest()
                ->get()
                ->take(5);

            return view('frontend.dashboard.plans-billing', $data);
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    public function cancelPlan()
    {
        try {
            $user_plan = auth('user')->user()->userPlan;
            $plan = Plan::find($user_plan->current_plan_id);

            $user_plan->update([
                'ad_limit' => $user_plan->ad_limit ? $user_plan->ad_limit - $plan->ad_limit : 0,
                'featured_limit' => $user_plan->featured_limit ? $user_plan->featured_limit - $plan->featured_limit : 0,
                'current_plan_id' => null,
                'expired_date' => null,
            ]);

            flashSuccess('Plan cancelled successfully!');

            return back();
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    public function accountSetting()
    {
        try {
            $user = authUser();
            $social_medias = $user->socialMedia;

            return view('frontend.dashboard.setting', compact('social_medias', 'user'));
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    public function profileUpdate(Request $request)
    {
        $customer = authUser();

        $request->validate([
            'name' => 'required',
            'email' => "required|email|unique:users,email,{$customer->id}",
            'phone' => 'sometimes|nullable',
            'web' => 'sometimes|nullable|url',
            'address' => 'nullable',
            'bio' => 'nullable',
        ]);

        try {

            $customer = ProfileUpdate::update($request, $customer);

            if ($customer) {
                flashSuccess('Profile Updated Successfully');

                return back();
            }
        } catch (\Exception $e) {
            flashError();

            return back();
        }
    }

    public function passwordUpdate(Request $request)
    {
        $request->validate([
            'current_password' => ['required', new MatchOldPassword()],
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required',
        ]);
        try {
            $password_check = Hash::check($request->current_password, auth('user')->user()->password);

            if ($password_check) {
                $user = User::findOrFail(auth('user')->id());
                $user->update([
                    'password' => bcrypt($request->password),
                    'updated_at' => Carbon::now(),
                ]);

                flashSuccess('Password Updated Successfully');

                return back();
            } else {
                flashError('Something went wrong');

                return back();
            }
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    public function socialUpdate(Request $request)
    {
        try {
            $user = auth('user')->user();

            $user->socialMedia()->delete();
            // $user->socialMedia()->createMany($request->all());

            $social_medias = $request->social_media;
            $urls = $request->url;

            foreach ($social_medias as $key => $value) {
                if ($value) {
                    $user->socialMedia()->create([
                        'social_media' => $value,
                        'url' => $urls[$key],
                    ]);
                }
            }

            flashSuccess('Social Media Updated Successfully');

            return back();
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    public function addToWishlist(Request $request)
    {
        try {
            $ad = Ad::findOrFail($request->ad_id);
            $data = Wishlist::where('ad_id', $request->ad_id)
                ->whereUserId($request->user_id)
                ->first();
            if ($data) {
                $data->delete();

                $user = auth('user')->user();
                if (checkSetup('mail')) {
                    $user->notify(new AdWishlistNotification($user, 'remove', $ad->slug));
                }

                flashSuccess('Ad removed from wishlist');
            } else {
                Wishlist::create([
                    'ad_id' => $request->ad_id,
                    'user_id' => $request->user_id,
                ]);

                $user = auth('user')->user();
                $user->notify(new AdWishlistNotification($user, 'add', $ad->slug));

                flashSuccess('Ad added to wishlist');
            }
            resetSessionWishlist();

            return back();
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    /**
     * Seller Account Verify Process Page
     *
     * @return Response
     */
    public function verifyAccount(CustomerAccountVerifyService $customerAccountVerifyService)
    {
        try {
            $data = $customerAccountVerifyService->verify();
            $data['resubmit'] = null;

            return view('frontend.dashboard.verify-account', $data);
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    public function resubmitVerifyAccount(CustomerAccountVerifyService $customerAccountVerifyService)
    {
        try {
            $data = $customerAccountVerifyService->verify();
            $data['resubmit'] = 'resubmit';

            return view('frontend.dashboard.verify-account', $data);
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    public function affiliteReg()
    {
        $wallet = Affiliate::where('user_id', Auth::id())->first();
        $wallet->affiliate_code = rand(100000, 999999);
        $wallet->save();

        return redirect()->route('frontend.wallet');
    }

    public function myWallet()
    {

        try {
            $wallet = Affiliate::firstOrCreate([
                'user_id' => Auth::id(),
            ]);

            if ($wallet->affiliate_code == null) {
                return view('frontend.dashboard.become-affiliate');
            } else {
                $baseUrl = url('/');
                $redeemPoints = RedeemPoint::latest()->get();
                $affiliateInvitedUsers = AffiliateInvite::where('user_id', Auth::id())->latest()->get();
                $affiliatePointHistory = AffiliatePointHistory::where('user_id', Auth::id())->latest()->get();
                $purchasedPlan = Transaction::whereUserId(auth()->id())->where('payment_provider', 'wallet_balance')->count();

                return view('frontend.dashboard.wallet', [
                    'baseUrl' => $baseUrl,
                    'wallet' => $wallet,
                    'redeemPoints' => $redeemPoints,
                    'affiliateInvitedUsers' => $affiliateInvitedUsers,
                    'affiliatePointHistory' => $affiliatePointHistory,
                    'purchasedPlan' => $purchasedPlan,
                ]);
            }
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    public function redeemPoints(Request $request, $id)
    {

        try {

            $affiliateSettings = AffiliateSetting::first();
            $redeemPoints = RedeemPoint::findorfail($id);
            $partnerWallet = Affiliate::where('user_id', Auth::id())->first();

            AffiliatePointHistory::create([
                'user_id' => Auth::id(),
                'order_id' => rand(100000, 999999),
                'points' => $redeemPoints->points,
                'pricing' => $redeemPoints->redeem_balance,
                'status' => ($affiliateSettings->point_convert_permission == 2) ? 0 : 1,
            ]);

            $partnerWallet->total_points = (int) $partnerWallet->total_points - (int) $redeemPoints->points;
            if ($affiliateSettings->point_convert_permission == 1) {
                $partnerWallet->balance = $partnerWallet->balance + $redeemPoints->redeem_balance;
            }
            $partnerWallet->save();

            flashSuccess('Your request has been submitted');

            return back();

        } catch (\Throwable $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }
}
