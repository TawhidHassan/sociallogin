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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//social login
Route::get('login/facebook', 'Auth\LoginController@redirectToProvider')->name('facebook_log');
Route::get('login/facebook/callback', 'Auth\LoginController@handleProviderCallback');

//login with twitter
Route::get('login/twitter', 'TwitterController@redirectToProvider')->name('twitter_log');
Route::get('login/twitter/callback', 'TwitterController@handleProviderCallback');
//login with google
Route::get('login/google', 'GoogleController@redirectToProvider')->name('google_log');
Route::get('login/google/callback', 'GoogleController@handleProviderCallback');
//login with anysite
Route::get('login/{service}', 'GoogleController@redirectToProvider');
Route::get('login/{service}/callback', 'GoogleController@handleProviderCallback');
