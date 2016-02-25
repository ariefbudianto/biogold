<?php namespace App\Http\Models;

use Sentinel, DB, Illuminate\Database\Eloquent\Model;

class Menu extends Model {

	public $table 		= 'menus';
	public $timestamps	= false;

	public static function getMenu()
    {
    	$user 			= Sentinel::getUser();
		$menu_allowed 	= [];
		$permissions 	= $user->roles()->first()->permissions;
		$menus			= DB::table('menus as m')->select('*')->get();

		foreach ($permissions as $key => $value) {
			if (strpos($key, "menu") !== false) {
				foreach ($menus as $key__ => $value__) {
					$menu_id = explode("-", $key)[1];
					if ($value__->id == $menu_id) {
						$menu_allowed[] = $value__;
					}
				}
			}
		}

		return $menu_allowed;
    }

}

