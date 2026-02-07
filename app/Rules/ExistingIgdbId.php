<?php

declare(strict_types=1);

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use MarcReichel\IGDBLaravel\Models\Game as IgdbGame;

class ExistingIgdbId implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $game = IgdbGame::find($value);

        if (! $game) {
            $fail('The :attribute is invalid.');
        }
    }
}
