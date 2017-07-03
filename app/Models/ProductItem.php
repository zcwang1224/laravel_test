<?php

namespace app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductItem extends Model
{
	use SoftDeletes;
	/**
	 *	Table name
	 */
	protected $table = 'product_item';

	/**
	 *	Primary key
	 */
	protected $primaryKey = 'product_item_id';

	/**
	 *	Category Name
	 */
	protected $name;

	/**
	 *	Parent
	 */
	protected $product_category_id;

	/**
	 *	Image
	 */
	protected $image;

	/**
	 *	Description 1
	 */
	protected $description1;

	/**
	 *	Description 2
	 */
	protected $description2;	

	/**
	 *	Content Editor - 商品特色
	 */
	protected $content1;

	/**
	 *	Content Editor - 商品規格
	 */
	protected $content2;

	/**
	 *	Content Editor - 退/換貨需知
	 */
	protected $content3;

	/**
	 *	Content Editor - 其他
	 */
	protected $content4;			

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
     * productCategory Model 多對一設定
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
	public function productCategory()
	{
		return $this->BelongsTo('app\models\ProductCategory', 'product_category_id', 'product_category_id');
	}

    /**
     * productItem Model 多對多設定 - 相關商品
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
	public function itemHasRelated()
	{
		return $this->BelongsToMany('app\models\ProductItem', 'product_item_related','product_item_id', 'product_related_id');
	}		

    /**
     * productItemImage Model 一對多設定
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
	public function productItemImages()
	{
		return $this->hasMany('app\models\ProductItemImage', 'product_item_id', 'product_item_id');
	}

}
