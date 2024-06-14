<?php

namespace Modules\Plan\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Plan\Database\factories\PriceplanFactory;

class Plan extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'badge' => 'boolean',
    ];

    protected static function newFactory()
    {
        return PriceplanFactory::new();
    }
}
