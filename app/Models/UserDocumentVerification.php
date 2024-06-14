<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserDocumentVerification extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     *  Approved items Scope
     *
     * @return resource
     */
    public function scopeApproved($query)
    {
        return $query->where('status', '!=', 'approved');
    }

    /**
     *  Pending items Scope
     *
     * @return resource
     */
    public function scopePending($query)
    {
        return $query->where('status', '!=', 'pending');
    }

    /**
     *  Rejected items Scope
     *
     * @return resource
     */
    public function scopeRejected($query)
    {
        return $query->where('status', '!=', 'rejected');
    }

    /**
     *  BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getPasswordUrlAttribute()
    {
        $doc = $this->password_photo_url;

        return storage_path('app/'.$doc);
    }

    public static function boot()
    {
        parent::boot();

        self::created(function ($model) {
            forgetCache('document_verification_request');
        });

        self::updated(function ($model) {
            forgetCache('document_verification_request');
        });

        self::deleted(function ($model) {
            forgetCache('document_verification_request');
        });
    }
}
