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

Route::get('/', ['as' => 'public.index', 'uses' => 'HomeController@index'])->middleware(['sponsor']);
Route::get('/produk', ['as' => 'public.products', 'uses' => 'HomeController@produk']);
Route::get('/register', ['as' => 'user.signup', 'uses' => 'RegisterController@create'])->middleware(['sponsor']);
Route::post('/registerProccess', ['as' => 'user.added', 'uses' => 'RegisterController@store']);
Route::get('/aktifasi/{activationCode}/{id}', ['as' => 'user.activation', 'uses' => 'RegisterController@activate']);
Route::get('/login', ['as' => 'user.login', 'uses' => 'LoginController@login'])->middleware(['sponsor']);
Route::get('/logout', ['as' => 'user.logout', 'uses' => 'LoginController@logout']);
Route::post('/loginCheck', ['as' => 'user.authorization', 'uses' => 'LoginController@loginAuth']);
Route::get('/passwordreset', ['as' => 'user.passwordreset', 'uses' => 'ReminderController@create'])->middleware(['sponsor']);
Route::post('/passwordresetlink', ['as' => 'user.passwordresetlink', 'uses' => 'ReminderController@store']);
Route::get('/passwordbaru/{id}/{code}', ['as' => 'user.passwordnew', 'uses' => 'ReminderController@edit']);
Route::post('/simpanpassword/{id}/{code}', ['as' => 'user.updatepassword', 'uses' => 'ReminderController@update']);

Route::group(['prefix' => 'member', 'as' => 'user.','middleware' => 'auth.member'], function () 
{// Matches The "/member/profile" URL
    Route::get('/profile', ['as' => 'profile', 'uses' => 'Member\UserController@edit']);// example call in blade:<a href="{{ route('user.profile') }}">Edit Account</a>
    Route::post('/update', ['as' => 'update', 'uses' => 'Member\UserController@update']);
    Route::get('/changepassword', ['as' => 'changepassword', 'uses' => 'Member\UserController@changepassword']);
    Route::post('/dochangepassword', ['as' => 'dochangepassword', 'uses' => 'Member\UserController@dochangepassword']);
    Route::get('/konfirmbayar', ['as' => 'confirmpayment', 'uses' => 'Member\RegistrasiController@index'])->middleware(['hasconfirmpayment']);
    Route::post('/kirimkonfirmbayar', ['as' => 'doconfirmpayment', 'uses' => 'Member\RegistrasiController@store'])->middleware(['hasconfirmpayment']);
    Route::get('/referral', ['as' => 'referral', 'uses' => 'Member\ReferralController@index']);
    Route::get('/referralData', ['as' => 'referralData', 'uses' => 'Member\ReferralController@getData']);
});

