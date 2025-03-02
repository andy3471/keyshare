<?php

use App\Http\Controllers\Web\Games\GameController;
use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Web\Keys\KeyController;
use App\Http\Controllers\Web\Platforms\PlatformController;
use App\Http\Controllers\Web\Search\SearchController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'home'])->name('home');

Route::middleware(['auth', 'verified'])->group(function (): void {
    Route::get('dashboard', [HomeController::class, 'dashboard'])->name('dashboard');

    Route::get('search', [SearchController::class, 'index'])->name('search.index');

    Route::resource('games', GameController::class)->only(['index', 'show']);

    Route::resource('keys', KeyController::class)->only(['show', 'create', 'store']);
    Route::post('keys/claim', [KeyController::class, 'claim'])->name('keys.claim');
    Route::get('my/claimed-keys', [KeyController::class, 'claimed'])->name('keys.claimed.index');
    Route::get('my/shared-keys', [KeyController::class, 'shared'])->name('keys.shared.index');

    Route::resource('platforms', PlatformController::class)->only(['show']);
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
