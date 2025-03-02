<?php

use App\Http\Controllers\Api\Games\GameController;
use App\Http\Controllers\Api\Keys\KeyController;
use App\Http\Controllers\Api\Platforms\PlatformController;
use App\Http\Controllers\Api\Search\SearchController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware(['auth'])->group(function (): void {
    Route::get('search', [SearchController::class, 'index']);

    Route::get('autocomplete/games/{search}', [SearchController::class, 'autoCompleteGames'])->name('autocomplete');

    Route::get('games', [GameController::class, 'index']);

    Route::get('claimed-keys', [KeyController::class, 'claimed']);

    Route::get('shared-keys/get', [KeyController::class, 'shared']);

    Route::get('platforms/{id}', [PlatformController::class, 'show']);

});
