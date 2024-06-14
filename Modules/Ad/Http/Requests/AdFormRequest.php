<?php

namespace Modules\Ad\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdFormRequest extends FormRequest
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
                'title' => 'required|unique:ads,title|max:255',
                'price' => 'required|numeric',
                // 'featured' => 'sometimes',
                'category_id' => 'required',
                'subcategory_id' => 'sometimes',
                'brand_id' => 'required',
                'phone' => 'sometimes',
                'description' => 'required',
                'thumbnail' => 'required',
                'user_id' => 'required',

                'featured' => 'sometimes|boolean',
                'urgent' => 'sometimes|boolean',
                'highlight' => 'sometimes|boolean',
                'top' => 'sometimes|boolean',
                'bump_up' => 'sometimes|boolean',

            ];
        } else {
            return [
                'title' => "required|unique:ads,title,{$this->ad->id}|max:255",
                'price' => 'required|numeric',
                // 'featured' => 'sometimes',
                'category_id' => 'required',
                'subcategory_id' => 'sometimes',
                'brand_id' => 'required',
                'phone' => 'sometimes',
                'description' => 'required',
                'user_id' => 'required',

                'featured' => 'sometimes|boolean',
                'urgent' => 'sometimes|boolean',
                'highlight' => 'sometimes|boolean',
                'top' => 'sometimes|boolean',
                'bump_up' => 'sometimes|boolean',
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
