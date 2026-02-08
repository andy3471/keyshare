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
        public bool $feedback,
        public ?ClaimDeniedReason $claimDeniedReason = null,
    ) {}

    public static function fromModel(Key $key): self
    {
        $user              = auth()->user();
        $policy            = new KeyPolicy;
        $claimDeniedReason = $user ? $policy->claimDeniedReason($user, $key) : null;

        return new self(
            view: Gate::allows('view', $key),
            claim: ! $claimDeniedReason instanceof ClaimDeniedReason,
            feedback: Gate::allows('feedback', $key),
            claimDeniedReason: $claimDeniedReason,
        );
    }
}
