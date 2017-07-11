<?php

namespace app\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductStand extends Model
{
    //
    use SoftDeletes;

	/**
	 *	Table name
	 */
	protected $table = 'product_stand';   

	/**
	 *	Primary key
	 */
	protected $primaryKey = 'product_stand_id';	    
	/**
	 *	product_item_id
	 */
	protected $product_item_id;	

    /**
     *  price
     */
    protected $price; 

    /**
     *  inventory
     */
    protected $inventory;   

    /**
     *  product_stand_number
     *  商品編號
     */ 
    protected $product_stand_number;             

	/**
	 *	Sort
	 */
	protected $sort;

    /**
     * SoftDeletes: 刪除時會自動記錄刪除日期
     *
     * @var string
     */
    protected $dates = ['deleted_at'];

    /**
     * product Model 多對一設定
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function productItem()
    {
    	return $this->BelongsTo('app\models\ProductItem', 'product_item_id', 'product_item_id');
    }	
    /**
     * product stand item Model 多對一設定
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function productStandItems()
    {
        return $this->hasMany('app\models\ProductStandItem', 'product_stand_id', 'product_stand_id');
    }       
}
