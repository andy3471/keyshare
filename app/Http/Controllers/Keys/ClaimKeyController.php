<?php

declare(strict_types=1);

namespace App\Http\Controllers\Keys;

use App\Http\Controllers\Controller;
use App\Models\Key;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ClaimKeyController extends Controller
{
    public function __invoke(Request $request, Key $key): RedirectResponse
    {
        $this->authorize('claim', $key);

        $key->claim(auth()->user());

        return back()->with('message', __('keys.claimsuccess'));
    }
}
