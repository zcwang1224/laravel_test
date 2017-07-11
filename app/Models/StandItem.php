<?php

namespace app\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class StandItem extends Model
{
    //
    use SoftDeletes;
	/**
	 *	table name
	 */    
    protected $table = 'stand_item';
    /**
     * Primary Key
     */
    protected $primaryKey = 'stand_item_id';   
    /**
     * stand_id
     */
    protected $stand_id;     
    /**
     * stand_item_name
     */
    protected $stand_item_name; 
    /**
     * sort
     */
    protected $sort;        
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];  

    /**
     * Stand Model 多對一設定
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function stand()
    {
    	return $this->BelongsTo('app\models\Stand', 'stand_id', 'stand_id');
    }        
}
