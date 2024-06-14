<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Traits\HasAd;
use App\Models\AboutPageSlider;
use App\Models\BlogComment;
use App\Models\Cms;
use App\Models\Customer;
use App\Models\HomePageSlider;
use App\Models\ManualPayment;
use App\Models\PricePlanService;
use App\Models\ReportAd;
use App\Models\SearchCountry;
use App\Models\User;
use App\Notifications\LogoutNotification;
use App\Services\Frontend\HomePageService;
use App\Services\Frontend\PrivacyPolicyService;
use App\Services\Frontend\PromotionsService;
use App\Services\Frontend\RefundPolicyService;
use App\Services\Frontend\TermsConditionService;
use App\Services\Midtrans\CreateSnapTokenService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Ad\Entities\Ad;
use Modules\Blog\Entities\Post;
use Modules\Blog\Entities\PostCategory;
use Modules\Brand\Entities\Brand;
use Modules\Category\Entities\Category;
use Modules\Category\Transformers\CategoryResource;
use Modules\Currency\Entities\Currency;
use Modules\Faq\Entities\Faq;
use Modules\Faq\Entities\FaqCategory;
use Modules\Plan\Entities\Plan;
use Modules\Testimonial\Entities\Testimonial;

class FrontendController extends Controller
{
    use HasAd;

    /**
     * View Home page
     *
     * @return \Illuminate\Http\Response
     * @return void
     */
    public function index()
    {
        try {
            $setting = loadSetting();

            $data = (new HomePageService())->execute();

            if ($setting->current_theme == 2) {
                // Get all FAQ categories with associated FAQs for the current language
                $data['categories'] = FaqCategory::with([
                    'faqs' => function ($query) {
                        $query->where('code', currentLangCode());
                    },
                ])->get(['id', 'name', 'slug', 'icon']);

                // If a category slug is specified in the request, filter by that category
                $category_slug = request('category');
                if ($category_slug) {
                    $data['selectedCategory'] = $data['categories']->firstWhere('slug', $category_slug);
                } else {
                    // If no category is specified, use the first category as default
                    $data['selectedCategory'] = $data['categories']->first();
                }

                // Get the FAQs for the selected category
                $data['faqs'] = $data['selectedCategory']->faqs ?? collect();

                // Initialize first Category
                $firstCategory = $data['categories']->first();
                $data['initialTab'] = $firstCategory ? 'tab-'.$firstCategory->id : 'tab-1';

                return view('frontend.homepage.index-2', $data);
            } elseif ($setting->current_theme == 3) {
                return view('frontend.homepage.index-3', $data);
            } else {
                return view('frontend.homepage.index', $data);
            }

            $featured_ads = $ads->where('featured', 1)->take(12);

            $latest_ads = $ads->take(12);

            $sliders = HomePageSlider::oldest('order')->get();

            // Top Categories Start
            $topCategories = CategoryResource::collection(
                Category::active()
                    ->with('subcategories', function ($q) {
                        $q->where('status', 1);
                    })
                    ->withCount([
                        'ads as ad_count' => function ($query) {
                            if (session()->get('selected_country')) {
                                $query->where('country', session()->get('selected_country'))->active();
                            } else {
                                $query->active();
                            }
                        },
                    ])
                    ->latest('ad_count')
                    ->take(12)
                    ->get(),
            );
            // Top Categories End

            return view('frontend.index', compact('featured_ads', 'latest_ads', 'sliders', 'topCategories'));
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    /**
     * View ad list page
     *
     * @return void
     */
    public function ads(Request $request)
    {
        try {
            $query = Ad::query()
                ->select('id', 'title', 'slug', 'user_id', 'category_id', 'subcategory_id', 'price', 'thumbnail', 'country', 'region')
                ->active()
                ->activeCategory()
                ->latest('id')
                ->with(['category']);

            if ($request->has('category') && $request->category != null) {
                $category = $request->category;

                $query->whereHas('category', function ($q) use ($category) {
                    $q->where('slug', $category);
                });
            }
            $data['brands'] = Brand::all();
            $data['headerSearch'] = $request->headerSearch ?? '';
            $data['headerLocation'] = $request->headerLocation ?? '';
            $data['ads'] = $query->paginate(20)->withQueryString();
            $data['metatitle'] = $query->count().' ads found for '.$request->category;

            return view('frontend.ads', $data);
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    public function adsCategory(Request $request)
    {
        try {
            $query = Ad::query()
                ->select('id', 'title', 'slug', 'user_id', 'category_id', 'subcategory_id', 'price', 'thumbnail', 'country', 'region')
                ->active()
                ->activeCategory()
                ->latest('id')
                ->with(['category']);

            $pathSegments = $request->segments();
            if ($pathSegments[1] != null) {
                $category = $pathSegments[1];

                $query->whereHas('category', function ($q) use ($category) {
                    $q->where('slug', $category);
                });
            }
            $data['brands'] = Brand::all();
            $data['headerSearch'] = $request->headerSearch ?? '';
            $data['headerLocation'] = $request->headerLocation ?? '';
            $data['ads'] = $query->paginate(20)->withQueryString();
            $data['metatitle'] = $query->count().' '.__('ads_found_for').'-'.$pathSegments[1];

            return view('frontend.ads', $data);
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    public function adsSubCategory(Request $request)
    {
        try {
            $query = Ad::query()
                ->select('id', 'title', 'slug', 'user_id', 'category_id', 'subcategory_id', 'price', 'thumbnail', 'country', 'region')
                ->active()
                ->activeCategory()
                ->latest('id')
                ->with(['category']);
            $pathSegments = $request->segments();
            if ($pathSegments[2] != null) {
                $category = $pathSegments[2];

                $query->whereHas('subCategory', function ($q) use ($category) {
                    $q->where('slug', $category);
                });
            }
            $data['brands'] = Brand::all();
            $data['headerSearch'] = $request->headerSearch ?? '';
            $data['headerLocation'] = $request->headerLocation ?? '';
            $data['ads'] = $query->paginate(20)->withQueryString();
            $data['metatitle'] = $query->count().' '.__('ads_found_for').'-'.$pathSegments[1].'-'.$pathSegments[2];

            return view('frontend.ads', $data);
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    /**
     * View Single Ad page
     *
     * @return void
     */
    public function adDetails(Ad $ad)
    {
        if ($ad->status == 'pending') {
            if ($ad->user_id != auth('user')->id()) {
                abort(404);
            }
        }

        if ($ad->status == 'sold') {
            if ($ad->user_id != auth('user')->id()) {
                abort(404);
            }
        }

        try {
            $ad->increment('total_views');

            $ad = $ad->load(['category', 'subcategory', 'customer', 'brand', 'adFeatures', 'galleries', 'productCustomFields.customField']);
            $product_custom_field_groups = $ad->productCustomFields->groupBy('custom_field_group_id');
            $related_ads = Ad::with('category', 'customer', 'subcategory')
                ->where('category_id', $ad->category_id)
                ->where('id', '!=', $ad->id)
                ->active()
                ->activeCategory()
                ->latest()
                ->take(12)
                ->get();

            return view('frontend.ad-details', compact('ad', 'product_custom_field_groups', 'related_ads'));
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    /**
     * View Testimonial page
     *
     * @param  Testimonial
     * @return \Illuminate\Http\Response
     * @return void
     */
    public function about()
    {
        try {
            $testimonials = Testimonial::latest('id')
                ->where('code', currentLangCode())
                ->get();

            $cms = Cms::select(['about_body', 'about_video_url', 'about_video_thumb'])->first();
            $aboutSliders = AboutPageSlider::oldest('order')->get();

            return view('frontend.about', compact('testimonials', 'cms', 'aboutSliders'));
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    /**
     * View Faq page
     *
     *  @param  Faq
     * @return void
     */
    public function faq()
    {
        if (! enableModule('faq')) {
            abort(404);
        }

        try {
            // Get all FAQ categories with associated FAQs for the current language
            $data['categories'] = FaqCategory::with([
                'faqs' => function ($query) {
                    $query->where('code', currentLangCode());
                },
            ])->get(['id', 'name', 'slug', 'icon']);

            // If a category slug is specified in the request, filter by that category
            $category_slug = request('category');
            if ($category_slug) {
                $data['selectedCategory'] = $data['categories']->firstWhere('slug', $category_slug);
            } else {
                // If no category is specified, use the first category as default
                $data['selectedCategory'] = $data['categories']->first();
            }

            // Get the FAQs for the selected category
            $data['faqs'] = $data['selectedCategory']->faqs ?? collect();

            // Initialize first Category
            $firstCategory = $data['categories']->first();
            $data['initialTab'] = $firstCategory ? 'tab-'.$firstCategory->id : 'tab-1';

            return view('frontend.faq', $data);
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    /**
     * View Contact page
     *
     * @return void
     */
    public function contact()
    {
        if (! enableModule('contact')) {
            abort(404);
        }

        return view('frontend.contact');
    }

    /**
     * View Priceplan page
     *
     * @return void
     */
    public function pricePlan()
    {
        if (! enableModule('price_plan')) {
            abort(404);
        }
        try {
            $plans = Plan::all();
            $cms = CMS::first();
            $aboutSliders = AboutPageSlider::oldest('order')->get();
            $price_plan_services = PricePlanService::all();
            $priceFaqs = Faq::where('code', currentLangCode())
                ->with('faq_category')
                ->whereHas('faq_category', function ($query) {
                    $query->where('name', 'Pricing-Plan');
                })
                ->get();

            return view('frontend.price-plan', [
                'plans' => $plans,
                'cms' => $cms,
                'aboutSliders' => $aboutSliders,
                'price_plan_services' => $price_plan_services,
                'priceFaqs' => $priceFaqs,
            ]);
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    /**
     * View Signup page
     *
     * @return void
     */
    public function signUp()
    {
        try {
            return view('frontend.auth.sign-up');
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  Customer
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $setting = setting();

        $request->validate(
            [
                'name' => 'required',
                'username' => 'required|unique:users,username',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|confirmed|min:8|max:50',
                'g-recaptcha-response' => config('captcha.active') ? 'required|captcha' : '',
                'check_me' => 'required',
            ],
            [
                'g-recaptcha-response.required' => 'Please verify that you are not a robot.',
                'g-recaptcha-response.captcha' => 'Captcha error! try again later or contact site admin.',
                'check_me.required' => 'Please accept that you are agree with Privacy policy and Terms conditions.',
            ],
        );
        try {
            $created = User::create([
                'name' => $request->name,
                'username' => $request->username,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);

            if ($created) {
                Auth::guard('user')->logout();
                Auth::guard('admin')->logout();
                flashSuccess('Registration Successful!');
                Auth::guard('user')->login($created);

                if ($setting->customer_email_verification) {
                    return redirect()->route('verification.notice');
                } else {
                    if ($request->post_job != null) {
                        return redirect()->route('frontend.post');
                    } else {
                        return redirect()->route('frontend.dashboard');
                    }
                }
            }
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function frontendLogout()
    {
        try {
            $this->loggedoutNotification();
            auth()
                ->guard('user')
                ->logout();

            return redirect()->route('users.login');
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    public function loggedoutNotification()
    {
        try {
            // Send login notification
            $user = User::find(auth('user')->id());
            $user->notify(new LogoutNotification($user));
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    /**
     * View Terms & Condition page
     *
     * @return void
     */
    public function blog(Request $request)
    {
        if (! enableModule('blog')) {
            abort(404);
        }
        try {
            $query = Post::with('author')->withCount('comments');

            if ($request->has('category') && $request->category != null) {
                $query->whereHas('category', function ($q) {
                    $q->where('slug', request('category'));
                });
            }

            if ($request->has('keyword') && $request->keyword != null) {
                $query->where('title', 'LIKE', "%$request->keyword%");
            }

            return view('frontend.blog', [
                'blogs' => $query->paginate(6)->withQueryString(),
                'recentBlogs' => Post::withCount('comments')
                    ->latest()
                    ->take(4)
                    ->get(),
                'topCategories' => PostCategory::latest()
                    ->take(6)
                    ->get(),
            ]);
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    /**
     * View Terms & Condition page
     *
     * @return void
     */
    public function singleBlog(Post $blog)
    {
        if (! enableModule('blog')) {
            abort(404);
        }
        try {
            $recentPost = Post::withCount('comments')
                ->latest('id')
                ->take(6)
                ->get();
            $categories = PostCategory::latest()
                ->take(6)
                ->get();
            $blog->load('author', 'category')->loadCount('comments');

            return view('frontend.blog-single', compact('blog', 'categories', 'recentPost'));
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    /**
     * View Privacy Policy page
     *
     * @return void
     */
    public function privacy(PrivacyPolicyService $privacyPolicyService)
    {
        try {
            $data = $privacyPolicyService->privacy();

            return view('frontend.privacy', $data);
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    /**
     * View Refund Policy page
     *
     * @return void
     */
    public function refund(RefundPolicyService $refundPolicyService)
    {
        try {
            $data = $refundPolicyService->refund();

            return view('frontend.refund', $data);
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    /**
     * View Terms & Condition page
     *
     * @return void
     */
    public function terms(TermsConditionService $termsConditionService)
    {
        try {
            $data = $termsConditionService->terms();

            return view('frontend.terms', $data);
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    /**
     * @param  int  $post_id
     * @return array
     */
    public function commentsCount($post_id)
    {
        try {
            return BlogComment::where('post_id', $post_id)->count();
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    /**
     * @param  int  $post_id
     * @return array
     */
    public function pricePlanDetails($plan_label)
    {
        if (! auth('user')->check()) {
            abort(404);
        }

        try {
            // session data storing
            $plan = Plan::where('label', $plan_label)->first();
            session(['plan' => $plan]);

            if ($plan->plan_payment_type == 'recurring') {
                $data['intent'] = request()
                    ->user()
                    ->createSetupIntent();
            } else {
                session(['stripe_amount' => currencyConversion($plan->price) * 100]);
                session(['razor_amount' => currencyConversion($plan->price, null, 'INR', 1) * 100]);
                session(['ssl_amount' => currencyConversion($plan->price, null, 'BDT', 1)]);

                // midtrans snap token
                if (config('templatecookie.midtrans_active') && config('templatecookie.midtrans_id') && config('templatecookie.midtrans_client_key') && config('templatecookie.midtrans_server_key')) {
                    $usd = $plan->price;
                    $fromRate = Currency::whereCode(config('templatecookie.currency'))->first()->rate;
                    $toRate = Currency::whereCode('IDR')->first()->rate;
                    $rate = $toRate / $fromRate;

                    $amount = (int) round($usd * $rate, 2);

                    $order['order_no'] = uniqid();
                    $order['total_price'] = $amount;

                    $midtrans = new CreateSnapTokenService($order);
                    $data['mid_token'] = $midtrans->getSnapToken();

                    session([
                        'midtrans_details' => [
                            'order_no' => $order['order_no'],
                            'total_price' => $order['total_price'],
                            'snap_token' => $data['mid_token'],
                            'plan_id' => $plan->id,
                        ],
                    ]);
                } else {
                    $data['mid_token'] = null;
                }

                // offline payment
                $data['manual_payments'] = ManualPayment::whereStatus(1)->get();

                // wallet balance
                $data['wallet_balance'] = authUser()?->affiliate?->balance ?? 0;
            }

            $data['plan'] = $plan;

            $data['current_plan'] = authUser()?->userPlan;

            return view('frontend.plan-details', $data);
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    public function adGalleryDetails(Ad $ad)
    {
        try {
            $ad->load('galleries');

            return view('frontend.single-ad-gallery', compact('ad'));
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    public function setSession(Request $request)
    {
        try {
            $request->session()->put('location', $request->input());

            return response()->json(true);
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    public function setSelectedCountry(Request $request)
    {
        try {
            if ($request->country == 'all_country') {
                session()->forget('selected_country');
            } else {
                $country = SearchCountry::find($request->country);
                session()->put('selected_country', $country->name);
            }

            return back();
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    public function adReport(Request $request)
    {
        $request->validate([
            'report_type' => 'required',
            'report_description' => 'required|max:500',
        ]);

        try {
            ReportAd::create([
                'report_from_id' => auth('user')->id(),
                'report_to_id' => $request->ad_id,
                'ad_report_category_id' => $request->report_type,
                'report_description' => $request->report_description,
            ]);

            if ($request->report_description) {
                $message = 'Report Sent Successfully';
                $success = true;
                $request->session()->flash('success', $message);
            } else {
                $message = 'Report Sent Failed';
                $success = false;
            }
            $redirectUrl = route('frontend.addetails', $request->ad_slug);

            return response()->json(['success' => $success, 'message' => $message, 'redirectUrl' => $redirectUrl]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'An error occurred: '.$e->getMessage()]);
        }
    }

    public function fetchCurrentTranslatedText()
    {
        try {
            $json = base_path('resources/lang/'.app()->getLocale().'.json');

            if (file_exists($json)) {
                $json = json_decode(file_get_contents($json), true);
            } else {
                $json = [];
            }

            return $json;
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    // Show Promotion Page
    public function promotionsView(PromotionsService $promotionsService)
    {

        try {
            $data = $promotionsService->promotions();

            return view('frontend.promotions', $data);
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }
}
