<?php

use App\Http\Controllers\Web\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Web\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Web\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Web\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Web\Auth\NewPasswordController;
use App\Http\Controllers\Web\Auth\PasswordResetLinkController;
use App\Http\Controllers\Web\Auth\RegisteredUserController;
use App\Http\Controllers\Web\Auth\VerifyEmailController;
use App\Http\Controllers\Web\LinkedAccounts\BattleNetLinkedAccountController;
use App\Http\Controllers\Web\LinkedAccounts\DiscordLinkedAccountController;
use App\Http\Controllers\Web\LinkedAccounts\MicrosoftLinkedAccountController;
use App\Http\Controllers\Web\LinkedAccounts\SteamLinkedAccountController;
use App\Http\Controllers\Web\LinkedAccounts\TwitchLinkedAccountController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function (): void {
    Route::get('register', [RegisteredUserController::class, 'create'])
        ->name('register');

    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('password.request');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset');

    Route::post('reset-password', [NewPasswordController::class, 'store'])
        ->name('password.store');
});

Route::middleware('auth')->group(function (): void {
    Route::get('verify-email', EmailVerificationPromptController::class)
        ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});

Route::middleware([])->group(function (): void {
    Route::get('login/battlenet', [BattleNetLinkedAccountController::class, 'redirect'])
        ->name('login.linked-accounts.battlenet.redirect');

    Route::get('login/battlenet/callbcak', [BattleNetLinkedAccountController::class, 'callback'])
        ->name('login.linked-accounts.battlenet.callback');

    Route::get('login/discord', [DiscordLinkedAccountController::class, 'redirect'])
        ->name('login.linked-accounts.discord.redirect');

    Route::get('login/discord/callback', [DiscordLinkedAccountController::class, 'callback'])
        ->name('login.linked-accounts.discord.callback');

    Route::get('login/microsoft', [MicrosoftLinkedAccountController::class, 'redirect'])
        ->name('login.linked-accounts.microsoft.redirect');

    Route::get('login/microsoft/callback', [MicrosoftLinkedAccountController::class, 'callback'])
        ->name('login.linked-accounts.microsoft.callback');

    Route::get('login/steam', [SteamLinkedAccountController::class, 'redirect'])
        ->name('login.linked-accounts.steam.redirect');

    Route::get('login/steam/callback', [SteamLinkedAccountController::class, 'callback'])
        ->name('login.linked-accounts.steam.callback');

    Route::get('login/twitch', [TwitchLinkedAccountController::class, 'redirect'])
        ->name('login.linked-accounts.twitch.redirect');

    Route::get('login/twitch/callback', [TwitchLinkedAccountController::class, 'callback'])
        ->name('login.linked-accounts.twitch.callback');
});
