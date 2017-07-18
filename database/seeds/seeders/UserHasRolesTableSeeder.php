<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Auth;
use app\User;
class UserHasRolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::findOrFail(1);
        

        $roles = config('permission.roles');
        foreach($roles as $key => $value)
        {
        	$user->assignRole($value['name']);
        }      
    }
}
