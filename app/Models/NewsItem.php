<?php

namespace app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NewsItem extends Model
{
	use SoftDeletes;
	/**
	 *	Table name
	 */
    protected $table = 'news_item';

	/**
	 *	Primary key
	 */
	protected $primaryKey = 'news_item_id';
	/**
	 *	Category ID
	 */
	protected $news_category_id;

	/**
	 *	Item Name
	 */
	protected $name;

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
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];


    /**
     * Get the news category that owns the news item.
     */
    public function newsCategory()
    {
        return $this->belongsTo('app\models\NewsCategory','news_category_id','news_category_id');
    }       
}
