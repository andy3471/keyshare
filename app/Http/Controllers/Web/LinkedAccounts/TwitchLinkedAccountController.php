<?php

namespace App\Http\Controllers\Web\LinkedAccounts;

class TwitchLinkedAccountController extends LinkedAccountController
{
    public function driver(): string
    {
        return 'twitch';
    }
}
