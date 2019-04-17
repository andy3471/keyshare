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

Route::get('/games', 'GamesController@index')->name('games')->middleware('auth');
Route::get('/games/{id}', 'GamesController@show')->name('game')->middleware('auth');

Route::get('/keys/{id}', 'KeysController@show')->name('key')->middleware('auth');
Route::get('/claimedkeys', 'KeysController@claimed')->name('claimedkeys')->middleware('auth');
Route::get('/sharedkeys', 'KeysController@shared')->name('sharedkeys')->middleware('auth');
Route::get('/addkey', 'KeysController@create')->name('addkey')->middleware('auth');
Route::post('/addkey/store', 'KeysController@store')->name('storekey')->middleware('auth');
Route::post('/addkey/claim', 'KeysController@claim')->name('claimkey')->middleware('auth');

Route::get('/users', 'UsersController@index')->name('users')->middleware('auth');
Route::get('/users/{id}', 'UsersController@view')->name('user')->middleware('auth');

// Testing - TBR
Route::get('/karma', function () {
    $karma = Redis::zscore('karma', auth()->id());
    Auth::user()->setAttribute('karma',$karma);

    return Response::json(Auth::user());
})->middleware('auth');
