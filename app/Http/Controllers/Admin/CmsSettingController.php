<?php

namespace App\Http\Controllers\Admin;

use App\Actions\File\FileDelete;
use App\Http\Controllers\Controller;
use App\Models\AboutPageSlider;
use App\Models\Cms;
use App\Models\CmsContent;
use App\Models\HomePageSlider;
use App\Models\PricePlanService;
use App\Services\Admin\Cms\FooterTextService;
use App\Services\Admin\Cms\PrivacyService;
use App\Services\Admin\Cms\PromotionsService;
use App\Services\Admin\Cms\RefundService;
use App\Services\Admin\Cms\TermsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class CmsSettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('access_limitation')->only([
            'updateHome',
            'updateAbout',
            'updatePromotions',
            'updatePromotionsStore',
            'updateTerms',
            'updateTermsStore',
            'updatePrivacy',
            'updatePrivacyStore',
            'postingRulesUpdate',
            'updateGetMembership',
            'updatePricingPlan',
            'updateBlog',
            'updateAds',
            'updateContact',
            'updateFaq',
            'updateDashboard',
            'updateAuthContent',
            'updateComingSoon',
            'updateMaintenance',
            'updateErrorPages',
            'footerText',
        ]);
    }

    public function index(Request $request, TermsService $termsService, PromotionsService $promotionsService, PrivacyService $privacyService, RefundService $refundService)
    {
        try {
            if (! userCan('setting.view')) {
                return abort(403);
            }

            session('cms_part') ?? session(['cms_part' => 'home']);
            $cms = Cms::first();
            $term_page_content = $termsService->index($request);

            $promotion_page_content = $promotionsService->index($request);

            $privacy_page_content = $privacyService->index($request);
            $refund_page_content = $refundService->index($request);
            $price_plan_services = PricePlanService::oldest('order')->get();
            $sliders = HomePageSlider::oldest('order')->get();
            $aboutSliders = AboutPageSlider::oldest('order')->get();

            return view('admin.settings.pages.cms', compact('cms', 'price_plan_services', 'term_page_content', 'promotion_page_content', 'privacy_page_content', 'refund_page_content', 'sliders', 'aboutSliders'));
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    /**
     * Update posting rules text
     *
     * @return \Illuminate\Http\Response
     */
    public function postingRulesUpdate(Request $request)
    {
        try {
            if (! userCan('setting.update')) {
                return abort(403);
            }

            session(['cms_part' => 'posting_rules']);

            $cms = Cms::first();
            if ($request->hasFile('posting_rules_background') && $request->file('posting_rules_background')->isValid()) {
                deleteImage($cms->posting_rules_background);
                $url = $request->posting_rules_background->move('uploads/banners', $request->posting_rules_background->hashName());
                $cms->update($request->only('posting_rules_body') + ['posting_rules_background' => $url]);
            } else {
                $request->validate([
                    'posting_rules_body' => ['required'],
                ]);
                $cms->update($request->only('posting_rules_body'));
            }

            return redirect()
                ->back()
                ->with('success', 'Posting rules update successfully!');
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    /**
     * About information update
     *
     * @return \Illuminate\Http\Response
     */
    public function updateAbout(Request $request)
    {
        $rules = [
            // 'about_body' => 'required',
            'about_video_url' => 'active_url|url|nullable',
        ];
        $request->validate($rules);

        try {
            if (! userCan('setting.update')) {
                return abort(403);
            }
            session(['cms_part' => 'about']);

            $cms = Cms::first();
            $data = $request->only(['about_body', 'about_video_url']);

            $data['about_video_thumb'] = $this->updatePageImage('about_video_thumb', $cms);

            $cms->update($data);

            return redirect()
                ->back()
                ->with('success', 'About update successfully!');
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    public function aboutVideoThumbDelete(Request $request)
    {
        try {

            if (! userCan('setting.update')) {
                return abort(403);
            }

            // Retrieve the encoded image URL from the query parameter
            $encodedImage = $request->query('image');

            // Decode the image URL
            $imagePath = urldecode($encodedImage);

            session(['cms_part' => 'about']);

            $cms = Cms::first();

            if (File::exists($imagePath)) {
                File::delete($imagePath);
            }

            // Set the about_video_thumb field to null
            $cms->update(['about_video_thumb' => null]);

            $imagePath ? flashSuccess('About video thumb deleted successfully') : flashError();

            return back();
        } catch (\Exception $e) {
            flashError('An error occurred while deleting the image');

            return back();
        }
    }

    /**
     * Terms Page Multi language content create
     *
     * @return \Illuminate\Http\Response
     */
    public function updateTermsStore(Request $request)
    {
        try {
            $cms = Cms::first();
            session(['cms_part' => 'terms']);

            if ($request->has('lang_query')) {
                if ($request->lang_query != 'en') {
                    $exist_cms_content = CmsContent::where('translation_code', $request->lang_query)
                        ->where('page_slug', 'terms_page')
                        ->first();

                    if (! $exist_cms_content) {
                        CmsContent::create([
                            'page_slug' => 'terms_page',
                            'translation_code' => $request->lang_query,
                            'text' => $cms->terms_body,
                        ]);
                    }
                }
            }

            return redirect()->route('settings.cms', ['lang_query' => $request->lang_query]);
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    /**
     * Terms information update
     *
     * @return \Illuminate\Http\Response
     */
    public function updateTerms(Request $request)
    {
        if (! userCan('setting.update')) {
            return abort(403);
        }

        $request->validate([
            'terms_body' => ['required'],
        ]);

        try {
            session(['cms_part' => 'terms']);
            $cms = Cms::first();

            if ($request->hasFile('terms_background') && $request->file('terms_background')->isValid()) {
                deleteImage($cms->terms_background);
                $url = $request->terms_background->move('uploads/banners', $request->terms_background->hashName());
                $cms->update(['terms_background' => $url]);
            }

            if ($request->language_code && $request->language_code != 'en') {
                $exist_cms_content = CmsContent::where('translation_code', $request->language_code)
                    ->where('page_slug', 'terms_page')
                    ->first();

                if ($exist_cms_content) {
                    $exist_cms_content->update([
                        'text' => $request->terms_body,
                    ]);
                }
            } else {
                $cms->update($request->only('terms_body'));
            }

            return redirect()
                ->back()
                ->with('success', 'Term & Condition update successfully!');
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    /**
     * Privacy Page Multi language content create
     *
     * @return \Illuminate\Http\Response
     */
    public function updatePrivacyStore(Request $request)
    {
        try {
            $cms = Cms::first();
            session(['cms_part' => 'privacy']);

            if ($request->has('lang_query')) {
                if ($request->lang_query != 'en') {
                    $exist_cms_content = CmsContent::where('translation_code', $request->lang_query)
                        ->where('page_slug', 'privacy_page')
                        ->first();

                    if (! $exist_cms_content) {
                        CmsContent::create([
                            'page_slug' => 'privacy_page',
                            'translation_code' => $request->lang_query,
                            'text' => $cms->privacy_body,
                        ]);
                    }
                }
            }

            return redirect()->route('settings.cms', ['lang_query' => $request->lang_query]);
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    /**
     * privacy information update
     *
     * @return \Illuminate\Http\Response
     */
    public function updatePrivacy(Request $request)
    {
        if (! userCan('setting.update')) {
            return abort(403);
        }

        $request->validate([
            'privacy_body' => ['required'],
        ]);
        try {
            session(['cms_part' => 'privacy']);

            $cms = Cms::first();
            if ($request->hasFile('privacy_background') && $request->file('privacy_background')->isValid()) {
                deleteImage($cms->privacy_background);
                $url = $request->privacy_background->move('uploads/banners', $request->privacy_background->hashName());
                $cms->update(['privacy_background' => $url]);
            }

            if ($request->language_code && $request->language_code != 'en') {
                $exist_cms_content = CmsContent::where('translation_code', $request->language_code)
                    ->where('page_slug', 'privacy_page')
                    ->first();

                if ($exist_cms_content) {
                    $exist_cms_content->update([
                        'text' => $request->privacy_body,
                    ]);
                }
            } else {
                $cms->update($request->only('privacy_body'));
            }

            return redirect()
                ->back()
                ->with('success', 'Privacy Policy update successfully!');
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    /**
     * Refund Page Multi language content create
     *
     * @return \Illuminate\Http\Response
     */
    public function updateRefundStore(Request $request)
    {
        try {
            $cms = Cms::first();
            session(['cms_part' => 'refund']);

            if ($request->has('lang_query')) {
                if ($request->lang_query != 'en') {
                    $exist_cms_content = CmsContent::where('translation_code', $request->lang_query)
                        ->where('page_slug', 'refund_page')
                        ->first();

                    if (! $exist_cms_content) {
                        CmsContent::create([
                            'page_slug' => 'refund_page',
                            'translation_code' => $request->lang_query,
                            'text' => $cms->refund_body,
                        ]);
                    }
                }
            }

            return redirect()->route('settings.cms', ['lang_query' => $request->lang_query]);
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    /**
     * Refund information update
     *
     * @return \Illuminate\Http\Response
     */
    public function updateRefund(Request $request)
    {
        if (! userCan('setting.update')) {
            return abort(403);
        }

        $request->validate([
            'refund_body' => ['required'],
        ]);
        try {
            session(['cms_part' => 'refund']);

            $cms = Cms::first();
            if ($request->hasFile('refund_background') && $request->file('refund_background')->isValid()) {
                deleteImage($cms->refund_background);
                $url = $request->refund_background->move('uploads/banners', $request->refund_background->hashName());
                $cms->update(['refund_background' => $url]);
            }

            if ($request->language_code && $request->language_code != 'en') {
                $exist_cms_content = CmsContent::where('translation_code', $request->language_code)
                    ->where('page_slug', 'refund_page')
                    ->first();

                if ($exist_cms_content) {
                    $exist_cms_content->update([
                        'text' => $request->refund_body,
                    ]);
                }
            } else {
                $cms->update($request->only('refund_body'));
            }

            return redirect()
                ->back()
                ->with('success', 'Refund Policy update successfully!');
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    /**
     * Update Get Membership Page static images
     *
     * @return void
     */
    public function updateGetMembership(Request $request)
    {
        if (! userCan('setting.update')) {
            return abort(403);
        }
        try {
            session(['cms_part' => 'membership']);

            $cms = Cms::first();
            $data = [];

            $data['get_membership_background'] = $this->updatePageImage('get_membership_background', $cms);
            $data['get_membership_image'] = $this->updatePageImage('get_membership_image', $cms);

            $cms->update($data);

            return redirect()
                ->back()
                ->with('success', 'Get Membership Settings update successfully!');
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    /**
     * Update Pricing Plan Background Images
     *
     *
     * @return void
     */
    public function updatePricingPlan(Request $request)
    {
        if (! userCan('setting.update')) {
            return abort(403);
        }
        try {
            session(['cms_part' => 'price_plan']);

            if ($request->hasFile('pricing_plan_background') && $request->file('pricing_plan_background')->isValid()) {
                $cms = Cms::first();
                deleteImage($cms->pricing_plan_background);
                $url = $request->pricing_plan_background->move('uploads/banners', $request->pricing_plan_background->hashName());
                $cms->update(['pricing_plan_background' => $url]);
            }

            return redirect()
                ->back()
                ->with('success', 'Pricing Plan Settings update successfully!');
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    /**
     * Update Pricing Plan Static Images
     *
     *
     * @return void
     */
    public function updatePricingPlanImage(Request $request)
    {
        if (! userCan('setting.update')) {
            return abort(403);
        }
        try {
            session(['cms_part' => 'price_plan']);

            if ($request->hasFile('pricing_plan_image') && $request->file('pricing_plan_image')->isValid()) {
                $cms = Cms::first();
                deleteImage($cms->pricing_plan_image);
                $url = $request->pricing_plan_image->move('uploads/banners', $request->pricing_plan_image->hashName());
                $cms->update(['pricing_plan_image' => $url]);
            }

            return redirect()
                ->back()
                ->with('success', 'Pricing Plan Settings update successfully!');
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    /**
     * Add Pricing Plan Service
     *
     * @return \Illuminate\Http\Response
     */
    public function postPricingPlanService(Request $request)
    {
        if (! userCan('setting.update')) {
            return abort(403);
        }

        // Validate the request data
        $request->validate([
            'pricing_plan_service_title' => 'required|string',
            'pricing_plan_service_description' => 'required|string',
            'pricing_plan_service_icon' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        try {
            session(['cms_part' => 'price_plan']);
            if ($request->hasFile('pricing_plan_service_icon') && $request->file('pricing_plan_service_icon')->isValid()) {
                $pps = new PricePlanService;
                $pps->title = $request->pricing_plan_service_title;
                $pps->description = $request->pricing_plan_service_description;
                $url = $request->pricing_plan_service_icon->move('uploads/banners', $request->pricing_plan_service_icon->hashName());
                $pps->service_icon = $url;
                $pps->save();
            }

            return redirect()
                ->back()
                ->with('success', 'Pricing Plan Service Added successfully!');
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    /**
     * Delete Pricing Plan Service
     *
     * @return \Illuminate\Http\Response
     */
    public function deletePricingPlanService(PricePlanService $id)
    {
        if (! userCan('setting.update')) {
            return abort(403);
        }

        try {
            session(['cms_part' => 'price_plan']);

            $imagePath = public_path($id->service_icon);
            // Check if the file exists before attempting to delete it
            if (file_exists($imagePath)) {
                FileDelete::delete($imagePath);
            }

            $id->delete();

            $imagePath ? flashSuccess('Image Deleted Successfully') : flashError();

            return back();
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while deleting the image',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Edit Pricing Plan Service
     *
     * @return \Illuminate\Http\Response
     */
    public function editPricingPlanService(PricePlanService $id)
    {

        if (! userCan('setting.update')) {
            return abort(403);
        }

        try {
            session(['cms_part' => 'price_plan']);
            $editData = $id;

            return back()->with('editData', $editData);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while deleting the image',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Update Pricing Plan Service
     *
     * @return \Illuminate\Http\Response
     */
    public function updatePricingPlanService(Request $request, int $id)
    {
        if (! userCan('setting.update')) {
            return abort(403);
        }

        // Validate the request data
        $request->validate([
            'pricing_plan_service_title' => 'required|string',
            'pricing_plan_service_description' => 'required|string',
            'pricing_plan_service_icon' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        try {
            $pricePlanService = PricePlanService::findOrFail($id);

            $pricePlanService->title = $request->input('pricing_plan_service_title');
            $pricePlanService->description = $request->input('pricing_plan_service_description');

            if ($request->hasFile('pricing_plan_service_icon') && $request->file('pricing_plan_service_icon')->isValid()) {
                deleteImage($pricePlanService->service_icon);
                $url = $request->pricing_plan_service_icon->move('uploads/banners', $request->pricing_plan_service_icon->hashName());
                $pricePlanService->service_icon = $url;
            }
            $pricePlanService->save();

            return redirect()
                ->back()
                ->with('success', 'Data updated successfully!');
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while updating the pricing plan service',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Sorts the pricing plans based on the order provided in the request.
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function sortingPricingPlan(Request $request)
    {
        try {
            $fields = PricePlanService::all();

            foreach ($fields as $field) {
                $field->timestamps = false;
                $id = $field->id;

                foreach ($request->order as $order) {
                    if ($order['id'] == $id) {
                        $field->update(['order' => $order['position']]);
                    }
                }
            }

            return response()->json(['message' => 'Home page slider sorted successfully!']);
        } catch (\Throwable $th) {
            flashError();

            return back();
        }
    }

    /**
     * Update Faqs static Images
     *
     *
     * @return void
     */
    public function updateFaq(Request $request)
    {
        if (! userCan('setting.update')) {
            return abort(403);
        }
        try {
            session(['cms_part' => 'faq']);

            $cms = Cms::first();
            $data = [];

            if ($request->hasFile('faq_background') && $request->file('faq_background')->isValid()) {
                deleteImage($cms->faq_background);
                $url = $request->faq_background->move('uploads/banners', $request->faq_background->hashName());
                $cms->update(['faq_background' => $url]);
            }

            $data['faq_content'] = $request->faq_content;
            $cms->update($data);

            return redirect()
                ->back()
                ->with('success', 'Faqs Settings update successfully!');
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    /**
     * Update DAshboard static Images
     *
     *
     * @return void
     */
    public function updateDashboard(Request $request)
    {
        if (! userCan('setting.update')) {
            return abort(403);
        }
        try {
            session(['cms_part' => 'dashboard']);

            $cms = Cms::first();
            $data = [];

            $data['dashboard_overview_background'] = $this->updatePageImage('dashboard_overview_background', $cms);
            $data['dashboard_post_ads_background'] = $this->updatePageImage('dashboard_post_ads_background', $cms);
            $data['dashboard_my_ads_background'] = $this->updatePageImage('dashboard_my_ads_background', $cms);
            $data['dashboard_favorite_ads_background'] = $this->updatePageImage('dashboard_favorite_ads_background', $cms);
            $data['dashboard_messenger_background'] = $this->updatePageImage('dashboard_messenger_background', $cms);
            $data['dashboard_plan_background'] = $this->updatePageImage('dashboard_plan_background', $cms);
            $data['dashboard_account_setting_background'] = $this->updatePageImage('dashboard_account_setting_background', $cms);

            $cms->update($data);

            return redirect()
                ->back()
                ->with('success', 'Dashboard Settings update successfully!');
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    /**
     * Update Blog Background Image
     *
     * @return void
     */
    public function updateBlog(Request $request)
    {
        if (! userCan('setting.update')) {
            return abort(403);
        }
        try {
            session(['cms_part' => 'blog']);

            if ($request->hasFile('blog_background') && $request->file('blog_background')->isValid()) {
                $cms = Cms::first();
                deleteImage($cms->blog_background);
                $url = $request->blog_background->move('uploads/banners', $request->blog_background->hashName());
                $cms->update(['blog_background' => $url]);
            }

            return redirect()
                ->back()
                ->with('success', 'Blog Settings update successfully!');
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    /**
     * Update Ads Background Image
     *
     *
     * @return void
     */
    public function updateAds(Request $request)
    {
        if (! userCan('setting.update')) {
            return abort(403);
        }

        try {
            session(['cms_part' => 'ads']);
            $cms = Cms::first();

            if ($request->hasFile('ads_background') && $request->file('ads_background')->isValid()) {
                $url = $request->ads_background->move('uploads/banners', $request->ads_background->hashName());
                deleteImage($cms->ads_background);
                $cms->update(['ads_background' => $url]);
            }

            if ($request->filled('ads_safety_msg')) {
                $cms->update(['ads_safety_msg' => $request->ads_safety_msg]);
            }

            return redirect()->back()->with('success', 'Ads Settings updated successfully!');
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    /**
     * Update Contact Background Image
     *
     *
     * @return void
     */
    public function updateContact(Request $request)
    {
        if (! userCan('setting.update')) {
            return abort(403);
        }
        try {
            session(['cms_part' => 'contact']);

            $cms = Cms::first();
            $cms->contact_number = $request->contact_number;
            $cms->contact_email = $request->contact_email;
            $cms->contact_address = $request->contact_address;
            if ($request->hasFile('contact_background') && $request->file('contact_background')->isValid()) {
                deleteImage($cms->contact_background);
                $url = $request->contact_background->move('uploads/contacts', $request->contact_background->hashName());
                $cms->update(['contact_background' => $url]);
            }
            $cms->save();

            return redirect()
                ->back()
                ->with('success', 'Contact Settings update successfully!');
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    public function updateAuthContent(Request $request)
    {
        if (! userCan('setting.update')) {
            return abort(403);
        }
        try {
            session(['cms_part' => 'auth']);

            $cms = Cms::first();
            $data = [];

            $data['manage_ads_content'] = $request->manage_ads_content;
            $data['chat_content'] = $request->chat_content;
            $data['verified_user_content'] = $request->verified_user_content;
            $cms->update($data);

            return redirect()
                ->back()
                ->with('success', 'Content updated successfully!');
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    public function updateComingSoon(Request $request)
    {
        if (! userCan('setting.update')) {
            return abort(403);
        }
        try {
            session(['cms_part' => 'c_soon']);

            $request->validate([
                'coming_soon_title' => 'required|max:255',
                'coming_soon_subtitle' => 'required|max:255',
            ]);

            $cms = Cms::first();
            $cms->coming_soon_title = $request->coming_soon_title;
            $cms->coming_soon_subtitle = $request->coming_soon_subtitle;
            $cms->save();

            return redirect()
                ->back()
                ->with('success', 'Content updated successfully!');
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    public function updateMaintenance(Request $request)
    {
        if (! userCan('setting.update')) {
            return abort(403);
        }
        $request->validate([
            'maintenance_title' => 'required|max:255',
            'maintenance_subtitle' => 'required|max:255',
        ]);
        try {
            session(['cms_part' => 'maintenance']);

            $cms = Cms::first();
            $cms->maintenance_title = $request->maintenance_title;
            $cms->maintenance_subtitle = $request->maintenance_subtitle;
            $cms->save();

            return redirect()
                ->back()
                ->with('success', 'Content updated successfully!');
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    public function updateErrorPages(Request $request)
    {
        if (! userCan('setting.update')) {
            return abort(403);
        }

        $request->validate([
            'e404_title' => 'sometimes|max:255',
            'e404_subtitle' => 'sometimes|max:255',
            'e500_title' => 'sometimes|max:255',
            'e500_subtitle' => 'sometimes|max:255',
            'e503_title' => 'sometimes|max:255',
            'e503_subtitle' => 'sometimes|max:255',
        ]);

        try {
            session(['cms_part' => 'errorpages']);

            $cms = Cms::first();
            $cms->e404_title = $request->e404_title;
            $cms->e404_subtitle = $request->e404_subtitle;
            if ($request->hasFile('e404_image')) {
                deleteImage($cms->e404_image);
                $url = $request->e404_image->move('uploads/errorpages', $request->e404_image->hashName());
                $cms->update(['e404_image' => $url]);
            }
            $cms->e500_title = $request->e500_title;
            $cms->e500_subtitle = $request->e500_subtitle;
            if ($request->hasFile('e500_image')) {
                deleteImage($cms->e500_image);
                $url = $request->e500_image->move('uploads/errorpages', $request->e500_image->hashName());
                $cms->update(['e500_image' => $url]);
            }
            $cms->e503_title = $request->e503_title;
            $cms->e503_subtitle = $request->e503_subtitle;
            if ($request->hasFile('e503_image')) {
                deleteImage($cms->e503_image);
                $url = $request->e503_image->move('uploads/errorpages', $request->e503_image->hashName());
                $cms->update(['e503_image' => $url]);
            }
            $cms->save();

            return redirect()
                ->back()
                ->with('success', 'Content updated successfully!');
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    /**
     * Footer Text Update
     *
     * @return void
     */
    public function footerText(Request $request, FooterTextService $footerTextService)
    {
        if (! userCan('setting.update')) {
            return abort(403);
        }

        $request->validate([
            'footer_text' => 'required',
        ]);

        try {
            $footerTextService->update($request);

            return redirect()
                ->back()
                ->with('success', 'Footer text update successfully!');
        } catch (\Throwable $e) {
            return redirect()
                ->back()
                ->with('error', $e->getMessage());
        }
    }

    private function updatePageImage($fileName, $cms)
    {

        if (
            request()->hasFile($fileName) &&
            request()
                ->file($fileName)
                ->isValid()
        ) {
            deleteImage($cms->$fileName);

            return request()
                ->file($fileName)
                ->move(
                    'uploads/banners',
                    request()
                        ->file($fileName)
                        ->hashName(),
                );
        }
    }

    public function sortingHome(Request $request)
    {
        try {
            $fields = HomePageSlider::all();

            foreach ($fields as $field) {
                $field->timestamps = false;
                $id = $field->id;

                foreach ($request->order as $order) {
                    if ($order['id'] == $id) {
                        $field->update(['order' => $order['position']]);
                    }
                }
            }

            return response()->json(['message' => 'Home page slider sorted successfully!']);
        } catch (\Throwable $th) {
            flashError();

            return back();
        }
    }

    public function sortingAbout(Request $request)
    {
        try {
            $fields = AboutPageSlider::all();

            foreach ($fields as $field) {
                $field->timestamps = false;
                $id = $field->id;

                foreach ($request->order as $order) {
                    if ($order['id'] == $id) {
                        $field->update(['order' => $order['position']]);
                    }
                }
            }

            return response()->json(['message' => 'About page slider sorted successfully!']);
        } catch (\Throwable $th) {
            flashError();

            return back();
        }
    }

    // Promotions CMS Methods Start
    /**
     * Promotions Page Multi language content create
     *
     * @return \Illuminate\Http\Response
     */
    public function updatePromotionsStore(Request $request)
    {
        try {
            $cms = Cms::first();
            session(['cms_part' => 'promotions']);

            if ($request->has('lang_query')) {
                if ($request->lang_query != 'en') {
                    $exist_cms_content = CmsContent::where('translation_code', $request->lang_query)
                        ->where('page_slug', 'promotions_page')
                        ->first();

                    if (! $exist_cms_content) {
                        CmsContent::create([
                            'page_slug' => 'promotions_page',
                            'translation_code' => $request->lang_query,
                            'title' => $cms->promotion_banner_title,
                            'text' => $cms->promotion_banner_text,

                            'title_featured' => $cms->featured_title,
                            'text_featured' => $cms->featured_text,

                            'title_urgent' => $cms->urgent_title,
                            'text_urgent' => $cms->urgent_text,

                            'title_highlight' => $cms->highlight_title,
                            'text_highlight' => $cms->highlight_text,

                            'title_top' => $cms->top_title,
                            'text_top' => $cms->top_text,

                            'title_bump_up' => $cms->bump_up_title,
                            'text_bump_up' => $cms->bump_up_text,
                        ]);
                    }
                }
            }

            return redirect()->route('settings.cms', ['lang_query' => $request->lang_query]);
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    /**
     * Promotions information update
     *
     * @return \Illuminate\Http\Response
     */
    public function updatePromotions(Request $request)
    {
        if (! userCan('setting.update')) {
            return abort(403);
        }

        $request->validate([
            'promotion_banner_title' => ['required'],
            'promotion_banner_text' => ['required'],
            'promotion_banner_img' => ['image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048'],

            'featured_title' => ['required'],
            'featured_text' => ['required'],
            'featured_img' => ['image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048'],

            'urgent_title' => ['required'],
            'urgent_text' => ['required'],
            'urgent_img' => ['image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048'],

            'highlight_title' => ['required'],
            'highlight_text' => ['required'],
            'highlight_img' => ['image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048'],

            'top_title' => ['required'],
            'top_text' => ['required'],
            'top_img' => ['image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048'],

            'bump_up_title' => ['required'],
            'bump_up_text' => ['required'],
            'bump_up_img' => ['image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048'],
        ]);

        try {
            session(['cms_part' => 'promotions']);
            $cms = Cms::first();

            if ($request->hasFile('promotion_banner_img') && $request->file('promotion_banner_img')->isValid()) {
                deleteImage($cms->promotion_banner_img);
                $url = $request->promotion_banner_img->move('uploads/banners', $request->promotion_banner_img->hashName());
                $cms->update(['promotion_banner_img' => $url]);
            }

            if ($request->hasFile('featured_img') && $request->file('featured_img')->isValid()) {
                deleteImage($cms->featured_img);
                $url_1 = $request->featured_img->move('uploads/banners', $request->featured_img->hashName());
                $cms->update(['featured_img' => $url_1]);
            }

            if ($request->hasFile('urgent_img') && $request->file('urgent_img')->isValid()) {
                deleteImage($cms->urgent_img);
                $url_2 = $request->urgent_img->move('uploads/banners', $request->urgent_img->hashName());
                $cms->update(['urgent_img' => $url_2]);
            }

            if ($request->hasFile('highlight_img') && $request->file('highlight_img')->isValid()) {
                deleteImage($cms->highlight_img);
                $url_3 = $request->highlight_img->move('uploads/banners', $request->highlight_img->hashName());
                $cms->update(['highlight_img' => $url_3]);
            }

            if ($request->hasFile('top_img') && $request->file('top_img')->isValid()) {
                deleteImage($cms->top_img);
                $url_4 = $request->top_img->move('uploads/banners', $request->top_img->hashName());
                $cms->update(['top_img' => $url_4]);
            }

            if ($request->hasFile('bump_up_img') && $request->file('bump_up_img')->isValid()) {
                deleteImage($cms->bump_up_img);
                $url_5 = $request->bump_up_img->move('uploads/banners', $request->bump_up_img->hashName());
                $cms->update(['bump_up_img' => $url_5]);
            }

            if ($request->language_code && $request->language_code != 'en') {
                $exist_cms_content = CmsContent::where('translation_code', $request->language_code)
                    ->where('page_slug', 'promotions_page')
                    ->first();

                if ($exist_cms_content) {
                    $exist_cms_content->update([
                        'title' => $request->promotion_banner_title,
                        'text' => $request->promotion_banner_text,

                        'title_featured' => $request->featured_title,
                        'text_featured' => $request->featured_text,

                        'title_urgent' => $request->urgent_title,
                        'text_urgent' => $request->urgent_text,

                        'title_highlight' => $request->highlight_title,
                        'text_highlight' => $request->highlight_text,

                        'title_top' => $request->top_title,
                        'text_top' => $request->top_text,

                        'title_bump_up' => $request->bump_up_title,
                        'text_bump_up' => $request->bump_up_text,
                    ]);
                }
            } else {
                $cms->update([
                    'promotion_banner_title' => $request->promotion_banner_title,
                    'promotion_banner_text' => $request->promotion_banner_text,

                    'title_featured' => $request->featured_title,
                    'text_featured' => $request->featured_text,

                    'title_urgent' => $request->urgent_title,
                    'text_urgent' => $request->urgent_text,

                    'title_highlight' => $request->highlight_title,
                    'text_highlight' => $request->highlight_text,

                    'title_top' => $request->top_title,
                    'text_top' => $request->top_text,

                    'title_bump_up' => $request->bump_up_title,
                    'text_bump_up' => $request->bump_up_text,
                ]);

            }

            return redirect()
                ->back()
                ->with('success', 'Promotion CMS content updated successfully!');
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }
    // Promotions CMS Methods End

}
