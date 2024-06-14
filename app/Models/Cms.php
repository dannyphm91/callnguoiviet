<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cms extends Model
{
    use HasFactory;

    protected $appends = ['posting_rules_background_url'];

    protected $guarded = [];

    public function getPostingRulesBackgroundUrlAttribute()
    {
        return is_null(! $this->posting_rules_background) ? asset($this->posting_rules_background) : asset('frontend/default_images/default_background.webp');
    }

    public function getTermsBackgroundAttribute($value)
    {
        return ! $value ? asset('frontend/default_images/default_background.webp') : asset($value);
    }

    public function getPrivacyBackgroundAttribute($value)
    {
        return ! $value ? asset('frontend/default_images/default_background.webp') : asset($value);
    }

    public function getRefundBackgroundAttribute($value)
    {
        return ! $value ? asset('frontend/default_images/default_background.jpg') : asset($value);
    }

    public function getAboutVideoThumbAttribute($value)
    {
        if ($value) {
            return asset($value);
        }

        return null;
    }

    public function getPricingPlanBackgroundAttribute($value)
    {
        return ! $value ? asset('frontend/images/membership-hero.png') : asset($value);
    }

    public function getPricingPlanImageAttribute($value)
    {
        return ! $value ? asset('frontend/images/membership-trial.png') : asset($value);
    }

    public function getFaqBackgroundAttribute($value)
    {
        return ! $value ? asset('frontend/default_images/default_background.webp') : asset($value);
    }

    public function getDashboardOverviewBackgroundAttribute($value)
    {
        return ! $value ? asset('frontend/default_images/default_background.webp') : asset($value);
    }

    public function getDashboardPostAdsBackgroundAttribute($value)
    {
        return ! $value ? asset('frontend/default_images/default_background.webp') : asset($value);
    }

    public function getDashboardMyAdsBackgroundAttribute($value)
    {
        return ! $value ? asset('frontend/default_images/default_background.webp') : asset($value);
    }

    public function getDashboardPlanBackgroundAttribute($value)
    {
        return ! $value ? asset('frontend/default_images/default_background.webp') : asset($value);
    }

    public function getDashboardAccountSettingBackgroundAttribute($value)
    {
        return ! $value ? asset('frontend/default_images/default_background.webp') : asset($value);
    }

    public function getPostingRulesBackgroundAttribute($value)
    {
        return ! $value ? asset('frontend/default_images/default_background.webp') : asset($value);
    }

    public function getGetMembershipBackgroundAttribute($value)
    {
        return ! $value ? asset('frontend/default_images/default_background.webp') : asset($value);
    }

    public function getGetMembershipImageAttribute($value)
    {
        return ! $value ? asset('frontend/default_images/default_background.webp') : asset($value);
    }

    public function getDashboardFavoriteAdsBackgroundAttribute($value)
    {
        return ! $value ? asset('frontend/default_images/default_background.webp') : asset($value);
    }

    public function getDashboardMessengerBackgroundAttribute($value)
    {
        return ! $value ? asset('frontend/default_images/default_background.webp') : asset($value);
    }

    public function getBlogBackgroundAttribute($value)
    {
        return ! $value ? asset('frontend/default_images/default_background.webp') : asset($value);
    }

    public function getAdsBackgroundAttribute($value)
    {
        return ! $value ? asset('frontend/default_images/default_background.webp') : asset($value);
    }

    public function getContactBackgroundAttribute($value)
    {
        return ! $value ? asset('frontend/default_images/default_background.webp') : asset($value);
    }

    public function getDefaultBackgroundAttribute($value)
    {
        return ! $value ? asset('frontend/default_images/default_background.webp') : asset($value);
    }

    public static function boot()
    {
        parent::boot();

        self::created(function ($model) {
            forgetCache('cms');
        });

        self::updated(function ($model) {
            forgetCache('cms');
        });

        self::deleted(function ($model) {
            forgetCache('cms');
        });
    }
}
