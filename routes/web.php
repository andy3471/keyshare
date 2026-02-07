<?php

declare(strict_types=1);

use App\Http\Controllers\Auth\SteamLoginController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\KeyController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WelcomeController;

Route::get('/', WelcomeController::class)->name('welcome');

Auth::routes();

Route::middleware(['steamlogin'])->group(function (): void {
    Route::get('login/steam', [SteamLoginController::class, 'redirect'])
        ->name('login.linked-account.steam');

    Route::get('login/steam/callback', [SteamLoginController::class, 'callback'])
        ->name('login.linked-account.steam.callback');
});

Route::middleware(['auth'])->group(function (): void {
    Route::get('games', [GameController::class, 'index'])->name('games.index');
    Route::get('games/{igdb_id}', [GameController::class, 'show'])->name('games.show');

    Route::get('search', [SearchController::class, 'index'])->name('search.index');

    Route::post('keys/{key}/claim', [KeyController::class, 'claim'])->name('keys.claim');
    Route::get('keys/claimed', [KeyController::class, 'claimed'])->name('keys.claimed.index');
    Route::get('keys/shared', [KeyController::class, 'shared'])->name('keys.shared.index');
    Route::resource('keys', KeyController::class)->only(['show', 'create', 'store']);

    // TODO: We need a change password process
    Route::resource('users', UserController::class)->only(['show', 'edit', 'update']);

    Route::get('autocomplete', [SearchController::class, 'autoComplete'])->name('autocomplete');
});
