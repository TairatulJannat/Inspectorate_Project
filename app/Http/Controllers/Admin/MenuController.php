<?php

namespace App\Http\Controllers\Admin;

use App\dynamic_route;
use App\Http\Controllers\Controller;
use App\ModelMenu;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class MenuController extends Controller
{
    public static function getMainMenu()
    {
        return ModelMenu::where('menu_parent_id', null)->where('menu_is_active',1)->with('route')->with('childs')->get();
    }

    public static function getLevel3Childern($id)
    {
        return ModelMenu::where('menu_parent_id', $id)->with('route')->get();
    }


    public function create_menu()
    {
        $master_menu = ModelMenu::select('menu_name', 'id')->get();
        $route = dynamic_route::select('title', 'id')->get();
        return view('backend.menu.menu_create_form', compact('master_menu', 'route'));
    }

    public function menu_save(Request $request)
    {
        $request->validate([
            'menu_name' => 'required',
            'menu_bangla_name' => 'required',
            'active_status' => 'required',
        ]);

        $menu = new ModelMenu();
        $menu->menu_name = $request->menu_name;
        $menu->menu_dynamic_route_id = $request->route_id;
        $menu->menu_is_active = $request->active_status;
        $menu->menu_icon_class = $request->icon_class;
        $menu->menu_parent_id = $request->parent_id;
        $menu->menu_name_bn = $request->menu_bangla_name;
        $menu->created_by = Auth::user()->id;
        $menu->save();

        Toastr::success('Menu Created Successfully', 'Menu Created');
        return redirect()->route('admin.menu/all_menu');
    }

    public function all_menu()
    {
        $data = ['title' => 'Menu Tree'];
        return view('backend.menu.all_menu', compact('data'));
    }

    public function menu_search(Request $request)
    {
        if ($request->ajax()) {
            $query = ModelMenu::select('id', 'menu_name', 'menu_name_bn', 'menu_parent_id', 'menu_icon_class', 'menu_is_active', 'menu_dynamic_route_id', 'created_by', 'created_at');

            $query->orderBy('created_at', 'ASC');
            return Datatables::of($query)
                ->setTotalRecords($query->count())
                ->addIndexColumn()
                ->addColumn('menu_name', function ($data) {
                    return $data->menu_name;
                })->addColumn('menu_name_bn', function ($data) {
                    return $data->menu_name_bn;
                })->addColumn('menu_icon_class', function ($data) {
                    return $data->menu_icon_class;
                })->addColumn('menu_is_active', function ($data) {
                    $status = '';
                    if ($data->menu_is_active == 1) {
                        $status = '<span class="right badge badge-info">Active</span>';
                    } elseif ($data->menu_is_active == 0) {
                        $status = '<span class="right badge badge-warning">Inactive</span>';
                    }
                    return $status;
                })->addColumn('parent_menu', function ($data) {
                    return isset($data->parent) ? $data->parent->menu_name : '-Master Menu-';
                })->addColumn('route', function ($data) {
                    return isset($data->route) ? $data->route->title : '';
                })->addColumn('action', function ($data) {
                    $actionBtn = '<a href="" class="edit btn btn-outline-danger btn-sm" target="null">Delete</a> <a href="' . url('admin/menu/edit_menu/' . $data->id) . '" class="edit btn btn-outline-success btn-sm" target="null">Edit</a>';
                    return $actionBtn;
                })->rawColumns(['menu_name', 'menu_name_bn', 'menu_icon_class', 'menu_is_active', 'action', 'rank'])
                ->make(true);
        }
    }

    public function edit_menu($id)
    {
        $menu = ModelMenu::find($id);
        $master_menu = ModelMenu::select('menu_name', 'id')->get();
        $route = dynamic_route::select('title', 'id')->get();
        return view('backend.menu.menu_edit', compact('menu', 'master_menu', 'route'));
    }

    public function update_menu(Request $request, $id)
    {
        $request->validate([
            'menu_name' => 'required',
            'active_status' => 'required',
            'menu_bangla_name' => 'required',
        ]);
        if ($request->parent_id) {
            $request->validate([
                'route_id' => 'required',
            ]);
        }

        $menu = ModelMenu::find($id);
        $menu->menu_name = $request->menu_name;
        $menu->menu_dynamic_route_id = $request->route_id;
        $menu->menu_is_active = $request->active_status;
        $menu->menu_icon_class = $request->icon_class;
        $menu->menu_parent_id = $request->parent_id;
        $menu->menu_name_bn = $request->menu_bangla_name;
        $menu->updated_by = Auth::user()->id;
        $menu->update();

        Toastr::success('Menu Updated Successfully', 'Menu Updated');
        return redirect()->route('admin.menu/all_menu');
    }

}
