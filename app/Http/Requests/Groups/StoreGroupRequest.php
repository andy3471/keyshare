<?php

declare(strict_types=1);

namespace App\Http\Requests\Groups;

use Illuminate\Foundation\Http\FormRequest;

class StoreGroupRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name'        => ['required', 'string', 'max:50', 'regex:/^[^<>]*$/'],
            'description' => ['nullable', 'string', 'max:1000', 'regex:/^[^<>]*$/s'],
            'is_public'   => ['boolean'],
            'avatar'      => ['nullable', 'image', 'max:2048'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'     => 'A group name is required.',
            'name.max'          => 'The group name must not exceed 50 characters.',
            'name.regex'        => 'The group name must not contain < or > characters.',
            'description.regex' => 'The description must not contain < or > characters.',
        ];
    }
}
