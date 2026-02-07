<?php

declare(strict_types=1);

namespace App\DataTransferObjects;

use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class KeyCreateData extends Data
{
    public function __construct(
        #[DataCollectionOf(PlatformData::class)]
        public DataCollection $platforms,
    ) {}
}
