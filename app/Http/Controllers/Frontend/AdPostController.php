<?php

namespace App\Http\Controllers\Frontend;

use App\Enum\Job\JobStatus;
use App\Http\Controllers\Controller;
use App\Http\Traits\AdCreateTrait;
use App\Http\Traits\HasPlanPromotion;
use App\Models\Admin;
use App\Models\ManualPayment;
use App\Models\UserPlan;
use App\Notifications\AdDeleteNotification;
use App\Notifications\AdResubmissionAdminNotification;
use App\Services\Midtrans\CreateSnapTokenService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Modules\Ad\Entities\Ad;
use Modules\Ad\Entities\AdGallery;
use Modules\Brand\Entities\Brand;
use Modules\Category\Entities\Category;
use Modules\Currency\Entities\Currency;
use Modules\CustomField\Entities\CustomField;
use Modules\CustomField\Entities\ProductCustomField;
use stdClass;

class AdPostController extends Controller
{
    use AdCreateTrait, HasPlanPromotion;

    /**
     * Ad Create step 1.
     *
     * @return void
     */
    public function postStep1()
    {
        $this->stepCheck();

        if (session('step1')) {
            $categories = Category::latest('id')->get();
            $brands = Brand::latest('id')->get();
            // $featured_ads = UserPlan::where('user_id', auth()->user()->id)->first();
            $ad = session('ad') ?? [];

            // return view('frontend.postad.step', compact('categories', 'brands', 'ad', 'featured_ads'));
            return view('frontend.postad.step', compact('categories', 'brands', 'ad'));
        } else {
            return redirect()->route('frontend.postad.step');
        }
    }

    public function payperAdsPostStep1()
    {
        $this->stepCheck();

        if (session('step1')) {
            $categories = Category::latest('id')->get();
            $brands = Brand::latest('id')->get();
            // $featured_ads = UserPlan::where('user_id', auth()->user()->id)->first();
            $ad = session('ad') ?? [];

            // return view('frontend.postad.step', compact('categories', 'brands', 'ad', 'featured_ads'));
            return view('frontend.payperads.postad.step', compact('categories', 'brands', 'ad'));
        } else {
            return redirect()->back();
        }
    }

    /**
     * Ad Create step 2.
     *
     * @return void
     */
    public function postStep2()
    {
        if (session('step2')) {
            $ad = session('ad');

            $category = Category::with('customFields.values')->FindOrFail($ad->category_id);
            $features = session('features') ?? [];
            $custom_fields = session('custom-field') ?? [];
            $custom_fields_checkbox = session('custom-field-checkbox') ?? [];

            return view('frontend.postad.step2', [
                'ad' => $ad,
                'category' => $category,
                'features' => $features,
                'custom_fields' => $custom_fields,
                'custom_fields_checkbox' => $custom_fields_checkbox,
            ]);
        } else {
            return redirect()->route('frontend.post');
        }
    }

    public function PayperAdsPostStep2()
    {
        if (session('step2')) {
            $ad = session('ad');

            $category = Category::with('customFields.values')->FindOrFail($ad->category_id);
            $features = session('features') ?? [];
            $custom_fields = session('custom-field') ?? [];
            $custom_fields_checkbox = session('custom-field-checkbox') ?? [];

            return view('frontend.payperads.postad.step2', [
                'ad' => $ad,
                'category' => $category,
                'features' => $features,
                'custom_fields' => $custom_fields,
                'custom_fields_checkbox' => $custom_fields_checkbox,
            ]);
        } else {
            return redirect()->back();
        }
    }

    /**
     * Ad Create step 3.
     *
     * @return void
     */
    public function postStep3()
    {
        if (session('step3')) {
            $user_plan_data = UserPlan::where('user_id', auth('user')->id())->first();
            $plan = $user_plan_data->currentPlan;

            $ad = session('ad');

            return view('frontend.postad.step3', compact('ad', 'user_plan_data', 'plan'));
        } else {
            return redirect()->route('frontend.post');
        }
    }

    public function PayperAdsPostStep3()
    {
        if (session('step3')) {
            $user_plan_data = UserPlan::where('user_id', auth('user')->id())->first();
            $plan = loadSetting()::query()->select('id', 'per_ads_active', 'per_ads_price', 'highlight_ads_price', 'highlight_ads_duration', 'featured_ads_price', 'featured_ads_duration', 'top_ads_price', 'top_ads_duration', 'bump_ads_price', 'bump_ads_duration', 'urgent_ads_price', 'urgent_ads_duration')->first();

            $ad = session('ad');

            return view('frontend.payperads.postad.step3', compact('ad', 'user_plan_data', 'plan'));
        } else {
            return redirect()->back();
        }
    }

    /**
     * Store Ad Create step 1
     *
     * @return void
     */
    public function storePostStep1(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|unique:ads,title',
            'price' => 'required|numeric|max:9999999999',
            // 'featured' => 'sometimes',
            'category_id' => 'required',
            'subcategory_id' => 'sometimes',
            'brand_id' => 'required',
            'description' => 'required',
        ]);

        if (empty(config('templatecookie.map_show'))) {
            session()->put('location', [
                'country' => session('selectedCountryId'),
                'region' => session('selectedStateId'),
                'district' => session('selectedCityId'),
                'lng' => session('selectedCityLong') ?? (session('selectedStateLong') ?? session('selectedCountryLong')),
                'lat' => session('selectedCityLat') ?? (session('selectedStateLat') ?? session('selectedCountryLat')),
            ]);
        }

        $location = session()->get('location');

        if (! $location) {
            $request->validate([
                'location' => 'required',
            ]);
        }

        try {
            if (empty(session('ad'))) {
                $ad = new Ad();
                $ad['slug'] = Str::slug($request->title);
                $ad->fill($validatedData);
                $request->session()->put('ad', $ad);
            } else {
                $ad = session('ad');
                $ad['slug'] = Str::slug($request->title);
                $ad->fill($validatedData);
                $request->session()->put('ad', $ad);
            }

            $this->step1Success();

            if ($request->get('draft')) {
                $this->adNotification($ad, 'update');
                $this->forgetStepSession();
                $ad->makeDraft(auth('user')->id());

                return view('frontend.postad.postsuccess', [
                    'ad_slug' => $ad->slug,
                    'mode' => 'draft',
                ]);
            }

            return to_route('frontend.post.step2');
        } catch (\Throwable $th) {
            $this->forgetStepSession();

            return redirect()->back()->with('error', 'Something went wrong while saving your ad.Please try again.');
        }
    }

    public function payperAdsStorePostStep1(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|unique:ads,title',
            'price' => 'required|numeric|max:9999999999',
            // 'featured' => 'sometimes',
            'category_id' => 'required',
            'subcategory_id' => 'sometimes',
            'brand_id' => 'required',
            'description' => 'required',
        ]);

        if (empty(config('templatecookie.map_show'))) {
            session()->put('location', [
                'country' => session('selectedCountryId'),
                'region' => session('selectedStateId'),
                'district' => session('selectedCityId'),
                'lng' => session('selectedCityLong') ?? (session('selectedStateLong') ?? session('selectedCountryLong')),
                'lat' => session('selectedCityLat') ?? (session('selectedStateLat') ?? session('selectedCountryLat')),
            ]);
        }

        $location = session()->get('location');

        if (! $location) {
            $request->validate([
                'location' => 'required',
            ]);
        }

        try {
            if (empty(session('ad'))) {
                $ad = new Ad();
                $ad['slug'] = Str::slug($request->title);
                $ad->fill($validatedData);
                $request->session()->put('ad', $ad);
            } else {
                $ad = session('ad');
                $ad['slug'] = Str::slug($request->title);
                $ad->fill($validatedData);
                $request->session()->put('ad', $ad);
            }

            $this->step1Success();

            if ($request->get('draft')) {
                $this->adNotification($ad, 'update');
                $this->forgetStepSession();
                $ad->makeDraft(auth('user')->id());

                return view('frontend.postad.postsuccess', [
                    'ad_slug' => $ad->slug,
                    'mode' => 'draft',
                ]);
            }

            return to_route('frontend.payper.ads.post.step2');
        } catch (\Throwable $th) {
            $this->forgetStepSession();

            return redirect()->back()->with('error', 'Something went wrong while saving your ad.Please try again.');
        }
    }

    /**
     * Store Ad Create step 2.
     *
     * @return void
     */
    public function storePostStep2(Request $request)
    {
        try {
            // Image Validation
            $maximum_ad_image_limit = setting('maximum_ad_image_limit');

            $request->validate([
                'images.*' => 'image|mimes:jpeg,png,jpg|max:2048',
                'thumbnail' => 'image|mimes:jpeg,png,jpg|max:2048',
            ]);

            if (! $request->hasFile('images')) {
                return redirect()
                    ->back()
                    ->with('error', 'Please upload at least 2 to '.$maximum_ad_image_limit.' images.');
            }

            $image_count = count($request->file('images'));
            if ($image_count < 2 || $image_count > $maximum_ad_image_limit) {
                return redirect()
                    ->back()
                    ->with('error', 'Please upload at least 2 to '.$maximum_ad_image_limit.' images.');
            }

            // Custom Fields Validation
            $category = Category::with('customFields.values')->findOrFail($request->category_id);

            foreach ($category->customFields as $field) {
                if ($field->slug !== $request->has($field->slug) && $field->required) {
                    if ($field->type != 'checkbox' && $field->type != 'checkbox_multiple') {
                        $request->validate([
                            $field->slug => 'required',
                        ]);
                    }
                }
                if ($field->type == 'textarea') {
                    $request->validate([
                        $field->slug => 'nullable|max:255',
                    ]);
                }
                if ($field->type == 'url') {
                    $request->validate([
                        $field->slug => 'nullable|url',
                    ]);
                }
                if ($field->type == 'number') {
                    $request->validate([
                        $field->slug => 'nullable|numeric',
                    ]);
                }
                if ($field->type == 'date') {
                    $request->validate([
                        $field->slug => 'nullable|date',
                    ]);
                }
            }

            // Image Store
            $images = $request->file('images');
            $thumbnail = $request->file('thumbnail');

            if ($thumbnail && $thumbnail->isValid()) {
                $url = uploadImage($thumbnail, 'adds_image', true);
                session(['ad_thumbnail' => $url]);
            }

            if ($images && count($images)) {
                $session_images = [];
                foreach ($images as $key => $image) {
                    if ($image && $image->isValid()) {
                        $url = uploadImage($image, 'adds_multiple', true);
                        array_push($session_images, $url);
                    }
                }

                session(['ad_images' => $session_images]);
            }

            // Feature Store
            session()->put('features', $request->get('features'));

            // Custom Fields Store
            $newItem = [];
            foreach ($request->except(['cf', 'features', 'images', '_token', 'category_id', 'video_url', 'thumbnail']) as $key => $value) {
                $fileType = gettype($value);

                if ($fileType == 'object') {
                    $image = uploadImage($value, 'custom-field', false);

                    $item = [$key => $image];
                } else {
                    $item = [$key => $value];
                }

                array_push($newItem, $item);
            }

            session()->put('custom-field', $newItem);
            session()->put('custom-field-checkbox', $request->get('cf'));

            $ad = session('ad');
            $ad->fill(['video_url' => $request->video_url]);
            $request->session()->put('ad', $ad);

            $this->step1Success2();

            if ($request->get('draft')) {
                $this->adNotification($ad, 'update');
                $this->forgetStepSession();
                $ad->makeDraft(auth('user')->id());

                return view('frontend.postad.postsuccess', [
                    'ad_slug' => $ad->slug,
                    'mode' => 'draft',
                ]);
            }

            return to_route('frontend.post.step3');
        } catch (\Throwable $th) {
            return redirect()
                ->route('frontend.post.step2')
                ->with('error', "An error occurred: {$th->getMessage()}");
        }
    }

    public function PayperAdsStorePostStep2(Request $request)
    {
        try {
            // Image Validation
            $maximum_ad_image_limit = setting('maximum_ad_image_limit');

            $request->validate([
                'images.*' => 'image|mimes:jpeg,png,jpg|max:2048',
                'thumbnail' => 'image|mimes:jpeg,png,jpg|max:2048',
            ]);

            if (! $request->hasFile('images')) {
                return redirect()
                    ->back()
                    ->with('error', 'Please upload at least 2 to '.$maximum_ad_image_limit.' images.');
            }

            $image_count = count($request->file('images'));
            if ($image_count < 2 || $image_count > $maximum_ad_image_limit) {
                return redirect()
                    ->back()
                    ->with('error', 'Please upload at least 2 to '.$maximum_ad_image_limit.' images.');
            }

            // Custom Fields Validation
            $category = Category::with('customFields.values')->findOrFail($request->category_id);

            foreach ($category->customFields as $field) {
                if ($field->slug !== $request->has($field->slug) && $field->required) {
                    if ($field->type != 'checkbox' && $field->type != 'checkbox_multiple') {
                        $request->validate([
                            $field->slug => 'required',
                        ]);
                    }
                }
                if ($field->type == 'textarea') {
                    $request->validate([
                        $field->slug => 'nullable|max:255',
                    ]);
                }
                if ($field->type == 'url') {
                    $request->validate([
                        $field->slug => 'nullable|url',
                    ]);
                }
                if ($field->type == 'number') {
                    $request->validate([
                        $field->slug => 'nullable|numeric',
                    ]);
                }
                if ($field->type == 'date') {
                    $request->validate([
                        $field->slug => 'nullable|date',
                    ]);
                }
            }

            // Image Store
            $images = $request->file('images');
            $thumbnail = $request->file('thumbnail');

            if ($thumbnail && $thumbnail->isValid()) {
                $url = uploadImage($thumbnail, 'adds_image', true);
                session(['ad_thumbnail' => $url]);
            }

            if ($images && count($images)) {
                $session_images = [];
                foreach ($images as $key => $image) {
                    if ($image && $image->isValid()) {
                        $url = uploadImage($image, 'adds_multiple', true);
                        array_push($session_images, $url);
                    }
                }

                session(['ad_images' => $session_images]);
            }

            // Feature Store
            session()->put('features', $request->get('features'));

            // Custom Fields Store
            $newItem = [];
            foreach ($request->except(['cf', 'features', 'images', '_token', 'category_id', 'video_url', 'thumbnail']) as $key => $value) {
                $fileType = gettype($value);

                if ($fileType == 'object') {
                    $image = uploadImage($value, 'custom-field', false);

                    $item = [$key => $image];
                } else {
                    $item = [$key => $value];
                }

                array_push($newItem, $item);
            }

            session()->put('custom-field', $newItem);
            session()->put('custom-field-checkbox', $request->get('cf'));

            $ad = session('ad');
            $ad->fill(['video_url' => $request->video_url]);
            $request->session()->put('ad', $ad);

            $this->step1Success2();

            if ($request->get('draft')) {
                $this->adNotification($ad, 'update');
                $this->forgetStepSession();
                $ad->makeDraft(auth('user')->id());

                return view('frontend.postad.postsuccess', [
                    'ad_slug' => $ad->slug,
                    'mode' => 'draft',
                ]);
            }

            return to_route('frontend.payper.ads.post.step3');
        } catch (\Throwable $th) {
            return redirect()
                ->route('frontend.post.step2')
                ->with('error', "An error occurred: {$th->getMessage()}");
        }
    }

    /**
     * Store Ad Create step 3.
     *
     * @return void
     */
    public function storePostStep3(Request $request)
    {
        $validatedData = $request->validate([
            'phone' => 'required',
            'whatsapp' => 'nullable',
            'email' => 'nullable',
            'featured' => 'sometimes|boolean',
            'urgent' => 'sometimes|boolean',
            'highlight' => 'sometimes|boolean',
            'top' => 'sometimes|boolean',
            'bump_up' => 'sometimes|boolean',
        ]);

        // try {

        $ad = session('ad');
        $ad['video_url'] = $ad['video_url'];
        $ad['user_id'] = auth('user')->id();
        $ad['whatsapp'] = $validatedData['whatsapp'] ?? '';
        $ad['phone'] = $validatedData['phone'] ?? '';
        $ad['email'] = $validatedData['email'] ?? '';
        $ad['status'] = setting('ads_admin_approval') ? JobStatus::PENDING->value : JobStatus::ACTIVE->value;

        $user_plan_data = UserPlan::where('user_id', auth('user')->id())->first();
        $plan = $user_plan_data->currentPlan;

        // Assign promotions to user
        $ad = $this->promotePlan($request, $ad, auth('user')->id());
        // return $ad;
        $ad->save();

        $request->session()->put('ad', $ad);

        // Image Storing
        $ad_images = session('ad_images');
        $ad_thumbnail = session('ad_thumbnail');

        $ad->update(['thumbnail' => $ad_thumbnail]);

        if ($ad_images && count($ad_images)) {
            foreach ($ad_images as $image_url) {
                $ad->galleries()->create(['image' => $image_url]);
            }
        }

        // Feature Storing
        $features = session('features');
        if ($features && count($features)) {
            foreach ($features as $feature) {
                if ($feature) {
                    $ad->adFeatures()->create(['name' => $feature]);
                }
            }
        }

        // ===================== For Custom Field   ================
        $customField = session()->get('custom-field'); // without checkbox
        $checkboxFields = session()->get('custom-field-checkbox'); // with checkbox

        if ($checkboxFields) {
            foreach ($checkboxFields as $key => $values) {
                $cField = CustomField::findOrFail($key)->load('customFieldGroup');

                if (gettype($values) == 'array') {
                    $imploded_value = implode(', ', $values);

                    if ($imploded_value) {
                        $ad->productCustomFields()->create([
                            'custom_field_id' => $key,
                            'value' => $imploded_value,
                            'custom_field_group_id' => $cField->custom_field_group_id,
                        ]);
                    }
                } else {
                    if ($values) {
                        $ad->productCustomFields()->create([
                            'custom_field_id' => $key,
                            'value' => $values ?? '0',
                            'custom_field_group_id' => $cField->custom_field_group_id,
                        ]);
                    }
                }
            }
        }

        $category = Category::with('customFields.values')->findOrFail($ad->category_id);

        if ($category) {
            foreach ($category->customFields as $field) {
                $keys = array_keys($customField);

                for ($i = 0; $i < count($customField); $i++) {
                    foreach ($customField[$keys[$i]] as $key => $value) {
                        if ($field->slug == $key) {
                            $CustomField = CustomField::findOrFail($field->id)->load('customFieldGroup');

                            if ($value) {
                                $ad->productCustomFields()->create([
                                    'custom_field_id' => $field->id,
                                    'value' => $value,
                                    'custom_field_group_id' => $CustomField->custom_field_group_id,
                                ]);
                            }
                        }
                    }
                }
            }
        }

        // location
        $location = session()->get('location');
        $region = array_key_exists('region', $location) ? $location['region'] : '';
        $country = array_key_exists('country', $location) ? $location['country'] : '';
        $address = Str::slug($region.'-'.$country);

        $ad->update([
            'address' => $address,
            'neighborhood' => array_key_exists('neighborhood', $location) ? $location['neighborhood'] : '',
            'locality' => array_key_exists('locality', $location) ? $location['locality'] : '',
            'place' => array_key_exists('place', $location) ? $location['place'] : '',
            'district' => array_key_exists('district', $location) ? $location['district'] : '',
            'postcode' => array_key_exists('postcode', $location) ? $location['postcode'] : '',
            'region' => array_key_exists('region', $location) ? $location['region'] : '',
            'country' => array_key_exists('country', $location) ? $location['country'] : '',
            'long' => array_key_exists('lng', $location) ? $location['lng'] : '',
            'lat' => array_key_exists('lat', $location) ? $location['lat'] : '',
        ]);

        if ($ad) {
            if ($request->get('draft')) {
                $this->adNotification($ad, 'update');
                $this->forgetStepSession();
                $ad->makeDraft(auth('user')->id());

                return view('frontend.postad.postsuccess', [
                    'ad_slug' => $ad->slug,
                    'mode' => 'draft',
                ]);
            }
            $this->forgetStepSession();
            $this->adNotification($ad);
            ! setting('ads_admin_approval') ? $this->userPlanInfoUpdate($ad->featured, $ad->urgent, $ad->highlight, $ad->top, $ad->bump_up) : '';
        }

        return view('frontend.postad.postsuccess', [
            'ad_slug' => $ad->slug,
            'mode' => 'create',
        ]);
        // } catch (\Exception $e) {
        //     flashError('An error occurred: ' . $e->getMessage());

        //     return back();
        // }
    }

    public function PayperAdsStorePostStep3(Request $request)
    {
        $validatedData = $request->validate([
            'phone' => 'required',
            'whatsapp' => 'nullable',
            'email' => 'nullable',
            'featured' => 'sometimes|boolean',
            'urgent' => 'sometimes|boolean',
            'highlight' => 'sometimes|boolean',
            'top' => 'sometimes|boolean',
            'bump_up' => 'sometimes|boolean',
        ]);

        try {

            session(['ads_request' => $request->all()]);
            $plan = loadSetting()::query()->select('id', 'per_ads_active', 'per_ads_price', 'highlight_ads_price', 'highlight_ads_duration', 'featured_ads_price', 'featured_ads_duration', 'top_ads_price', 'top_ads_duration', 'bump_ads_price', 'bump_ads_duration', 'urgent_ads_price', 'urgent_ads_duration')->first();
            $total_price = ($plan->per_ads_price) + ($request->featured ? $plan->featured_ads_price : 0) +
            ($request->highlight ? $plan->highlight_ads_price : 0) +
            ($request->top ? $plan->top_ads_price : 0) +
            ($request->bump_up ? $plan->bump_ads_price : 0) +
            ($request->urgent ? $plan->urgent_ads_price : 0);

            session(['total_ads_price' => $total_price]);
            if ($total_price < 1) {
                $ad = session('ad');
                $ad['video_url'] = $ad['video_url'];
                $ad['user_id'] = auth('user')->id();
                $ad['whatsapp'] = $validatedData['whatsapp'] ?? '';
                $ad['phone'] = $validatedData['phone'] ?? '';
                $ad['email'] = $validatedData['email'] ?? '';
                $ad['status'] = setting('ads_admin_approval') ? JobStatus::PENDING->value : JobStatus::ACTIVE->value;

                // Assign promotions to user
                if ($request->featured || $request->highlight || $request->top || $request->bump_up || $request->urgent) {

                    $current_date = now();
                    $ad->featured = $request->featured ? $request->featured : 0;
                    if ($request->featured) {
                        if ($plan->featured_ads_duration < 1) {
                            $expire_date = now()->addYears(20);
                        } else {
                            $expire_date = now()->addDays($plan->featured_ads_duration);
                        }

                        $ad->featured_at = $current_date;
                        $ad->featured_till = $expire_date;
                    }

                    $ad->urgent = $request->urgent ? $request->urgent : 0;
                    if ($request->urgent) {
                        if ($plan->urgent_ads_duration < 1) {
                            $expire_date = now()->addYears(20);
                        } else {
                            $expire_date = now()->addDays($plan->urgent_ads_duration);
                        }
                        $ad->urgent_at = $current_date;
                        $ad->urgent_till = $expire_date;
                    }
                    $ad->highlight = $request->highlight ? $request->highlight : 0;
                    if ($request->highlight) {
                        if ($plan->highlight_ads_duration < 1) {
                            $expire_date = now()->addYears(20);
                        } else {
                            $expire_date = now()->addDays($plan->highlight_ads_duration);
                        }

                        $ad->highlight_at = $current_date;
                        $ad->highlight_till = $expire_date;
                    }

                    $ad->top = $request->top ? $request->top : 0;
                    if ($request->top) {
                        if ($plan->top_ads_duration < 1) {
                            $expire_date = now()->addYears(20);
                        } else {
                            $expire_date = now()->addDays($plan->top_ads_duration);
                        }

                        $ad->top_at = $current_date;
                        $ad->top_till = $expire_date;
                    }

                    $ad->bump_up = $request->bump_up ? $request->bump_up : 0;
                    if ($request->bump_up) {
                        if ($plan->bump_ads_duration < 1) {
                            $expire_date = now()->addYears(20);
                        } else {
                            $expire_date = now()->addDays($plan->bump_ads_duration);
                        }

                        $ad->bump_up_at = $current_date;
                        $ad->bump_up_till = $expire_date;
                    }
                    $ad->save();
                }

                $request->session()->put('ad', $ad);

                // Image Storing
                $ad_images = session('ad_images');
                $ad_thumbnail = session('ad_thumbnail');

                $ad->update(['thumbnail' => $ad_thumbnail]);

                if ($ad_images && count($ad_images)) {
                    foreach ($ad_images as $image_url) {
                        $ad->galleries()->create(['image' => $image_url]);
                    }
                }

                // Feature Storing
                $features = session('features');
                if ($features && count($features)) {
                    foreach ($features as $feature) {
                        if ($feature) {
                            $ad->adFeatures()->create(['name' => $feature]);
                        }
                    }
                }

                // ===================== For Custom Field   ================
                $customField = session()->get('custom-field'); // without checkbox
                $checkboxFields = session()->get('custom-field-checkbox'); // with checkbox

                if ($checkboxFields) {
                    foreach ($checkboxFields as $key => $values) {
                        $cField = CustomField::findOrFail($key)->load('customFieldGroup');

                        if (gettype($values) == 'array') {
                            $imploded_value = implode(', ', $values);

                            if ($imploded_value) {
                                $ad->productCustomFields()->create([
                                    'custom_field_id' => $key,
                                    'value' => $imploded_value,
                                    'custom_field_group_id' => $cField->custom_field_group_id,
                                ]);
                            }
                        } else {
                            if ($values) {
                                $ad->productCustomFields()->create([
                                    'custom_field_id' => $key,
                                    'value' => $values ?? '0',
                                    'custom_field_group_id' => $cField->custom_field_group_id,
                                ]);
                            }
                        }
                    }
                }

                $category = Category::with('customFields.values')->findOrFail($ad->category_id);

                if ($category) {
                    foreach ($category->customFields as $field) {
                        $keys = array_keys($customField);

                        for ($i = 0; $i < count($customField); $i++) {
                            foreach ($customField[$keys[$i]] as $key => $value) {
                                if ($field->slug == $key) {
                                    $CustomField = CustomField::findOrFail($field->id)->load('customFieldGroup');

                                    if ($value) {
                                        $ad->productCustomFields()->create([
                                            'custom_field_id' => $field->id,
                                            'value' => $value,
                                            'custom_field_group_id' => $CustomField->custom_field_group_id,
                                        ]);
                                    }
                                }
                            }
                        }
                    }
                }

                // location
                $location = session()->get('location');
                $region = array_key_exists('region', $location) ? $location['region'] : '';
                $country = array_key_exists('country', $location) ? $location['country'] : '';
                $address = Str::slug($region.'-'.$country);

                $ad->update([
                    'address' => $address,
                    'neighborhood' => array_key_exists('neighborhood', $location) ? $location['neighborhood'] : '',
                    'locality' => array_key_exists('locality', $location) ? $location['locality'] : '',
                    'place' => array_key_exists('place', $location) ? $location['place'] : '',
                    'district' => array_key_exists('district', $location) ? $location['district'] : '',
                    'postcode' => array_key_exists('postcode', $location) ? $location['postcode'] : '',
                    'region' => array_key_exists('region', $location) ? $location['region'] : '',
                    'country' => array_key_exists('country', $location) ? $location['country'] : '',
                    'long' => array_key_exists('lng', $location) ? $location['lng'] : '',
                    'lat' => array_key_exists('lat', $location) ? $location['lat'] : '',
                ]);

                if ($ad) {
                    if ($request->get('draft')) {
                        $this->adNotification($ad, 'update');
                        $this->forgetStepSession();
                        $ad->makeDraft(auth('user')->id());

                        return view('frontend.postad.postsuccess', [
                            'ad_slug' => $ad->slug,
                            'mode' => 'draft',
                        ]);
                    }
                    $this->forgetStepSession();
                    $this->adNotification($ad);
                    ! setting('ads_admin_approval') ? $this->userPlanInfoUpdate($ad->featured, $ad->urgent, $ad->highlight, $ad->top, $ad->bump_up) : '';
                }

                return view('frontend.postad.postsuccess', [
                    'ad_slug' => $ad->slug,
                    'mode' => 'create',
                ]);
            } else {

                session(['payperads' => true]);
                $plan = new stdClass();

                // Assign properties to the object
                $plan->id = '100';
                $plan->price = $total_price;

                session(['plan' => $plan]);

                return redirect()->route('frontend.payper.ads.payment');
            }

        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    public function pricePlanDetails()
    {
        if (! auth('user')->check()) {
            abort(404);
        }

        try {
            // session data storing
            $plan = loadSetting()::query()->select('id', 'per_ads_active', 'per_ads_price', 'highlight_ads_price', 'highlight_ads_duration', 'featured_ads_price', 'featured_ads_duration', 'top_ads_price', 'top_ads_duration', 'bump_ads_price', 'bump_ads_duration', 'urgent_ads_price', 'urgent_ads_duration')->first();

            $price = session('total_ads_price');

            session(['stripe_amount' => currencyConversion($price) * 100]);
            session(['razor_amount' => currencyConversion($price, null, 'INR', 1) * 100]);
            session(['ssl_amount' => currencyConversion($price, null, 'BDT', 1)]);

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

            $data['plan'] = $plan;

            return view('frontend.payperads.plan-details', $data);
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    /**
     * Ad Edit step 1.
     *
     * @return void
     */
    public function editPostStep1(Ad $ad)
    {
        try {
            if (auth('user')->id() == $ad->user_id) {
                $this->stepCheck();
                session(['edit_mode' => true]);

                if (session('step1') && session('edit_mode')) {
                    $subcategories = $ad->category->subcategories;
                    $ad = collectionToResource($this->setAdEditStep1Data($ad));
                    $categories = Category::latest('id')->get();
                    $brands = Brand::latest('id')->get();

                    return view('frontend.postad_edit.step', compact('ad', 'categories', 'subcategories', 'brands'));
                } else {
                    return redirect()->route('frontend.dashboard');
                }
            }

            abort(404);
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    /**
     * Ad Edit step 2.
     *
     * @return void
     */
    public function getItemFromOb(object $items, string $id, string $search_field)
    {
        foreach ($items as $key => $value) {
            if ($value[$search_field] == $id) {
                return $value;
            }
        }
    }

    public function editPostStep2(Ad $ad)
    {
        $ad_fields = $ad->productCustomFields;
        $array = json_decode(json_encode($ad_fields), true);

        $category = $ad->category;
        $fields = $category->customFields->map(function ($c) use ($ad_fields) {
            $custom_field_value = $this->getItemFromOb($ad_fields, $c->id, 'custom_field_id');
            $c->value = $custom_field_value['value'] ?? '';

            return $c;
        });

        if (auth('user')->id() == $ad->user_id) {
            $ad->load('adFeatures', 'galleries');
            $ad = collectionToResource($this->setAdEditStep2Data($ad));

            if (session('step2') && session('edit_mode')) {
                return view('frontend.postad_edit.step2', compact('ad', 'fields'));
            } else {
                return redirect()->route('frontend.dashboard');
            }
        }

        abort(404);
    }

    /**
     * Edit Ad step 3.
     *
     * @return void
     */
    public function editPostStep3(Ad $ad)
    {
        $ad->load('adFeatures', 'galleries');

        if (auth('user')->id() == $ad->user_id) {
            $ad = collectionToResource($this->setAdEditStep3Data($ad));

            $user_plan_data = UserPlan::where('user_id', auth()->id())->first();
            $plan = $user_plan_data->currentPlan;

            if (session('step3') && session('edit_mode')) {
                return view('frontend.postad_edit.step3', compact('ad', 'user_plan_data', 'plan'));
            } else {
                return redirect()->route('frontend.dashboard');
            }
        }

        abort(404);
    }

    /**
     * Update Ad step 1.ul Islam <devboyarif@gmail.com>
     *
     * @return void
     */
    public function UpdatePostStep1(Request $request, Ad $ad)
    {
        $request->validate([
            'title' => "required|unique:ads,title,$ad->id",
            'price' => 'required|numeric|max:9999999999',
            'category_id' => 'required',
            'brand_id' => 'required',
            'description' => 'required',
        ]);

        try {
            $ad->update([
                'title' => $request->title,
                'slug' => Str::slug($request->title),
                'category_id' => $request->category_id,
                'subcategory_id' => $request->subcategory_id,
                'brand_id' => $request->brand_id,
                'price' => $request->price,
                // 'featured' => $request->featured,
                'description' => $request->description,
            ]);

            if (empty(config('templatecookie.map_show'))) {
                session()->put('location', [
                    'country' => session('selectedCountryId'),
                    'region' => session('selectedStateId'),
                    'district' => session('selectedCityId'),
                    'lng' => session('selectedCityLong') ?? (session('selectedStateLong') ?? session('selectedCountryLong')),
                    'lat' => session('selectedCityLat') ?? (session('selectedStateLat') ?? session('selectedCountryLat')),
                ]);
            }

            // <!--  location  -->
            $location = session()->get('location');

            if ($location) {
                $region = array_key_exists('region', $location) ? $location['region'] : '';
                $country = array_key_exists('country', $location) ? $location['country'] : '';
                $address = Str::slug($region.'-'.$country);

                $ad->update([
                    'address' => $address,
                    'neighborhood' => array_key_exists('neighborhood', $location) ? $location['neighborhood'] : '',
                    'locality' => array_key_exists('locality', $location) ? $location['locality'] : '',
                    'place' => array_key_exists('place', $location) ? $location['place'] : '',
                    'district' => array_key_exists('district', $location) ? $location['district'] : '',
                    'postcode' => array_key_exists('postcode', $location) ? $location['postcode'] : '',
                    'region' => array_key_exists('region', $location) ? $location['region'] : '',
                    'country' => array_key_exists('country', $location) ? $location['country'] : '',
                    'long' => array_key_exists('lng', $location) ? $location['lng'] : '',
                    'lat' => array_key_exists('lat', $location) ? $location['lat'] : '',
                ]);
                session()->forget('location');

                session([
                    'selectedCountryId' => null,
                    'selectedStateId' => null,
                    'selectedCityId' => null,
                    'selectedCountryLong' => null,
                    'selectedCountryLat' => null,
                    'selectedStateLong' => null,
                    'selectedStateLat' => null,
                    'selectedCityLong' => null,
                    'selectedCityLat' => null,
                ]);
            }

            flashSuccess(__('your_ad_has_successfully_update'));

            if ($request->cancel_edit) {
                if ($ad->resubmission == true) {
                    $this->adNotification($ad, 'update');
                    if (checkSetup('mail')) {
                        $admins = Admin::all();
                        foreach ($admins as $admin) {
                            $admin->notify(new AdResubmissionAdminNotification($admin, $ad));
                        }
                    }
                    flashSuccess('Ad updated successfully');

                    return redirect()->route('frontend.addetails', $ad->slug);
                } else {
                    $this->forgetStepSession();

                    return redirect()->route('frontend.dashboard');
                }
            } else {
                $this->step1Success();

                if ($request->get('draft')) {
                    $this->forgetStepSession();
                    $ad->makeDraft(auth('user')->id());

                    return view('frontend.postad.postsuccess', [
                        'ad_slug' => $ad->slug,
                        'mode' => 'draft',
                    ]);
                }

                return redirect()->route('frontend.post.edit.step2', $ad->slug);
            }
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    /**
     * Update Ad step 2.
     *
     * @return void
     */
    public function updatePostStep2(Request $request, Ad $ad)
    {
        try {
            $ad->update([
                'video_url' => $request->video_url,
            ]);

            // feature inserting
            $ad->adFeatures()->delete();
            foreach ($request->features as $feature) {
                if ($feature) {
                    $ad->adFeatures()->create(['name' => $feature]);
                }
            }

            // image uploading
            $images = $request->file('images');
            $thumbnail = $request->file('thumbnail');

            if ($thumbnail && $thumbnail->isValid()) {
                @unlink(public_path($ad->thumbnail));
                $url = uploadImage($thumbnail, 'adds_image', true);
                $ad->update(['thumbnail' => $url]);
            }

            if ($images) {
                foreach ($ad->galleries as $single_gallery) {
                    @unlink(public_path($single_gallery->image));
                    $single_gallery->delete();
                }

                foreach ($images as $image) {
                    if ($image && $image->isValid()) {
                        $url = uploadImage($image, 'adds_multiple', true);
                        $ad->galleries()->create(['image' => $url]);
                    }
                }
            }

            // Custom Field Update
            $this->updateCustomField($request, $ad);

            flashSuccess(__('your_ad_has_successfully_update'));

            if ($request->cancel_edit) {
                if ($ad->resubmission == true) {
                    $this->adNotification($ad, 'update');
                    if (checkSetup('mail')) {
                        $admins = Admin::all();
                        foreach ($admins as $admin) {
                            $admin->notify(new AdResubmissionAdminNotification($admin, $ad));
                        }
                    }
                    flashSuccess('Ad updated successfully');

                    return redirect()->route('frontend.addetails', $ad->slug);
                } else {
                    $this->forgetStepSession();

                    return redirect()->route('frontend.dashboard');
                }
            } else {
                $this->step1Success2();

                if ($request->get('draft')) {
                    $this->forgetStepSession();
                    $ad->makeDraft(auth('user')->id());

                    return view('frontend.postad.postsuccess', [
                        'ad_slug' => $ad->slug,
                        'mode' => 'draft',
                    ]);
                }

                return redirect()->route('frontend.post.edit.step3', $ad->slug);
            }
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    /**
     * Update Ad step 3.
     *
     * @return void
     */
    public function updatePostStep3(Request $request, Ad $ad)
    {
        $request->validate([
            'phone' => 'required',
            'whatsapp' => 'nullable',
            'email' => 'nullable',
            'featured' => 'sometimes|boolean',
            'urgent' => 'sometimes|boolean',
            'highlight' => 'sometimes|boolean',
            'top' => 'sometimes|boolean',
            'bump_up' => 'sometimes|boolean',
        ]);

        try {
            // Assign promotions to user
            $ad = $this->promotePlan($request, $ad, auth()->id());
            $ad->save();

            if ($ad->resubmission == true) {
                if (checkSetup('mail')) {
                    $admins = Admin::all();
                    foreach ($admins as $admin) {
                        $admin->notify(new AdResubmissionAdminNotification($admin, $ad));
                    }
                }
                $ad->customer_edit_time = now();
            }

            $ad->update([
                'phone' => $request->phone,
                'email' => $request->email,
                'whatsapp' => $request->whatsapp,
                'status' => setting('ads_admin_approval') ? JobStatus::PENDING->value : JobStatus::ACTIVE->value,
            ]);

            $this->forgetStepSession();
            $this->adNotification($ad, 'update');
            if ($request->get('draft')) {
                $this->forgetStepSession();
                $ad->makeDraft(auth('user')->id());

                return view('frontend.postad.postsuccess', [
                    'ad_slug' => $ad->slug,
                    'mode' => 'draft',
                ]);
            }

            return view('frontend.postad.postsuccess', [
                'ad_slug' => $ad->slug,
                'mode' => 'update',
            ]);
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    /**
     * Cancel Ad Edit.
     *
     * @return void
     */
    public function cancelAdPostEdit()
    {
        $this->forgetStepSession();

        return redirect()->route('frontend.dashboard');
    }

    public function adGalleryDelete($ad_gallery)
    {
        try {
            $ad_gallery = AdGallery::find($ad_gallery);
            if ($ad_gallery) {
                $ad_gallery->delete();
            }

            return true;
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    protected function updateCustomField($request, Ad $ad)
    {
        $category = Category::with('customFields.values')->findOrFail($ad->category_id);

        foreach ($category->customFields as $field) {
            if ($field->slug !== $request->has($field->slug) && $field->required) {
                if ($field->type != 'checkbox' && $field->type != 'checkbox_multiple') {
                    $request->validate([
                        $field->slug => 'required',
                    ]);
                }
            }
            if ($field->type == 'textarea') {
                $request->validate([
                    $field->slug => 'nullable|max:255',
                ]);
            }
            if ($field->type == 'url') {
                $request->validate([
                    $field->slug => 'nullable|url',
                ]);
            }
            if ($field->type == 'number') {
                $request->validate([
                    $field->slug => 'nullable|numeric',
                ]);
            }
            if ($field->type == 'date') {
                $request->validate([
                    $field->slug => 'nullable|date',
                ]);
            }
        }

        try {
            // First Delete If Custom Field Value exist for this Ad
            $field_values = ProductCustomField::where('ad_id', $ad->id)->get();
            foreach ($field_values as $item) {
                if (file_exists($item->value)) {
                    unlink($item->value);
                }
                $item->delete();
            }

            $checkboxFields = [];
            if (request()->filled('cf')) {
                $checkboxFields = request()->get('cf');
            }

            // Checkbox Fields
            if ($checkboxFields) {
                foreach ($checkboxFields as $key => $values) {
                    $CustomField = CustomField::findOrFail($key)->load('customFieldGroup');

                    if (gettype($values) == 'array') {
                        $imploded_value = implode(', ', $values);

                        if ($imploded_value) {
                            $ad->productCustomFields()->create([
                                'custom_field_id' => $key,
                                'value' => $imploded_value,
                                'custom_field_group_id' => $CustomField->custom_field_group_id,
                            ]);
                        }
                    } else {
                        if ($values) {
                            $ad->productCustomFields()->create([
                                'custom_field_id' => $key,
                                'value' => $values ?? '0',
                                'custom_field_group_id' => $CustomField->custom_field_group_id,
                            ]);
                        }
                    }
                }
            }

            // then insert
            foreach ($category->customFields as $field) {
                if ($field->slug == $request->has($field->slug)) {
                    $CustomField = CustomField::findOrFail($field->id)->load('customFieldGroup');

                    // check data type for confirm it is image
                    if (request($field->slug)) {
                        $fileType = gettype(request($field->slug));

                        if ($fileType == 'object') {
                            $image = uploadImage(request($field->slug), 'custom-field');
                            $value = $image;
                        } else {
                            $value = request($field->slug) ?? 'No Value';
                        }

                        if ($field->id && $CustomField->custom_field_group_id && $value && $fileType != 'array') {
                            $ad->productCustomFields()->create([
                                'custom_field_id' => $field->id,
                                'value' => $value,
                                'custom_field_group_id' => $CustomField->custom_field_group_id,
                            ]);
                            // $ad->productCustomFields()->create([
                            //     'custom_field_id' => $field->id,
                            //     'value' => $fileType == 'object' ? $image : request($field->slug),
                            //     'custom_field_group_id' => $CustomField->custom_field_group_id,
                            // ]);
                        }
                    }
                }
            }

            return true;
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    public function PostDelete(Ad $ad)
    {
        try {
            // Delete the ad
            $ad->delete();
            $this->adDeleteNotification();

            // Redirect back with a success message
            return redirect()->back()->with('success', 'Ad deleted successfully');
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    public function adDeleteNotification()
    {
        try {
            // Send ad create notification
            $user = auth('user')->user();
            $user->notify(new AdDeleteNotification($user));
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }
}
