<?php

namespace App\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;

class DocumentVerifyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'image' => 'nullable|image',
            'name' => 'required|string',
            'email' => 'required|email',
            'passport' => 'required|mimes:zip,7zip,rar,jpg,jpeg,png,svg,docs,pdf,xls,xlsx,ppt',
        ];
    }

    public function messages()
    {
        return [
            'passport.required' => 'The voter id / passport / driver license field is required.',
            'passport.mimes' => 'The voter id / passport / driver license field must be zip,7zip,rar,jpg,jpeg,png,svg,docs,pdf,xls,xlsx,ppt.',
        ];
    }
}
