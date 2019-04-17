<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Users;
use Illuminate\Support\Facades\Redis;

class UsersController extends Controller
{
    public function index()
    {
        $topusers = Redis::zrangebyscore('karma', 0, 10);

        return $topusers;
    }

    public function show($id)
    {
        return 'hello';
    }
}
