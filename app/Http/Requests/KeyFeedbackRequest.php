<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Enums\KeyFeedback;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class KeyFeedbackRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'feedback' => ['required', Rule::enum(KeyFeedback::class)],
        ];
    }
}
