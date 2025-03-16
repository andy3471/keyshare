<?php

namespace App\Filament\SuperAdmin\Resources\PlatformResource\Pages;

use App\Filament\SuperAdmin\Resources\PlatformResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPlatform extends EditRecord
{
    protected static string $resource = PlatformResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
