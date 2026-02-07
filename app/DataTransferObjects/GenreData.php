<?php

declare(strict_types=1);

namespace App\DataTransferObjects;

use MarcReichel\IGDBLaravel\Models\Genre;
use Spatie\LaravelData\Data;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class GenreData extends Data
{
    public function __construct(
        public int $id,
        public string $name,
    ) {}

    public static function fromIgdb(Genre $genre): self
    {
        return new self(
            id: $genre->id,
            name: $genre->name,
        );
    }
}
