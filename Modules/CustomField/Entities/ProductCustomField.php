<?php

namespace Modules\CustomField\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCustomField extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected static function newFactory()
    {
        return \Modules\CustomField\Database\factories\ProductCustomFieldFactory::new();
    }

    public function customField()
    {
        return $this->belongsTo(CustomField::class, 'custom_field_id');
    }
}
