<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Cashier\Billable;
use Modules\Ad\Entities\Ad;
use Modules\PushNotification\Entities\UserDeviceToken;

class User extends Authenticatable implements MustVerifyEmail
{
    use Billable, HasFactory, Notifiable, SoftDeletes;

    protected $guarded = [];

    protected $dates = ['deleted_at'];

    protected $appends = ['image_url'];

    protected $guard = 'user';

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::created(function ($customer) {
            $customer->userPlan()->create([
                'ad_limit' => 0,
                'featured_limit' => 0,
            ]);
        });
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['username'] = Str::slug($value).'_'.time();
    }

    public function getImageUrlAttribute()
    {
        if (is_null($this->image)) {
            return asset('backend/image/default-user.png');
        }

        return asset($this->image);
    }

    /**
     *  HasMany
     *
     * @return HasMany|Collection|Customer
     */
    public function ads(): HasMany
    {
        return $this->hasMany(Ad::class);
    }

    /**
     * User Pricing Plan
     */
    public function userPlan(): HasOne
    {
        return $this->hasOne(UserPlan::class);
    }

    /**
     * User Transactions
     */
    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function reviews()
    {
        return $this->hasMany(User::class, 'user_id');
    }

    public function socialMedia()
    {
        return $this->hasMany(SocialMedia::class, 'user_id');
    }

    public function deviceToken()
    {
        return $this->hasMany(UserDeviceToken::class, 'user_id', 'id');
    }

    /**
     *  HasOne
     *
     * @return hasOne|Collection|Document_Verified
     */
    public function document_verified(): HasOne
    {
        return $this->hasOne(UserDocumentVerification::class, 'user_id');
    }

    public function affiliate()
    {
        return $this->hasOne(Affiliate::class);
    }

    public function affiliateInvites()
    {
        return $this->hasMany(AffiliateInvite::class);
    }
}
