<?php namespace App\Http\Controllers\App;

use Input, Validator, Sentinel;
use Illuminate\Http\Request;
use App\Http\Libraries\AppAssets;
use App\Http\Controllers\Controller;

class AuthController extends Controller {

	public function index()
	{
		if (!Sentinel::check()) {
			$this->data['css_assets'] 	= AppAssets::load('css', ['bootstrap', 'animate', 'font', 'app']);
			$this->data['js_assets'] 	= AppAssets::load('js', ['jquery', 'validate']);
			$this->data['title']		= 'Sign In';
		    return view('app/signin/main')->with('data', $this->data);
		} else {
			return redirect('app/home');
		}
	}

	public function signin(Request $request)
	{
		$rules = array(
			'email'	 		=> 'required|email',
			'password'	 	=> 'required'
		);

	    $validator 	= Validator::make($request->all(), $rules);
	    if (!$validator->fails()) {
	    	try
			{
			    $credentials = array(
			        'email'    		=> $request->email,
		    		'password' 		=> $request->password
			    );

			    if ($request->has('remember_me')) {
					Sentinel::authenticateAndRemember($credentials, false);
		    	} else {
		    		Sentinel::authenticate($credentials, false);
		    	}
		    	return 'Login Success';
			}
			catch (\Cartalyst\Sentinel\Users\WrongPasswordException $e)
			{
			    return 'Wrong password, try again.';
			}
			catch (\Cartalyst\Sentinel\Users\UserNotFoundException $e)
			{
			    return 'User was not found.';
			}
			catch (\Cartalyst\Sentinel\Users\UserNotActivatedException $e)
			{
			    return 'User is not activated.';
			}
	    } else {
	    	return $validator->messages();	
	    }
	}

	public function signout()
	{
		Sentinel::logout();
		return redirect('app');
	}
}
