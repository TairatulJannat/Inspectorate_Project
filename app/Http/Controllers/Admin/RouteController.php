<?php

namespace App\Http\Controllers\Admin;

use App\dynamic_route;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class RouteController extends Controller
{
    public function dynamic_route()
    {
        $route = dynamic_route::all();
        $page_data = [
            'add_menu' => 'yes',
            'modal' => 'yes',
        ];
        return view('backend.dynamic_route.dynamic_route', compact('route', 'page_data'));
    }

    public function save_dynamic_route(Request $request)
    {
        $route = new dynamic_route();
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
