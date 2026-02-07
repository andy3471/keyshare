<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Rules\ExistingIgdbId;
use Illuminate\Foundation\Http\FormRequest;

class StoreGameKeyRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'platform_id' => ['required', 'exists:platforms,id'],
            'key'         => ['required'],
            'message'     => ['max:255'],
            'igdb_id'     => [new ExistingIgdbId()],
        ];
    }
}
