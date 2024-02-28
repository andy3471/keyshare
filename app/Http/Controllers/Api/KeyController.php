<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class KeyController extends Controller
{
    public function claimed(): JsonResponse
    {
        $keys = auth()->user()->claimedKeys()->paginate(12);

        return response()->json($keys);
    }

    public function shared(): JsonResponse
    {
        $keys = auth()->user()->sharedKeys()->paginate(12);

        return response()->json($keys);
    }
}
