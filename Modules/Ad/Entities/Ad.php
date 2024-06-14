<?php

namespace Modules\Ad\Entities;

use App\Enum\Job\JobStatus;
use App\Models\ResubmissionGallery;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Ad\Database\factories\AdFactory;
use Modules\Brand\Entities\Brand;
use Modules\Category\Entities\Category;
use Modules\Category\Entities\SubCategory;
use Modules\CustomField\Entities\ProductCustomField;
use Modules\Wishlist\Entities\Wishlist;

class Ad extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $appends = ['image_url'];

    protected $casts = [
        'wishlisted' => 'boolean',
        'show_phone' => 'boolean',
        'featured_at' => 'datetime',
        'urgent_at' => 'datetime',
        'highlight_at' => 'datetime',
        'top_at' => 'datetime',
        'bump_up_at' => 'datetime',
        'featured_till' => 'datetime',
        'urgent_till' => 'datetime',
        'highlight_till' => 'datetime',
        'top_till' => 'datetime',
        'bump_up_till' => 'datetime',
    ];

    public static function boot()
    {
        parent::boot();

        self::created(function ($model) {
            forgetCache('min_price');
            forgetCache('max_price');
        });

        self::updated(function ($model) {
            forgetCache('min_price');
            forgetCache('max_price');
        });

        self::deleted(function ($model) {
            forgetCache('min_price');
            forgetCache('max_price');
        });
    }

    protected static function newFactory()
    {
        return AdFactory::new();
    }

    public function getImageUrlAttribute()
    {
        if (is_null($this->thumbnail)) {
            return asset('backend/image/default.webp');
        }

        return asset($this->thumbnail);
    }

    /**
     *  My ads scope
     *
     * @return mixed
     */
    public function scopeMyAds($query)
    {
        return $query->where('user_id', auth('user')->id());
    }

    /**
     *  Customer scope
     *
     * @return mixed
     */
    public function scopeCustomerData($query, $api = false)
    {
        if ($api) {
            return $query->where('user_id', auth('api')->id());
        } else {
            return $query->where('user_id', auth('user')->id());
        }
    }

    /**
     *  Active ad scope
     *
     * @return mixed
     */
    public function scopeActive($query)
    {
        return $query->where('status', JobStatus::ACTIVE->value);
    }

    /**
     *  Active Category scope
     *
     * @return mixed
     */
    public function scopeActiveCategory($query)
    {
        return $query->whereHas('category', function ($q) {
            $q->where('status', 1);
        });
    }

    /**
     *  Active Category scope
     *
     * @return mixed
     */
    public function scopeActiveSubcategory($query)
    {
        return $query->whereHas('subcategory', function ($q) {
            $q->where('status', 1);
        });
    }

    /**
     *  Inactive Category scope
     *
     * @return mixed
     */
    public function scopeInactiveCategory($query)
    {
        return $query->whereHas('category', function ($q) {
            $q->where('status', 0);
        });
    }

    /**
     *  Featured ad scope
     *
     * @return mixed
     */
    public function scopeFeatured($query)
    {
        return $query->whereFeatured(true)->whereNotNull('featured_at');
    }

    /**
     *  Featured ad scope
     *
     * @return mixed
     */
    public function scopeUrgent($query)
    {
        return $query->whereUrgent(true)->whereNotNull('urgent_at');
    }

    /**
     * Highlight ad scope
     *
     * @return mixed
     */
    public function scopeHighlight($query)
    {
        return $query->whereHighlight(true)->whereNotNull('highlight_at');
    }

    /**
     * Top ad scope
     *
     * @return mixed
     */
    public function scopeTop($query)
    {
        return $query->whereTop(true)->whereNotNull('top_at');
    }

    /**
     * Bump up ad scope
     *
     * @return mixed
     */
    public function scopeBumpUp($query)
    {
        return $query->whereBumpUp(true)->whereNotNull('bump_up_at');
    }

    /**
     *  Make job drafted
     *
     * @return mixed
     */
    public function makeDraft(?int $user_id = null)
    {
        $this->status = JobStatus::DRAFT->value;
        $this->user_id = $user_id ?? auth('user')->id();
        $this->drafted_at = Carbon::now();

        return $this->save();
    }

    /**
     *  BelongTo
     *
     * @return BelongsTo|Collection|Category[]
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     *  BelongTo
     *
     * @return BelongsTo|Collection|Category[]
     */
    public function subcategory(): BelongsTo
    {
        return $this->belongsTo(SubCategory::class);
    }

    /**
     *  BelongTo
     *
     * @return BelongsTo|Collection|Customer[]
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     *  Has Many
     *
     * @return HasMany|Collection|AdGallery[]
     */
    public function galleries(): HasMany
    {
        return $this->hasMany(AdGallery::class);
    }

    /**
     *  BelongTo
     *
     * @return BelongsTo|Collection|Customer[]
     */
    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class, 'ad_id');
    }

    public function adFeatures()
    {
        return $this->hasMany(AdFeature::class, 'ad_id');
    }

    public function productCustomFields()
    {
        return $this->hasMany(ProductCustomField::class, 'ad_id')->oldest('order')->with('customField.values', 'customField.customFieldGroup');
    }

    public function resubmissionGalleries()
    {
        return $this->hasMany(ResubmissionGallery::class, 'ad_id');
    }
}
