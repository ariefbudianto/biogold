<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', 'HomeController@index')->middleware(['sponsor']);
Route::get('/produk', ['as' => 'products', 'uses' => 'HomeController@produk']);
Route::get('/register', ['as' => 'user.signup', 'uses' => 'RegisterController@create'])->middleware(['sponsor']);
Route::post('/registerProccess', ['as' => 'user.added', 'uses' => 'RegisterController@store']);
Route::get('/aktifasi/{activationCode}/{id}', ['as' => 'user.activation', 'uses' => 'RegisterController@activate']);
Route::get('/login', ['as' => 'user.login', 'uses' => 'LoginController@login'])->middleware(['sponsor']);
Route::get('/logout', ['as' => 'user.logout', 'uses' => 'LoginController@logout']);
Route::post('/loginCheck', ['as' => 'user.authorization', 'uses' => 'LoginController@loginAuth']);

Route::group(['prefix' => 'member','middleware' => 'auth.member'], function () {
    Route::get('/profile', ['as' => 'user.profile', 'uses' => 'UserController@edit']);// Matches The "/member/profile" URL
});

