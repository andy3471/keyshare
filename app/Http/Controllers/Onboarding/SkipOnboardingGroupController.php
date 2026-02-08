<?php

declare(strict_types=1);

namespace App\Http\Controllers\Onboarding;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SkipOnboardingGroupController extends Controller
{
    public function __invoke(Request $request): RedirectResponse
    {
        $request->user()->update(['onboarded_at' => now()]);

        return to_route('games.index')->with('message', 'Welcome to Sparekey!');
    }
}
