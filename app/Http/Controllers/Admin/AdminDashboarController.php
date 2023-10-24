<?php

namespace App\Http\Controllers\Admin;

use App\Admin;
use App\Http\Controllers\Controller;
use App\Models\Provider\JobModel;
use App\Models\User\JobSeekerDetailsModel;
use App\Models\User\UserCourseDetailsModel;
use App\Models\User\UserEducationDetailsModel;
use App\Models\User\UserExperienceDetailsModel;
use App\Provider;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class AdminDashboarController extends Controller
{
    public function index()
    {
        $total_entry = User::all()->count();
        $approve_entry = User::where('submit_status', 3)->count();
        $pending_entry = User::where('submit_status', 1)->count();
//        dd($total_entry,$approve_entry,$pending_entry);
        return view('backend.dashboard.dashboard', compact('total_entry', 'approve_entry', 'pending_entry'));
    }


    public function save_change_password(Request $request)
    {
        $validatedData = $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8',
            'password_confirmation' => 'required|same:password',
        ], [
            'current_password.required' => 'Old password is required',
            'current_password.min' => 'Old password needs to have at least 8 characters',
            'password.required' => 'Password is required',
            'password.min' => 'Password needs to have at least 8 characters',
            'password_confirmation.required' => 'Passwords do not match'
        ]);

        $current_password = Auth::User()->password;
        if (Hash::check($request->input('current_password'), $current_password)) {
            $user_id = Auth::User()->id;
            $obj_user = Admin::find($user_id);
            $obj_user->password = Hash::make($request->input('password'));
            $obj_user->update();
            Toastr::success('Password Save Successfully', 'Changed');
            return redirect()->route('admin.adminDashboard');
        } else {
            Toastr::error('Please enter correct current password', 'Wrong');
            return redirect()->back();
        }
    }

    public function change_pasword()
    {
        return view('backend.partial.change_password');
    }


    public function admin_logout(Request $request)
    {
        Auth::logout();
        return redirect()->route('login');
    }

    


    

  

    


   

    


}
