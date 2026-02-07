<?php

declare(strict_types=1);

namespace App\DataTransferObjects;

use MarcReichel\IGDBLaravel\Models\Screenshot;
use Spatie\LaravelData\Data;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class ScreenshotData extends Data
{
    public function __construct(
        public int $id,
        public string $image_id,
    ) {}

    public static function fromIgdb(Screenshot $screenshot): self
    {
        return new self(
            id: $screenshot->id,
            image_id: $screenshot->image_id,
        );
    }
}
