<?php

namespace Modules\Testimonial\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $appends = ['image_url'];

    protected static function newFactory()
    {
        return \Modules\Testimonial\Database\factories\TestimonialFactory::new();
    }

    public function getImageUrlAttribute()
    {
        if (is_null($this->image)) {
            return asset('backend/image/default-user.png');
        }

        return asset($this->image);
    }
}
