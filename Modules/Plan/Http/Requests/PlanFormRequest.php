<?php

namespace Modules\Plan\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PlanFormRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'price' => ['required', 'numeric'],
            'ad_limit' => ['required', 'numeric', 'min:1'],

            'featured_limit' => ['required', 'numeric', 'min:0'],
            'featured_duration' => ['required', 'numeric', 'min:-1'],

            'urgent_limit' => ['numeric', 'min:0'],
            'urgent_duration' => ['numeric', 'min:-1'],

            'highlight_limit' => ['numeric', 'min:0'],
            'highlight_duration' => ['numeric', 'min:-1'],

            'top_limit' => ['numeric', 'min:0'],
            'top_duration' => ['numeric', 'min:-1'],

            'bump_up_limit' => ['numeric', 'min:0'],
            'bump_up_duration' => ['numeric', 'min:-1'],

            'badge' => ['required', 'boolean'],
            'premium_member' => ['required', 'boolean'],
            'plan_payment_type' => ['required', 'string', 'in:one_time,recurring'],
            'stripe_id' => ['required_if:plan_payment_type,recurring', 'nullable', 'string'],
        ];

        if ($this->method() == 'POST') {
            $rules['label'] = ['required', 'string', 'unique:plans,label'];
        } else {
            $rules['label'] = ['required', 'string',  "unique:plans,label,{$this->plan->id}"];
        }

        return $rules;
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
