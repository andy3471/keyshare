<?php

namespace App\Http\Controllers\Web\LinkedAccounts;

class MicrosoftLinkedAccountController extends LinkedAccountController
{
    public function driver(): string
    {
        return 'microsoft';
    }
}
