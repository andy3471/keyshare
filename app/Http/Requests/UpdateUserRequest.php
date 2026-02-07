<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name'  => ['required'],
            'image' => ['image', 'nullable', 'max:1999', 'dimensions:ratio=1/1'],
            'bio'   => ['nullable'],
        ];
    }
}
