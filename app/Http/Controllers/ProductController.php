<?php

namespace app\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use app\Models\Product;
use app\Models\ProductCategory;
use app\Models\ProductItem;
use app\Models\ProductItemImage;
use app\Models\Stand;
use app\Models\StandItem;
use app\Models\ProductStand;
use app\Models\ProductStandItem;
class ProductController extends Controller
{
    /**
     * Index View Controller
     * @param 
     * @return \Illuminate\Http\Response
     */    
    protected function index()
    {
    	try
    	{
            $product = Product::first();
            $this->data['product'] = $product;
    		return view('admin.content.product.index.index', $this->data);
    	}
    	catch(Exception $e)
    	{
            Log::error('------------------------------------------錯誤: ' . get_class($this) . '@productIndex---------------------------------------------');
            Log::error($e->getMessage());             
            Log::error($e->getTraceAsString());
            return view('error.500');
    	}
    }

    /**
     * Index Edit Controller
     * @param 
     * @return \Illuminate\Http\Response
     */
    protected function edit(Request $request)
    {
        try
        {

        /* Validation Form Data */
            $this->validate($request, [
                'seo_title'       => 'required|max:100',
                'seo_description' => 'required|max:100',
                'seo_keyword'     => 'required|max:100',
            ]);    
        /* Get Data */
            $input           = $request->all();
            $product_collection = Product::all();

        /* Store Data */
            if($product_collection->count() == 1)
            {
                $product = Product::first();
            }
            else
            {
                $product = new Product;
            }
            $product->seo_title       = $input['seo_title'];
            $product->seo_description = $input['seo_description'];
            $product->seo_keyword     = $input['seo_keyword'];
            $product->content         = $input['content'];
            $product->save();
            return redirect()->action('ProductController@index');
        }
        catch(Exception $e)
        {
            Log::error('------------------------------------------錯誤: ' . get_class($this) . '@productEdit---------------------------------------------');
            Log::error($e->getMessage());             
            Log::error($e->getTraceAsString());
            return view('error.500');
        }
    }   
    /**
     * Category Index Controller
     * @param 
     * @return \Illuminate\Http\Response
     */
    protected function category($category_id = null,Request $request)
    {
        try
        {
            $per_page = 10;
            if($request->search != '')
            {
                $productCategories = ProductCategory::where('name','like','%'.$request->search.'%')
                                                        ->paginate($per_page);    
            }
            else
            {
                if($category_id === null)
                {
                    $productCategories = ProductCategory::with('ProductCategory','ProductCategories')->whereRaw('product_category_id = parent')
                                                            ->paginate($per_page);
                }
                else
                {
                    $productCategories = ProductCategory::with('ProductCategory','ProductCategories')->where('parent', '=', $category_id)
                                                            ->whereRaw('product_category_id != parent')
                                                            ->paginate($per_page);
                }
                
            }
            $this->data['productCategories'] = $productCategories;
            return view('admin.content.product.category.index',$this->data);
        }
        catch(Exception $e)
        {
            Log::error('------------------------------------------錯誤: ' . get_class($this) . '@category---------------------------------------------');
            Log::error($e->getMessage());             
            Log::error($e->getTraceAsString());
            return view('error.500');
        }
    }  

    /**
     * Category Create Controller
     * @param 
     * @return \Illuminate\Http\Response
     */
    protected function categoryCreate(Request $request)
    {
        try
        {
            $data['productCategories'] = ProductCategory::all();
            if($request->isMethod('post'))
            {
                // Log::info($request);
                // exit();
                /* -------- Validation Form Data -------- */
                $this->validate($request, [
                    'name'            => 'required|max:100',
                    'seo_title'       => 'required|max:100',
                    'seo_description' => 'required|max:100',
                    'seo_keyword'     => 'required|max:100',
                ]); 
                
                /* -------- Create A New Product Category Instance -------- */                
                $updateData                       = $request->all();               
                $productCategory                  = new ProductCategory;
                $productCategory->name            = $updateData['name'];
                $productCategory->image           = $updateData['image'   ];
                $productCategory->parent          = $updateData['parent'];
                $productCategory->seo_title       = $updateData['seo_title'];
                $productCategory->seo_description = $updateData['seo_description'];
                $productCategory->seo_keyword     = $updateData['seo_keyword'];
                $productCategory->content         = $updateData['content'];
                /* Status */
                if(isset($updateData['status']) && $updateData['status']==1) 
                {
                    $productCategory->status = 1;
                }
                else
                {
                    $productCategory->status = 0;
                }

                $productCategory->save();   
                
                return redirect()->action('ProductController@category');             
            }


            return view('admin.content.product.category.create',$data);
        }
        catch(Exception $e)
        {
            Log::error('------------------------------------------錯誤: ' . get_class($this) . '@categoryCreate---------------------------------------------');
            Log::error($e->getMessage());             
            Log::error($e->getTraceAsString());
            return view('error.500');
        }
    } 

    /**
     * Category Edit Controller
     * @param 
     * @return \Illuminate\Http\Response
     */
    protected function categoryEdit($id,Request $request)
    {
        try
        {
            /* ------------ 上層分類下拉選單 -------------*/
            $childCategories                  = explode(',',$this->getChildCategoriesId($id));
            $this->data['categoriesDropMenu'] = DB::table('product_category')
                                                    ->whereNotIn('product_category_id', $childCategories)
                                                    ->where('product_category_id', '!=', $id)
                                                    ->get();

            $productCategory = ProductCategory::findOrFail($id);
            if($request->isMethod('post'))
            {
                /* -------- Validation Form Data -------- */
                $this->validate($request, [
                    'name'            => 'required|max:100',
                    'seo_title'       => 'required|max:100',
                    'seo_description' => 'required|max:100',
                    'seo_keyword'     => 'required|max:100',
                ]);  
                /* -------- Basic Data --------  */
                $updateData              = $request->all(); 
                $productCategory->parent = $updateData['parent' ];
                $productCategory->name   = $updateData['name'   ];
                $productCategory->image  = $updateData['image'  ];
                if(isset($updateData['status']) && $updateData['status']==1) 
                {
                    $productCategory->status = 1;
                }
                else
                {
                    $productCategory->status = 0;
                }
                $productCategory->seo_title       = $updateData['seo_title'];
                $productCategory->seo_description = $updateData['seo_description'];
                $productCategory->seo_keyword     = $updateData['seo_keyword'];
                $productCategory->content         = $updateData['content'];

                $productCategory->save();   
                
                return redirect()->action('ProductController@category');             
            }
            $this->data['productCategory'] = $productCategory;
            return view('admin.content.product.category.edit',$this->data);
        }
        catch(Exception $e)
        {
            Log::error('------------------------------------------錯誤: ' . get_class($this) . '@categoryEdit---------------------------------------------');
            Log::error($e->getMessage());             
            Log::error($e->getTraceAsString());
            return view('error.500');
        }
    }   

    /**
     * Category Delete Controller
     * SoftDelete 
     * @param $id - product_category_id
     * @return \Illuminate\Http\Response
     */
    protected function categoryDelete($id)
    {
        try
        {
            $productCategory = ProductCategory::findOrFail($id);
            $productCategory->delete();
            return redirect()->action('ProductController@category');
        }
        catch(Exception $e)
        {
            Log::error('------------------------------------------錯誤: ' . get_class($this) . '@categoryDelete---------------------------------------------');
            Log::error($e->getMessage());             
            Log::error($e->getTraceAsString());
            return view('error.500');
        }
    }  

    /**
     * Category Index Multiple action
     *  
     * @param 
     * @return \Illuminate\Http\Response
     */
    protected function categoryMultipleAction(Request $request)
    {
        try
        {
            // Log::info($request);
            $action                 = $request->input('multiple_action');
            $checked_categories_str = $request->input('checked_categories');
            if(!$checked_categories_str == '' && $checked_categories_str != null)
            {
                $categoryArray = explode(',', $checked_categories_str);

                if(count($categoryArray) > 0)
                {
                    switch ($action) 
                    {
                        case 'delete':
                            foreach ($categoryArray as $key => $category_id) 
                            {
                                $productCategory = ProductCategory::findOrFail($category_id);
                                
                                $productCategory->delete();
                            }
                            return redirect()->action('ProductController@category');
                            break;
                        case 'hide':
                            foreach ($categoryArray as $key => $category_id) 
                            {
                                $productCategory = ProductCategory::findOrFail($category_id);
                                $productCategory->status = 0;
                                $productCategory->save();
                            }
                            return redirect()->action('ProductController@category');
                            break; 
                        case 'show':
                            foreach ($categoryArray as $key => $category_id) 
                            {
                                $productCategory = ProductCategory::findOrFail($category_id);
                                $productCategory->status = 1;
                                $productCategory->save();
                            }
                            return redirect()->action('ProductController@category');
                            break;                                    
                        default:
                            # code...
                            break;
                    }                
                }
            }
            return redirect()->action('ProductController@category');
        }
        catch(Exception $e)
        {
            Log::error('------------------------------------------錯誤: ' . get_class($this) . '@categoryMultipleAction---------------------------------------------');
            Log::error($e->getMessage());             
            Log::error($e->getTraceAsString());
            return view('error.500');
        }
    } 

    /**
     * Item Index Controller
     * @param 
     * @return \Illuminate\Http\Response
     */
    protected function item(Request $request)
    {
        try
        {
            $per_page = 10;
            if($request->search != '')
            {
                $productItems = ProductItem::with('ProductCategory')
                                                ->select('product_item.*')
                                                ->leftJoin('product_category', 'product_category.product_category_id', '=', 'product_item.product_category_id')
                                                ->where('product_item.name','like','%'.$request->search.'%')
                                                ->orWhere('product_item.name','like','%'.$request->search.'%')
                                                ->paginate($per_page);    
            }
            else
            {
                    $productItems = ProductItem::with('ProductCategory')
                                                ->paginate($per_page);
                
            }

            $this->data['productItems'] = $productItems;
            return view('admin.content.product.item.index',$this->data);
        }
        catch(Exception $e)
        {
            Log::error('------------------------------------------錯誤: ' . get_class($this) . '@category---------------------------------------------');
            Log::error($e->getMessage());             
            Log::error($e->getTraceAsString());
            return view('error.500');
        }
    } 
    /**
     * Item Create Controller
     * @param 
     * @return \Illuminate\Http\Response
     */
    protected function itemCreate(Request $request)
    {
        try
        {
            $data['productCategories'] = ProductCategory::all();
            if($request->isMethod('post'))
            {
                // Log::info($request);
                // exit();
                /* -------- Validation Form Data -------- */
                $this->validate($request, [
                    'name'            => 'required|max:100',
                    'seo_title'       => 'required|max:100',
                    'seo_description' => 'required|max:100',
                    'seo_keyword'     => 'required|max:100',
                ]); 
                
                /* -------- Create A New Product Category Instance -------- */                
                $updateData                       = $request->all();               
                $productItem                      = new ProductItem;
                $productItem->product_category_id = $updateData['product_category'  ];
                $productItem->name                = $updateData['name'              ];
                $productItem->description1        = $updateData['description1'      ];
                $productItem->description2        = $updateData['description2'      ];
                $productItem->image               = $updateData['image'             ];
                $productItem->content1            = $updateData['content1'          ];
                $productItem->content2            = $updateData['content2'          ];
                $productItem->content3            = $updateData['content3'          ];
                $productItem->content4            = $updateData['content4'          ];                
                $productItem->seo_title           = $updateData['seo_title'         ];
                $productItem->seo_description     = $updateData['seo_description'   ];
                $productItem->seo_keyword         = $updateData['seo_keyword'       ];
                $productItem->save(); 
                /* Status */
                if(isset($updateData['status']) && $updateData['status']==1) 
                {
                    $productItem->status = 1;
                }
                else
                {
                    $productItem->status = 0;
                }

                // 相關產品
                $productItem->itemHasRelated()->detach();
                if(!is_null($updateData['related_items']))
                {
                    $related_ids = explode(',',$updateData['related_items']);
                    $productItem->itemHasRelated()->attach($related_ids);
                }

                // 商品圖片
                $productItem->productItemImages()->delete();
                if(isset($updateData['multiple_image_comment']))
                {
                    foreach($updateData['multiple_image_comment'] as $key => $value)
                    {
                        $productItemImage                  = new ProductItemImage;
                        $productItemImage->image_comment   = $value;
                        $productItemImage->image_path      = $updateData['multiple_image'][$key];
                        $productItemImage->product_item_id = $productItem->product_item_id;
                        $productItemImage->save();
                    }                    
                }                
                // 規格名稱 - stand name
                $productItem->stands()->delete();
                $stand_name_arr = array();
                if(isset($updateData['stand_name']))
                {
                    foreach($updateData['stand_name_number'] as $stand_name_number_key => $stand_name_number_value)
                    {
                        $stand                  = new Stand;
                        $stand->stand_name      = $updateData['stand_name'][$stand_name_number_key];
                        $stand->product_item_id = $productItem->product_item_id;
                        $stand->stand_item      = $updateData['stand_'.$stand_name_number_value];                       
                        $stand->save();
                        $stand_name_arr[$stand_name_number_key] = $stand;
                        // 規格項目 - stand item
                        foreach(explode(',',$updateData['stand_'.$stand_name_number_value]) as $stand_item_key => $stand_item_value)
                        {
                            $standItem = new StandItem;
                            $standItem->stand_item_name = $stand_item_value;
                            $standItem->stand_id = $stand->stand_id;
                            $standItem->save();                                
                        }
                    }   
                }
                // 商品規格
                if(isset($updateData['product_stand_0']) && isset($updateData['stand_name']))
                {
                    $count_product_stand = count($updateData['product_stand_0']);
                    $count_stand_name    = count($updateData['stand_name']);
                    $product_item_ids    = array();
                    // 刪除不存在資料庫中沒有對應的product stand
                    for($i = 0 ; $i < $count_product_stand ; $i++)
                    {
                        $product_item_ids[$i] = $updateData['product_stand_id_'.$i];
                    }                 
                    $toBeDeletes = $productItem->productStands->whereNotIn('product_stand_id',$product_item_ids);
                    foreach ($toBeDeletes as $key => $value) {
                        $toBeDelete = ProductStand::findOrFail($value->product_stand_id);
                        $toBeDelete->delete();
                    }

                    // 存入資料庫
                    for($i = 0 ; $i < $count_product_stand ; $i++)
                    {

                        if($updateData['product_stand_id_'.$i] != 'null' && $updateData['product_stand_id_'.$i] != 'undefined')
                        {
                            $productStand            = ProductStand::with(['productStandItems'])->findOrFail($updateData['product_stand_id_'.$i]);
                            $productStand->price     = $updateData['product_stand_price_'.$i];
                            $productStand->inventory = $updateData['product_stand_inventory_'.$i];
                            $productStand->save();
                            $old_stand_item = array();
                            foreach($productStand->productStandItems as $productStandItem_key => $productStandItem_value)
                            {
                                $old_stand_item[$productStandItem_key] = $productStandItem_value->stand_item;
                            }
                            for($j = 0 ; $j < $count_stand_name ; $j++)
                            {
                                if(!in_array($updateData['product_stand_'.$j][$i], $old_stand_item))
                                {
                                    $productStandItem                   = new ProductStandItem;
                                    $productStandItem->product_stand_id = $productStand->product_stand_id;
                                    $productStandItem->stand_id         = $stand_name_arr[$j]->stand_id;
                                    $productStandItem->stand_item       = $updateData['product_stand_'.$j][$i];
                                    $productStandItem->save();                                    
                                }      
                            }
                        }
                        else
                        {
                            $productStand                  = new ProductStand;
                            $productStand->product_item_id = $productItem->product_item_id;
                            $productStand->price           = $updateData['product_stand_price_'.$i];
                            $productStand->inventory       = $updateData['product_stand_inventory_'.$i];
                            // $productStand->product_stand_number = $updateData['product_stand_price_'.$i];
                            $productStand->save();
                            for($j = 0 ; $j < $count_stand_name ; $j++)
                            {
                                $productStandItem                   = new ProductStandItem;
                                $productStandItem->product_stand_id = $productStand->product_stand_id;
                                $productStandItem->stand_id         = $stand_name_arr[$j]->stand_id;
                                $productStandItem->stand_item       = $updateData['product_stand_'.$j][$i];
                                $productStandItem->save();
                            }                             
                        }
                    }                    
                }
                else
                {
                    foreach($productItem->productStands as $productStand_key => $productStand_value)
                    {
                        foreach($productStand_value->productStandItems as $productStandItem_key => $productStandItem_value)
                        {
                            $productStandItem_value->delete();
                        }
                        $productStand_value->delete();

                    }

                    foreach($productItem->stands as $stand_key => $stand_value)
                    {
                        foreach($stand_value->standItems as $standItem_key => $standItem_value)
                        {
                            $standItem_value->delete();
                        }
                        $stand_value->delete();
                        
                    }
                }                
  
                
                return redirect()->action('ProductController@item');             
            }


            return view('admin.content.product.item.create',$data);
        }
        catch(Exception $e)
        {
            Log::error('------------------------------------------錯誤: ' . get_class($this) . '@categoryCreate---------------------------------------------');
            Log::error($e->getMessage());             
            Log::error($e->getTraceAsString());
            return view('error.500');
        }
    } 

    /**
     * Item Edit Controller
     * @param 
     * @return \Illuminate\Http\Response
     */
    protected function itemEdit(ProductItem $productItem,Request $request)
    {
        try
        {
            // 上層分類下拉選單
            $productCategories = ProductCategory::all();
            $productItem->load(['stands','stands.standItems','productStands','productStands.productStandItems']);
      // Log::info($productItem);
            if($request->isMethod('post'))
            {
                Log::info($request);
                // exit();
                /* -------- Validation Form Data -------- */
                $this->validate($request, [
                    'name'            => 'required|max:100',
                    'seo_title'       => 'required|max:100',
                    'seo_description' => 'required|max:100',
                    'seo_keyword'     => 'required|max:100',
                ]);  
                /* -------- Basic Data --------  */
                $updateData                       = $request->all(); 
                $productItem->product_category_id = $updateData['product_category_id'];
                $productItem->name                = $updateData['name'];
                $productItem->image               = $updateData['image'];
                $productItem->content1            = $updateData['content1'];
                $productItem->content2            = $updateData['content2'];
                $productItem->content3            = $updateData['content3'];
                $productItem->content4            = $updateData['content4'];
                if(isset($updateData['status']) && $updateData['status']==1) 
                {
                    $productItem->status = 1;
                }
                else
                {
                    $productItem->status = 0;
                }
                $productItem->seo_title       = $updateData['seo_title'];
                $productItem->seo_description = $updateData['seo_description'];
                $productItem->seo_keyword     = $updateData['seo_keyword'];


                // 相關產品
                $productItem->itemHasRelated()->detach();
                if(!is_null($updateData['related_items']))
                {
                    $related_ids = explode(',',$updateData['related_items']);
                    $productItem->itemHasRelated()->attach($related_ids);
                }

                // 商品圖片
                $productItem->productItemImages()->delete();
                if(isset($updateData['multiple_image_comment']))
                {
                    foreach($updateData['multiple_image_comment'] as $key => $value)
                    {
                        $productItemImage                  = new ProductItemImage;
                        $productItemImage->image_comment   = $value;
                        $productItemImage->image_path      = $updateData['multiple_image'][$key];
                        $productItemImage->product_item_id = $productItem->product_item_id;
                        $productItemImage->save();
                    }                    
                }
                // 規格名稱 - stand name
                $productItem->stands()->delete();
                $stand_name_arr = array();
                if(isset($updateData['stand_name']))
                {
                    foreach($updateData['stand_name_number'] as $stand_name_number_key => $stand_name_number_value)
                    {
                        $stand                  = new Stand;
                        $stand->stand_name      = $updateData['stand_name'][$stand_name_number_key];
                        $stand->product_item_id = $productItem->product_item_id;
                        $stand->stand_item      = $updateData['stand_'.$stand_name_number_value];                       
                        $stand->save();
                        $stand_name_arr[$stand_name_number_key] = $stand;
                        // 規格項目 - stand item
                        foreach(explode(',',$updateData['stand_'.$stand_name_number_value]) as $stand_item_key => $stand_item_value)
                        {
                            $standItem = new StandItem;
                            $standItem->stand_item_name = $stand_item_value;
                            $standItem->stand_id = $stand->stand_id;
                            $standItem->save();                                
                        }
                    }   
                }
                // 商品規格
                if(isset($updateData['product_stand_0']) && isset($updateData['stand_name']))
                {
                    $count_product_stand = count($updateData['product_stand_0']);
                    $count_stand_name    = count($updateData['stand_name']);
                    $product_item_ids    = array();
                    // 刪除不存在資料庫中沒有對應的product stand
                    for($i = 0 ; $i < $count_product_stand ; $i++)
                    {
                        $product_item_ids[$i] = $updateData['product_stand_id_'.$i];
                    }                 
                    $toBeDeletes = $productItem->productStands->whereNotIn('product_stand_id',$product_item_ids);
                    foreach ($toBeDeletes as $key => $value) {
                        $toBeDelete = ProductStand::findOrFail($value->product_stand_id);
                        $toBeDelete->delete();
                    }

                    // 存入資料庫
                    for($i = 0 ; $i < $count_product_stand ; $i++)
                    {

                        if($updateData['product_stand_id_'.$i] != 'null' && $updateData['product_stand_id_'.$i] != 'undefined')
                        {
                            $productStand            = ProductStand::with(['productStandItems'])->findOrFail($updateData['product_stand_id_'.$i]);
                            $productStand->price     = $updateData['product_stand_price_'.$i];
                            $productStand->inventory = $updateData['product_stand_inventory_'.$i];
                            $productStand->save();
                            $old_stand_item = array();
                            foreach($productStand->productStandItems as $productStandItem_key => $productStandItem_value)
                            {
                                $old_stand_item[$productStandItem_key] = $productStandItem_value->stand_item;
                            }
                            for($j = 0 ; $j < $count_stand_name ; $j++)
                            {
                                if(!in_array($updateData['product_stand_'.$j][$i], $old_stand_item))
                                {
                                    $productStandItem                   = new ProductStandItem;
                                    $productStandItem->product_stand_id = $productStand->product_stand_id;
                                    $productStandItem->stand_id         = $stand_name_arr[$j]->stand_id;
                                    $productStandItem->stand_item       = $updateData['product_stand_'.$j][$i];
                                    $productStandItem->save();                                    
                                }      
                            }
                        }
                        else
                        {
                            $productStand                  = new ProductStand;
                            $productStand->product_item_id = $productItem->product_item_id;
                            $productStand->price           = $updateData['product_stand_price_'.$i];
                            $productStand->inventory       = $updateData['product_stand_inventory_'.$i];
                            // $productStand->product_stand_number = $updateData['product_stand_price_'.$i];
                            $productStand->save();
                            for($j = 0 ; $j < $count_stand_name ; $j++)
                            {
                                $productStandItem                   = new ProductStandItem;
                                $productStandItem->product_stand_id = $productStand->product_stand_id;
                                $productStandItem->stand_id         = $stand_name_arr[$j]->stand_id;
                                $productStandItem->stand_item       = $updateData['product_stand_'.$j][$i];
                                $productStandItem->save();
                            }                             
                        }
                    }                    
                }
                else
                {
                    foreach($productItem->productStands as $productStand_key => $productStand_value)
                    {
                        foreach($productStand_value->productStandItems as $productStandItem_key => $productStandItem_value)
                        {
                            $productStandItem_value->delete();
                        }
                        $productStand_value->delete();

                    }

                    foreach($productItem->stands as $stand_key => $stand_value)
                    {
                        foreach($stand_value->standItems as $standItem_key => $standItem_value)
                        {
                            $standItem_value->delete();
                        }
                        $stand_value->delete();
                        
                    }
                }



                // Log::info($productItem->stands);
                // Log::info($inputStandName->intersect($productItem->stands));

                /* -------- Image Upload --------  */
                // if($request->file('image'))
                // {   
                //     //刪除舊有檔案
                //     if(Storage::exists($productItem->image))
                //     {
                //         Storage::delete($productItem->image);
                //     }
                //     //存入檔案與資料庫
                //     $dateTime  = date('YmdHis');
                //     $file_name = $dateTime.'_'.$request->file('image')->getClientOriginalName();
                //     $request->file('image')->storeAs('upload/product/category/', $file_name);
                //     $productItem->image = '/upload/product/category/'.$file_name;
                // }

                $productItem->save();   
               
                return redirect()->action('ProductController@item');             
            }
            
            $this->data['productCategories'] = $productCategories;
            $this->data['productItem']       = $productItem;
            return view('admin.content.product.item.edit',$this->data);
        }
        catch(Exception $e)
        {
            Log::error('------------------------------------------錯誤: ' . get_class($this) . '@categoryEdit---------------------------------------------');
            Log::error($e->getMessage());             
            Log::error($e->getTraceAsString());
            return view('error.500');
        }
    }   

    /**
     * 遞迴取得特定分類中所有的子分類 Recursive
     * @param int category_id 特定分類
     * @return string
     */
    public function getChildCategoriesId( $category_id = 0 )
    {
        $item = '';

        if($category_id == 0)
        {
            $categories = ProductCategory::whereRaw('product_category_id = parent')
                                            ->get();          
        }
        else
        {
            $categories = ProductCategory::where('parent', '=', $category_id)
                                            ->whereRaw('product_category_id != parent')
                                            ->get();  
        }
        // 遞迴取得所有下層子分類
        if($categories->count() != 0)
        {
            foreach ( $categories as $category ) {
                $childs = $this->getChildCategoriesId( $category[ 'product_category_id' ] );
                // 某分類及其子分類包成陣列後存入陣列
                if($childs == '' && $item == '')
                {
                    $item = $category->product_category_id;
                }
                elseif($childs == '')
                {
                    $item = $item.','.$category->product_category_id;
                }
                else
                {
                    $item = $childs.','.$category->product_category_id.$item;
                }
            }            
        }
        // Log::info($item);
        return $item;
    } 



    /**
     * Item Index Multiple action
     *  
     * @param 
     * @return \Illuminate\Http\Response
     */
    protected function itemMultipleAction(Request $request)
    {
        try
        {
            // Log::info($request);
            $action            = $request->input('multiple_action');
            $checked_items_str = $request->input('checked_categories');
            if(!$checked_items_str == '' && $checked_items_str != null)
            {
                $itemArray = explode(',', $checked_items_str);

                if(count($itemArray) > 0)
                {
                    switch ($action) 
                    {
                        case 'delete':
                            foreach ($itemArray as $key => $item_id) 
                            {
                                $productItem = ProductItem::findOrFail($item_id);
                                $productItem->delete();
                            }
                            return redirect()->action('ProductController@item');
                            break;
                        case 'hide':
                            foreach ($itemArray as $key => $item_id) 
                            {
                                $productItem = ProductItem::findOrFail($item_id);
                                $productItem->status = 0;
                                $productItem->save();
                            }
                            return redirect()->action('ProductController@item');
                            break; 
                        case 'show':
                            foreach ($itemArray as $key => $item_id) 
                            {
                                $productItem = ProductItem::findOrFail($item_id);
                                $productItem->status = 1;
                                $productItem->save();
                            }
                            return redirect()->action('ProductController@item');
                            break;                                    
                        default:
                            # code...
                            break;
                    }                
                }
            }
            return redirect()->action('ProductController@item');
        }
        catch(Exception $e)
        {
            Log::error('------------------------------------------錯誤: ' . get_class($this) . '@itemMultipleAction---------------------------------------------');
            Log::error($e->getMessage());             
            Log::error($e->getTraceAsString());
            return view('error.500');
        }
    } 
    /**
     * Item Index Controller
     * @param 
     * @return \Illuminate\Http\Response
     */
    protected function itemPopup(Request $request)
    {
        try
        {
            $ids        = explode(',', $request['ids']);
            $current_id = $request['current_id'];
            $per_page   = 10;
            if($request->search != '')
            {
                $productItems = ProductItem::with('ProductCategory')
                                                ->select('product_item.*')
                                                ->leftJoin('product_category', 'product_category.product_category_id', '=', 'product_item.product_category_id')
                                                ->where('product_item.name','like','%'.$request->search.'%')
                                                ->orWhere('product_item.name','like','%'.$request->search.'%')
                                                ->paginate($per_page);    
            }
            else
            {
                    $productItems = ProductItem::with('ProductCategory')
                                                ->whereNotIn('product_item_id',$ids)
                                                ->where('product_item_id', '!=', $current_id)
                                                ->paginate($per_page);
                
            }
            $this->data['productItems'] = $productItems;
            return view('admin.content.product.item.index_popup',$this->data);
        }
        catch(Exception $e)
        {
            Log::error('------------------------------------------錯誤: ' . get_class($this) . '@category---------------------------------------------');
            Log::error($e->getMessage());             
            Log::error($e->getTraceAsString());
            return view('error.500');
        }
    }     

}
