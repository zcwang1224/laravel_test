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
                /* Image Upload */
                if($request->file('image'))
                {   
                    //刪除舊有檔案
                    if(Storage::exists($productCategory->image))
                    {
                        Storage::delete($productCategory->image);
                    }
                    //存入檔案與資料庫
                    $dateTime  = date('YmdHis');
                    $file_name = $dateTime.'_'.$request->file('image')->getClientOriginalName();
                    $request->file('image')->storeAs('upload/product/category/', $file_name);
                    $productCategory->image = '/upload/product/category/'.$file_name;
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
                $updateData                    = $request->all(); 
                $productCategory->parent            = $updateData['parent'];
                $productCategory->name            = $updateData['name'];
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

                /* -------- Image Upload --------  */
                if($request->file('image'))
                {   
                    //刪除舊有檔案
                    if(Storage::exists($productCategory->image))
                    {
                        Storage::delete($productCategory->image);
                    }
                    //存入檔案與資料庫
                    $dateTime  = date('YmdHis');
                    $file_name = $dateTime.'_'.$request->file('image')->getClientOriginalName();
                    $request->file('image')->storeAs('upload/product/category/', $file_name);
                    $productCategory->image = '/upload/product/category/'.$file_name;
                }

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
                $productItem->content1            = $updateData['content1'          ];
                $productItem->content2            = $updateData['content2'          ];
                $productItem->content3            = $updateData['content3'          ];
                $productItem->content4            = $updateData['content4'          ];                
                $productItem->seo_title           = $updateData['seo_title'         ];
                $productItem->seo_description     = $updateData['seo_description'   ];
                $productItem->seo_keyword         = $updateData['seo_keyword'       ];

                /* Status */
                if(isset($updateData['status']) && $updateData['status']==1) 
                {
                    $productItem->status = 1;
                }
                else
                {
                    $productItem->status = 0;
                }
                /* Image Upload */
                if($request->file('image'))
                {   
                    //刪除舊有檔案
                    if(Storage::exists($productItem->image))
                    {
                        Storage::delete($productItem->image);
                    }
                    //存入檔案與資料庫
                    $dateTime  = date('YmdHis');
                    $file_name = $dateTime.'_'.$request->file('image')->getClientOriginalName();
                    $request->file('image')->storeAs('upload/product/item/', $file_name);
                    $productItem->image = '/upload/product/item/'.$file_name;
                }

                $productItem->save();   
                
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

                $productItem->itemHasRelated()->detach();
                if(!is_null($updateData['related_items']))
                {
                    $related_ids = explode(',',$updateData['related_items']);
                    $productItem->itemHasRelated()->attach($related_ids);
                }

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
     * 檔案上傳
     * @param 
     * @return 
     */
    function itemMultipleFileUploadAction(Request $request)
    {
        Log::info($request->all());
        if($request->file('image'))
        {   
            //刪除舊有檔案
            if(Storage::exists($productItem->image))
            {
                Storage::delete($productItem->image);
            }
            //存入檔案與資料庫
            $dateTime  = date('YmdHis');
            $file_name = $dateTime.'_'.$request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs('upload/product/item/', $file_name);
            $productItem->image = '/upload/product/item/'.$file_name;
        }        
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