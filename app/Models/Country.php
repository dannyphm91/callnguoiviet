<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    protected $guarded = [];

    public static function boot()
    {
        parent::boot();

        self::created(function ($model) {
            forgetCache('all_countries');
        });

        self::updated(function ($model) {
            forgetCache('all_countries');
        });

        self::deleted(function ($model) {
            forgetCache('all_countries');
        });
    }
}
