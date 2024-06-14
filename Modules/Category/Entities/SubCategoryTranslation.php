<?php

namespace Modules\Category\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategoryTranslation extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['name'];

    protected static function newFactory()
    {
        return \Modules\Category\Database\factories\SubCategoryTranslationFactory::new();
    }
}
