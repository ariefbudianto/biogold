<?php

use Illuminate\Database\Seeder;

class RoleSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
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