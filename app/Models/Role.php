<?php

namespace app\models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{

	/**
	 *	table name
	 */    
    protected $table = 'roles';
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

    public function permissions()
    {
        return $this->belongsToMany('app\models\Permission','role_has_permissions','role_id','permission_id');
    }   
}
