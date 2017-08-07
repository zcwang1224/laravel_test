<?php

namespace app\Http\Controllers\Admin;

use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;
use app\Models\Member;
use app\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

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
            return redirect()->action('Admin\MemberController@index');
        }
        catch(Exception $e)
        {
            Log::error('------------------------------------------錯誤: ' . get_class($this) . '@memberEdit---------------------------------------------');
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
                $roles = Role::where('display_name','like','%'.$request->search.'%')->paginate($per_page);    
            }
            else
            {
                $roles = Role::paginate($per_page);
            }

            $this->data['roles'] = $roles;

            return view('admin.content.member.category.index',$this->data);
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
     * Category Edit Controller
     * @param 
     * @return \Illuminate\Http\Response
     */
    protected function categoryCreate(Request $request)
    {
        try
        {
            $permissions = Permission::all();
            if($request->isMethod('post'))
            {
                $updateData = $request->all();
                /* -------- Validation Form Data -------- */
                $validator = Validator::make($request->all(), [
                    'name'            => 'required|max:100',
                    'permission'      => 'required',
                ]);

                if($validator->fails())
                {
                    return back()->withErrors($validator)
                                 ->withInput($request->flash())
                                 ->with(['permission' => $updateData['permission']]);
                }

                /* -------- 基本資料 -------- */
                $role = new Role;
                $role->name = $updateData['name'];
                $role->display_name = $updateData['name'];
                $role->save();
                /* -------- 權限設定 -------- */
                foreach($permissions as $permission_key => $permission_value)
                {
                    if(in_array($permission_value->name,$updateData['permission']))
                    {
                        if(!$role->hasPermissionTo($permission_value->name))
                        {
                            $role->givePermissionTo($permission_value->name);
                        }
                    }
                    else
                    {
                        if($role->hasPermissionTo($permission_value->name))
                        {
                            $role->revokePermissionTo($permission_value->name);
                        }                        
                    }
                }

                
                return redirect()->action('Admin\MemberController@category');             
            }
            
            $this->data['permissions'] = $permissions; 
            return view('admin.content.member.category.create',$this->data);
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
     * Category Edit Controller
     * @param 
     * @return \Illuminate\Http\Response
     */
    protected function categoryEdit(Role $role,Request $request)
    {
        try
        {
            $permissions = Permission::all();
            $role->load(['permissions']);
            if($request->isMethod('post'))
            {
                $updateData = $request->all();
                /* -------- Validation Form Data -------- */
                $this->validate($request, [
                    'name'            => 'required|max:100',
                    'permission'      => 'required',
                ]);  
                /* -------- 基本資料 -------- */
                $role->name = $updateData['name'];

                $role->save();
                /* -------- 權限設定 -------- */
                if(isset($updateData['permission']) && count($updateData['permission']) >0)
                {
                    foreach($permissions as $permission_key => $permission_value)
                    {
                        if(in_array($permission_value->name,$updateData['permission']))
                        {
                            if(!$role->hasPermissionTo($permission_value->name))
                            {
                                $role->givePermissionTo($permission_value->name);
                            }
                        }
                        else
                        {
                            if($role->hasPermissionTo($permission_value->name))
                            {
                                $role->revokePermissionTo($permission_value->name);
                            }                        
                        }
                    }                    
                }


                
                return redirect()->action('Admin\MemberController@category');             
            }
            
            $role_has_permission_arr = array();
            foreach($role->permissions as $permission_key => $permission_value)
            {
                array_push($role_has_permission_arr,$permission_value->name);
            }
            $this->data['permissions'] = $permissions; 
            $this->data['role_has_permission'] = $role_has_permission_arr;
            $this->data['role'] = $role;
            return view('admin.content.member.category.edit',$this->data);
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
     * Category Index Multiple action
     *  
     * @param 
     * @return \Illuminate\Http\Response
     */
    protected function categoryMultipleAction(Request $request)
    {
        try
        {
            $action                 = $request->input('multiple_action');
            $checked_categories_str = $request->input('checked_categories');
            if(!$checked_categories_str == '' && $checked_categories_str != null)
            {
                $categoryArray = explode(',', $checked_categories_str);

                if(count($categoryArray) > 0)
                {
                    foreach ($categoryArray as $key => $category_id) 
                    {
                        $role = Role::findOrFail($category_id);
                        
                        $role->delete();
                    }
                    return redirect()->action('Admin\MemberController@category');            
                }
            }
            return redirect()->action('Admin\MemberController@category');
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
                $users = User::where('name','like','%'.$request->search.'%')->paginate($per_page);    
            }
            else
            {
                $users = User::paginate($per_page);
            }
            $this->data['users'] = $users;
            return view('admin.content.member.item.index',$this->data);
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
            $roles = Role::all();
            if($request->isMethod('post'))
            {
                /* -------- Validation Form Data -------- */
                $updateData   = $request->all(); 
                $validator = Validator::make($updateData, [
                    'name'     => 'required|max:100',
                    'password' => 'required|min:6|confirmed',
                    'email'    => 'required|email|unique:users,email',
                ]);

                if($validator->fails())
                {
                    return back()->withErrors($validator)
                                 ->withInput($request->except('password'));
                }

                /* -------- Edit Form Data -------- */             
                
                $user           = new User;
                $user->name     = $updateData['name'];
                $user->email    = $updateData['email'];
                $user->password = bcrypt($updateData['password']);
                if(isset($updateData['image']))
                {
                    $user->image  = $updateData['image'];
                }
                $user->mobile = $updateData['mobile'];
                if(isset($updateData['status']) && $updateData['status']==1) 
                {
                    $user->status = 1;
                }
                else
                {
                    $user->status = 0;
                }
                $user->save(); 
                /* -------- 修改分類 --------- */
                $user->syncRoles($updateData['role']);
               
                return redirect()->action('Admin\MemberController@item');             
            }
            $this->data['roles'] = $roles;
            return view('admin.content.member.item.create',$this->data);  

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
     * Item Edit Controller
     * @param 
     * @return \Illuminate\Http\Response
     */
    protected function itemEdit(User $user,Request $request)
    {
        try
        {
            $roles = Role::all();
            if($request->isMethod('post'))
            {
                /* -------- Validation Form Data -------- */
                $this->validate($request, [
                    'name'     => 'required|max:100',
                    'password' => 'required|min:6|confirmed',
                    'email'    => 'email',
                ]); 

                /* -------- Edit Form Data -------- */             
                $updateData   = $request->all(); 
                $user->name   = $updateData['name'];
                $user->email  = $updateData['email'];
                if(isset($updateData['image']))
                {
                    $user->image  = $updateData['image'];
                }
                $user->mobile = $updateData['mobile'];
                if(isset($updateData['status']) && $updateData['status']==1) 
                {
                    $user->status = 1;
                }
                else
                {
                    $user->status = 0;
                }
                $user->save(); 
                /* -------- 修改分類 --------- */
                if(isset($updateData['role']))
                {
                    $user->syncRoles($updateData['role']);
                }
                return redirect()->action('Admin\MemberController@item');             
            }

            $this->data['user']  = $user;
            $this->data['roles'] = $roles;
            return view('admin.content.member.item.edit',$this->data);  

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
     * Category Index Multiple action
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
            $checked_items_str = $request->input('checked_items');
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
                                $user = User::findOrFail($item_id);
                                $user->delete();
                            }
                            return redirect()->action('Admin\MemberController@item');
                            break;
                        case 'hide':
                            foreach ($itemArray as $key => $item_id) 
                            {
                                $user = User::findOrFail($item_id);
                                $user->status = 0;
                                $user->save();
                            }
                            return redirect()->action('Admin\MemberController@item');
                            break; 
                        case 'show':
                            foreach ($itemArray as $key => $item_id) 
                            {
                                $user = User::findOrFail($item_id);
                                $user->status = 1;
                                $user->save();
                            }
                            return redirect()->action('Admin\MemberController@item');
                            break;                                    
                        default:
                            # code...
                            break;
                    }                
                }
            }
            return redirect()->action('Admin\MemberController@item');
        }
        catch(Exception $e)
        {
            Log::error('------------------------------------------錯誤: ' . get_class($this) . '@categoryMultipleAction---------------------------------------------');
            Log::error($e->getMessage());             
            Log::error($e->getTraceAsString());
            return view('error.500');
        }
    }                 

}
