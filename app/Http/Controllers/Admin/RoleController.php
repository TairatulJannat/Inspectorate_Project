<?php

namespace App\Http\Controllers\Admin;

use App\dynamic_route;
use App\Http\Controllers\Controller;
use App\permission_role;
use App\role;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class RoleController extends Controller
{
    public function all_role()
    {
        $auth_inspectorate_id =  Auth::user()->inspectorate_id;
        
        if(Auth::user()->id==92){
            $role = role::all();
        }else{
            $role = role::where('inspectorate_id', $auth_inspectorate_id)->get();
        }
         
        $page_data = [
            'add_menu' => 'yes',
            'modal' => 'no',
        ];
        return view('backend.role.all_role', compact('role', 'page_data'));
    }

    public function add_role()
    {
      
        $auth_inspectorate_id =  Auth::user()->inspectorate_id;
        $auth_admin_type =  Auth::user()->admin_type;
        $inspectorateIds = [0,  $auth_inspectorate_id];
        if($auth_admin_type=='inspe_admin'){
            $route = dynamic_route::where('route_status', 1)->whereIn('inspectorate_id', $inspectorateIds)->get()->groupBy('model_name');
          
            return view('backend.role.add_role', compact('route')); 
        }elseif (Auth::user()->id==92) {
            $route = dynamic_route::where('route_status', 1)->get()->groupBy('model_name');
            return view('backend.role.add_role', compact('route'));
        }
        else {
            $route = dynamic_route::where('route_status', 1)->where('inspectorate_id', $auth_inspectorate_id)->where('inspectorate_id', 0)->get()->groupBy('model_name');
            return view('backend.role.add_role', compact('route'));
           
        }
             
       
        // $route = dynamic_route::where('route_status', 1)->get()->groupBy('model_name');
        //     return view('backend.role.add_role', compact('route'));
       
    }

    public function save_role(Request $request)
    {
        $auth_inspectorate_id =  Auth::user()->inspectorate_id;
        $request->validate([
            'route_name' => 'required',
            'name' => ['required', 'unique:roles'],
        ]);
        $role = new role();
        $role->inspectorate_id = $auth_inspectorate_id;
        $role->name = $request->name;
        $role->slag = Str::slug($request->name, '_');
        $role->save();

        if (isset($request->route_name)) {
            foreach ($request->route_name as $data) {
                $find_url = dynamic_route::find($data)->url;
                $permission_role = new permission_role();
                $permission_role->dynamic_route_id = $data;
                $permission_role->role_id = $role->id;
                $permission_role->url = $find_url;
                $permission_role->save();
            }
        }


        Toastr::Success('Role Successfully Created', '');
        return redirect()->route('admin.role/all_role');
    }

    public function edit_role($id)
    {
        $auth_inspectorate_id =  Auth::user()->inspectorate_id;
        $auth_admin_type =  Auth::user()->admin_type;
        $inspectorateIds = [0,  $auth_inspectorate_id];
        $role = role::find($id);

        if($auth_admin_type=='inspe_admin'){

            $route = dynamic_route::where('route_status', 1)->whereIn('inspectorate_id', $inspectorateIds)->get()->groupBy('model_name');
            $permission_route = permission_role::where('role_id', $id)->get();
            return view('backend.role.edit_role', compact('role', 'route', 'permission_route'));

        }elseif (Auth::user()->id==92) {

            $route = dynamic_route::where('route_status', 1)->get()->groupBy('model_name');
            $permission_route = permission_role::where('role_id', $id)->get();
            return view('backend.role.edit_role', compact('role', 'route', 'permission_route'));
        }
        else {
            $route = dynamic_route::where('route_status', 1)->where('inspectorate_id', $auth_inspectorate_id)->where('inspectorate_id', 0)->get()->groupBy('model_name');
            $permission_route = permission_role::where('role_id', $id)->get();
        return view('backend.role.edit_role', compact('role', 'route', 'permission_route'));
           
        }
        
       
    }

    public function update_role(Request $request, $id)
    {
        $request->validate([
            'name' => "required|unique:roles,name,$id",
            'route_name' => 'required',
        ]);
        $role = role::find($id);
        $role->name = $request->name;
        $role->slag = Str::slug($request->name, '_');
        $role->update();

        permission_role::where('role_id', $id)->delete();

        if (isset($request->route_name)) {
            foreach ($request->route_name as $data) {
                $find_url = dynamic_route::find($data)->url;
                $permission_role = new permission_role();
                $permission_role->dynamic_route_id = $data;
                $permission_role->role_id = $role->id;
                $permission_role->url = $find_url;
                $permission_role->save();
            }
        }


        Toastr::Success('Role Successfully updated', '');
        return redirect()->route('admin.role/all_role');
    }

    public function delete_role($id)
    {
        role::find($id)->delete();
        Toastr::Success('Role Successfully Deleted', '');
        return redirect()->route('admin.all_role');
    }
}
