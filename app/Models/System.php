<?php

namespace app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class System extends Model
{
    
	use SoftDeletes;

    /**
     * Table name
     */
    protected $table = 'system';
    /**
     * Primary Key
     */
    protected $primaryKey = 'system_id';
    /**
     * Image
     */
    protected $image;
    /**
     * content
     */
    protected $content; 
    /**
     * content1
     */
    protected $content1; 
    /**
     * content2
     */
    protected $content2;                
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
