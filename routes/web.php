<?php

use App\Dlc;

Auth::routes();
Route::get('/notapproved', 'HomeController@notApproved')->name('notapproved');

Route::middleware(['steamlogin'])->group(function () {
    Route::get('login/steam', 'Auth\LoginController@steamRedirect')->name('steamlogin');
    Route::get('login/steam/callback', 'Auth\LoginController@steamCallback');
});

Route::middleware(['auth', 'approved'])->group(function () {
    Route::get('/', 'HomeController@index')->name('home');

    Route::get('/search', 'SearchController@search')->name('search');
    Route::get('/search/get', 'SearchController@getSearch');

    Route::get('/autocomplete/games/{search}', 'SearchController@autocomplete')->name('autocomplete');
    Route::get('/autocomplete/dlc/{gamename}/{search}', 'SearchController@autocompleteDlc')->name('autocompleteDlc');

    Route::get('/games', 'GamesController@index')->name('games');
    Route::get('/games/get', 'GamesController@getGames');

    Route::get('/games/{id}', 'GamesController@show')->name('game');
    Route::get('/games/edit/{id}', 'GamesController@edit')->name('editgame');
    Route::post('/games/update', 'GamesController@update')->name('updategame');

    Route::get('/keys/{key}', 'KeysController@show')->name('key');

    Route::get('/claimedkeys', 'KeysController@showClaimed')->name('claimedkeys');
    Route::get('/claimedkeys/get', 'KeysController@getClaimed');

    Route::get('/sharedkeys', 'KeysController@showShared')->name('sharedkeys');
    Route::get('/sharedkeys/get', 'KeysController@getShared');

    Route::get('/addkey/', 'KeysController@create')->name('addkey');
    Route::post('/addkey/', 'KeysController@store')->name('storekey');
    Route::post('/addkey/claim', 'KeysController@claim')->name('claimkey');

    Route::get('/users', 'UsersController@index')->name('users');
    Route::get('/users/{id}', 'UsersController@show')->name('showuser');
    Route::get('/user/edit', 'UsersController@edit')->name('edituser');
    Route::post('/user/update', 'UsersController@update')->name('updateuser');

    Route::get('/changepassword', 'UsersController@passwordResetPage')->name('changepassword');
    Route::post('/changepassword/save', 'UsersController@passwordResetSave')->name('postpassword');

    Route::get('/platform/{id}', 'PlatformsController@show')->name('platform');
    Route::get('/platform/get/{id}', 'PlatformsController@getPlatform');

    Route::get('/platforms/index/', 'PlatformsController@index');

    Route::get('/games/dlc/get/{id}', 'DlcController@index');
    Route::get('/games/dlc/{dlc}', 'DlcController@show')->name('dlc');
    Route::get('/games/dlc/edit/{dlc}', 'DlcController@edit')->name('editdlc');
    Route::post('/games/dlc/update', 'DlcController@update')->name('updatedlc');
});

Route::middleware(['admin'])->group(function () {
    Route::get('/admin/users', 'AdminController@usersIndex')->name('adminshowusers');
    Route::get('/admin/user/{id}', 'AdminController@usersEdit')->name('adminuseredit');
    Route::post('/admin/user/update', 'AdminController@usersUpdate')->name('adminuserupdate');
});



//TBR
Route::get('/home', 'HomeController@home')->name('adminuserupdate');
