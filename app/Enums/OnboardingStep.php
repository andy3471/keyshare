<?php

declare(strict_types=1);

namespace App\Enums;

enum OnboardingStep: string
{
    case SetCredentials  = 'set_credentials';
    case JoinGroup       = 'join_group';
    case Complete        = 'complete';

    public function isComplete(): bool
    {
        return $this === self::Complete;
    }

    /** Get the route name the user should be redirected to for this step. */
    public function routeName(): ?string
    {
        return match ($this) {
            self::SetCredentials  => 'onboarding.credentials',
            self::JoinGroup       => 'onboarding.group',
            self::Complete        => null,
        };
    }
}
