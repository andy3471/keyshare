<?php

declare(strict_types=1);

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//
use App\Http\Controllers\Api\DlcController;
use App\Http\Controllers\Api\GameController;
use App\Http\Controllers\Api\KeyController;
use App\Http\Controllers\Api\PlatformController;
use App\Http\Controllers\Api\SearchController;

Route::middleware(['auth', 'approved'])->name('api.')->group(function (): void {
    Route::resource('platforms', PlatformController::class)->only(['index', 'show']);

    Route::get('search', [SearchController::class, 'index'])->name('search.index');
    Route::get('search/games/{search}', [SearchController::class, 'autoCompleteGames'])->name('games.search.index');
    Route::get('search/dlc/{gamename}/{search}', [SearchController::class, 'autoCompleteDlc'])->name('dlc.search.index');

    Route::get('games', [GameController::class, 'index'])->name('games.index');
    Route::get('games/{game}/dlc', [DlcController::class, 'index'])->name('dlc.index');

    Route::get('my/claimed-keys', [KeyController::class, 'claimed'])->name('my.keys.claimed.index');
    Route::get('my/shared-keys', [KeyController::class, 'shared'])->name('my.keys.shared.index');
});
