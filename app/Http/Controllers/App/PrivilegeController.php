<?php namespace App\Http\Controllers\App;

use App\Http\Models\Menu;
use App\Http\Models\Role;
use Illuminate\Http\Request;
use App\Http\Libraries\AppAssets;
use App\Http\Controllers\AppController;
use Input, Validator, Sentinel;

class PrivilegeController extends AppController 
{
	public function main_layout()
	{
		$this->data['css_assets'] 		= AppAssets::load('css', ['bootstrap', 'animate', 'font-awesome', 'icon', 'font', 'app', 'jquery-treegrid']);
		$this->data['js_assets'] 		= AppAssets::load('js', ['jquery', 'datagrid', 'validate', 'disabler', 'enabler', 'form', 'bootstrap', 'app', 'jquery-slimscroll', 'app-plugin', 'jquery-treegrid']);
		$this->data['menus'] 			= Menu::all();
		$this->data['groups'] 			= Role::all();
		$this->data['title']			= 'Administrator';
		$this->data['page_title'] 		= 'Privilege Page';
		$this->data['page_subtitle'] 	= 'Anda sedang berada di : App » Privilege List';
	    return view('app/components/main_layout')->with('data', $this->data)
								  				 ->nest('content', 'app/privilege/main', array('data' => $this->data));
	}

	public function load(Request $request)
	{
	    $menu_allowed 	= [];

		$role 			= Sentinel::findRoleById($request->role_id);
	    foreach ($role->permissions as $key => $value) {
			$menu_allowed[] = $key;
		}

		return $menu_allowed;
	}

	public function action(Request $request)
	{
		$role = Role::find($request->role_id);
		$role->permissions = $request->arr_id;
	    $role->save();
	}
}