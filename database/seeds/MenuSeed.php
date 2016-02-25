<?php

use Illuminate\Database\Seeder;

class MenuSeed extends Seeder
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
    }
}
