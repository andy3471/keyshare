<?php

declare(strict_types=1);

namespace App\DataTransferObjects\Games;

use App\DataTransferObjects\Keys\KeyData;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class GameShowData extends Data
{
    public function __construct(
        public GameData $game,
        #[DataCollectionOf(KeyData::class)]
        public DataCollection $keys,
        public ?int $dlcCount = null,
        public ?string $dlcUrl = null,
        public ?array $genres = null,
        public ?array $screenshots = null,
    ) {}
}
