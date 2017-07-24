<?php

namespace app\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Exception;

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
            
            return view('admin.content.system.index');
    	}
    	catch(Exception $e)
    	{
            Log::error('------------------------------------------錯誤: ' . get_class($this) . '@productIndex---------------------------------------------');
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
            return view('admin.content.system.index');
        }
        catch(Exception $e)
        {
            Log::error('------------------------------------------錯誤: ' . get_class($this) . '@productIndex---------------------------------------------');
            Log::error($e->getMessage());             
            Log::error($e->getTraceAsString());
            return view('error.403',['exception' => $e]);           
        }
    }

}
