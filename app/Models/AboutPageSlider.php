<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutPageSlider extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function getImageUrlAttribute()
    {
        if (is_null($this->url)) {
            return asset('frontend/images/about-slider-img/img-01.png');
        }

        return asset($this->url);
    }
}
