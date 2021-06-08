<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\DlcController;
use App\Http\Controllers\ExternalLoginController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KeyController;
use App\Http\Controllers\PlatformController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// TODO group routes

Route::get('login/steam', [ExternalLoginController::class, 'steamRedirect'])->name('login.steam');
Route::get('login/steam/callback', [ExternalLoginController::class, 'steamCallback'])->name('login.steam.callback');

Route::get('login/discord', [ExternalLoginController::class, 'discordRedirect'])->name('login.discord');
Route::get('login/discord/callback', [ExternalLoginController::class, 'discordCallback'])->name('login.discord.callback');

Route::get('login/twitch', [ExternalLoginController::class, 'twitchRedirect'])->name('login.twitch');
Route::get('login/twitch/callback', [ExternalLoginController::class, 'twitchCallback'])->name('login.twitch.callback');

Route::middleware(['auth:sanctum', 'verified', 'approved'])->group(function () {
    //SETUP (Accounts created with socialite)
    Route::get('login/setup', [UserController::class, 'setup'])->name('login.setup');
    Route::put('login/setup/update', [UserController::class, 'setupUpdate'])->name('login.setup.update');

    //HOME
    Route::get('/', [HomeController::class, 'index'])->name('home');

    //SEARCH
    Route::get('search', [SearchController::class, 'search'])->name('search');
    Route::get('search/get', [SearchController::class, 'getSearch']);
    Route::get('autocomplete/games/{search}', [SearchController::class, 'autocomplete'])->name('autocomplete');
    Route::get('autocomplete/dlc/{gamename}/{search}', [SearchController::class, 'autocompleteDlc'])->name('autocompleteDlc');

    //GAMES
    Route::get('games', [GameController::class, 'index'])->name('game.index');
    Route::get('games/get', [GameController::class, 'getGames']);
    Route::get('games/{id}', [GameController::class, 'show'])->name('game.show');

    //KEYS
    Route::get('keys/{key}', [KeyController::class, 'show'])->name('key.show');
    Route::get('claimedkeys', [KeyController::class, 'showClaimed'])->name('claimedkeys');
    Route::get('claimedkeys/get', [KeyController::class, 'getClaimed']);
    Route::get('sharedkeys', [KeyController::class, 'showShared'])->name('sharedkeys');
    Route::get('sharedkeys/get', [KeyController::class, 'getShared']);

    Route::get('addkey', [KeyController::class, 'create'])->name('addkey');
    Route::post('addkey/store', [KeyController::class, 'store'])->name('key.store');
    Route::put('addkey/claim', [KeyController::class, 'claim'])->name('key.claim');

    //PLATFORMS
    Route::get('platform/{id}', [PlatformController::class, 'show'])->name('platform.show');
    Route::get('platform/get/{id}', [PlatformController::class, 'getPlatform']);

    //DLC
    Route::get('games/dlc/get/{id}', [DlcController::class, 'index']);
    Route::get('games/dlc/{dlc}', [DlcController::class, 'show'])->name('dlc.show');
});

Route::middleware(['admin'])->group(function () {
    //Users
    Route::get('admin/users', [AdminController::class, 'usersIndex'])->name('admin.users.index');
    Route::get('admin/user/{id}', [AdminController::class, 'usersEdit'])->name('admin.users.edit')->middleware('demo');
    Route::post('admin/user/update', [AdminController::class, 'usersUpdate'])->name('admin.users.update')->middleware('demo');

    //Games
    Route::get('games/edit/{id}', [GameController::class, 'edit'])->name('game.edit');
    Route::put('games/update', [GameController::class, 'update'])->name('game.update');

    //DLC
    Route::get('games/dlc/edit/{dlc}', [DlcController::class, 'edit'])->name('dlc.edit');
    Route::put('games/dlc/update', [DlcController::class, 'update'])->name('dlc.update');
});
