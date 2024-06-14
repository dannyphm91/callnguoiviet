<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
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
            'plan' => 'required',
            'user' => 'required',
            'payment_provider' => 'required',
            'amount' => 'required',
            'currency_symbol' => 'required',
            'usd_amount' => 'required',
            'payment_status' => 'required',
        ];
    }
}
