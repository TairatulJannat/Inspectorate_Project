<?php

namespace App\Http\Controllers\Admin;

use App\Admin;
use App\Http\Controllers\Controller;
use App\Models\AdminSection;
use App\Models\Designation;
use App\Models\Section;
use App\role;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{


    public function all_user()
    {
        if (Auth::user()->id == 92) {
            $auth_inspectorate_id =  Auth::user()->inspectorate_id;
            $users = Admin::where('status_id', '!=', 2)->get();
            // dd($users);
            $role = role::all();
            $page_data = [
                'add_menu' => 'yes',
                'modal' => 'yes',
            ];
            return view('backend.user.all_user', compact('users', 'page_data', 'role'));
        } else {

            $auth_inspectorate_id =  Auth::user()->inspectorate_id;
            $users = Admin::where('inspectorate_id', $auth_inspectorate_id)->where('status_id', '!=', 2)->get();
            $role = role::where('inspectorate_id', $auth_inspectorate_id)->get();
            $page_data = [
                'add_menu' => 'yes',
                'modal' => 'yes',
            ];
            return view('backend.user.all_user', compact('users', 'page_data', 'role'));
        }
    }

    public function save_user(Request $request)
    {

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:3', 'confirmed'],
            'role_id' => ['required'],
        ]);
        if (Auth::user()->id == 92) {
            $auth_inspectorate_id = 0;

            $user = new Admin();
            $user->name = $request->name;
            $user->inspectorate_id = $auth_inspectorate_id;
            $user->email = $request->email;
            $user->role_id = $request->role_id;
            $user->type = "admin";
            $user->admin_type = "inspe_admin";
            $user->mobile = $request->mobile;
            $user->created_by = Auth::user()->id;
            $user->password = Hash::make($request->password);
            $user->save();
        } else {
            $auth_inspectorate_id = Auth::user()->inspectorate_id;

            $user = new Admin();
            $user->name = $request->name;
            $user->inspectorate_id = $auth_inspectorate_id;
            $user->email = $request->email;
            $user->role_id = $request->role_id;
            $user->type = "admin";
            $user->admin_type = "";
            $user->mobile = $request->mobile;
            $user->created_by = Auth::user()->id;
            $user->password = Hash::make($request->password);
            $user->save();
        }


        Toastr::success('User Created Successfully', 'Success');
        return redirect()->route('admin.all_user');
    }

    public function edit_user($id)
    {

        $auth_inspectorate_id =  Auth::user()->inspectorate_id;
        if (Auth::user()->id) {
            $role = role::all();
        } else {
            $role = role::where('inspectorate_id', $auth_inspectorate_id)->get();
        }

        $user = Admin::find($id);

        $output = '';
        $role_loop = '';
        foreach ($role as $data) {
            $role_loop .= '<option value="' . $data->id . '" ' . (($data->id == $user->role_id) ? 'selected="selected"'
                : "") . '>' . $data->name . '</option>';
        }

        $output .= '<div class="form-group"> <label for="Route_name">user name</label> <input type="text" class="form-control" name="name" value="' . $user->name . '"> </div><div class="form-group"> <label for="mobile">Mobile</label> <input type="text" class="form-control" name="mobile" value="' . $user->mobile . '"> </div><input type="hidden" name="user_id" value="' . $id . '"> <div class="form-group"> <label for="Route_name">user Email</label> <input id="email" type="email" class="form-control" name="email" value="' . $user->email . '" required autocomplete="email"> </div><div class="form-group"> <label for="status">Role</label> <select class="form-control" id="status" name="role_id"> ' . $role_loop . ' </select> </div>';


        return $output;
    }
    public function assign_section($id)
    {
        $admin_id = $id;
        if (Auth::user()->id == 92) {
            $section = Section::all();
            $designation = Designation::all();
        } else {
            $auth_inspectorate_id =  Auth::user()->inspectorate_id;
            $section = Section::where('inspectorate_id',  $auth_inspectorate_id)->get();
            $designation = Designation::all();
        }


        return view('backend.user.assign_section_modal', compact('section', 'designation', 'admin_id'));
    }
    public function store_assign_section(Request $request)
    {
        $request->validate([
            'sec_id' => 'required|array',
            'sec_id.*' => 'exists:sections,id',
            'desig_id' => 'required|exists:designations,id'
        ]);
        foreach ($request->sec_id as $sectionId) {

            $admin_section = new AdminSection();
            $admin_section->admin_id = $request->admin_id;
            $admin_section->sec_id = $sectionId;
            $admin_section->desig_id = $request->desig_id;
            $admin_section->created_at = Carbon::now();
            $admin_section->created_at = Carbon::now();
            $admin_section->save();
        }

        return response()->json(['success' => 'Done']);
    }
    public function upadte_user(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $request->user_id],
            'role_id' => ['required'],
        ]);
        $auth_inspectorate_id =  Auth::user()->inspectorate_id;
        $user = Admin::find($request->user_id);
        $user->inspectorate_id = $auth_inspectorate_id;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role_id = $request->role_id;
        $user->role_id = $request->role_id;
        $user->type = "admin";
        $user->status_id = 1;
        $user->mobile = $request->mobile;
        //        $user->password = Hash::make(123456);
        $user->update();

        Toastr::success('User Created Successfully', 'Created');
        return redirect()->route('admin.all_user');
    }

    public function suspend_user($id)
    {
        $user = Admin::find($id);
        $user->type = 'user';
        $user->password = Hash::make(123456);
        $user->update();

        Toastr::error('User suspended Successfully', 'Suspended');
        return redirect()->route('admin.all_user');
    }

    public function unsuspend_user($id)
    {
        $user = Admin::find($id);
        $user->type = 'admin';
        $user->update();

        Toastr::success('User suspended Successfully', 'UnSuspended');
        return redirect()->route('admin.all_user');
    }

    public function delete_user($id)
    {
        $user = Admin::find($id);
        $user->status_id = 2;
        $user->update();

        Toastr::error('User deleted Successfully', 'Deleted');
        return redirect()->route('admin.all_user');
    }
}
