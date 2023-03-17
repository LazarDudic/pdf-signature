<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class Base64PngImage implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $pattern = '/^data:image\/png;base64,/';
        $decoded = base64_decode(str_replace('data:image/png;base64,', '', $value));

        if (
            ! is_string($value) ||
            ! preg_match($pattern, $value) ||
            ! imagecreatefromstring($decoded)
        ) {
            $fail('The :attribute must be a valid PNG image encoded as a base64 data URI.');
        }
    }
}
