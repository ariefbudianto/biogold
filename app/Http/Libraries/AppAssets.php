<?php namespace App\Http\Libraries;

class AppAssets {

	public static function load($type, $assets)
	{
		$data = [];
		if ($type == "css") {
			$css_assets = \Config::get('app-assets.css');
			foreach ($assets as $key => $value) {
				$data[] = $css_assets[$value];	
			}
		} else {
			$js_assets = \Config::get('app-assets.js');
			foreach ($assets as $key => $value) {
				$data[] = $js_assets[$value];	
			}
		}
		return $data;
	}
}
