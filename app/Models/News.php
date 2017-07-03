<?php

namespace app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class News extends Model
{
	use SoftDeletes;

    /**
     * Table name
     */
    protected $table = 'news';
    /**
     * Primary Key
     */
    protected $primaryKey = 'news_id';
    /**
     * Image
     */
    protected $image;
    /**
     * content
     */
    protected $content;        
    /**
     * Seo Title
     */
    protected $seo_title;
    /**
     * Seo Description.
     */
    protected $seo_description;
    /**
     * Seo keyword.
     */
    protected $seo_keyword;
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
}
