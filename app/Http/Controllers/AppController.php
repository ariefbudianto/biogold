<?php namespace App\Http\Controllers;

use Request, Sentinel;
use App\Http\Models\Menu;
use App\Http\Libraries\Helpers;

class AppController extends Controller {

	public function __construct()
	{
		$this->data['list_menu'] 	= Menu::getMenu();
		$this->data['active_user'] 	= Sentinel::getUser()->first_name;
		$this->data['active_menu'] 	= $this->activeMenu($this->data['list_menu']);
	}

	public function activeMenu($list_menu)
	{
		$active_menu = 0;

		foreach ($list_menu as $menu) {
			if (Request::segment(1) . '/' . Request::segment(2) == $menu->link) {
				$active_menu = $menu->parent_id;
			}
		}

		return $active_menu;
	}
}
