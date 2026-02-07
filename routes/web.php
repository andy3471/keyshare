<?php

declare(strict_types=1);

// TODO: Tidy these routes up
use App\Http\Controllers\Auth\SteamLoginController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KeyController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\UserController;

Auth::routes();

// TODO: These should not be routes
Route::get('not-approved', [HomeController::class, 'notApproved'])->name('auth.not-approved');
Route::get('demo', [HomeController::class, 'demo'])->name('auth.demo-mode');

Route::middleware(['steamlogin'])->group(function (): void {
    Route::get('login/steam', [SteamLoginController::class, 'redirect'])
        ->name('login.linked-account.steam');

    Route::get('login/steam/callback', [SteamLoginController::class, 'callback'])
        ->name('login.linked-account.steam.callback');
});

Route::middleware(['auth', 'approved'])->group(function (): void {
    Route::get('/', [HomeController::class, 'index'])->name('index');

    Route::get('search', [SearchController::class, 'index'])->name('search.index');

    Route::get('games', [GameController::class, 'index'])->name('games.index');
    Route::get('game/{igdb_id}', [GameController::class, 'show'])->name('games.show');

    Route::resource('keys', KeyController::class)->only(['show', 'create', 'store']);
    Route::post('keys/claim', [KeyController::class, 'claim'])->name('keys.claim');
    Route::get('my/claimed-keys', [KeyController::class, 'claimed'])->name('keys.claimed.index');
    Route::get('my/shared-keys', [KeyController::class, 'shared'])->name('keys.shared.index');

    Route::resource('users', UserController::class)->only(['index', 'show', 'edit', 'update']);

    // TODO: change these routes
    Route::get('change-password', [UserController::class, 'passwordResetPage'])
        ->name('password.reset.request')
        ->middleware('demomode');

    Route::post('change-password', [UserController::class, 'passwordResetSave'])
        ->name('password.reset.save')
        ->middleware('demomode');

    // Autocomplete routes (return JSON for autocomplete component)
    Route::get('autocomplete/games', [SearchController::class, 'autoCompleteGames'])->name('autocomplete.games');
    Route::get('autocomplete/dlc/{gamename}', [SearchController::class, 'autoCompleteDlc'])->name('autocomplete.dlc');
});
