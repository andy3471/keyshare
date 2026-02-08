<?php

declare(strict_types=1);

use App\Http\Controllers\Auth\HandleSteamCallbackController;
use App\Http\Controllers\Auth\RedirectToSteamController;
use App\Http\Controllers\Games\GameController;
use App\Http\Controllers\Groups\AcceptGroupInviteController;
use App\Http\Controllers\Groups\GroupController;
use App\Http\Controllers\Groups\JoinGroupController;
use App\Http\Controllers\Groups\LeaveGroupController;
use App\Http\Controllers\Groups\RegenerateGroupInviteCodeController;
use App\Http\Controllers\Groups\RemoveGroupMemberController;
use App\Http\Controllers\Groups\SwitchGroupController;
use App\Http\Controllers\Keys\ClaimKeyController;
use App\Http\Controllers\Keys\KeyController;
use App\Http\Controllers\Keys\ListClaimedKeysController;
use App\Http\Controllers\Keys\ListSharedKeysController;
use App\Http\Controllers\Keys\SubmitKeyFeedbackController;
use App\Http\Controllers\Search\AutocompleteSearchController;
use App\Http\Controllers\Search\SearchController;
use App\Http\Controllers\Users\UserController;
use App\Http\Controllers\WelcomeController;

Route::get('/', WelcomeController::class)->name('welcome');

Auth::routes();

Route::middleware(['steamlogin'])->group(function (): void {
    Route::get('login/steam', RedirectToSteamController::class)
        ->name('login.linked-account.steam');

    Route::get('login/steam/callback', HandleSteamCallbackController::class)
        ->name('login.linked-account.steam.callback');
});

Route::middleware(['auth'])->group(function (): void {
    Route::get('games', [GameController::class, 'index'])->name('games.index');
    Route::get('games/{igdb_id}', [GameController::class, 'show'])->name('games.show');

    Route::get('search', SearchController::class)->name('search.index');

    Route::post('keys/{key}/claim', ClaimKeyController::class)->name('keys.claim');
    Route::post('keys/{key}/feedback', SubmitKeyFeedbackController::class)->name('keys.feedback');
    Route::get('keys/claimed', ListClaimedKeysController::class)->name('keys.claimed.index');
    Route::get('keys/shared', ListSharedKeysController::class)->name('keys.shared.index');
    Route::resource('keys', KeyController::class)->only(['show', 'create', 'store']);

    // TODO: We need a change password process
    Route::resource('users', UserController::class)->only(['show', 'edit', 'update']);

    Route::get('autocomplete', AutocompleteSearchController::class)->name('autocomplete');

    // Groups
    Route::resource('groups', GroupController::class);
    Route::post('groups/{group}/join', JoinGroupController::class)->name('groups.join');
    Route::post('groups/{group}/leave', LeaveGroupController::class)->name('groups.leave');
    Route::delete('groups/{group}/members/{user}', RemoveGroupMemberController::class)->name('groups.members.remove');
    Route::post('groups/{group}/regenerate-invite-code', RegenerateGroupInviteCodeController::class)->name('groups.regenerate-invite-code');
    Route::post('groups/switch', SwitchGroupController::class)->name('groups.switch');
    Route::get('invite/{code}', AcceptGroupInviteController::class)->name('groups.join-via-code');
});
