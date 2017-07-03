<?php

namespace app\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NewsCategory extends Model
{
	use SoftDeletes;
	/**
	 *	Table name
	 */
	protected $table = 'news_category';

	/**
	 *	Primary key
	 */
	protected $primaryKey = 'news_category_id';

	/**
	 *	Category Name
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

	public static function boot()
	{
	    parent::boot();

	    static::deleted(function ($model) {
	        // Probably lazy load these relationships to avoid lots of queries?
	        $model->load([ 'newsItems']);

	        $model->newsItems()->delete();
	    });
	}

    /**
     * Get the news items for the news category.
     */
    public function newsItems()
    {
        return $this->hasMany('app\models\NewsItem','news_category_id','news_category_id');
    }     
}
