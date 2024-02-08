<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Additional_document;
use App\Models\AdminSection;
use App\Models\CoverLetter;
use App\Models\Designation;
use App\Models\DocumentTrack;
use App\Models\File;
use App\Models\Inote;
use App\Models\InoteLetter;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;


class InoteOutgoingController extends Controller
{
    public function index()
    {
        $insp_id = Auth::user()->inspectorate_id;
        $admin_id = Auth::user()->id;
        $section_ids = AdminSection::where('admin_id', $admin_id)->pluck('sec_id')->toArray();
        $designation_id = AdminSection::where('admin_id', $admin_id)->pluck('desig_id')->first();
        $desig_position = Designation::where('id', $designation_id)->first();

        if ($designation_id == 1 || $designation_id == 0) {
            $inoteNew = Inote::where('status', 0)->count();
            $inoteOnProcess = '0';
            $inoteCompleted = '0';
            $inoteDispatch = DocumentTrack::where('doc_type_id', 13)
                ->leftJoin('inotes', 'document_tracks.doc_ref_id', '=', 'inotes.id')
                ->where('reciever_desig_id', $designation_id)
                ->where('track_status', 4)
                ->where('inotes.status', 4)
                ->whereIn('document_tracks.section_id', $section_ids)
                ->count();
        } else {

            $inoteNew = DocumentTrack::where('doc_type_id', 13)
                ->leftJoin('inotes', 'document_tracks.doc_ref_id', '=', 'inotes.id')
                ->where('reciever_desig_id', $designation_id)
                ->where('track_status', 1)
                ->where('inotes.status', 0)
                ->whereIn('document_tracks.section_id', $section_ids)
                ->count();

            $inoteOnProcess = DocumentTrack::where('doc_type_id', 13)
                ->leftJoin('inotes', 'document_tracks.doc_ref_id', '=', 'inotes.id')
                ->where('reciever_desig_id', $designation_id)
                ->where('track_status', 3)
                ->where('inotes.status', 3)
                ->whereIn('document_tracks.section_id', $section_ids)
                ->count();

            $inoteCompleted = DocumentTrack::where('doc_type_id', 13)
                ->leftJoin('inotes', 'document_tracks.doc_ref_id', '=', 'inotes.id')
                ->where('reciever_desig_id', $designation_id)
                ->where('track_status', 2)
                ->where('inotes.status', 1)
                ->whereIn('document_tracks.section_id', $section_ids)
                ->count();

            $inoteDispatch = DocumentTrack::where('doc_type_id', 13)
                ->leftJoin('inotes', 'document_tracks.doc_ref_id', '=', 'inotes.id')
                ->where('reciever_desig_id', $designation_id)
                ->where('track_status', 4)
                ->where('inotes.status', 4)
                ->whereIn('document_tracks.section_id', $section_ids)
                ->count();
        }
        return view('backend.inote.inote_outgoing.outgoing', compact('inoteNew', 'inoteOnProcess', 'inoteCompleted', 'inoteDispatch'));
    }
    public function all_data(Request $request)
    {

        if ($request->ajax()) {

            $insp_id = Auth::user()->inspectorate_id;
            $admin_id = Auth::user()->id;
            $section_ids = AdminSection::where('admin_id', $admin_id)->pluck('sec_id')->toArray();
            $designation_id = AdminSection::where('admin_id', $admin_id)->pluck('desig_id')->first();
            $desig_position = Designation::where('id', $designation_id)->first();


            if (Auth::user()->id == 92) {
                $query = Inote::leftJoin('items', 'inotes.item_id', '=', 'items.id')
                    ->leftJoin('dte_managments', 'inotes.sender_id', '=', 'dte_managments.id')
                    ->leftJoin('sections', 'inotes.section_id', '=', 'sections.id')
                    ->select('inotes.*', 'items.name as item_name',  'dte_managments.name as dte_managment_name', 'sections.name as section_name')
                    ->where('inotes.status', '=', 1)
                    ->get();
            } else {
                $inoteIds = Inote::leftJoin('document_tracks', 'inotes.id', '=', 'document_tracks.doc_ref_id')
                    ->where('document_tracks.reciever_desig_id', $designation_id)
                    ->where('inotes.inspectorate_id', $insp_id)
                    ->where('inotes.status', 1)
                    ->where('document_tracks.doc_type_id', 13)
                    ->whereIn('inotes.section_id', $section_ids)->pluck('inotes.id', 'inotes.id')->toArray();

                $query = Inote::leftJoin('items', 'inotes.item_id', '=', 'items.id')
                    ->leftJoin('dte_managments', 'inotes.sender_id', '=', 'dte_managments.id')
                    ->leftJoin('sections', 'inotes.section_id', '=', 'sections.id')
                    ->select('inotes.*', 'items.name as item_name', 'dte_managments.name as dte_managment_name', 'sections.name as section_name')
                    ->whereIn('inotes.id', $inoteIds)
                    ->where('inotes.status', '=', 1)
                    ->get();

                //......Start for DataTable Forward and Details btn change
                $inoteId = [];
                if ($query) {
                    foreach ($query as $inote) {
                        array_push($inoteId, $inote->id);
                    }
                }

                //......Start for showing data for receiver designation

                $document_tracks_receiver_id = DocumentTrack::whereIn('doc_ref_id', $inoteId)
                    ->where('reciever_desig_id', $designation_id)
                    ->where('track_status', 2)
                    ->first();

                if (!$document_tracks_receiver_id) {
                    $query = Inote::where('id', 'no data')->get();
                }
                //......End for showing data for receiver designation
            }

            $query=$query->sortByDesc('id');

            return DataTables::of($query)
                ->setTotalRecords($query->count())
                ->addIndexColumn()

                ->addColumn('status', function ($data) {

                    if ($data->status == '1') {
                        return '<button class="btn  btn-info text-white btn-sm">Completed</button>';
                    } else {
                        return '<button class="btn btn-info text-white  btn-sm">None</button>';
                    }
                })
                ->addColumn('action', function ($data) {
                    // start Forward Btn Change for index
                    $DocumentTrack = DocumentTrack::where('doc_ref_id', $data->id)->where('doc_type_id', 13)->latest()->first();
                    $designation_id = AdminSection::where('admin_id', Auth::user()->id)->pluck('desig_id')->first();
                    // start Forward Btn Change for index

                    if ($DocumentTrack) {
                        if ($designation_id  ==  $DocumentTrack->reciever_desig_id) {
                            $actionBtn = '<div class="btn-group" role="group">

                    <a href="' . url('admin/outgoing_inote/details/' . $data->id) . '" class="edit">Forward</a>
                    </div>';
                        } else {
                            $actionBtn = '<div class="btn-group" role="group">

                            <a href="' . url('admin/outgoing_inote/details/' . $data->id) . '" class="update">Forwarded</a>
                            </div>';
                        }

                        if ($designation_id  ==  $DocumentTrack->sender_designation_id) {
                            $actionBtn = '<div class="btn-group" role="group">

                            <a href="' . url('admin/outgoing_inote/details/' . $data->id) . '" class="update">Forwarded</a>
                            </div>';
                        }
                    } else {
                        $actionBtn = '<div class="btn-group" role="group">

                    <a href="' . url('admin/outgoing_inote/details/' . $data->id) . '" class="edit">forward</a>
                    </div>';
                    }

                    return $actionBtn;
                })

                ->rawColumns(['action', 'status'])
                ->make(true);
        }
    }

    public function details($id)
    {

        $details = Inote::leftJoin('item_types', 'inotes.item_type_id', '=', 'item_types.id')
            ->leftJoin('dte_managments', 'inotes.sender_id', '=', 'dte_managments.id')
            ->leftJoin('items', 'inotes.item_id', '=', 'items.id')
            ->select('inotes.*', 'item_types.name as item_type_name', 'items.name as item_name', 'dte_managments.name as dte_managment_name')
            ->where('inotes.id', $id)
            ->where('inotes.status', 1)
            ->first();

        // Attached File
        $files = File::where('doc_type_id', 13)->where('reference_no', $details->reference_no)->get();
        // Attached File End

        $designations = Designation::all();
        $admin_id = Auth::user()->id;
        $section_ids = $section_ids = AdminSection::where('admin_id', $admin_id)->pluck('sec_id')->toArray();

        $document_tracks = DocumentTrack::where('doc_ref_id', $details->id)
            ->leftJoin('designations as sender_designation', 'document_tracks.sender_designation_id', '=', 'sender_designation.id')
            ->leftJoin('designations as receiver_designation', 'document_tracks.reciever_desig_id', '=', 'receiver_designation.id')
            ->where('track_status', 2)
            ->where('doc_type_id', 13)
            ->skip(1) // Skip the first row
            ->take(PHP_INT_MAX) // Take a large number of rows to emulate offset
            ->select(
                'document_tracks.*',
                'sender_designation.name as sender_designation_name',
                'receiver_designation.name as receiver_designation_name'
            )
            ->get();


        $auth_designation_id = AdminSection::where('admin_id', $admin_id)->first();
        if ($auth_designation_id) {

            $desig_id = $auth_designation_id->desig_id;
        }

        // delay cause for sec IC start

        $admin_id = Auth::user()->id;
        $sender_designation_id = AdminSection::where('admin_id', $admin_id)->pluck('desig_id')->first();
        $desig_position = Designation::where('id', $sender_designation_id)->first();

        // delay cause for sec IC start


        //Start blade forward on off section....
        $DocumentTrack_hidden = DocumentTrack::where('doc_ref_id',  $details->id)
            ->where('doc_type_id', 13)->latest()->first();

        //End blade forward on off section....

        // start cover letter start

        $cover_letter = CoverLetter::where('doc_reference_id', $details->reference_no)->first();
        $inote_letter = InoteLetter::where('inote_reference_no', $details->reference_no)->first();

        // end cover letter start


        return view('backend.inote.inote_outgoing.outgoing_details', compact('details', 'designations', 'document_tracks', 'desig_id', 'desig_position',  'auth_designation_id', 'sender_designation_id', 'DocumentTrack_hidden', 'cover_letter', 'inote_letter', 'files'));
    }

    public function Tracking(Request $request)
    {
        $ins_id = Auth::user()->inspectorate_id;
        $admin_id = Auth::user()->id;
        $section_ids = AdminSection::where('admin_id', $admin_id)->pluck('sec_id')->toArray();
        $doc_type_id = 13; // 13 for doc type qac from doctype table column doc_serial
        $doc_ref_id = $request->doc_ref_id;
        $doc_reference_number = $request->doc_reference_number;
        $remarks = $request->remarks;
        $reciever_desig_id = $request->reciever_desig_id;
        $section_id = Inote::where('reference_no', $doc_reference_number)->pluck('section_id')->first();
        $sender_designation_id = AdminSection::where('admin_id', $admin_id)->pluck('desig_id')->first();

        $desig_position = Designation::where('id', $sender_designation_id)->first();
        // dd( $desig_position);
        $data = new DocumentTrack();
        $data->ins_id = $ins_id;
        $data->section_id = $section_id;
        $data->doc_type_id = $doc_type_id;
        $data->doc_ref_id = $doc_ref_id;
        $data->doc_reference_number = $doc_reference_number;
        $data->track_status = 2;
        $data->remarks = $remarks;

        $data->reciever_desig_id = $reciever_desig_id;
        $data->sender_designation_id = $sender_designation_id;
        $data->created_at = Carbon::now('Asia/Dhaka');
        $data->updated_at = Carbon::now('Asia/Dhaka');
        $data->save();

        // ----delay_cause and terms and conditions start here
        if ($desig_position->position == 3) {
            $inote_data = Inote::find($doc_ref_id);
            $inote_data->delay_cause = $request->delay_cause;
            $inote_data->delivery_date = $request->delivery_date;


            $inote_data->delivery_by = Auth::user()->id;
            $inote_data->save();
        }
        // ----delay_cause and terms and conditions end here

        if ($desig_position->position == 7) {

            $data = Inote::find($doc_ref_id);

            if ($data) {

                $data->status = 4;
                $data->save();
                $value = new DocumentTrack();
                $value->ins_id = $ins_id;
                $value->section_id = $section_id;
                $value->doc_type_id = $doc_type_id;
                $value->doc_ref_id = $doc_ref_id;
                $value->doc_reference_number = $doc_reference_number;
                $value->track_status = 4;
                $value->remarks = $remarks;
                $value->reciever_desig_id = $reciever_desig_id;
                $value->sender_designation_id = $sender_designation_id;
                $value->created_at = Carbon::now('Asia/Dhaka');
                $value->updated_at = Carbon::now('Asia/Dhaka');
                $value->save();
            }
        }

        return response()->json(['success' => 'Done']);
    }
}
