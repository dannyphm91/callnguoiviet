<?php

namespace App\Http\Traits;

use App\Models\UserPlan;
use App\Notifications\AdCreateNotification;
use App\Notifications\AdPendingNotification;
use App\Notifications\AdUpdateNotification;

trait AdCreateTrait
{
    protected function forgetStepSession()
    {
        session()->forget('ad');
        session()->forget('edit_mode');
        session()->forget('step1');
        session()->forget('step2');
        session()->forget('step3');
        session()->forget('step1_success');
        session()->forget('step2_success');
        session()->forget('features');
        session()->forget('ad_images');
        session()->forget('ad_thumbnail');
        session()->forget('location');
        session()->forget('custom-field');
        session()->forget('custom-field-checkbox');

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

    protected function stepCheck()
    {
        storePlanInformation();
        session(['step1' => true]);
        session(['step2' => false]);
        session(['step3' => false]);
        session(['step1_success' => false]);
        session(['step2_success' => false]);
    }

    public function postStep1Back($slug = null)
    {
        session(['step1' => true]);
        session(['step2' => false]);
        session(['step3' => false]);
        session(['step1_success' => false]);
        session(['step2_success' => false]);

        if ($slug) {
            return redirect()->route('frontend.post.edit', $slug);
        } else {
            return redirect()->route('frontend.post');
        }
    }

    public function postStep2Back($slug = null)
    {
        session(['step1' => false]);
        session(['step2' => true]);
        session(['step3' => false]);
        session(['step1_success' => true]);
        session(['step2_success' => false]);

        if ($slug) {
            return redirect()->route('frontend.post.edit.step2', $slug);
        } else {
            return redirect()->route('frontend.post.step2');
        }
    }

    protected function step1Success()
    {
        session(['step1' => false]);
        session(['step2' => true]);
        session(['step3' => false]);

        session(['step1_success' => true]);
        session(['step2_success' => false]);
    }

    protected function step1Success2()
    {
        session(['step1' => false]);
        session(['step2' => false]);
        session(['step3' => true]);

        session(['step1_success' => true]);
        session(['step2_success' => true]);
    }

    protected function userPlanInfoUpdate(
        $is_featured,
        $is_urgent,
        $is_highlight,
        $is_top,
        $is_bump_up,
        $user_id = null)
    {
        $userPlan = UserPlan::customerData($user_id)->firstOrFail();

        if ($userPlan->ad_limit != 0) {
            $userPlan->ad_limit = $userPlan->ad_limit - 1;
        }

        if ($userPlan->featured_limit != 0 && $is_featured) {
            $userPlan->featured_limit = $userPlan->featured_limit - 1;
        }

        if ($userPlan->urgent_limit != 0 && $is_urgent) {
            $userPlan->urgent_limit = $userPlan->urgent_limit - 1;
        }

        if ($userPlan->highlight_limit != 0 && $is_highlight) {
            $userPlan->highlight_limit = $userPlan->highlight_limit - 1;
        }

        if ($userPlan->top_limit != 0 && $is_top) {
            $userPlan->top_limit = $userPlan->top_limit - 1;
        }

        if ($userPlan->bump_up_limit != 0 && $is_bump_up) {
            $userPlan->bump_up_limit = $userPlan->bump_up_limit - 1;
        }

        return $userPlan->save();
    }

    protected function adNotification($ad, $mode = 'create', $api = false)
    {
        $user = auth($api ? 'api' : 'user')->user();

        if (checkMailConfig()) {
            if ($mode == 'create') {
                if (checkSetup('mail') && setting('ads_admin_approval')) {
                    $user->notify(new AdPendingNotification($user, $ad));
                } else {
                    $user->notify(new AdCreateNotification($user, $ad));
                }
            } else {
                $user->notify(new AdUpdateNotification($user, $ad));

            }
        }
    }

    protected function setAdEditStep1Data($ad)
    {
        // step 1 data
        return [
            'id' => $ad->id,
            'title' => $ad->title,
            'slug' => $ad->slug,
            'price' => $ad->price,
            'category_id' => $ad->category_id,
            'subcategory_id' => $ad->subcategory_id,
            'brand_id' => $ad->brand_id,
            // 'featured' => $ad->featured,
            'description' => $ad->description,
            'country' => $ad->country,
            'region' => $ad->region,
            'district' => $ad->district,
            'lat' => $ad->lat,
            'lng' => $ad->lng,
            'location' => $ad->location,
            'resubmission' => $ad->resubmission,
        ];
    }

    protected function setAdEditStep2Data($ad)
    {
        // step 2 data
        return [
            'id' => $ad->id,
            'title' => $ad->title,
            'slug' => $ad->slug,
            'features' => $ad->adFeatures,
            'galleries' => $ad->galleries,
            'video_url' => $ad->video_url,
            'image_url' => $ad->image_url,
            'thumbnail' => $ad->thumbnail,
            'resubmission' => $ad->resubmission,
        ];
    }

    protected function setAdEditStep3Data($ad)
    {
        // step 3 data
        return [
            'id' => $ad->id,
            'title' => $ad->title,
            'slug' => $ad->slug,
            'phone' => $ad->phone,
            'whatsapp' => $ad->whatsapp,
            'show_phone' => $ad->show_phone,
            'email' => $ad->email,
            'featured' => $ad->featured,
            'urgent' => $ad->urgent,
            'highlight' => $ad->highlight,
            'top' => $ad->top,
            'bump_up' => $ad->bump_up,
            'resubmission' => $ad->resubmission,
        ];
    }
}
