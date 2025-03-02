<?php

namespace App\Http\Controllers\Web\LinkedAccounts;

class SteamLinkedAccountController extends LinkedAccountController
{
    public function driver(): string
    {
        return 'steam';
    }
}
