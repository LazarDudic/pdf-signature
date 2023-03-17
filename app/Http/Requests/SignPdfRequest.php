<?php

namespace App\Http\Requests;

use App\Rules\Base64PngImage;
use Illuminate\Foundation\Http\FormRequest;

class SignPdfRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'pdf' => ['required', 'file', 'mimes:pdf'],
            'signature' => ['required', 'string', new Base64PngImage],
        ];
    }
}
