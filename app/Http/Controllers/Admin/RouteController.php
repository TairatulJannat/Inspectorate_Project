<?php

namespace App\Http\Controllers\Admin;

use App\dynamic_route;
use App\Http\Controllers\Controller;
use App\Models\Inspectorate;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RouteController extends Controller
{
    public function dynamic_route()
    {
        $auth_inspectorate_id =  Auth::user()->inspectorate_id;
        $inspectorate_ids=[0,  $auth_inspectorate_id];
       
        if(Auth::user()->id==92){
            $route =  dynamic_route::where('route_status', 1)
            ->leftJoin('inspectorates', 'dynamic_routes.inspectorate_id', '=', 'inspectorates.id')
            ->select('dynamic_routes.*', 'inspectorates.name as ins_name')
            ->get();
            $inspectorates=Inspectorate::all();
            $page_data = [
                'add_menu' => 'yes',
                'modal' => 'yes',
            ];
            return view('backend.dynamic_route.dynamic_route', compact('route', 'page_data', 'inspectorates'));
        }else{

            $route =  dynamic_route::where('route_status', 1)
            ->where('inspectorate_id', $auth_inspectorate_id)
            ->leftJoin('inspectorates', 'dynamic_routes.inspectorate_id', '=', 'inspectorates.id')
            ->select('dynamic_routes.*', 'inspectorates.name as ins_name')
            ->get();
        
            $inspectorates=Inspectorate::all();
            $page_data = [
                'add_menu' => 'yes',
                'modal' => 'yes',
            ];
            return view('backend.dynamic_route.dynamic_route', compact('route', 'page_data', 'inspectorates'));
        }
    
    }

    public function save_dynamic_route(Request $request)
    {
        $auth_inspectorate_id =  Auth::user()->inspectorate_id;
        $route = new dynamic_route(); 
        $route->inspectorate_id = Auth::user()->id==92 ? $request->inspectorate : $auth_inspectorate_id;
        $route->title = $request->title;
        $route->model_name = $request->model_name;
        $route->controller_action = $request->controller_action;
        $route->function_name = $request->function_name;
        $route->url = $request->url;
        $route->method = $request->method;
        $route->route_type = $request->route_type;
        $route->parameter = $request->parameter;
        $route->route_status = $request->route_status;
        $route->show_in_menu = $request->show_in_menu;
        $route->ajax = $request->ajax;
        $route->save();

        Toastr::success('Save Successfully', '');
        return redirect()->back();
    }

    public function delete_route($id)
    {
        dynamic_route::find($id)->delete();
        Toastr::Success('Route Successfully Deleted', '');
        return redirect()->route('admin.dynamic_route');
    }

    public function edit_route($id)
    {
        $route = dynamic_route::find($id);
        return view('backend.dynamic_route.edit_route',compact('route'));
    }

    public function update_route(Request $request,$id)
    {
        $route = dynamic_route::find($id);
        $route->title = $request->title;
        $route->model_name = $request->model_name;
        $route->controller_action = $request->controller_action;
        $route->function_name = $request->function_name;
        $route->url = $request->url;
        $route->method = $request->method;
        $route->route_type = $request->route_type;
        $route->parameter = $request->parameter;
        $route->route_status = $request->route_status;
        $route->show_in_menu = $request->show_in_menu;
        $route->ajax = $request->ajax;
        $route->update();

        Toastr::success('Update Successfully', '');
        return redirect()->back();
    }
}
