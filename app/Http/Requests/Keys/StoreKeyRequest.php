<?php

namespace App\Http\Requests\Keys;

use Illuminate\Foundation\Http\FormRequest;

class StoreKeyRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, array<int, \Illuminate\Contracts\Validation\Rule|array|string>>
     */
    public function rules(): array
    {
        return [
            'key_type' => 'required',
            'platform_id' => 'required',
            'key' => 'required',
            'message' => 'max:255',
            'gamename' => 'required',
        ];
    }
}
