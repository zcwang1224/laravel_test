<?php

namespace app\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use app\Models\Member;

class MemberController extends Controller
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
            $member = Member::first();
            $this->data['member'] = $member;
    		return view('admin.content.member.index.index', $this->data);
    	}
    	catch(Exception $e)
    	{
            Log::error('------------------------------------------錯誤: ' . get_class($this) . '@memberIndex---------------------------------------------');
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
            $member_collection = Member::all();

        /* Store Data */
            if($member_collection->count() == 1)
            {
                $member = Member::first();
            }
            else
            {
                $member = new Member;
            }
            $member->seo_title       = $input['seo_title'];
            $member->seo_description = $input['seo_description'];
            $member->seo_keyword     = $input['seo_keyword'];
            $member->content         = $input['content'];
            $member->save();
            return redirect()->action('MemberController@index');
        }
        catch(Exception $e)
        {
            Log::error('------------------------------------------錯誤: ' . get_class($this) . '@memberEdit---------------------------------------------');
            Log::error($e->getMessage());             
            Log::error($e->getTraceAsString());
            return view('error.500');
        }
    }    
}
