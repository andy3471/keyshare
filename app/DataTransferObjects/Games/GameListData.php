<?php

declare(strict_types=1);

namespace App\DataTransferObjects\Games;

use Spatie\LaravelData\Data;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class GameListData extends Data
{
    public function __construct(
        public string $title,
        public string $url,
    ) {}
}
