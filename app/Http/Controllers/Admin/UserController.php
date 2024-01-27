<?php

namespace App\Http\Controllers\Admin;

use App\Admin;
use App\Http\Controllers\Controller;
use App\Models\AdminSection;
use App\Models\Designation;
use App\Models\Inspectorate;
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

            $role = role::all();
            $inspectorates = Inspectorate::all();
            $page_data = [
                'add_menu' => 'yes',
                'modal' => 'yes',
            ];
            $section = Section::all();
            $designation = Designation::all();
            return view('backend.user.all_user', compact('users', 'page_data', 'role', 'inspectorates', 'section', 'designation'));
        } else {

            $auth_inspectorate_id =  Auth::user()->inspectorate_id;
            $users = Admin::where('inspectorate_id', $auth_inspectorate_id)->where('status_id', '!=', 2)->get();
            $role = role::where('inspectorate_id', $auth_inspectorate_id)->get();
            $page_data = [
                'add_menu' => 'yes',
                'modal' => 'yes',
            ];
            $section = Section::where('inspectorate_id',  $auth_inspectorate_id)->get();
            $designation = Designation::all();
            return view('backend.user.all_user', compact('users', 'page_data', 'role', 'section', 'designation'));
        }
    }

    public function save_user(Request $request)
    {
        
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:3', 'confirmed'],
            'role_id' => ['required'],
            'sec_id' => 'required|array',
            'sec_id.*' => 'exists:sections,id',
            'desig_id' => 'required|exists:designations,id'
        ]);
        if (Auth::user()->id == 92) {
            $auth_inspectorate_id = $request->insp_id;


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

            $user_id = $user->id;
            
            if ($user_id) {
                foreach ($request->sec_id as $sectionId) {

                    $admin_section = new AdminSection();
                    $admin_section->admin_id = $user_id;
                    $admin_section->sec_id = $sectionId;
                    $admin_section->desig_id = $request->desig_id;
                    $admin_section->created_at = Carbon::now();
                    $admin_section->updated_at = Carbon::now();
                    $admin_section->save();
                }
            }

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

            $user_id = $user->id;
            if ($user_id) {
                foreach ($request->sec_id as $sectionId) {

                    $admin_section = new AdminSection();
                    $admin_section->admin_id = $user_id;
                    $admin_section->sec_id = $sectionId;
                    $admin_section->desig_id = $request->desig_id;
                    $admin_section->created_at = Carbon::now();
                    $admin_section->updated_at = Carbon::now();
                    $admin_section->save();
                }
            }
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
        $all_sections=Section::all();
        $assign_section=AdminSection::where('admin_id',$user->id)->get();

        $section_loop='';
        foreach ($all_sections as $section) {
            $isChecked = false;

            foreach ($assign_section as $as) {
                if ($section->id == $as->sec_id) {
                    $isChecked = true;
                    break; // No need to continue checking if the section is already found
                }
            }

            $section_loop .= '<br><input  name="sec_id[]" type="checkbox" value="' . $section->id . '" ' . ($isChecked ? 'checked' : '') . '/>' . $section->name ;
        }
        $allDesig=Designation::all();
        $assignDesig=AdminSection::where('admin_id', $user->id)->first();
        $designation_loop = '';

        foreach ($allDesig as $data) {
            $designation_loop .= '<option value="' . $data->id . '" ' . (($data->id == $assignDesig->desig_id) ? 'selected="selected"'
                : "") . '>' . $data->name . '</option>';
        }

        $output .= '<div class="form-group"> <label for="Route_name">user name</label> <input type="text" class="form-control" name="name" value="' . $user->name . '"> </div><div class="form-group"> <label for="mobile">Mobile</label> <input type="text" class="form-control" name="mobile" value="' . $user->mobile . '"> </div><input type="hidden" name="user_id" value="' . $id . '"> <div class="form-group"> <label for="Route_name">user Email</label> <input id="email" type="email" class="form-control" name="email" value="' . $user->email . '" required autocomplete="email"> </div><div class="form-group"> <label for="status">Role</label> <select class="form-control" id="status" name="role_id"> ' . $role_loop . ' </select> </div>
        <div class="form-group">  <label for="section_multiple">Assign Section</label>'.$section_loop.'</div><div class="form-group"> <label for="desig_id">Designaton</label> <select class="form-control" id="desig_id" name="desig_id"> ' . $role_loop . ' </select> </div>';


        return $output;
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

        AdminSection::where('admin_id', $request->user_id)->delete();

        foreach ($request->sec_id as $sectionId) {
        $admin_section = new AdminSection();
        $admin_section->admin_id = $request->user_id;
        $admin_section->sec_id = $sectionId;
        $admin_section->desig_id = $request->desig_id;
        $admin_section->created_at = Carbon::now();
        $admin_section->updated_at = Carbon::now();
        $admin_section->save();
    }

        Toastr::success('User Updated Successfully', 'Updated');
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
