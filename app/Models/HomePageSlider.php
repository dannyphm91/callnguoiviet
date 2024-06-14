<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomePageSlider extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function getImageUrlAttribute()
    {
        if (is_null($this->url)) {
            return asset('frontend/images/slider-img/hero-banner.png');
        }

        return asset($this->url);
    }
}
