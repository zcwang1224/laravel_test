<?php

namespace app\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use app\Models\ProductCategory;
use Illuminate\Support\Facades\Log;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests; 

    protected $productCategory;
    protected $data = array();

    public function __construct()
    {
    	// $this->data['productCategories'] = $this->getChildCategories();
    }

    /**
     * 由最上層開始遞迴取得各層分類
     * @param int $of_id 上層分類id，0 為最上層
     * @return array
     */
    // public function getChildCategories( $category_id = 0 )
    // {
    //     $item = [];
    //     // 取得某一個分類的第一層子分類，並且只取回 id of_id title 欄位
    //     // 第一次取得的是最上層
    //     // $categories 為 collection
    //     if($category_id == 0)
    //     {
	   //      $categories = ProductCategory::whereRaw('product_category_id = parent')->get();        	
    //     }
    //     else
    //     {
    //     	$categories = ProductCategory::where('parent', '=', $category_id)->whereRaw('product_category_id != parent')->get();  
    //     }
    //     // 遞迴取得所有下層子分類
    //     if($categories->count() != 0)
    //     {

	   //      foreach ( $categories as $category ) {
	   //          $childs = $this->getChildCategories( $category[ 'product_category_id' ] );
	   //          // 某分類及其子分類包成陣列後存入陣列
	   //          $item[] = compact( 'category', 'childs' );
	   //      }        	
    //     }
    //     return $item;
    // }    

}
