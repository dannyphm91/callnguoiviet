<?php

namespace Modules\CustomField\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class CustomFieldGroup extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'order'];

    protected static function newFactory()
    {
        return \Modules\CustomField\Database\factories\CustomFieldGroupFactory::new();
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    public function customFields()
    {
        return $this->hasMany(CustomField::class, 'custom_field_group_id');
    }
}
