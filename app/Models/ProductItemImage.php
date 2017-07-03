<?php

namespace app\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductItemImage extends Model
{
    //
    use SoftDeletes;
	/**
	 *	Table name
	 */
	protected $table = 'product_item_image';   

	/**
	 *	Primary key
	 */
	protected $primaryKey = 'product_item_image_id';	

	/**
	 *	image path
	 */
	protected $image_path;	

	/**
	 *	image thumbnail path
	 */
	protected $image_thumbnail;	

	/**
	 *	image comment
	 */
	protected $image_comment;

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
     * productItem Model 多對一設定
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function productItem()
    {
    	return $this->BelongsTo('app\models\ProductItem', 'product_item_id', 'product_item_id');
    }				
}
