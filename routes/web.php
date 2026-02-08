<?php

declare(strict_types=1);

use App\Http\Controllers\Auth\SteamLoginController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\GroupController;
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
    Route::post('keys/{key}/feedback', [KeyController::class, 'feedback'])->name('keys.feedback');
    Route::get('keys/claimed', [KeyController::class, 'claimed'])->name('keys.claimed.index');
    Route::get('keys/shared', [KeyController::class, 'shared'])->name('keys.shared.index');
    Route::resource('keys', KeyController::class)->only(['show', 'create', 'store']);

    // TODO: We need a change password process
    Route::resource('users', UserController::class)->only(['show', 'edit', 'update']);

    Route::get('autocomplete', [SearchController::class, 'autoComplete'])->name('autocomplete');

    // Groups
    Route::resource('groups', GroupController::class);
    Route::post('groups/{group}/join', [GroupController::class, 'join'])->name('groups.join');
    Route::post('groups/{group}/leave', [GroupController::class, 'leave'])->name('groups.leave');
    Route::delete('groups/{group}/members/{user}', [GroupController::class, 'removeMember'])->name('groups.members.remove');
    Route::post('groups/{group}/regenerate-invite-code', [GroupController::class, 'regenerateInviteCode'])->name('groups.regenerate-invite-code');
    Route::post('groups/switch', [GroupController::class, 'switchGroup'])->name('groups.switch');
    Route::get('invite/{code}', [GroupController::class, 'joinViaInviteCode'])->name('groups.join-via-code');
});
