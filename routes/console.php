<?php

declare(strict_types=1);

use App\Console\Commands\DemoModeRefresh;
use Illuminate\Support\Facades\Schedule;

Schedule::command(DemoModeRefresh::class)
    ->daily();

Schedule::command(DemoModeRefresh::class)
    ->daily();
