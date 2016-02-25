<?php namespace App\Http\Models;

use App\Http\Libraries\Datagrid;
use DB, Illuminate\Database\Eloquent\Model;
use Sentinel;

class User extends Model {

    protected $table = 'users';
    
    public function getJson($input)
	{
		$table 	= 'users as a';
		$select = 'a.*';
		
		$replace_field 	= [
			['old_name' => 'first_name', 'new_name' => 'a.first_name'],
			['old_name' => 'last_name', 'new_name' => 'a.last_name'],
			['old_name' => 'activated', 'new_name' => 'a.activated'],
			['old_name' => 'phone_number', 'new_name' => 'a.phone_number']
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

		foreach ($data["rows"] as $key => $row) {
            $data["rows"][$key]->role_id = Sentinel::findUserById($data["rows"][$key]->id)->getRoles()->first()->id;
        }

		return $data;
	}

}