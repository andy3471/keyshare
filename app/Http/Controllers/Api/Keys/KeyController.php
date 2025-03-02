<?php

namespace App\Http\Controllers\Api\Keys;

use App\Http\Controllers\Controller;
use App\Resources\KeyResource;
use Illuminate\Http\JsonResponse;
use Spatie\LaravelData\PaginatedDataCollection;

class KeyController extends Controller
{
    public function claimed(): JsonResponse
    {
        return response()->json(
            KeyResource::collect(
                auth()
                    ->user()
                    ->claimedKeys()
                    ->paginate(12), PaginatedDataCollection::class)
        );
    }

    public function shared(): JsonResponse
    {
        return response()->json(
            KeyResource::collect(
                auth()
                    ->user()
                    ->sharedKeys()
                    ->paginate(12), PaginatedDataCollection::class)
        );
    }
}
