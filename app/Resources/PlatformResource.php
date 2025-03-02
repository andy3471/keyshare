<?php

namespace App\Resources;

use App\Models\Platform;
use Spatie\LaravelData\Resource;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class PlatformResource extends Resource
{
    public function __construct(
        public string $name,
    ) {}

    public static function fromModel(Platform $platform): static
    {
        return new static(
            name: $platform->name
        );
    }
}
