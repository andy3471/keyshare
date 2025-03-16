<?php

namespace App\Http\Controllers\WebApi\Platforms;

use App\Http\Controllers\Controller;
use App\Models\Platform;
use App\Resources\PlatformResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;

class PlatformController extends Controller
{
    // TODO: Cache this on te model
    // TODO: Only return require attributes
    public function index(): JsonResponse
    {
        $platforms = Cache::remember('platforms:all', 3600, function (): array|\Illuminate\Contracts\Pagination\CursorPaginator|\Illuminate\Contracts\Pagination\Paginator|\Illuminate\Pagination\AbstractCursorPaginator|\Illuminate\Pagination\AbstractPaginator|\Illuminate\Support\Enumerable|\Spatie\LaravelData\CursorPaginatedDataCollection|\Spatie\LaravelData\DataCollection|\Spatie\LaravelData\PaginatedDataCollection {
            return PlatformResource::collect(Platform::all());
        });

        return response()->json($platforms);
    }

    public function show(Platform $platform): JsonResponse
    {
        return response()->json(PlatformResource::from($platform));
    }
}
