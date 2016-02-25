<?php namespace App\Http\Controllers\App;

use App\Http\Models\User;
use App\Http\Models\Role;
use Illuminate\Http\Request;
use App\Http\Libraries\AppAssets;
use App\Http\Controllers\AppController;
use Input, Response, Validator;
use Sentinel, Activation, Reminder;

class UserController extends AppController 
{

	/**
     * Main Layout
     *
     * @access 	public
     * @param 	
     * @return 	view
     */
	public function main_layout()
	{
		$this->data['css_assets'] 		= AppAssets::load('css', ['bootstrap', 'animate', 'font-awesome', 'icon', 'font', 'app']);
		$this->data['js_assets'] 		= AppAssets::load('js', ['jquery', 'datagrid', 'validate', 'disabler', 'enabler', 'form', 'bootstrap', 'app', 'jquery-slimscroll', 'app-plugin']);
		$this->data['title']			= 'Administrator';
		$this->data['page_title'] 		= 'User Page';
		$this->data['page_subtitle'] 	= 'Anda sedang berada di : App » User List';
	    return view('app/components/main_layout')->with('data', $this->data)
								  				 ->nest('content', 'app/user/main', array('data' => $this->data));
	}

	/**
     * Form
     *
     * @access 	public
     * @param 	
     * @return 	view
     */
	public function form()
	{
		$input 							= Input::all();
		$this->data['index'] 			= $input['index'];
		$this->data['roles'] 			= Role::all();
		$this->data['page_subtitle'] 	= 'Anda sedang berada di : App » User Form';

		return view('app/user/form')->with('data', $this->data);
	}

	/**
     * Validate Input
     *
     * @access 	public
     * @param 	
     * @return 	json(array)
     */
	public function validate_input()
	{
		$input = Input::all();

		$rules = array(
			'first_name' 	=> 'required',
			'last_name' 	=> 'required',
			'email'	 		=> 'required|email|unique:users,email',
			'password'	 	=> 'required',
			'handphone'		=> 'required',
			'role_id'		=> 'required'
		);

		if ($input['id'] != '') {
			$rules['email'] 	= 'required|email';
		}

	    $validator 	= Validator::make($input, $rules);
	    $messages 	= $validator->fails() ? $validator->messages() : 'success';

	    return Response::json($messages);
	}

	/**
     * To New Create User
     *
     * @access 	public
     * @param 	Object Request
     * @return 	json(array)
     */
	public function create(Request $request)
	{
		$return = array();

		$user = Sentinel::register([
    		'first_name' 	=> $request->first_name,
    		'last_name'		=> $request->last_name,
    		'email'    		=> $request->email,
    		'password' 		=> $request->password,
    		'handphone' 	=> $request->handphone,
    	]);

		$activation = Activation::create($user);
		Activation::complete($user, $activation->code);

    	$role = Sentinel::findRoleById($request->role_id);
    	$role->users()->attach($user);

    	$return['status'] = 'success';
    	return Response::json($return);
	}

	/**
     * To Update Exsisting User Data
     *
     * @access 	public
     * @param 	Object Request
     * @return 	json(array)
     */
	public function update(Request $request)
	{
		$return = array();

	    $user = Sentinel::findUserById($request->id);
	    $user->first_name 		= $request->first_name;
	    $user->last_name 		= $request->last_name;
	    $user->email 			= $request->email;
	    $user->handphone 		= $request->handphone;
	    $user->save();

	    // CHANGE PASSWORD
	    if ($user->password != $request->password) {
	    	$reminder = Reminder::create($user);
	    	Reminder::complete($user, $reminder->code, $request->password);
	    	Reminder::removeExpired();
	    }

	    // REMOVE ALL GROUPS
    	foreach (Role::all() as $role) {
		    $role = Sentinel::findRoleById($role->id);
		    $role->users()->detach($user);
    	}

	    // ADD GROUPS
	    $role = Sentinel::findRoleById($request->role_id);
		$role->users()->attach($user);

    	$return['status'] = 'success';
    	return Response::json($return);
	}

	/**
     * To display delete user confirmation
     *
     * @access 	public
     * @param 	
     * @return 	view
     */
	public function delete_form()
	{
		$input = Input::all();
		$this->data['page_subtitle'] 	= 'Confirmation Message';
		$this->data['index'] 			= $input['index'];
		return view('app/user/delete_form')->with('data', $this->data);
	}

	/**
     * To display ban user confirmation
     *
     * @access 	public
     * @param 	
     * @return 	view
     */
	public function ban_form()
	{
		$input = Input::all();
		$this->data['page_subtitle'] 	= 'Confirmation Message';
		$this->data['index'] 			= $input['index'];
		return view('app/user/ban_form')->with('data', $this->data);
	}

	/**
     * To deleting user
     *
     * @access 	public
     * @param 	Object Request
     * @return 	void
     */
	public function delete(Request $request)
	{
		$user = Sentinel::findUserById($request->id);
    	$user->delete();
	}

	/**
     * To ban user
     *
     * @access 	public
     * @param 	Object Request
     * @return 	void
     */
	public function ban_user(Request $request)
	{
		$user = Sentinel::findUserById($request->id);
		if($user->banned){
			$user->banned = false;
			$user->save();
		} else {
			$user->banned = true;
			$user->save();
		}
	}

}