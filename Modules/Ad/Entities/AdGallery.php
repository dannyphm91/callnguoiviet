<?php

namespace Modules\Ad\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AdGallery extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $appends = ['image_url'];

    protected static function newFactory()
    {
        return \Modules\Ad\Database\factories\AdGalleryFactory::new();
    }

    public function getImageUrlAttribute()
    {
        if (is_null($this->image)) {
            return asset('backend/image/default.webp');
        }

        return asset($this->image);
    }

    /**
     *  Belongs To
     *
     * @return BelongsTo|Collection|Feature[]
     */
    public function ad(): BelongsTo
    {
        return $this->belongsTo(Ad::class);
    }
}
