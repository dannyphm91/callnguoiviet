<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Ad\Entities\Ad;

class ResubmissionGallery extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function ads(): BelongsTo
    {
        return $this->belongsTo(Ad::class, 'id');
    }
}
