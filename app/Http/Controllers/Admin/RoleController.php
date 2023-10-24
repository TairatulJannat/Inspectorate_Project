<?php

namespace App\Http\Controllers\Admin;

use App\dynamic_route;
use App\Http\Controllers\Controller;
use App\permission_role;
use App\role;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RoleController extends Controller
{
    public function all_role()
    {
        $role = role::all();
        $page_data = [
            'add_menu' => 'yes',
            'modal' => 'no',
        ];
        return view('backend.role.all_role', compact('role', 'page_data'));
    }

    public function add_role()
    {
        $route = dynamic_route::where('route_status', 1)->get()->groupBy('model_name');
        return view('backend.role.add_role', compact('route'));
    }

    public function save_role(Request $request)
    {
        $request->validate([
            'route_name' => 'required',
            'name' => ['required', 'unique:roles'],
        ]);
        $role = new role();
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
        $role = role::find($id);
        $route = dynamic_route::where('route_status', 1)->get()->groupBy('model_name');
        $permission_route = permission_role::where('role_id', $id)->get();
        return view('backend.role.edit_role', compact('role', 'route', 'permission_route'));
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
