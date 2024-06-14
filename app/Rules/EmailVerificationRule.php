<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class EmailVerificationRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Check is APP KEY is Present - ref. https://botscout.com/api.htm
        if (! empty(config('app.botscout_key'))) {
            $url = 'http://botscout.com/test/?mail='.$value.'&/'.config('app.botscout_key');
        } else {
            $url = 'http://botscout.com/test/?mail='.$value;
        }
        $response = file_get_contents($url);
        $array = explode('|', $response);

        if ($array[0] == 'Y') {
            $fail('Use a valid :attribute.');
        }
    }
}
