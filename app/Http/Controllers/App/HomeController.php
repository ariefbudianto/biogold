<?php namespace App\Http\Controllers\App;

use App\Http\Libraries\AppAssets;
use App\Http\Controllers\AppController;
use App\Http\Models\User;
use App\Http\Models\UserMeta;
use DB;

class HomeController extends AppController {

	public function main_layout()
	{
		$this->data['css_assets'] 	= AppAssets::load('css', ['bootstrap', 'animate', 'font-awesome', 'icon', 'font', 'app']);
		$this->data['js_assets'] 	= AppAssets::load('js', ['jquery', 'bootstrap', 'app', 'jquery-slimscroll', 'app-plugin']);
		$this->data['title']		= 'Dashboard';
		$this->data['member_count'] = User::all()->count();
		$this->data['this_month'] = date('Y-m-d', strtotime('-1 Month'));
		$this->data['new_member_count'] = User::where(DB::raw('DATE(created_at)'), '>=', $this->data['this_month'])->count();
	    return view('app/components/main_layout')->with('data', $this->data)
								  				 ->nest('content', 'app/home/main', array('data' => $this->data));
	}

}