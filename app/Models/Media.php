<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Spatie\MediaLibrary\MediaCollections\Models\Media as BaseMedia;

class Media extends BaseMedia
{
    /** @return Attribute<string, never> */
    protected function uuid(): Attribute
    {
        return Attribute::make(
            get: fn (): string => $this->id
        );
    }
}
