<?php

namespace app\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use app\Models\News;
use app\Models\NewsCategory;
use app\Models\NewsItem;

class NewsController extends Controller
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
            $news = News::first();
            $this->data['news'] = $news;
    		return view('admin.content.news.index.index', $this->data);
    	}
    	catch(Exception $e)
    	{
            Log::error('------------------------------------------錯誤: ' . get_class($this) . '@newsIndex---------------------------------------------');
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
            $news_collection = News::all();

        /* Store Data */
            if($news_collection->count() == 1)
            {
                $news = News::first();
            }
            else
            {
                $news = new News;
            }
            $news->seo_title       = $input['seo_title'];
            $news->seo_description = $input['seo_description'];
            $news->seo_keyword     = $input['seo_keyword'];
            $news->content         = $input['content'];
            $news->save();
            return redirect()->action('NewsController@index');
        }
        catch(Exception $e)
        {
            Log::error('------------------------------------------錯誤: ' . get_class($this) . '@newsEdit---------------------------------------------');
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
    protected function category(Request $request)
    {
        try
        {
            $per_page = 10;
            if($request->search != '')
            {
                $newsCategories = NewsCategory::where('name','like','%'.$request->search.'%')->paginate($per_page);    
            }
            else
            {
                $newsCategories = NewsCategory::paginate($per_page);
            }
            $this->data['newsCategories'] = $newsCategories;
            return view('admin.content.news.category.index',$this->data);
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
            if($request->isMethod('post'))
            {
                /* -------- Validation Form Data -------- */
                $this->validate($request, [
                    'name'            => 'required|max:100',
                    'seo_title'       => 'required|max:100',
                    'seo_description' => 'required|max:100',
                    'seo_keyword'     => 'required|max:100',
                ]); 

                /* -------- Create A New News Category Instance -------- */                
                $updateData                    = $request->all();
                $newsCategory                  = new NewsCategory;
                $newsCategory->name            = $updateData['name'             ];
                $newsCategory->image           = $updateData['image'            ];
                $newsCategory->seo_title       = $updateData['seo_title'        ];
                $newsCategory->seo_description = $updateData['seo_description'  ];
                $newsCategory->seo_keyword     = $updateData['seo_keyword'      ];
                $newsCategory->content         = $updateData['content'          ];
                /* Status */
                if(isset($updateData['status']) && $updateData['status']==1) 
                {
                    $newsCategory->status = 1;
                }
                else
                {
                    $newsCategory->status = 0;
                }

                $newsCategory->save();   
                
                return redirect()->action('NewsController@category');             
            }


            return view('admin.content.news.category.create');
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
            $newsCategory = NewsCategory::findOrFail($id);
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
                $newsCategory->name            = $updateData['name'     ];
                $newsCategory->image           = $updateData['image'    ];
                if(isset($updateData['status']) && $updateData['status']==1) 
                {
                    $newsCategory->status = 1;
                }
                else
                {
                    $newsCategory->status = 0;
                }
                $newsCategory->seo_title       = $updateData['seo_title'];
                $newsCategory->seo_description = $updateData['seo_description'];
                $newsCategory->seo_keyword     = $updateData['seo_keyword'];
                $newsCategory->content         = $updateData['content'];

                $newsCategory->save();   
                
                return redirect()->action('NewsController@category');             
            }
            $this->data['newsCategory'] = $newsCategory;
            return view('admin.content.news.category.edit',$this->data);
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
     * @param $id - news_category_id
     * @return \Illuminate\Http\Response
     */
    protected function categoryDelete($id)
    {
        try
        {
            $newsCategory = NewsCategory::findOrFail($id);
            $newsCategory->delete();
            return redirect()->action('NewsController@category');
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
                                $newsCategory = NewsCategory::findOrFail($category_id);
                                
                                $newsCategory->delete();
                            }
                            return redirect()->action('NewsController@category');
                            break;
                        case 'hide':
                            foreach ($categoryArray as $key => $category_id) 
                            {
                                $newsCategory = NewsCategory::findOrFail($category_id);
                                $newsCategory->status = 0;
                                $newsCategory->save();
                            }
                            return redirect()->action('NewsController@category');
                            break; 
                        case 'show':
                            foreach ($categoryArray as $key => $category_id) 
                            {
                                $newsCategory = NewsCategory::findOrFail($category_id);
                                $newsCategory->status = 1;
                                $newsCategory->save();
                            }
                            return redirect()->action('NewsController@category');
                            break;                                    
                        default:
                            # code...
                            break;
                    }                
                }
            }
            return redirect()->action('NewsController@category');
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
     * Ajax Fetch Category Related Item Controller 
     * 抓出指定分類的關聯item
     * @param $id - news_category_id
     * @return \Illuminate\Http\Response
     */
    protected function ajaxCategoryRelatedItem(Request $request)
    {
        try
        {
            $result = array();
            $ids    = explode(',', $request['ids']);
            foreach($ids as $key => $category_id)
            {
                $category = NewsCategory::findOrFail($category_id);
                $itemCount = $category->newsItems()->count();
                $result[$category_id]['count'] = $itemCount;
                $result[$category_id]['data'] = $category;
            }
            return response()->json($result);
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
                $newsItems = NewsItem::with(['newsCategory'])
                                     ->select('news_item.*')
                                     ->leftJoin('news_category', 'news_item.news_category_id', '=', 'news_category.news_category_id')
                                     ->where('news_item.name', 'like', '%'.$request->search.'%')
                                     ->orWhere('news_category.name', 'like', '%'.$request->search.'%')
                                     ->paginate($per_page);
            }
            else
            {
                $newsItems = NewsItem::with('newsCategory')->paginate($per_page);
            }           
            $this->data['newsItems'] = $newsItems;
            return view('admin.content.news.item.index',$this->data);
        }
        catch(Exception $e)
        {
            Log::error('------------------------------------------錯誤: ' . get_class($this) . '@Item---------------------------------------------');
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

            $newsCategories = NewsCategory::all();
            $this->data['newsCategories'] = $newsCategories;
            if($request->isMethod('post'))
            {
                /* -------- Validation Form Data -------- */
                $this->validate($request, [
                    'name'            => 'required|max:100',
                    'seo_title'       => 'required|max:100',
                    'seo_description' => 'required|max:100',
                    'seo_keyword'     => 'required|max:100',
                ]); 

                /* -------- Create A New News Item Instance -------- */                 
                $updateData                 = $request->all();
                $newsItem                   = new NewsItem;
                $newsItem->news_category_id = $updateData['news_category'   ];
                $newsItem->name             = $updateData['name'            ];
                $newsItem->image            = $updateData['image'           ];
                $newsItem->seo_title        = $updateData['seo_title'       ];
                $newsItem->seo_description  = $updateData['seo_description' ];
                $newsItem->seo_keyword      = $updateData['seo_keyword'     ];
                $newsItem->content          = $updateData['content'         ];
                /* Status */
                if(isset($updateData['status']) && $updateData['status']==1) 
                {
                    $newsItem->status = 1;
                }
                else
                {
                    $newsItem->status = 0;
                }
                $newsItem->save();   
                
                return redirect()->action('NewsController@item');             
            }

            return view('admin.content.news.item.create', $this->data);
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
    protected function itemEdit($id,Request $request)
    {
        try
        {
            $newsItem       = NewsItem::findOrFail($id);
            $newsCategories = NewsCategory::all();

            if($request->isMethod('post'))
            {
                /* -------- Validation Form Data -------- */
                $this->validate($request, [
                    'name'            => 'required|max:100',
                    'seo_title'       => 'required|max:100',
                    'seo_description' => 'required|max:100',
                    'seo_keyword'     => 'required|max:100',
                ]); 

                /* -------- Edit Form Data -------- */             
                $updateData                 = $request->all(); 
                $newsItem->name             = $updateData['name'            ];
                $newsItem->image            = $updateData['image'           ];
                $newsItem->news_category_id = $updateData['news_category'   ];
                if(isset($updateData['status']) && $updateData['status']==1) 
                {
                    $newsItem->status = 1;
                }
                else
                {
                    $newsItem->status = 0;
                }
                $newsItem->seo_title       = $updateData['seo_title'        ];
                $newsItem->seo_description = $updateData['seo_description'  ];
                $newsItem->seo_keyword     = $updateData['seo_keyword'      ];
                $newsItem->content         = $updateData['content'          ];

                $newsItem->save();                
                return redirect()->action('NewsController@item');             
            }
            else
            {
                $this->data['newsItem']       = $newsItem;
                $this->data['newsCategories'] = $newsCategories;

                return view('admin.content.news.item.edit',$this->data);                
            }

        }
        catch(Exception $e)
        {
            Log::error('------------------------------------------錯誤: ' . get_class($this) . '@itemEdit---------------------------------------------');
            Log::error($e->getMessage());             
            Log::error($e->getTraceAsString());
            return view('error.500');
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
            $action                 = $request->input('multiple_action');
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
                                $newsItem = NewsItem::findOrFail($item_id);
                                $newsItem->delete();
                            }
                            return redirect()->action('NewsController@item');
                            break;
                        case 'hide':
                            foreach ($itemArray as $key => $item_id) 
                            {
                                $newsItem = NewsItem::findOrFail($item_id);
                                $newsItem->status = 0;
                                $newsItem->save();
                            }
                            return redirect()->action('NewsController@item');
                            break; 
                        case 'show':
                            foreach ($itemArray as $key => $item_id) 
                            {
                                $newsItem = NewsItem::findOrFail($item_id);
                                $newsItem->status = 1;
                                $newsItem->save();
                            }
                            return redirect()->action('NewsController@item');
                            break;                                    
                        default:
                            # code...
                            break;
                    }                
                }
            }
            return redirect()->action('NewsController@item');
        }
        catch(Exception $e)
        {
            Log::error('------------------------------------------錯誤: ' . get_class($this) . '@itemMultipleAction---------------------------------------------');
            Log::error($e->getMessage());             
            Log::error($e->getTraceAsString());
            return view('error.500');
        }
    } 
}
