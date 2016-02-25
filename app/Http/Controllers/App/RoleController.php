<?php namespace App\Http\Controllers\App;

use App\Http\Models\Role;
use Illuminate\Http\Request;
use App\Http\Libraries\AppAssets;
use App\Http\Controllers\AppController;
use Input, Response, Validator;
use Sentinel, Activation, Reminder;

class RoleController extends AppController 
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
		$this->data['page_title'] 		= 'Group Page';
		$this->data['page_subtitle'] 	= 'Anda sedang berada di : App » Group List';
	    return view('app/components/main_layout')->with('data', $this->data)
								  				 ->nest('content', 'app/role/main', array('data' => $this->data));
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
		$this->data['page_subtitle'] 	= 'Anda sedang berada di : App » Group Form';

		return view('app/role/form')->with('data', $this->data);
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
			'name'	 => 'required|unique:roles,name',
		);

		if ($input['id'] != '') {
			$rules['name'] 	= 'required';
		}

	    $validator 	= Validator::make($input, $rules);
	    $messages 	= $validator->fails() ? $validator->messages() : 'success';

	    return Response::json($messages);
	}

	/**
     * To Create New Role
     *
     * @access 	public
     * @param 	Object Request
     * @return 	json(array)
     */
	public function create(Request $request)
	{
	    $return = array();

		$role = Sentinel::getRoleRepository()->createModel()->create([
		    'name' => $request->name,
		    'slug' => str_replace(' ', '-', strtolower($request->name)),
		]);

		$return['status'] = 'success';
    	return Response::json($return);
	}

	/**
     * To Update Exsisting Role
     *
     * @access 	public
     * @param 	Object Request
     * @return 	json(array)
     */
	public function update(Request $request)
	{
	    $return = array();

		$role = Sentinel::findRoleById($request->id);
	    $role->name = $request->name;
	    $role->save();

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

		return view('app/role/delete_form')->with('data', $this->data);
	}

	/**
     * To deleting role
     *
     * @access 	public
     * @param 	Object Request
     * @return 	json(array)
     */
	public function delete(Request $request)
	{
		$return = array();
	    $role = Sentinel::findRoleById($request->id);
	    
	    // DETACH ALL USERS
	    $users = $role->users()->get();
	    if (!empty($users)) {
	    	foreach ($users as $user) {
	    		$role->users()->detach($user);
	    	}
	    }

	    $role->delete();
		
		$return['status'] = 'success';
    	return Response::json($return);
	}
}