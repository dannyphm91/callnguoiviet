<?php

namespace Modules\Category\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryFormRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if ($this->method() === 'POST') {
            return [
                'name' => 'required|array',
                'name.en' => 'required|string',
                'image' => 'required|image|max:3072|mimes:jpeg,png,jpg',
                'icon' => 'required|string',
            ];
        } else {
            return [
                'name' => 'required|array',
                'name.en' => 'required|string',
                'image' => 'image|max:3072|mimes:jpeg,png,jpg',
                'icon' => 'required|string',
            ];
        }
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
