<?php

namespace App\Filament\SuperAdmin\Resources\UserResource\Pages;

use App\Filament\SuperAdmin\Resources\UserResource;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;
}
