<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name'     => ['required', 'string', 'max:50', 'regex:/^[^<>]*$/'],
            'bio'      => ['nullable', 'string', 'max:1000', 'regex:/^[^<>]*$/s'],
            'avatar'   => ['nullable', 'image', 'max:1999', 'dimensions:ratio=1/1'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.regex' => 'Your name must not contain < or > characters.',
            'bio.regex'  => 'Your bio must not contain < or > characters.',
        ];
    }
}
