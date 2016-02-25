<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        for ($i=4; $i < 20; $i++) { 
        	$users[] = 
				[
					'email'    => 'demo'.$i.'@example.com',
					'password' => 'demo123',
					'username' => 'AAA00'.$i,
					'username_upline' => 'AAA001',
					'first_name'	=> 'Member ke-'.$i
				];
        }
  //  		$users = [
		// 	[
		// 		'email'    => 'demo4@example.com',
		// 		'password' => 'demo123',
		// 		'username' => 'AAA004',
		// 		'username_upline' => 'AAA001',
		// 	],
		// 	[
		// 		'email'    => 'demo5@example.com',
		// 		'password' => 'demo123',
		// 		'username' => 'AAA005',
		// 		'username_upline' => 'AAA001',
		// 	],
		// 	[
		// 		'email'    => 'demo6@example.com',
		// 		'password' => 'demo123',
		// 		'username' => 'AAA006',
		// 		'username_upline' => 'AAA001',
		// 	],
		// ];
        $role = Sentinel::findRoleByName('Members');//dibuat dulu bila blm ada Role nya

		foreach ($users as $user)
		{
			$newUser = Sentinel::registerAndActivate($user);
			//$newUser = Sentinel::findById($user->id);
			$role->users()->attach($newUser);
		}
        Model::reguard();
    }
}
