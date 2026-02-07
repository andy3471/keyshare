<?php

declare(strict_types=1);

namespace App\DataTransferObjects;

use Spatie\LaravelData\Data;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class KeyCreateData extends Data
{
    public function __construct(
        /** @var PlatformData[] */
        public array $platforms,
    ) {}
}
