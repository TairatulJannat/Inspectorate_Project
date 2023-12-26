<?php

namespace App\Http\Controllers\Admin;

use App\Admin;
use App\Http\Controllers\Controller;
use App\Models\DocumentTrack;
use App\Models\Indent;
use App\Models\Offer;
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
        $x=Indent::where('status', 0)->get();
        foreach ( $x as $indent) {
            $indentNew=DocumentTrack::where('doc_reference_number', $indent->reference_no)->count();
        }

        $indentForward=Indent::where('status', 3)->count();
        $indentDownward=Indent::where('status', 1)->count();
        $indentDispatch=Indent::where('status', 4)->count();

        $offerNew=Offer::where('status', 0)->count();
        $offerForward=Offer::where('status', 3)->count();
        $offerDownward=Offer::where('status', 1)->count();
        $offerDispatch=Offer::where('status', 4)->count();
        return view('backend.dashboard.dashboard' , compact('indentNew', 'indentForward', 'indentDownward', 'indentDispatch', 'offerNew', 'offerForward', 'offerDownward', 'offerDispatch'));
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
