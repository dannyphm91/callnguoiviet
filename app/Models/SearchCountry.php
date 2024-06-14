<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SearchCountry extends Model
{
    use HasFactory;

    protected $guarded = [];

    public static function boot()
    {
        parent::boot();

        self::created(function ($model) {
            forgetCache('countries');
        });

        self::updated(function ($model) {
            forgetCache('countries');
        });

        self::deleted(function ($model) {
            forgetCache('countries');
        });
    }

    public function states()
    {
        return $this->hasMany(State::class, 'country_id');
    }
}
