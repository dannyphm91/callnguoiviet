<?php

namespace Modules\Category\Entities;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
use Modules\Ad\Entities\Ad;
use Modules\Blog\Entities\Post;
use Modules\CustomField\Entities\CustomField;

class Category extends Model implements TranslatableContract
{
    use HasFactory , Translatable;

    public $translatedAttributes = ['name'];

    protected $fillable = ['slug', 'image', 'icon', 'order', 'status'];

    protected $guarded = [];

    protected $appends = ['image_url'];

    protected $with = ['translations'];

    protected static function newFactory()
    {
        return \Modules\Category\Database\factories\CategoryFactory::new();
    }

    public static function boot()
    {
        parent::boot();

        self::created(function ($model) {
            forgetCache('footer_categories');
            forgetCache('top_categories');
            forgetCache('categories_subcategories');
        });

        self::updated(function ($model) {
            forgetCache('footer_categories');
            forgetCache('top_categories');
            forgetCache('categories_subcategories');
        });

        self::deleted(function ($model) {
            forgetCache('footer_categories');
            forgetCache('top_categories');
            forgetCache('categories_subcategories');
        });
    }

    public function getImageUrlAttribute()
    {
        if (is_null($this->image)) {
            return asset('backend/image/default-thumbnail.jpg');
        }

        return asset($this->image);
    }

    /**
     * Set the category name.
     * Set the category slug.
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
     *  Active Category scope
     *
     * @return mixed
     */
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    /**
     *  BelongTo
     *
     * @return BelongsTo|Collection|Ad[]
     */
    public function ads(): HasMany
    {
        return $this->hasMany(Ad::class, 'category_id');
    }

    public function subcategories()
    {
        return $this->hasMany(SubCategory::class);
    }

    public function posts()
    {
        return $this->hasMany(Post::class, 'category_id');
    }

    public function customFields()
    {
        return $this->belongsToMany(CustomField::class, 'category_custom_field')->withPivot('order')->oldest('order');
    }
}
