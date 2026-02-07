<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class KeyController extends Controller
{
    public function claimed(): JsonResponse
    {
        return response()->json(
            auth()
                ->user()
                ->claimedKeys()
                ->paginate(12)
        );
    }

    public function shared(): JsonResponse
    {
        return response()->json(
            auth()
                ->user()
                ->sharedKeys()
                ->paginate(12)
        );
    }
}
