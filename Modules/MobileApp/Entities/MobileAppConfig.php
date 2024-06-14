<?php

namespace Modules\MobileApp\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MobileAppConfig extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected static function newFactory()
    {
        return \Modules\MobileApp\Database\factories\MobileAppConfigFactory::new();
    }

    public static function boot()
    {
        parent::boot();

        self::created(function ($model) {
            forgetCache('mobile_app_config');
        });

        self::updated(function ($model) {
            forgetCache('mobile_app_config');
        });

        self::deleted(function ($model) {
            forgetCache('mobile_app_config');
        });
    }
}
