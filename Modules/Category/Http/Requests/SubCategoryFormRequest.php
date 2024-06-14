<?php

namespace Modules\Category\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Language\Entities\Language;

class SubCategoryFormRequest extends FormRequest
{
    protected $locales;

    public function __construct()
    {
        parent::__construct();
        $this->locales = Language::orderBy('created_at', 'asc')->get();
    }

    public function rules()
    {
        $rules = [
            'category_id' => 'required',
        ];

        foreach ($this->locales ?? [] as $locale) {
            $rules["name.{$locale->code}"] = 'required|max:255';
        }

        return $rules;
    }

    public function messages()
    {
        $messages = [
            'category_id.required' => 'The category field is required.',
        ];

        foreach ($this->locales as $locale) {
            $messages["name.{$locale->code}.required"] = "The subcategory name is required for the language {$locale->name}.";
            $messages["name.{$locale->code}.max"] = "The subcategory name for the language {$locale->name} must not exceed the maximum character limit of 255.";
        }

        return $messages;
    }

    public function authorize()
    {
        return true;
    }
}
