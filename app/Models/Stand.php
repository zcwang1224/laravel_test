<?php

namespace app\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stand extends Model
{
    use SoftDeletes;

	/**
	 *	table name
	 */    
    protected $table = 'stand';
    /**
     * Primary Key
     */
    protected $primaryKey = 'stand_id';
    /**
     * product_item_id
     */
    protected $product_item_id;
    /**
     * stand_name
     */
    protected $stand_name; 
    /**
     * stand_item
     */
    protected $stand_item;     
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
     * productItem Model 多對一設定
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function productItem()
    {
    	return $this->BelongsTo('app\models\ProductItem', 'product_item_id', 'product_item_id');
    } 

    /**
     * StandItem Model 一對多設定
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function standItems()
    {
        return $this->hasMany('app\models\StandItem', 'stand_id', 'stand_id');
    }    

    /**
     * product stand item Model 一對多設定
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function productStandItems()
    {
        return $this->hasMany('app\models\ProductStandItem', 'stand_id', 'stand_id');
    }              

}
