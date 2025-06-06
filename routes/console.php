<?php

declare(strict_types=1);

use App\Console\Commands\DemoModeRefresh;
use App\Console\Commands\UpdateGames;
use Illuminate\Support\Facades\Schedule;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Schedule::command(DemoModeRefresh::class)
    ->daily();

Schedule::command(UpdateGames::class)
    ->daily();
