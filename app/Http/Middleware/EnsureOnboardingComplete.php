<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Enums\OnboardingStep;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureOnboardingComplete
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user) {
            return $next($request);
        }

        $step = $user->onboardingStep();

        if ($step->isComplete()) {
            return $next($request);
        }

        // Avoid redirect loops -- don't redirect if already on an onboarding route
        if ($request->routeIs('onboarding.*')) {
            return $next($request);
        }

        // Allow group routes during the JoinGroup step so users can join/create groups
        if ($step === OnboardingStep::JoinGroup && $request->routeIs('groups.*')) {
            return $next($request);
        }

        return to_route($step->routeName());
    }
}
