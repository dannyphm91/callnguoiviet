<?php

namespace Modules\Ad\Http\Controllers;

use App\Http\Traits\AdCreateTrait;
use App\Http\Traits\HasPlanPromotion;
use App\Models\ResubmissionGallery;
use App\Models\User;
use App\Notifications\AdApprovedNotification;
use App\Notifications\AdCreateNotification;
use App\Notifications\AdResubmissionNotification;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Modules\Ad\Entities\Ad;
use Modules\Ad\Http\Requests\AdFormRequest;
use Modules\Brand\Entities\Brand;
use Modules\Category\Entities\Category;
use Modules\Category\Entities\SubCategory;
use Modules\CustomField\Entities\CustomField;
use Modules\CustomField\Entities\ProductCustomField;

class AdController extends Controller
{
    use AdCreateTrait, HasPlanPromotion;

    /**
     * Display a listing of the ads.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (! userCan('ad.view')) {
            return abort(403);
        }
        try {
            $categories = Category::active()->get();
            $brands = Brand::get(['id', 'name', 'slug']);
            $query = Ad::query();

            // keyword search
            if (request()->has('keyword') && request()->keyword != null) {
                $query->where('title', 'LIKE', '%'.request('keyword').'%');
            }

            // category filter
            if ($request->has('category') && $request->category != null) {
                $category = $request->category;

                $query->whereHas('category', function ($q) use ($category) {
                    $q->where('slug', $category);
                });
            }

            // brand filter
            if ($request->has('brand') && $request->brand != null) {
                $brand = $request->brand;

                $query->whereHas('brand', function ($q) use ($brand) {
                    $q->where('slug', $brand);
                });
            }

            // filtering
            if (request()->has('filter_by') && request()->filter_by != null) {
                switch (request()->filter_by) {
                    case 'sold':
                        $query->where('status', 'sold');
                        break;
                    case 'active':
                        $query->where('status', 'active');
                        break;
                    case 'pending':
                        $query->where('status', 'pending');
                        break;
                    case 'declined':
                        $query->where('status', 'declined');
                        break;
                    case 'featured':
                        $query->where('featured', 1)->latest();
                        break;
                    case 'most_viewed':
                        $query->latest('total_views');
                        break;
                    case 'all':
                        $query;
                        break;
                }
            }

            $ads = $query
                ->with('category', 'customer', 'resubmissionGalleries')
                ->latest()
                ->paginate(10)
                ->withQueryString();

            return view('ad::index', compact('ads', 'categories', 'brands'));
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
    public function create()
    {
        if (! userCan('ad.create')) {
            return abort(403);
        }
        try {
            $brands = Brand::all();
            $customers = User::all();
            $categories = Category::active()
                ->with('subcategories', function ($q) {
                    $q->where('status', 1);
                })
                ->get();

            if ($categories->count() < 1) {
                flashWarning("You don't have any active category. Please create or active category first.");

                return redirect()->route('module.category.create');
            }

            if ($customers->count() < 1) {
                flashWarning("You don't have any customer. Please create customer first.");

                return redirect()->route('module.customer.create');
            }

            if ($brands->count() < 1) {
                flashWarning("You don't have any brand. Please create brand first.");

                return redirect()->route('module.brand.index');
            }

            return view('ad::create', [
                'brands' => $brands,
                'customers' => $customers,
                'categories' => $categories,
            ]);
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    public function getSubcategory($id)
    {
        try {
            echo json_encode(SubCategory::where('category_id', $id)->get());
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(AdFormRequest $request)
    {
        if (! userCan('ad.create')) {
            return abort(403);
        }

        $location = session()->get('location');
        if (! $location) {
            $request->validate([
                'location' => 'sometimes|text',
            ]);
        }
        try {
            $ad = new Ad();
            $ad->title = $request->title;
            $ad->slug = Str::slug($request->title);
            $ad->user_id = $request->user_id;
            $ad->category_id = $request->category_id;
            $ad->subcategory_id = $request->subcategory_id;
            $ad->brand_id = $request->brand_id;
            $ad->price = $request->price;
            $ad->description = $request->description;
            $ad->video_url = $request->video_url;
            $ad->show_phone = $request->show_phone;
            $ad->phone = $request->phone;
            $ad->whatsapp = $request->whatsapp ?? '';
            $ad->status = setting('ads_admin_approval') ? 'pending' : 'active';

            // Assign promotions to user
            $ad = $this->promotePlan($request, $ad, $ad->user_id);

            $ad->save();

            // image uploading
            if ($request->hasFile('thumbnail') && $request->file('thumbnail')->isValid()) {
                $url = uploadImage($request->thumbnail, 'addss_images', true);
                $ad->update(['thumbnail' => $url]);
            }

            // feature inserting
            foreach ($request->features as $feature) {
                if ($feature) {
                    $ad->adFeatures()->create(['name' => $feature]);
                }
            }

            ! setting('ads_admin_approval') ? $this->userPlanInfoUpdate(
                $ad->featured,
                $ad->urgent,
                $ad->highlight,
                $ad->top,
                $ad->bump_up,
                $request->user_id
            ) : '';
            if (empty(config('templatecookie.map_show'))) {
                session()->put('location', [
                    'country' => session('selectedCountryId'),
                    'region' => session('selectedStateId'),
                    'district' => session('selectedCityId'),
                    'lng' => session('selectedCityLong') ?? session('selectedStateLong') ?? session('selectedCountryLong'),
                    'lat' => session('selectedCityLat') ?? session('selectedStateLat') ?? session('selectedCountryLat'),
                ]);
            }
            // <!--  location  -->
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

            flashSuccess('Ad Created Successfully. Please add category custom field values .');

            return redirect()->route('module.ad.custom.field.value', $ad->id);
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Ad $ad)
    {
        if (! userCan('ad.view')) {
            return abort(403);
        }
        try {
            $ad->load('adFeatures', 'galleries', 'category', 'subcategory', 'customer', 'galleries', 'brand', 'productCustomFields');

            return view('ad::show', compact('ad'));
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    public function edit(Ad $ad)
    {
        try {
            $data['brands'] = Brand::get();
            $data['customers'] = User::get();

            $data['categories'] = Category::get();
            $data['subcategories'] = SubCategory::where('category_id', $ad->category->id)->get();

            return view('ad::edit', compact('ad'), $data);
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    public function update(AdFormRequest $request, Ad $ad)
    {
        if (! userCan('ad.update')) {
            return abort(403);
        }
        try {

            $ad->update([
                'title' => $request->title,
                'slug' => Str::slug($request->title),
                'user_id' => $request->user_id,
                'category_id' => $request->category_id,
                'subcategory_id' => $request->subcategory_id,
                'brand_id' => $request->brand_id,
                'price' => $request->price,
                'description' => $request->description,
                'video_url' => $request->video_url,
                'phone' => $request->phone,
                'show_phone' => $request->show_phone,
                'whatsapp' => $request->whatsapp ?? '',
            ]);

            // Assign promotions to users start
            $ad = $this->promotePlan($request, $ad, $ad->user_id);

            $ad->update();

            // image updating
            if ($request->hasFile('thumbnail') && $request->file('thumbnail')->isValid()) {
                deleteImage($ad->thumbnail);

                $url = uploadImage($request->thumbnail, 'addss_image', true);
                $ad->update(['thumbnail' => $url]);
            }

            // feature inserting
            $ad->adFeatures()->delete();
            foreach ($request->features as $feature) {
                if ($feature) {
                    $ad->adFeatures()->create(['name' => $feature]);
                }
            }

            if (empty(config('templatecookie.map_show'))) {
                session()->put('location', [
                    'country' => session('selectedCountryId'),
                    'region' => session('selectedStateId'),
                    'district' => session('selectedCityId'),
                    'lng' => session('selectedCityLong') ?? session('selectedStateLong') ?? session('selectedCountryLong'),
                    'lat' => session('selectedCityLat') ?? session('selectedStateLat') ?? session('selectedCountryLat'),
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

            flashSuccess('Ad Updated Successfully. Please update category custom field values .');

            // return redirect()->route('module.ad.custom.field.value' , $ad->id);
            return redirect()->route('module.ad.custom.field.value.edit', $ad->id);
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ad $ad)
    {
        if (! userCan('ad.delete')) {
            return abort(403);
        }

        try {
            if (file_exists(public_path($ad->thumbnail))) {
                @unlink(public_path($ad->thumbnail));
            }

            $ad->delete();

            flashSuccess('Ad Deleted Successfully');

            return back();
        } catch (\Throwable $th) {
            flashError();

            return back();
        }
    }

    public function status(Ad $ad, $status)
    {
        try {
            $customer = $ad->customer;
            $ad_status = $ad->status;

            if ($ad) {
                $ad->update(['status' => $status]);
                flashSuccess('Ad Status Updated Successfully');

                if ($ad_status == 'pending') {
                    if ($status == 'active') {
                        $this->userPlanInfoUpdate(
                            $ad->featured,
                            $ad->urgent,
                            $ad->highlight,
                            $ad->top,
                            $ad->bump_up,
                            $ad->user_id
                        );

                        $ad->update(['resubmission' => 0]); // Set resubmission to 0

                        if (checkSetup('mail')) {
                            $customer->notify(new AdApprovedNotification($customer, $ad));
                            $customer->notify(new AdCreateNotification($customer, $ad));
                        }
                    }
                }

                return back();
            }

            flashError();

            return back();
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    public function addCustomFieldValue(Ad $ad)
    {
        try {
            $category = Category::with('customFields.values')->FindOrFail($ad->category_id);

            return view('customfield::ad_create_field', compact('ad', 'category'));
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    public function getItemFromOb(object $items, string $id, string $search_field)
    {
        try {
            foreach ($items as $key => $value) {
                if ($value[$search_field] == $id) {
                    return $value;
                }
            }
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    public function editCustomFieldValue(Ad $ad)
    {
        try {
            $ad_fields = $ad->productCustomFields;
            $array = json_decode(json_encode($ad_fields), true);

            $category = $ad->category;
            $fields = $category->customFields->map(function ($c) use ($ad_fields) {
                $custom_field_value = $this->getItemFromOb($ad_fields, $c->id, 'custom_field_id');
                $c->value = $custom_field_value['value'] ?? '';

                return $c;
            });

            $ad->load('productCustomFields');

            return view('customfield::ad_edit_field', compact('ad', 'fields'));
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    public function storeCustomFieldValue(Request $request, Ad $ad)
    {
        try {
            $category = Category::with('customFields.values')->FindOrFail($ad->category_id);

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
                            if ($imploded_value) {
                                $ad->productCustomFields()->create([
                                    'custom_field_id' => $key,
                                    'value' => $imploded_value,
                                    'custom_field_group_id' => $CustomField->custom_field_group_id,
                                ]);
                            }
                        }
                    } else {
                        $ad->productCustomFields()->create([
                            'custom_field_id' => $key,
                            'value' => $values ?? '0',
                            'custom_field_group_id' => $CustomField->custom_field_group_id,
                        ]);
                    }
                }
            }

            // then insert
            foreach ($category->customFields as $field) {
                if ($field->slug == $request->has($field->slug)) {
                    $CustomField = CustomField::findOrFail($field->id)->load('customFieldGroup');

                    // check data type for confirm it is image
                    $fileType = gettype(request($field->slug));

                    if ($fileType == 'object') {
                        $image = uploadImage(request($field->slug), 'custom-field');
                    }

                    if (request($field->slug)) {
                        if (request($field->slug)) {
                            $ad->productCustomFields()->create([
                                'custom_field_id' => $field->id,
                                'value' => $fileType == 'object' ? $image : request($field->slug),
                                'custom_field_group_id' => $CustomField->custom_field_group_id,
                            ]);
                        }
                    }
                }
            }

            flashSuccess('Ad Created Successfully. Please add the ad gallery images.');

            return redirect()->route('module.ad.show_gallery', $ad->id);
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    public function updateCustomFieldValue(Request $request, Ad $ad)
    {
        $category = Category::with('customFields.values')->FindOrFail($ad->category_id);

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
            $field_values = ProductCustomField::with('customField')
                ->where('ad_id', $ad->id)
                ->get();
            foreach ($field_values as $item) {
                $item->delete();
            }

            // then insert
            foreach ($category->customFields as $field) {
                if ($field->slug == $request->has($field->slug)) {
                    $CustomField = CustomField::findOrFail($field->id)->load('customFieldGroup');

                    // check data type for confirm it is image
                    $fileType = gettype(request($field->slug));

                    if ($fileType == 'object') {
                        $image = uploadImage(request($field->slug), 'custom-field');
                    }

                    if (request($field->slug)) {
                        $ad->productCustomFields()->create([
                            'custom_field_id' => $field->id,
                            'value' => $fileType == 'object' ? $image : request($field->slug),
                            'custom_field_group_id' => $CustomField->custom_field_group_id,
                        ]);
                    }
                }
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
                        $ad->productCustomFields()->create([
                            'custom_field_id' => $key,
                            'value' => $values ?? '0',
                            'custom_field_group_id' => $CustomField->custom_field_group_id,
                        ]);
                    }
                }
            }

            flashSuccess('Ad Updated Successfully');

            return redirect()->route('module.ad.index');
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    public function sortingCustomFieldValue(Ad $ad)
    {
        try {
            $ad = $ad->load([
                'productCustomFields' => function ($q) {
                    $q->without('customField.values', 'customField.customFieldGroup');
                },
            ]);

            $fields = $ad->productCustomFields;

            return view('customfield::ad_sorting_field', compact('ad', 'fields'));
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    public function sortingCustomFieldValueStore(Request $request)
    {
        try {
            $fields = ProductCustomField::where('ad_id', $request->ad)->get();

            foreach ($fields as $task) {
                $task->timestamps = false;
                $id = $task->id;

                foreach ($request->order as $order) {
                    if ($order['id'] == $id) {
                        $task->update(['order' => $order['position']]);
                    }
                }
            }

            return response()->json(['message' => 'Custom Field Sorted Successfully!']);
        } catch (\Throwable $th) {
            flashError();

            return back();
        }
    }

    public function ResubmissionStatus(Request $request, $slug)
    {
        try {

            $ad = Ad::where('slug', $slug)->first();

            if (! $ad) {
                flashError('Ad not found.');

                return back();
            }

            $ad->update([
                'resubmission' => 1,
                'resubmission_time' => now(),
                'comment' => $request->input('comment'),
            ]);
            // Handle the uploaded photos
            if ($request->hasFile('photos')) {

                $photos = $request->file('photos');
                foreach ($photos as $photo) {
                    if ($photo && $photo->isValid()) {
                        $photoName = time().'_'.$photo->getClientOriginalName();
                        $destinationPath = public_path('/uploads/resubmissionGallery');
                        $photo->move($destinationPath, $photoName);
                        $newPhoto = new ResubmissionGallery();
                        $newPhoto->ad_id = $ad->id;
                        $newPhoto->image = '/uploads/resubmissionGallery/'.$photoName;
                        $newPhoto->save();
                    }
                }
            }

            if (checkSetup('mail')) {
                $customer = $ad->customer; // Assuming there is a relationship between Ad and Customer
                $customer->notify(new AdResubmissionNotification($customer, $ad));
            }

            flashSuccess('Status updated successfully');

            return back();

        } catch (\Throwable $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    public function resubmissionImage($id)
    {
        try {
            $resubmissionImage = ResubmissionGallery::findOrFail($id);

            $filePath = $resubmissionImage->image;

            if (Storage::disk('public')->exists($filePath)) {
                Storage::disk('public')->delete($filePath);
            }

            $resubmissionImage->delete();

            // Return a JSON response instead of redirecting
            return response()->json(['success' => true, 'message' => 'Image deleted successfully'])->withCallback(flashSuccess('Status updated successfully'));

        } catch (\Throwable $e) {
            // Return a JSON response with the error message
            return response()->json(['success' => false, 'error' => 'An error occurred: '.$e->getMessage()]);
        }
    }

    public function resubmissionIndex(Request $request)
    {
        if (! userCan('ad.view')) {
            return abort(403);
        }
        try {
            $categories = Category::active()->get();
            $brands = Brand::get(['id', 'name', 'slug']);
            $query = Ad::query();
            $resubmissionGallery = ResubmissionGallery::all();

            // keyword search
            if (request()->has('keyword') && request()->keyword != null) {
                $query->where('title', 'LIKE', '%'.request('keyword').'%');
            }

            // category filter
            if ($request->has('category') && $request->category != null) {
                $category = $request->category;

                $query->whereHas('category', function ($q) use ($category) {
                    $q->where('slug', $category);
                });
            }

            // brand filter
            if ($request->has('brand') && $request->brand != null) {
                $brand = $request->brand;

                $query->whereHas('brand', function ($q) use ($brand) {
                    $q->where('slug', $brand);
                });
            }

            // filtering
            if (request()->has('filter_by') && request()->filter_by != null) {
                switch (request()->filter_by) {
                    case 'sold':
                        $query->where('status', 'sold');
                        break;
                    case 'active':
                        $query->where('status', 'active');
                        break;
                    case 'pending':
                        $query->where('status', 'pending');
                        break;
                    case 'declined':
                        $query->where('status', 'declined');
                        break;
                    case 'featured':
                        $query->where('featured', 1)->latest();
                        break;
                    case 'most_viewed':
                        $query->latest('total_views');
                        break;
                    case 'all':
                        $query;
                        break;
                }
            }

            $ads = $query
                ->with('category', 'customer', 'resubmissionGalleries')->where('resubmission', true)
                ->latest()
                ->paginate(10)
                ->withQueryString();

            return view('ad::resubmission_index', compact('ads', 'categories', 'brands'));
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }
}
