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
Route::get('/register', ['as' => 'user.signup', 'uses' => 'RegisterController@create']);
Route::post('/registerProccess', ['as' => 'user.added', 'uses' => 'RegisterController@store']);
Route::get('/aktifasi/{activationCode}/{id}', ['as' => 'user.activation', 'uses' => 'RegisterController@activate']);
