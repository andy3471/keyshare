<?php

declare(strict_types=1);

namespace App\Http\Controllers\Keys;

use App\DataTransferObjects\Keys\KeyData;
use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response;

class ListSharedKeysController extends Controller
{
    public function __invoke(): Response
    {
        auth()->user()->loadMissing(['media', 'groups']);

        return Inertia::render('Keys/Shared', [
            'keys' => Inertia::scroll(fn (): \Spatie\LaravelData\DataCollection|\Spatie\LaravelData\PaginatedDataCollection|\Spatie\LaravelData\CursorPaginatedDataCollection|\Illuminate\Support\Enumerable|\Illuminate\Pagination\AbstractPaginator|\Illuminate\Contracts\Pagination\Paginator|\Illuminate\Pagination\AbstractCursorPaginator|\Illuminate\Contracts\Pagination\CursorPaginator|array => KeyData::collect(
                auth()
                    ->user()
                    ->sharedKeys()
                    ->with(['game', 'platform', 'group.media', 'claimedUser.media'])
                    ->latest()
                    ->paginate(12)
            )),
        ]);
    }
}
