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
        public string $icon,
    ) {}

    public static function fromModel(Platform $platform): self
    {
        return new self(
            id: $platform->id,
            name: $platform->name,
            icon: $platform->icon(),
        );
    }
}
