<?php

declare(strict_types=1);

namespace App\DataTransferObjects\Keys;

use App\DataTransferObjects\Games\GameData;
use App\DataTransferObjects\Platforms\PlatformData;
use App\DataTransferObjects\Users\UserData;
use App\Models\Key;
use Illuminate\Support\Facades\Gate;
use Spatie\LaravelData\Data;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class KeyCanData extends Data
{
    public function __construct(
        public bool $view,
        public bool $claim,
    ) {}

    public static function fromModel(Key $key): self
    {
        return new self(
            view: Gate::allows('view', $key),
            claim: Gate::allows('claim', $key),
        );
    }
}
