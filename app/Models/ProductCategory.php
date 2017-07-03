<?php

namespace app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;
class ProductCategory extends Model
{
	use SoftDeletes;
	/**
	 *	Table name
	 */
	protected $table = 'product_category';

	/**
	 *	Primary key
	 */
	protected $primaryKey = 'product_category_id';

	/**
	 *	Category Name
	 */
	protected $name;

	/**
	 *	Parent
	 */
	protected $parent;

	/**
	 *	Image
	 */
	protected $image;

	/**
	 *	Content Editor
	 */
	protected $content;

	/**
	 *	Seo title
	 */
	protected $seo_title;

	/**
	 *	Seo description
	 */
	protected $seo_description;

	/**
	 *	Seo keyword
	 */
	protected $seo_keyword;

	/**
	 *	Status (show or hide)
	 */
	protected $status;	

    /**
     * SoftDeletes: 刪除時會自動記錄刪除日期
     *
     * @var string
     */
    protected $dates = ['deleted_at'];
    
	public static function boot()
	{
	    parent::boot();

	    static::deleting(function ($model) {
	        $model->load(['productCategories' => function($query){ $query->whereRaw('product_category_id != parent');},
						  'productItems']);
	       
	        foreach($model->productCategories as $key => $productCategory)
	        {
	        	$productCategory->delete();
	        }
	        $model->productItems()->delete(); 
	    });
	}

    /**
     * productCategory Model 多對一設定
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
	public function productCategory()
	{
		return $this->belongsTo('app\models\ProductCategory','parent','product_category_id');
	}

    /**
     * productCategory Model 一對多設定
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
	public function productCategories()
	{
		return $this->hasMany('app\models\ProductCategory','parent','product_category_id');
	}

    /**
     * productItem Model 一對多設定
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
	public function productItems()
	{
		return $this->hasMany('app\models\ProductItem','product_category_id','product_category_id');
	}	

}
