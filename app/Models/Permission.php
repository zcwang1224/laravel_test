<?php

namespace app\models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
	/**
	 *	table name
	 */    
    protected $table = 'permissions';
    /**
     * Primary Key
     */
    protected $primaryKey = 'id';
    /**
     * name
     */
    protected $name;
    /**
     * display_name
     */
    protected $display_name;
    /**
     * guard_name
     */    
    protected $guard_name;  

    /**
     * model_name
     */
    protected $model_name;      

    public function roles()
    {
        return $this->belongsToMany('app\models\Role','role_has_permissions','permission_id','role_id');
    }  
}
