<?php

Auth::routes();
Route::get('/notapproved', 'HomeController@notApproved')->name('notapproved');
Route::get('/demo', 'HomeController@demo')->name('demomode');

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

    Route::get('/games', 'GameController@index')->name('games');
    Route::get('/games/get', 'GameController@getGames');

    Route::get('/games/{id}', 'GameController@show')->name('game');

    Route::get('/keys/{key}', 'KeyController@show')->name('key');

    Route::get('/claimedkeys', 'KeyController@showClaimed')->name('claimedkeys');
    Route::get('/claimedkeys/get', 'KeyController@getClaimed');

    Route::get('/sharedkeys', 'KeyController@showShared')->name('sharedkeys');
    Route::get('/sharedkeys/get', 'KeyController@getShared');

    Route::get('/addkey/', 'KeyController@create')->name('addkey');
    Route::post('/addkey/store', 'KeyController@store')->name('storekey');
    Route::post('/addkey/claim', 'KeyController@claim')->name('claimkey');

    Route::get('/users', 'UserController@index')->name('users');
    Route::get('/users/{id}', 'UserController@show')->name('showuser');
    Route::get('/user/edit', 'UserController@edit')->name('edituser')->middleware('demomode');
    Route::post('/user/update', 'UserController@update')->name('updateuser')->middleware('demomode');

    Route::get('/changepassword', 'UserController@passwordResetPage')->name('changepassword')->middleware('demomode');
    Route::post('/changepassword/save', 'UserController@passwordResetSave')->name('postpassword')->middleware('demomode');

    Route::get('/platform/{id}', 'PlatformController@show')->name('platform');
    Route::get('/platform/get/{id}', 'PlatformController@getPlatform');

    Route::get('/platforms/index/', 'PlatformController@index');

    Route::get('/games/dlc/get/{id}', 'DlcController@index');
    Route::get('/games/dlc/{dlc}', 'DlcController@show')->name('dlc');
});

Route::middleware(['admin'])->group(function () {
    Route::get('/admin/users', 'AdminController@usersIndex')->name('adminshowusers');
    Route::get('/admin/user/{id}', 'AdminController@usersEdit')->name('adminuseredit')->middleware('demomode');
    Route::post('/admin/user/update', 'AdminController@usersUpdate')->name('adminuserupdate')->middleware('demomode');

    Route::get('/games/dlc/edit/{dlc}', 'DlcController@edit')->name('editdlc');
    Route::post('/games/dlc/update', 'DlcController@update')->name('updatedlc');

    Route::get('/games/edit/{id}', 'GameController@edit')->name('editgame');
    Route::post('/games/update', 'GameController@update')->name('updategame');
});
