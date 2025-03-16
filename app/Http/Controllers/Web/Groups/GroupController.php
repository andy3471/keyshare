<?php

namespace App\Http\Controllers\Web\Groups;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response;

class GroupController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('groups/IndexGroups');
    }
}
