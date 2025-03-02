<?php

namespace App\Http\Controllers\Web\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class LinkedAccountsController extends Controller
{
    public function edit(Request $request): Response
    {
        return Inertia::render('settings/LinkedAccounts');
    }
}
