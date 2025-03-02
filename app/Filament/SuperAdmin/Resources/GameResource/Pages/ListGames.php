<?php

namespace App\Filament\SuperAdmin\Resources\GameResource\Pages;

use App\Filament\SuperAdmin\Resources\GameResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListGames extends ListRecords
{
    protected static string $resource = GameResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
