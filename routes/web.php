<?php

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

//Testing - TBR
use Illuminate\Support\Facades\Redis;

Auth::routes();
Route::get('/notapproved', 'HomeController@notApproved')->name('notapproved');

Route::middleware(['steamlogin'])->group(function () {
    Route::get('login/steam', 'Auth\LoginController@steamRedirect')->name('steamlogin');
    Route::get('login/steam/callback', 'Auth\LoginController@steamCallback');
});

Route::middleware(['auth', 'approved'])->group(function () {
    Route::get('/', 'HomeController@index')->name('home');
    Route::get('/search', 'HomeController@search')->name('search');
    Route::get('/autocomplete/{search}', 'HomeController@autocomplete')->name('autocomplete');

    Route::get('/games', 'HomeController@gamesList')->name('games');
    Route::get('/games/{id}', 'GamesController@show')->name('game');
    Route::get('/games/edit/{id}', 'GamesController@edit')->name('editgame');
    Route::post('/games/update', 'GamesController@update')->name('updategame');

    Route::get('/keys/{id}', 'KeysController@show')->name('key');
    Route::get('/claimedkeys', 'HomeController@claimedkeys')->name('claimedkeys');
    Route::get('/sharedkeys', 'HomeController@sharedKeys')->name('sharedkeys');
    Route::get('/addkey', 'KeysController@create')->name('addkey');
    Route::post('/addkey/store', 'KeysController@store')->name('storekey');
    Route::post('/addkey/claim', 'KeysController@claim')->name('claimkey');

    Route::get('/users', 'UsersController@index')->name('users');
    Route::get('/users/{id}', 'UsersController@show')->name('showuser');
    Route::get('/user/edit', 'UsersController@edit')->name('edituser');
    Route::post('/user/update', 'UsersController@update')->name('updateuser');

    Route::get('/changepassword', 'UsersController@passwordResetPage')->name('changepassword');
    Route::post('/changepassword/save', 'UsersController@passwordResetSave')->name('postpassword');

    //JSON
    Route::get('game/all', 'GamesController@index');
    Route::get('game/claimed', 'KeysController@claimed');
    Route::get('game/shared', 'KeysController@shared');
    Route::get('/searchresults', 'HomeController@searchResults')->name('searchresults');
});



//TBR
Route::get('/home', function() {
    return redirect()->route('games');
});
