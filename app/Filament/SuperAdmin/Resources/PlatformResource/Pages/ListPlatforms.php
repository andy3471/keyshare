<?php

namespace App\Filament\SuperAdmin\Resources\PlatformResource\Pages;

use App\Filament\SuperAdmin\Resources\PlatformResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPlatforms extends ListRecords
{
    protected static string $resource = PlatformResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
