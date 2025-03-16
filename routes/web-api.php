<?php

use App\Http\Controllers\WebApi\Search\SearchController;

Route::middleware(['auth', 'verified'])->name('web-api.')->group(function (): void {
    Route::get('search', [SearchController::class, 'index'])->name('search.index');
    //
    //    Route::get('games', [GameController::class, 'index']);
    //
    //    Route::get('claimed-keys', [KeyController::class, 'claimed']);
    //
    //    Route::get('shared-keys/get', [KeyController::class, 'shared']);
    //
    //    Route::get('platforms/{id}', [PlatformController::class, 'show']);
});
