<?php

namespace App\Http\Controllers\Web\LinkedAccounts;

class DiscordLinkedAccountController extends LinkedAccountController
{
    public function driver(): string
    {
        return 'discord';
    }
}
