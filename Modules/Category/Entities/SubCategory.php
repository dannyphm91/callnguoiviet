<?php

namespace Modules\Category\Entities;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
use Modules\Ad\Entities\Ad;

class SubCategory extends Model implements TranslatableContract
{
    use HasFactory, Translatable;

    public $translatedAttributes = ['name'];

    protected $with = ['translations'];

    protected $fillable = [
        'category_id',
        'slug',
    ];

    /**
     *  Active Subcategory scope
     *
     * @return mixed
     */
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    protected static function newFactory()
    {
        return \Modules\Category\Database\factories\SubCategoryFactory::new();
    }

    /**
     * Set the subcategory name.
     * Set the subcategory slug.
     *
     * @param  string  $value
     * @return void
     */
    public function setNameAttribute($name)
    {
        $this->attributes['name'] = $name;
        $this->attributes['slug'] = Str::slug($name);
    }

    /**
     * Set the sub category slug.
     *
     * @param  string  $slug
     * @return void
     */
    public function setSlugAttribute($slug)
    {
        $value_slug = Str::slug($slug);
        $is_exists = SubCategory::whereSlug($value_slug)->where('id', '!=', $this->id)->exists();

        if ($is_exists) {
            $this->attributes['slug'] = $value_slug.'-'.uniqid();
        } else {
            $this->attributes['slug'] = $value_slug;
        }
    }

    public function ads(): HasMany
    {
        return $this->hasMany(Ad::class, 'subcategory_id');
    }
}
