<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Seo extends Model
{
    use HasFactory;

    protected $guarded = [];

    // mutator
    public function setPageSlugAttribute($value)
    {
        $this->attributes['page_slug'] = Str::slug($value);
    }

    /**
     * One to Many relationship with page content model to get page contents
     */
    public function contents()
    {
        return $this->hasMany(SeoPageContent::class, 'page_id', 'id');
    }
}
