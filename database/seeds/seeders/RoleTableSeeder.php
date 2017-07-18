<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = config('permission.roles');
        foreach($roles as $key => $value)
        {
        	Role::create(['name' => $value['name'],'display_name' => $value['display_name']]);
        }
    }
}
