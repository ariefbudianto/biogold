<?php

use Illuminate\Database\Seeder;

class seed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('menus')->insert([
            'parent_id' => 0,
            'title' => 'Settings',
            'link' => '',
            'icon' => 'fa fa-cog',
        ]);
        DB::table('menus')->insert([
        	'parent_id' => 1,
            'title' => 'Members',
            'link' => 'app/user',
            'icon' => 'i i-dot',
       	]);
        DB::table('menus')->insert([
        	'parent_id' => 1,
            'title' => 'Groups',
            'link' => 'app/group',
            'icon' => 'i i-dot',
       	]);
        DB::table('menus')->insert([
        	'parent_id' => 1,
            'title' => 'Privileges',
            'link' => 'app/privilege',
            'icon' => 'i i-dot',
       	]);
        DB::table('menus')->insert([
        	'parent_id' => 1,
            'title' => 'Global Settings',
            'link' => 'app/settings',
            'icon' => 'i i-dot',
       	]);
       	DB::table('roles')->insert([
            'slug' => 'super-admin',
            'name' => 'Super Admin',
            'permissions' => '{"app":true,"menu-1":true,"menu-2":true,"menu-3":true,"menu-4":true,"menu-5":true}',
        ]);
        DB::table('roles')->insert([
            'slug' => 'admin',
            'name' => 'Admin',
            'permissions' => '{"app":true,"menu-1":true,"menu-2":true,"menu-3":true,"menu-4":true,"menu-5":true}',
        ]);
        DB::table('roles')->insert([
            'slug' => 'members',
            'name' => 'Members',
            'permissions' => '{"app":false}',
        ]);
    }
}
