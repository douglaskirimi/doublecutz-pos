<?php

use Illuminate\Database\Seeder;
 use Illuminate\Support\Facades\DB;
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('modules')->insert([[
            'name' => "Users",
            
        ],[
            'name' => "Roles"
            
        ],]);
       
        DB::table('roles')->insert([
            'name' => "Administrator",
          
        ]);
        DB::table('permissions')->insert([
            'role_id' => "1",
            'module_id' => "1",
            'can_view' => "1",
            'can_create' => "1",
            'can_update' => "1",
            'can_delete' => "1",
          
        ],[
            'role_id' => "1",
            'module_id' => "2",
            'can_view' => "1",
            'can_create' => "1",
            'can_update' => "1",
            'can_delete' => "1",
          
        ]);
        DB::table('usergroups')->insert([
            ['name'=>'secretary'],
            ['name'=>'admin'],
            ['name'=>'super-admin']
        ]);
        DB::table('users')->insert([
            'f_name' => "Admin",
            'l_name' => "User",
            'image' => "user.jpg",
            'email' => 'admin@egmail.com',
            'role_id'=>'1',
            'usergroup_id'=>'1',
            'password' => bcrypt('password'),
        ]);


    }
}
