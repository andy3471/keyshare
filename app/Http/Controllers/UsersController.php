<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Users;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\DB;

class UsersController extends Controller
{
    public function index()
    {
        $karma = Redis::zrangebyscore('karma', 0, 9);

        $users = array();

        foreach ( $karma as $user) {
            $user = DB::table('users')
                    ->select('id', 'name')
                    ->where('id', '=', $user)
                    ->get();

            array_push($users, $user[0]);
        }
        return $users;
    }

    public function show($id)
    {
        return 'hello';
    }
}
