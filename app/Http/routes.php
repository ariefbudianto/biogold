<?php

Route::get('/', ['as' => 'public.index', 'uses' => 'HomeController@index'])->middleware(['sponsor']);
Route::get('/produk', ['as' => 'public.products', 'uses' => 'HomeController@produk']);
Route::get('/register', ['as' => 'user.signup', 'uses' => 'RegisterController@create'])->middleware(['sponsor']);
Route::post('/registerProccess', ['as' => 'user.added', 'uses' => 'RegisterController@store']);
Route::get('/aktifasi/{activationCode}/{id}', ['as' => 'user.activation', 'uses' => 'RegisterController@activate']);
Route::get('/login', ['as' => 'user.login', 'uses' => 'LoginController@login'])->middleware(['sponsor']);
Route::get('/logout', ['as' => 'user.logout', 'uses' => 'LoginController@logout']);
Route::post('/loginCheck', ['as' => 'user.authorization', 'uses' => 'LoginController@loginAuth']);

Route::group(['prefix' => 'member', 'as' => 'user.','middleware' => 'auth.member'], function () 
{// Matches The "/member/profile" URL
    Route::get('/profile', ['as' => 'profile', 'uses' => 'Member\UserController@edit']);// example call in blade:<a href="{{ route('user.profile') }}">Edit Account</a>
    Route::post('/update', ['as' => 'update', 'uses' => 'Member\UserController@update']);
});


// APP
Route::group(['prefix' => 'app'], function()
{ 
	Route::get('/', 'App\AuthController@index');
	Route::post('signin', 'App\AuthController@signin');
	Route::get('signout', 'App\AuthController@signout');

	Route::group(['middleware' => 'adminloggedin'], function()
	{
		// HOME ROUTES
		Route::get('home', 'App\HomeController@main_layout');
		Route::post('ajax_getNotif', 'App\HomeController@ajax_getNotif');
		// END HOME ROUTES

		// USER ROUTES
		Route::group(['prefix' => 'user'], function()
		{ 
			Route::get('/', 'App\UserController@main_layout');
			Route::post('form', 'App\UserController@form');
			Route::post('validate', 'App\UserController@validate_input');
			Route::post('action', function(Illuminate\Http\Request $request)
			{
				$controller = App::make('App\Http\Controllers\App\UserController');
				return empty($request->id) ? $controller->create($request) : $controller->update($request);
			});
			Route::post('delete_form', 'App\UserController@delete_form');
			Route::post('delete', 'App\UserController@delete');
			Route::post('ban_form', 'App\UserController@ban_form');
			Route::post('ban', 'App\UserController@ban_user');
			Route::post('data', function()
			{
				$input = Input::all();
				$user = new App\Http\Models\User;
				return Response::json($user->getJson($input));
			});
		});
		// END USER ROUTES

		// GROUP ROUTES
		Route::group(['prefix' => 'group'], function()
		{ 
			Route::get('/', 'App\RoleController@main_layout');
			Route::post('form', 'App\RoleController@form');
			Route::post('validate', 'App\RoleController@validate_input');
			Route::post('action', function(Illuminate\Http\Request $request)
			{
				$controller = App::make('App\Http\Controllers\App\RoleController');
				return empty($request->id) ? $controller->create($request) : $controller->update($request);
			});

			Route::post('delete_form', 'App\RoleController@delete_form');
			Route::post('delete', 'App\RoleController@delete');
			Route::post('data', function()
			{
				$input = Input::all();
				$group = new App\Http\Models\Role;
				return Response::json($group->getJson($input));
			});
		});
		// END GROUP ROUTES
		
		// PRIVILEGE ROUTES
		Route::group(['prefix' => 'privilege'], function()
		{
			Route::get('/', 'App\PrivilegeController@main_layout');
			Route::post('load', 'App\PrivilegeController@load');
			Route::post('action', 'App\PrivilegeController@action');
		});
		// END PRIVILEGE ROUTES
	});
});
// END APP