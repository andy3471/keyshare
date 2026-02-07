<?php

declare(strict_types=1);

namespace App\DataTransferObjects;

use Spatie\LaravelData\Data;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class GameShowData extends Data
{
    public function __construct(
        public GameData $game,
        /** @var KeyData[] */
        public array $keys,
        public ?int $dlcCount = null,
        public ?string $dlcUrl = null,
        public ?array $igdb = null,
        public ?array $genres = null,
        public ?array $screenshots = null,
    ) {}
}
