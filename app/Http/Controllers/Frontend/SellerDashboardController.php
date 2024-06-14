<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Traits\HasPlanPromotion;
use App\Models\Report;
use App\Models\ResubmissionGallery;
use App\Models\User;
use App\Models\UserPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Modules\Ad\Entities\Ad;
use Modules\Category\Entities\Category;
use Modules\Review\Entities\Review;
use Modules\Wishlist\Entities\Wishlist;

class SellerDashboardController extends Controller
{
    use HasPlanPromotion;

    public function profile(User $user)
    {
        try {
            session()->put(['seller_tab' => 'ads']);

            $reviews = Review::whereSellerId($user->id)
                ->whereStatus(1)
                ->get();
            $already_review = $reviews->firstWhere('user_id', auth()->id());
            $rating_details = [
                'total' => $reviews->count(),
                'rating' => $reviews->sum('stars'),
                'average' => number_format($reviews->avg('stars')),
            ];
            $total_active_ad = Ad::where('user_id', $user->id)
                ->activeCategory()
                ->active()
                ->count();
            $social_medias = $user->socialMedia;

            return view('frontend.seller.dashboard', [
                'user' => $user,
                'already_review' => $already_review,
                'rating_details' => $rating_details,
                'total_active_ad' => $total_active_ad,
                'social_medias' => $social_medias,
            ]);
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    public function rateReview(Request $request)
    {
        session(['seller_tab' => 'review_store']);

        $request->validate([
            'stars' => 'required|numeric|between:1,5',
            'comment' => 'required|string|max:255',
        ]);
        try {
            Review::create([
                'seller_id' => $request->seller_id,
                'user_id' => auth()->id(),
                'stars' => $request->stars,
                'comment' => $request->comment,
            ]);

            if ($request->stars && $request->comment) {
                $message = 'Review submitted successfully';
                $request->session()->flash('success', $message);
                $success = true;
            } else {
                $message = 'Review submit Failed';
                $success = false;
            }
            $redirectUrl = route('frontend.seller.profile', $request->seller_username);

            return response()->json(['success' => $success, 'message' => $message, 'redirectUrl' => $redirectUrl]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'An error occurred: '.$e->getMessage()]);
        }
    }

    public function preSignup(Request $request)
    {
        session(['seller_tab' => 'review_store']);

        $request->validate([
            'email' => 'required',
        ]);
        try {
            return redirect()->route('frontend.signup', ['email' => $request->email]);
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    public function report(Request $request)
    {
        $request->validate([
            'reason' => 'required',
        ]);

        try {
            Report::create([
                'report_from_id' => auth('user')->id(),
                'report_to_id' => $request->user_id,
                'reason' => $request->reason,
            ]);

            if ($request->reason) {
                $message = 'Report Sent Successfully';
                $success = true;
                $request->session()->flash('success', $message);
            } else {
                $message = 'Report Sent Failed';
                $success = false;
            }

            // Get the redirect URL
            $redirectUrl = route('frontend.seller.profile', $request->username);

            // Return the JSON response with the success status, message, and redirect URL
            return response()->json(['success' => $success, 'message' => $message, 'redirectUrl' => $redirectUrl]);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'An error occurred: '.$e->getMessage()]);
        }
    }

    public function favoriteList()
    {
        try {
            $wishlistsIds = Wishlist::select('ad_id')
                ->customerData()
                ->pluck('ad_id')
                ->all();

            $query = Ad::select(['id', 'title', 'slug', 'thumbnail', 'price', 'status', 'category_id', 'country', 'district', 'region', 'created_at'])
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

            return view('frontend.favorite-listing', $data);
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    public function myListing()
    {
        try {
            $data['categories'] = Category::active()->get();
            $data['user'] = auth('user')->user();

            $query = Ad::customerData();
            $query->whereNot('resubmission', 1);

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

            $data['ads'] = $query->with('category')->paginate(5)->withQueryString();

            // $data['user_plan'] = UserPlan::where('user_id', auth()->user()->id)->first();
            $data['user_plan_data'] = UserPlan::where('user_id', auth()->user()->id)->first();
            $data['plan'] = $data['user_plan_data']->currentPlan;

            return view('frontend.my-listing', $data);
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    public function resubmissionList()
    {
        try {
            $data['categories'] = Category::active()->get();
            $data['user'] = auth('user')->user();
            $data['resubmissionGallery'] = ResubmissionGallery::all();
            $query = Ad::customerData();
            $query->where('resubmission', 1);

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

            $data['ads'] = $query->with('category')->paginate(5)->withQueryString();

            return view('frontend.resubmission-listing', $data);
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    public function deleteProfile(User $user)
    {

        try {
            if (Hash::check(request('password'), auth()->user()->password)) {

                $user->delete();

                return redirect()->back()->with('success', 'Account deleted successfully');
            } else {

                return redirect()->back()->with('error', 'Incorrect password. Please try again.');
            }
        } catch (\Exception $e) {

            return redirect()->back()->with('error', 'An error occurred while processing your request. Please try again.');
        }
    }

    public function promoteListing(Request $request, Ad $ad)
    {

        $request->validate([
            'featured' => 'sometimes|boolean',
            'urgent' => 'sometimes|boolean',
            'highlight' => 'sometimes|boolean',
            'top' => 'sometimes|boolean',
            'bump_up' => 'sometimes|boolean',
        ]);

        // Assign promotions to user
        $ad = $this->promotePlan($request, $ad, auth()->id());
        $ad->save();

        flashSuccess('Listing Promotions updated Successfully!');

        return back();
    }
}
