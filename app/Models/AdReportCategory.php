<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class AdReportCategory extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function reportAds()
    {
        return $this->hasMany(ReportAd::class, 'report_category_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($category) {
            $category->slug = Str::slug($category->name);
        });

        static::updating(function ($category) {
            $category->slug = Str::slug($category->name);
        });

        self::created(function ($model) {
            forgetCache('report_categories');
        });

        self::updated(function ($model) {
            forgetCache('report_categories');
        });

        self::deleted(function ($model) {
            forgetCache('report_categories');
        });
    }

    public function getSlugAttribute(): string
    {
        return Str::slug($this->name);
    }
}
