<?php

declare(strict_types=1);

namespace App\DataTransferObjects\Keys;

use App\Enums\ClaimDeniedReason;
use App\Models\Key;
use App\Policies\KeyPolicy;
use Illuminate\Support\Facades\Gate;
use Spatie\LaravelData\Data;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class KeyCanData extends Data
{
    public function __construct(
        public bool $view,
        public bool $claim,
        public bool $delete,
        public bool $feedback,
        public ?ClaimDeniedReason $claimDeniedReason = null,
        public ?string $cooldownEndsAt = null,
    ) {}

    public static function fromModel(Key $key): self
    {
        $user              = auth()->user();
        $policy            = new KeyPolicy;
        $claimDeniedReason = $user ? $policy->claimDeniedReason($user, $key) : null;

        $cooldownEndsAt = null;

        if ($claimDeniedReason === ClaimDeniedReason::CooldownActive && $user && $key->group) {
            $cooldownEndsAt = $policy->cooldownEndsAt($user, $key->group)?->toIso8601String();
        }

        return new self(
            view: Gate::allows('view', $key),
            claim: ! $claimDeniedReason instanceof ClaimDeniedReason,
            delete: Gate::allows('delete', $key),
            feedback: Gate::allows('feedback', $key),
            claimDeniedReason: $claimDeniedReason,
            cooldownEndsAt: $cooldownEndsAt,
        );
    }
}
