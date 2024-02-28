<?php

// TODO: Tidy these routes up
use App\Http\Controllers\Front\Auth\SteamLoginController;
use App\Http\Controllers\Front\DlcController;
use App\Http\Controllers\Front\GameController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\KeyController;
use App\Http\Controllers\Front\PlatformController;
use App\Http\Controllers\Front\SearchController;
use App\Http\Controllers\Front\UserController;

Auth::routes();

// TODO: These should not be routes
Route::get('not-approved', [HomeController::class, 'notApproved'])->name('auth.not-approved');
Route::get('demo', [HomeController::class, 'demo'])->name('auth.demo-mode');

Route::middleware(['steamlogin'])->group(function () {
    Route::get('login/steam', [SteamLoginController::class, 'redirect'])
        ->name('login.linked-account.steam');

    Route::get('login/steam/callback', [SteamLoginController::class, 'callback'])
        ->name('login.linked-account.steam.callback');
});

Route::middleware(['auth', 'approved'])->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('index');

    Route::get('search', [SearchController::class, 'index'])->name('search.index');

    Route::resource('games', GameController::class)->only(['index', 'show']);

    Route::resource('keys', KeyController::class)->only(['show', 'create', 'store']);
    Route::post('keys/claim', [KeyController::class, 'claim'])->name('keys.claim');
    Route::get('my/claimed-keys', [KeyController::class, 'claimed'])->name('keys.claimed.index');
    Route::get('my/shared-keys', [KeyController::class, 'shared'])->name('keys.shared.index');

    Route::resource('users', UserController::class)->only(['index', 'show', 'edit', 'update']);

    // TODO: change these routes
    Route::get('change-password', [UserController::class, 'passwordResetPage'])
        ->name('password.reset')
        ->middleware('demomode');

    Route::post('change-password', [UserController::class, 'passwordResetSave'])
        ->name('password.reset.save')
        ->middleware('demomode');

    Route::resource('platforms', PlatformController::class)->only(['show']);
    Route::resource('dlc', DlcController::class)->only(['show']);
});
