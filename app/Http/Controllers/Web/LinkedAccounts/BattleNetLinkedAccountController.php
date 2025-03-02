<?php

namespace App\Http\Controllers\Web\LinkedAccounts;

class BattleNetLinkedAccountController extends LinkedAccountController
{
    public function driver(): string
    {
        return 'battlenet';
    }
}
