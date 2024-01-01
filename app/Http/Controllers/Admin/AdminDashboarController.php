<?php

namespace App\Http\Controllers\Admin;

use App\Admin;
use App\Http\Controllers\Controller;
use App\Models\AdminSection;
use App\Models\Designation;
use App\Models\DocumentTrack;
use App\Models\Indent;
use App\Models\Offer;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class AdminDashboarController extends Controller
{
    public function index()
    {
        $insp_id = Auth::user()->inspectorate_id;
        $admin_id = Auth::user()->id;
        $section_ids = AdminSection::where('admin_id', $admin_id)->pluck('sec_id')->toArray();
        $designation_id = AdminSection::where('admin_id', $admin_id)->pluck('desig_id')->first();
        $desig_position = Designation::where('id', $designation_id)->first();

        if ($designation_id==1 || $designation_id==0) {
            $indentNew = Indent::where('status' ,0)->count();
            $indentOnProcess = '0';
            $indentCompleted = '0';
            $indentDispatch = DocumentTrack::where('doc_type_id', 3)
            ->leftJoin('indents', 'document_tracks.doc_ref_id', '=', 'indents.id')
            ->where('reciever_desig_id', $designation_id)
            ->where('track_status', 4)
            ->where('indents.status', 4)
            ->whereIn('document_tracks.section_id', $section_ids)
            ->count();
        }else {

            $indentNew = DocumentTrack::where('doc_type_id', 3)
            ->leftJoin('indents', 'document_tracks.doc_ref_id', '=', 'indents.id')
            ->where('reciever_desig_id', $designation_id)
            ->where('track_status', 1)
            ->where('indents.status', 0)
            ->whereIn('document_tracks.section_id', $section_ids)
            ->count();

            $indentOnProcess = DocumentTrack::where('doc_type_id', 3)
            ->leftJoin('indents', 'document_tracks.doc_ref_id', '=', 'indents.id')
            ->where('reciever_desig_id', $designation_id)
            ->where('track_status', 3)
            ->where('indents.status', 3)
            ->whereIn('document_tracks.section_id', $section_ids)
            ->count();

            $indentCompleted = DocumentTrack::where('doc_type_id', 3)
            ->leftJoin('indents', 'document_tracks.doc_ref_id', '=', 'indents.id')
            ->where('reciever_desig_id', $designation_id)
            ->where('track_status', 2)
            ->where('indents.status', 1)
            ->whereIn('document_tracks.section_id', $section_ids)
            ->get();

            $indentDispatch = DocumentTrack::where('doc_type_id', 3)
            ->leftJoin('indents', 'document_tracks.doc_ref_id', '=', 'indents.id')
            ->where('reciever_desig_id', $designation_id)
            ->where('track_status', 4)
            ->where('indents.status', 4)
            ->whereIn('document_tracks.section_id', $section_ids)
            ->count();

        }







        $indentNewChart = Indent::where('status', 0)->count();
        $indentOnProcessChart = Indent::where('status', 3)->count();
        $indentCompletedChart = Indent::where('status', 1)->count();
        $indentDispatchChart = Indent::where('status', 4)->count();

        $offerNew = Offer::where('status', 0)->count();
        $offerForward = Offer::where('status', 3)->count();
        $offerDownward = Offer::where('status', 1)->count();
        $offerDispatch = Offer::where('status', 4)->count();
        return view('backend.dashboard.dashboard', compact('indentNew', 'indentOnProcess', 'indentCompleted', 'indentDispatch', 'offerNew', 'offerForward', 'offerDownward', 'offerDispatch',  'indentNewChart','indentOnProcessChart','indentCompletedChart','indentDispatchChart'));
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
