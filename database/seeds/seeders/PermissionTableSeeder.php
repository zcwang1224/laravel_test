<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::findOrFail(1);
        $permissions = config('permission.permissions');
        foreach($permissions as $model_name => $model_permission)
        {
            foreach($model_permission['value'] as $group_key => $group_value)
            {
                foreach($group_value['value'] as $permission_key => $permission_value)
                {
                    $permission = Permission::create(['name' => $permission_value['name'], 'display_name' => $permission_value['display_name'], 'model_name' => $model_name]);   
                    $role->givePermissionTo($permission);                 
                }

            }
        	
        }
    }
}
