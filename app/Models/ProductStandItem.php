<?php

namespace app\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductStandItem extends Model
{
    //
    use SoftDeletes;

	/**
	 *	Table name
	 */
	protected $table = 'product_stand_item';   

	/**
	 *	Primary key
	 */
	protected $primaryKey = 'product_stand_item_id';	

	/**
	 *	product_item_id
	 */
	protected $product_stand_id;

	/**
	 *	stand_id
	 */
	protected $stand_id;

	/**
	 *	stand_item
	 */
	protected $stand_item;			

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
     * Product Stand Model 多對一設定
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function productStand()
    {
    	return $this->BelongsTo('app\models\ProductStand', 'product_stand_id', 'product_stand_id');
    }	

    /**
     * Stand Model 多對一設定
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function Stand()
    {
    	return $this->BelongsTo('app\models\Stand', 'stand_id', 'stand_id');
    }	    	
}
