<?php namespace App\Http\Models;

use App\Http\Libraries\Datagrid;
use DB, Illuminate\Database\Eloquent\Model;

class Role extends Model {

	protected $table = 'roles';

	public function getJson($input)
	{
		$table 	= 'roles as a';
		$select = 'a.*';
		
		$replace_field 	= [
			['old_name' => 'name', 'new_name' => 'a.name']
		];

		$param = [
			'input' 		=> $input,
			'select' 		=> $select,
			'table' 		=> $table,
			'replace_field' => $replace_field
		];

		$datagrid = new Datagrid;
		$data = $datagrid->datagrid_query($param, function($data) {
			return $data;
		});

		return $data;
	}
}