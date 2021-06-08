<?php

namespace App\Http\Controllers;

use App\Models\Platform;
use Inertia\Inertia;

class PlatformController extends Controller
{
    /**
     * @param $id
     * @return \Inertia\Response
     */
    public function show($id)
    {
        $platform = Platform::find($id);

        return Inertia::render('Games', [
            'url' => '/platform/get/' . $id,
            'title' => $platform->name,
        ]);
    }

    // TODO make API routes
    /**
     * @param $id
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getPlatform($id)
    {
        // TODO this function is a little dirty.
        return Platform::getPlatformWithKeys($id);
    }
}
