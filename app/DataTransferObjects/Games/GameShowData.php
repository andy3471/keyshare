<?php

declare(strict_types=1);

namespace App\DataTransferObjects\Games;

use App\DataTransferObjects\Keys\KeyData;
use Spatie\LaravelData\Data;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class GameShowData extends Data
{
    /**
     * @param  KeyData[]  $keys
     * @param  GenreData[]|null  $genres
     * @param  ScreenshotData[]|null  $screenshots
     */
    public function __construct(
        public GameData $game,
        public array $keys,
        public ?int $dlcCount = null,
        public ?string $dlcUrl = null,
        public ?array $genres = null,
        public ?array $screenshots = null,
    ) {}
}
