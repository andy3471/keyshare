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
Route::get('login/steam', 'Auth\LoginController@steamRedirect')->name('steamlogin');
Route::get('login/steam/callback', 'Auth\LoginController@steamCallback');

Route::get('/', 'HomeController@index')->name('home')->middleware('auth');
Route::get('/search', 'HomeController@search')->name('search')->middleware('auth');
Route::get('/autocomplete/{search}', 'HomeController@autocomplete')->name('autocomplete')->middleware('auth');

Route::get('/games', 'HomeController@gamesList')->name('games')->middleware('auth');
Route::get('/games/{id}', 'GamesController@show')->name('game')->middleware('auth');
Route::get('/games/edit/{id}', 'GamesController@edit')->name('editgame')->middleware('auth');
Route::post('/games/update', 'GamesController@update')->name('updategame')->middleware('auth');

Route::get('/keys/{id}', 'KeysController@show')->name('key')->middleware('auth');
Route::get('/claimedkeys', 'HomeController@claimedkeys')->name('claimedkeys')->middleware('auth');
Route::get('/sharedkeys', 'HomeController@sharedKeys')->name('sharedkeys')->middleware('auth');
Route::get('/addkey', 'KeysController@create')->name('addkey')->middleware('auth');
Route::post('/addkey/store', 'KeysController@store')->name('storekey')->middleware('auth');
Route::post('/addkey/claim', 'KeysController@claim')->name('claimkey')->middleware('auth');

Route::get('/users', 'UsersController@index')->name('users')->middleware('auth');
Route::get('/users/{id}', 'UsersController@show')->name('showuser')->middleware('auth');
Route::get('/user/edit', 'UsersController@edit')->name('edituser')->middleware('auth');
Route::post('/user/update', 'UsersController@update')->name('updateuser')->middleware('auth');

Route::get('/changepassword', 'HomeController@passwordResetPage')->name('changepassword')->middleware('auth');
Route::post('/changepassword/save', 'HomeController@passwordResetSave')->name('postpassword')->middleware('auth');

//JSON
Route::get('game/all', 'GamesController@index')->middleware('auth');
Route::get('game/claimed', 'KeysController@claimed')->middleware('auth');
Route::get('game/shared', 'KeysController@shared')->middleware('auth');
Route::get('/searchresults', 'HomeController@searchResults')->name('searchresults')->middleware('auth');

//TBR
Route::get('/home', function() {
    return redirect()->route('games');
});
