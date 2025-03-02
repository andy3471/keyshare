<?php

use App\Http\Controllers\Web\Settings\AppearanceController;
use App\Http\Controllers\Web\Settings\LinkedAccountsController;
use App\Http\Controllers\Web\Settings\PasswordController;
use App\Http\Controllers\Web\Settings\ProfileController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function (): void {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('settings/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('settings/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('settings/password', [PasswordController::class, 'edit'])->name('password.edit');
    Route::put('settings/password', [PasswordController::class, 'update'])->name('password.update');

    Route::get('settings/appearance', [AppearanceController::class, 'edit'])->name('appearance');

    Route::get('settings/linked-accounts', [LinkedAccountsController::class, 'edit'])->name('linked-accounts');
});
