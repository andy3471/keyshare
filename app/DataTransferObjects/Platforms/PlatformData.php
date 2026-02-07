<?php

declare(strict_types=1);

namespace App\DataTransferObjects\Platforms;

use App\Models\Platform;
use Spatie\LaravelData\Data;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class PlatformData extends Data
{
    public function __construct(
        public string $id,
        public string $name,
    ) {}

    public static function fromModel(Platform $platform): self
    {
        return new self(
            id: (string) $platform->id,
            name: $platform->name,
        );
    }
}
