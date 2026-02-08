<?php

declare(strict_types=1);

namespace App\Enums;

use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
enum KeyFeedback: string
{
    case Worked      = 'worked';
    case DidNotWork  = 'did_not_work';

    public function isNegative(): bool
    {
        return $this === self::DidNotWork;
    }
}
