<?php

namespace App\Http\Controllers\Admin;

use App\Admin;
use App\Http\Controllers\Controller;
use App\Models\AdminSection;
use App\Models\Contract;
use App\Models\Designation;
use App\Models\DocType;
use App\Models\DocumentTrack;
use App\Models\DraftContract;
use App\Models\FinalSpec;
use App\Models\Indent;
use App\Models\Inote;
use App\Models\Offer;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;

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
            ->count();

            $indentDispatch = DocumentTrack::where('doc_type_id', 3)
            ->leftJoin('indents', 'document_tracks.doc_ref_id', '=', 'indents.id')
            ->where('reciever_desig_id', $designation_id)
            ->where('track_status', 4)
            ->where('indents.status', 4)
            ->whereIn('document_tracks.section_id', $section_ids)
            ->count();

        }
        if ($designation_id==1 || $designation_id==0) {
            $offerNew = Offer::where('status' ,0)->count();
            $offerOnProcess = '0';
            $offerCompleted = '0';
            $offerDispatch = DocumentTrack::where('doc_type_id', 5)
            ->leftJoin('offers', 'document_tracks.doc_ref_id', '=', 'offers.id')
            ->where('reciever_desig_id', $designation_id)
            ->where('track_status', 4)
            ->where('offers.status', 4)
            ->whereIn('document_tracks.section_id', $section_ids)
            ->count();
        }else {

            $offerNew = DocumentTrack::where('doc_type_id', 5)
            ->leftJoin('offers', 'document_tracks.doc_ref_id', '=', 'offers.id')
            ->where('reciever_desig_id', $designation_id)
            ->where('track_status', 1)
            ->where('offers.status', 0)
            ->whereIn('document_tracks.section_id', $section_ids)
            ->count();

            $offerOnProcess = DocumentTrack::where('doc_type_id', 5)
            ->leftJoin('offers', 'document_tracks.doc_ref_id', '=', 'offers.id')
            ->where('reciever_desig_id', $designation_id)
            ->where('track_status', 3)
            ->where('offers.status', 3)
            ->whereIn('document_tracks.section_id', $section_ids)
            ->count();

            $offerCompleted = DocumentTrack::where('doc_type_id', 5)
            ->leftJoin('offers', 'document_tracks.doc_ref_id', '=', 'offers.id')
            ->where('reciever_desig_id', $designation_id)
            ->where('track_status', 2)
            ->where('offers.status', 1)
            ->whereIn('document_tracks.section_id', $section_ids)
            ->count();

            $offerDispatch = DocumentTrack::where('doc_type_id', 5)
            ->leftJoin('offers', 'document_tracks.doc_ref_id', '=', 'offers.id')
            ->where('reciever_desig_id', $designation_id)
            ->where('track_status', 4)
            ->where('offers.status', 4)
            ->whereIn('document_tracks.section_id', $section_ids)
            ->count();

        }



        $counts = [
            'IndentOverAll' => Indent::count(),
            'OfferOverAll' => Offer::count(),
            'FinalSpecOverAll' => FinalSpec::count(),
            'DraftContractOverAll' => DraftContract::count(),
            'ContractOverAll' => Contract::count(),
            'I_NoteOverAll' => Inote::count()
        ];
        $currentStatusCounts = [
            'IndentOverAll' => Indent::whereIn('status',[0,1,3,4])->whereIn('sec_id',$section_ids)->where('insp_id', $insp_id)->count(),
            'OfferOverAll' => Offer::whereIn('status',[0,1,3,4])->whereIn('sec_id',$section_ids)->where('insp_id', $insp_id)->count(),
            'FinalSpecOverAll' => FinalSpec::whereIn('status',[0,1,3,4])->whereIn('sec_id',$section_ids)->where('insp_id', $insp_id)->count(),
            'DraftContractOverAll' => DraftContract::whereIn('status',[0,1,3,4])->whereIn('section_id',$section_ids)->where('inspectorate_id', $insp_id)->count(),
            'ContractOverAll' => Contract::whereIn('status',[0,1,3,4])->whereIn('section_id',$section_ids)->where('inspectorate_id', $insp_id)->count(),
            'I_NoteOverAll' => Inote::whereIn('status',[0,1,3,4])->whereIn('section_id',$section_ids)->where('inspectorate_id', $insp_id)->count()
        ];





        return view('backend.dashboard.dashboard', compact('indentNew', 'indentOnProcess', 'indentCompleted', 'indentDispatch','counts','currentStatusCounts'));
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
    public function multiDashboard($docTypeId){

        // dd($docTypeId->all());
        $doc_type = DocType::find($docTypeId);
        $modelClass = 'App\\Models\\' . $doc_type->name;
        $table = $doc_type->table_name;



        $insp_id = Auth::user()->inspectorate_id;
        $admin_id = Auth::user()->id;
        $section_ids = AdminSection::where('admin_id', $admin_id)->pluck('sec_id')->toArray();
        $designation_id = AdminSection::where('admin_id', $admin_id)->pluck('desig_id')->first();



        if ($designation_id==1 || $designation_id==0) {
            $mulipleModelNew = $modelClass::where('status' ,0)->count();
            $mulipleModelOnProcess = '0';
            $mulipleModelCompleted = '0';
            $mulipleModelDispatch = DocumentTrack::where('doc_type_id', $doc_type->doc_serial)
            ->leftJoin($table, 'document_tracks.doc_ref_id', '=', $table.'.id')
            ->where('reciever_desig_id', $designation_id)
            ->where('track_status', 4)
            ->where($table.'.status', 4)
            ->whereIn('document_tracks.section_id', $section_ids)
            ->count();
            //  dd($mulipleModelDispatch);
        }else {

            $mulipleModelNew = DocumentTrack::where('doc_type_id', $doc_type->doc_serial)
            ->leftJoin($table, 'document_tracks.doc_ref_id', '=', $table . '.id')
            ->where('reciever_desig_id', $designation_id)
            ->where('track_status', 1)
            ->where($table . '.status', 0)
            ->where('document_tracks.section_id', $section_ids)
            ->count();        
// dd($mulipleModelNew);
            $mulipleModelOnProcess = DocumentTrack::where('doc_type_id', $doc_type->doc_serial)
            ->leftJoin($table, 'document_tracks.doc_ref_id', '=', $table.'.id')
            ->where('reciever_desig_id', $designation_id)
            ->where('track_status', 3)
            ->where($table.'.status', 3)
            ->whereIn('document_tracks.section_id', $section_ids)
            ->count();

            $mulipleModelCompleted = DocumentTrack::where('doc_type_id', $doc_type->doc_serial)
            ->leftJoin($table, 'document_tracks.doc_ref_id', '=', $table.'.id')
            ->where('reciever_desig_id', $designation_id)
            ->where('track_status', 2)
            ->where($table.'.status', 1)
            ->whereIn('document_tracks.section_id', $section_ids)
            ->count();

            $mulipleModelDispatch = DocumentTrack::where('doc_type_id', $doc_type->doc_serial)
            ->leftJoin($table, 'document_tracks.doc_ref_id', '=', $table.'.id')
            ->where('reciever_desig_id', $designation_id)
            ->where('track_status', 4)
            ->where($table.'.status', 4)
            ->whereIn('document_tracks.section_id', $section_ids)
            ->count();

        }

        $counts = [
            'IndentOverAll' => Indent::count(),
            'OfferOverAll' => Offer::count(),
            'FinalSpecOverAll' => FinalSpec::count(),
            'DraftContractOverAll' => DraftContract::count(),
            'ContractOverAll' => Contract::count(),
            'I_NoteOverAll' => Inote::count()
        ];
        $currentStatusCounts = [
            'IndentOverAll' => Indent::whereIn('status',[0,1,3,4])->whereIn('sec_id',$section_ids)->where('insp_id', $insp_id)->count(),
            'OfferOverAll' => Offer::whereIn('status',[0,1,3,4])->whereIn('sec_id',$section_ids)->where('insp_id', $insp_id)->count(),
            'FinalSpecOverAll' => FinalSpec::whereIn('status',[0,1,3,4])->whereIn('sec_id',$section_ids)->where('insp_id', $insp_id)->count(),
            'DraftContractOverAll' => DraftContract::whereIn('status',[0,1,3,4])->whereIn('section_id',$section_ids)->where('inspectorate_id', $insp_id)->count(),
            'ContractOverAll' => Contract::whereIn('status',[0,1,3,4])->whereIn('section_id',$section_ids)->where('inspectorate_id', $insp_id)->count(),
            'I_NoteOverAll' => Inote::whereIn('status',[0,1,3,4])->whereIn('section_id',$section_ids)->where('inspectorate_id', $insp_id)->count()
        ];
        // dd($counts);

        //   dd($counts);   
        return view('backend.dashboard.multiDashboard',compact('mulipleModelNew', 'mulipleModelOnProcess', 'mulipleModelCompleted','mulipleModelDispatch','doc_type','counts','currentStatusCounts'));

    }
}