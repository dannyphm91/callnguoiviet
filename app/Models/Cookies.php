<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cookies extends Model
{
    use HasFactory;

    protected $fillable = [
        'allow_cookies', 'cookie_name', 'cookie_expiration', 'force_consent', 'darkmode', 'language', 'title', 'description', 'button_text',
    ];

    protected $casts = [
        'allow_cookies' => 'boolean',
        'force_consent' => 'boolean',
        'darkmode' => 'boolean',
    ];

    public static function boot()
    {
        parent::boot();

        self::created(function ($model) {
            forgetCache('cookies');
        });

        self::updated(function ($model) {
            forgetCache('cookies');
        });

        self::deleted(function ($model) {
            forgetCache('cookies');
        });
    }
}
