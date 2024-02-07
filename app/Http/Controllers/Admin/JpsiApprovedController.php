<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Additional_document;
use App\Models\AdminSection;
use App\Models\Designation;
use App\Models\DocumentTrack;
use App\Models\File;
use App\Models\Jpsi;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;

class jpsiApprovedController extends Controller
{
    public function index()
    {
        $insp_id = Auth::user()->inspectorate_id;
        $admin_id = Auth::user()->id;
        $section_ids = AdminSection::where('admin_id', $admin_id)->pluck('sec_id')->toArray();
        $designation_id = AdminSection::where('admin_id', $admin_id)->pluck('desig_id')->first();
        $desig_position = Designation::where('id', $designation_id)->first();

        if ($designation_id == 1 || $designation_id == 0) {
            $jpsiNew = jpsi::where('status', 0)->count();
            $jpsiOnProcess = '0';
            $jpsiCompleted = '0';
            $jpsiDispatch = DocumentTrack::where('doc_type_id', 12)
                ->leftJoin('jpsies', 'document_tracks.doc_ref_id', '=', 'jpsies.id')
                ->where('reciever_desig_id', $designation_id)
                ->where('track_status', 4)
                ->where('jpsies.status', 4)
                ->whereIn('document_tracks.section_id', $section_ids)
                ->count();
        } else {

            $jpsiNew = DocumentTrack::where('doc_type_id', 12)
                ->leftJoin('jpsies', 'document_tracks.doc_ref_id', '=', 'jpsies.id')
                ->where('reciever_desig_id', $designation_id)
                ->where('track_status', 1)
                ->where('jpsies.status', 0)
                ->whereIn('document_tracks.section_id', $section_ids)
                ->count();

            $jpsiOnProcess = DocumentTrack::where('doc_type_id', 12)
                ->leftJoin('jpsies', 'document_tracks.doc_ref_id', '=', 'jpsies.id')
                ->where('reciever_desig_id', $designation_id)
                ->where('track_status', 3)
                ->where('jpsies.status', 3)
                ->whereIn('document_tracks.section_id', $section_ids)
                ->count();

            $jpsiCompleted = DocumentTrack::where('doc_type_id', 12)
                ->leftJoin('jpsies', 'document_tracks.doc_ref_id', '=', 'jpsies.id')
                ->where('reciever_desig_id', $designation_id)
                ->where('track_status', 2)
                ->where('jpsies.status', 1)
                ->whereIn('document_tracks.section_id', $section_ids)
                ->count();

            $jpsiDispatch = DocumentTrack::where('doc_type_id', 12)
                ->leftJoin('jpsies', 'document_tracks.doc_ref_id', '=', 'jpsies.id')
                ->where('reciever_desig_id', $designation_id)
                ->where('track_status', 4)
                ->where('jpsies.status', 4)
                ->whereIn('document_tracks.section_id', $section_ids)
                ->count();
        }
        return view('backend.jpsi.jpsi_incomming_approved.jpsi_approved_index', compact('jpsiNew', 'jpsiOnProcess', 'jpsiCompleted', 'jpsiDispatch'));
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
                $query = jpsi::leftJoin('items', 'jpsies.item_id', '=', 'items.id')
                    ->leftJoin('dte_managments', 'jpsies.sender_id', '=', 'dte_managments.id')
                    ->leftJoin('sections', 'jpsies.section_id', '=', 'sections.id')
                    ->where('jpsies.status', 3)
                    ->select('jpsies.*', 'items.name as item_name', 'dte_managments.name as dte_managment_name', 'sections.name as section_name')
                    ->get();
            } elseif ($desig_position->id == 1) {

                $query = jpsi::leftJoin('items', 'jpsies.item_id', '=', 'items.id')
                    ->leftJoin('dte_managments', 'jpsies.sender_id', '=', 'dte_managments.id')
                    ->leftJoin('sections', 'jpsies.section_id', '=', 'sections.id')
                    ->select('jpsies.*', 'items.name as item_name', 'dte_managments.name as dte_managment_name', 'sections.name as section_name')
                    ->where('jpsies.status', 3)
                    ->get();
            } else {

                $jpsiIds = jpsi::leftJoin('document_tracks', 'jpsies.id', '=', 'document_tracks.doc_ref_id')
                    ->where('document_tracks.reciever_desig_id', $designation_id)
                    ->where('document_tracks.doc_type_id', 12)
                    ->where('jpsies.inspectorate_id', $insp_id)
                    ->where('jpsies.status', 3)
                    ->whereIn('jpsies.section_id', $section_ids)->pluck('jpsies.id', 'jpsies.id')->toArray();

                $query = jpsi::leftJoin('items', 'jpsies.item_id', '=', 'items.id')
                    ->leftJoin('dte_managments', 'jpsies.section_id', '=', 'dte_managments.id')
                    ->leftJoin('sections', 'jpsies.section_id', '=', 'sections.id')
                    ->select('jpsies.*', 'items.name as item_name',  'dte_managments.name as dte_managment_name', 'sections.name as section_name')
                    ->whereIn('jpsies.id', $jpsiIds)
                    ->where('jpsies.status', 3)
                    ->get();

                //......Start for DataTable Forward and Details btn change
                $jpsiId = [];
                if ($query) {
                    foreach ($query as $jpsi) {
                        array_push($jpsiId, $jpsi->id);
                    }
                }

                $document_tracks_receiver_id = DocumentTrack::whereIn('doc_ref_id', $jpsiId)
                    ->where('reciever_desig_id', $designation_id)
                    ->where('track_status', '3')
                    ->first();

                if (!$document_tracks_receiver_id) {
                    $query = jpsi::where('id', 'no data')->get();
                }
                //......End for showing data for receiver designation
            }

            // $query->orderBy('id', 'asc');

            return DataTables::of($query)
                ->setTotalRecords($query->count())
                ->addIndexColumn()

                ->addColumn('status', function ($data) {

                    if ($data->status == '3') {
                        return '<button class="btn btn-secondary btn-sm">Approved</button>';
                    } else {
                        return '<button class="btn btn-secondary btn-sm">None</button>';
                    }
                })
                ->addColumn('action', function ($data) {
                    // start Forward Btn Change for index
                    $DocumentTrack = DocumentTrack::where('doc_ref_id', $data->id)->where('doc_type_id', 12)->latest()->first();
                    $designation_id = AdminSection::where('admin_id', Auth::user()->id)->pluck('desig_id')->first();
                    // start Forward Btn Change for index

                    if ($DocumentTrack) {
                        if ($designation_id  ==  $DocumentTrack->reciever_desig_id) {
                            $actionBtn = '<div class="btn-group" role="group">
                            <a href="' . url('admin/jpsi_approved/details/' . $data->id) . '" class="edit">Forward</a>
                            </div>';
                        } else {
                            $actionBtn = '<div class="btn-group" role="group">

                            <a href="' . url('admin/jpsi_approved/details/' . $data->id) . '" class="update">Forwarded</a>
                            </div>';
                        }

                        if ($designation_id  ==  $DocumentTrack->sender_designation_id) {
                            $actionBtn = '<div class="btn-group" role="group">

                            <a href="' . url('admin/jpsi_approved/details/' . $data->id) . '" class="update">Forwarded</a>
                            </div>';
                        }
                    } else {
                        $actionBtn = '<div class="btn-group" role="group">

                        <a href="' . url('admin/jpsi_approved/details/' . $data->id) . '" class="edit">Forward</a>
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

        $details = jpsi::leftJoin('item_types', 'jpsies.item_type_id', '=', 'item_types.id')
            ->leftJoin('dte_managments', 'jpsies.sender_id', '=', 'dte_managments.id')
            ->leftJoin('items', 'jpsies.item_id', '=', 'items.id')
            ->leftJoin('fin_years', 'jpsies.fin_year_id', '=', 'fin_years.id')
            ->select(
                'jpsies.*',
                'item_types.name as item_type_name',
                'items.name as item_name',
                'dte_managments.name as dte_managment_name',
                'fin_years.year as fin_year_name'
            )
            ->where('jpsies.id', $id)
            ->first();
        $files = File::where('doc_type_id', 12)->where('reference_no', $details->reference_no)->get();
        $designations = Designation::all();
        $admin_id = Auth::user()->id;
        $section_ids = $section_ids = AdminSection::where('admin_id', $admin_id)->pluck('sec_id')->toArray();

        $document_tracks = DocumentTrack::where('doc_ref_id', $details->id)
            ->leftJoin('designations as sender_designation', 'document_tracks.sender_designation_id', '=', 'sender_designation.id')
            ->leftJoin('designations as receiver_designation', 'document_tracks.reciever_desig_id', '=', 'receiver_designation.id')
            ->where('doc_type_id', 12)
            ->whereIn('track_status', [1, 3])
            ->whereNot(function ($query) {
                $query->where('sender_designation.id', 7)
                    ->where('receiver_designation.id', 5)
                    ->where('document_tracks.track_status', 1);
            })
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

        //Start close forward Status...

        $sender_designation_id = '';
        foreach ($document_tracks as $track) {
            if ($track->sender_designation_id === $desig_id) {
                $sender_designation_id = $track->sender_designation_id;
                break;
            }
        }

        //End close forward Status...

        //Start blade forward on off section....
        $DocumentTrack_hidden = DocumentTrack::where('doc_ref_id',  $details->id)
            ->where('doc_type_id', 12)->latest()->first();

        //End blade forward on off section....

        return view('backend.jpsi.jpsi_incomming_approved.jpsi_approved_details', compact('details', 'designations', 'document_tracks', 'desig_id', 'auth_designation_id', 'sender_designation_id',  'DocumentTrack_hidden', 'files'));
    }

    public function Tracking(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'doc_ref_id' => 'required',
            'doc_reference_number' => 'required',
            'reciever_desig_id' => 'required',
        ], [
            'reciever_desig_id.required' => 'The receiver designation field is required.'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $ins_id = Auth::user()->inspectorate_id;
        $admin_id = Auth::user()->id;
        $section_ids = AdminSection::where('admin_id', $admin_id)->pluck('sec_id')->toArray();
        $doc_type_id = 12; //...... 8 for jpsi from jpsi table doc_serial.
        $doc_ref_id = $request->doc_ref_id;
        $remarks = $request->remarks;
        $doc_reference_number = $request->doc_reference_number;
        $reciever_desig_id = $request->reciever_desig_id;
        $section_id = Jpsi::where('reference_no', $doc_reference_number)->pluck('section_id')->first();
        $sender_designation_id = AdminSection::where('admin_id', $admin_id)->pluck('desig_id')->first();

        if ($validator) {
            if ($reciever_desig_id == $sender_designation_id) {
                return response()->json(['error' => ['reciever_desig_id' => ['You cannot send to your own designation.']]], 422);
            }
        }

        $desig_position = Designation::where('id', $sender_designation_id)->first();

        $data = new DocumentTrack();
        $data->ins_id = $ins_id;
        $data->section_id = $section_id;
        $data->doc_type_id = $doc_type_id;
        $data->doc_ref_id = $doc_ref_id;
        $data->doc_reference_number = $doc_reference_number;
        $data->track_status = 3;
        $data->reciever_desig_id = $reciever_desig_id;
        $data->sender_designation_id = $sender_designation_id;
        $data->remarks = $remarks;
        $data->created_at = Carbon::now('Asia/Dhaka');
        $data->updated_at = Carbon::now('Asia/Dhaka');;
        $data->save();


        if ($desig_position->position == 5) {

            $data = jpsi::find($doc_ref_id);

            if ($data) {

                $data->status = 1;
                $data->save();

                $value = new DocumentTrack();
                $value->ins_id = $ins_id;
                $value->section_id = $section_id;
                $value->doc_type_id = $doc_type_id;
                $value->doc_ref_id = $doc_ref_id;
                $value->doc_reference_number = $doc_reference_number;
                $value->track_status = 2;
                $value->reciever_desig_id = $reciever_desig_id;
                $value->sender_designation_id = $sender_designation_id;
                $value->remarks = $remarks;
                $value->created_at = Carbon::now('Asia/Dhaka');
                $value->updated_at = Carbon::now('Asia/Dhaka');
                $value->save();
            }
        }

        return response()->json(['success' => 'Done']);
    }
}