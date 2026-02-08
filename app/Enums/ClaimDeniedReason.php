<?php

declare(strict_types=1);

namespace App\Enums;

use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
enum ClaimDeniedReason: string
{
    case AlreadyClaimed  = 'already_claimed';
    case OwnKey          = 'own_key';
    case NotInGroup      = 'not_in_group';
    case KarmaTooLow     = 'karma_too_low';
    case CooldownActive  = 'cooldown_active';
    case AlreadyOwnsGame = 'already_owns_game';
}
