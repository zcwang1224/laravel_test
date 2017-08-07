<?php

namespace app\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Exception;
use app\Models\System;
// use Illuminate\Support\Facades\Route;
class SystemController extends Controller
{
    /**
     *  系統管理 首頁 view
     *
     * @param 
     * @return \Illuminate\Http\Response
     */
    public function index(){
    	try
    	{
            // dd(Route::current());
            $system               = System::first();
            $this->data['system'] = $system;
            return view('admin.content.system.index', $this->data);
    	}
    	catch(Exception $e)
    	{
            Log::error('------------------------------------------錯誤: ' . get_class($this) . '@systemIndex---------------------------------------------');
            Log::error($e->getMessage());             
            Log::error($e->getTraceAsString());
            return view('error.403',['exception' => $e]);    		
    	}
    }

    /**
     *  系統管理 首頁 修改
     *
     * @param 
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request){
        try
        {
            $system = System::first();

            $updateData              = $request->all();
            $system->name            = $updateData['name'];
            $system->image           = $updateData['image'];
            $system->content         = $updateData['content'];
            $system->seo_title       = $updateData['seo_title'];
            $system->seo_description = $updateData['seo_description'];
            $system->seo_keyword     = $updateData['seo_keyword'];
            $system->save();

            return redirect()->action('Admin\SystemController@index');
        }
        catch(Exception $e)
        {
            Log::error('------------------------------------------錯誤: ' . get_class($this) . '@systemIndex---------------------------------------------');
            Log::error($e->getMessage());             
            Log::error($e->getTraceAsString());
            return view('error.403',['exception' => $e]);           
        }
    }

}
