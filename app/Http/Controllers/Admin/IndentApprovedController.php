<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Additional_document;
use App\Models\AdminSection;
use App\Models\Designation;
use App\Models\DocumentTrack;
use App\Models\Dte_managment;
use App\Models\File;
use App\Models\FinancialYear;
use App\Models\Indent;
use App\Models\Item_type;
use App\Models\Items;
use App\Models\Section;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class IndentApprovedController extends Controller
{
    public function index()
    {
        $insp_id = Auth::user()->inspectorate_id;
        $admin_id = Auth::user()->id;
        $section_ids = AdminSection::where('admin_id', $admin_id)->pluck('sec_id')->toArray();
        $designation_id = AdminSection::where('admin_id', $admin_id)->pluck('desig_id')->first();
        $desig_position = Designation::where('id', $designation_id)->first();

        if ($designation_id == 1 || $designation_id == 0) {
            $indentNew = Indent::where('status', 0)->count();
            $indentOnProcess = '0';
            $indentCompleted = '0';
            $indentDispatch = DocumentTrack::where('doc_type_id', 3)
                ->leftJoin('indents', 'document_tracks.doc_ref_id', '=', 'indents.id')
                ->where('reciever_desig_id', $designation_id)
                ->where('track_status', 4)
                ->where('indents.status', 4)
                ->whereIn('document_tracks.section_id', $section_ids)
                ->count();
        } else {

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
        return view('backend.indent.indent_incomming_approved.indent_approved_index', compact('indentNew', 'indentOnProcess', 'indentCompleted', 'indentDispatch'));
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
                $query = Indent::leftJoin('items', 'indents.item_id', '=', 'items.id')
                    ->leftJoin('dte_managments', 'indents.sender', '=', 'dte_managments.id')
                    ->leftJoin('sections', 'indents.sec_id', '=', 'sections.id')
                    ->where('indents.status', 3)
                    ->select('indents.*', 'items.name as item_name', 'dte_managments.name as dte_managment_name', 'sections.name as section_name')
                    ->get();
            } elseif ($desig_position->id == 1) {

                $query = Indent::leftJoin('items', 'indents.item_id', '=', 'items.id')
                    ->leftJoin('dte_managments', 'indents.sender', '=', 'dte_managments.id')
                    ->leftJoin('sections', 'indents.sec_id', '=', 'sections.id')
                    ->select('indents.*', 'items.name as item_name', 'dte_managments.name as dte_managment_name', 'sections.name as section_name')
                    ->where('indents.status', 3)
                    ->get();
            } else {

                $indentIds = Indent::leftJoin('document_tracks', 'indents.id', '=', 'document_tracks.doc_ref_id')
                    ->where('document_tracks.reciever_desig_id', $designation_id)
                    ->where('indents.insp_id', $insp_id)
                    ->where('indents.status', 3)
                    ->where('document_tracks.doc_type_id', 3)
                    ->whereIn('indents.sec_id', $section_ids)->pluck('indents.id', 'indents.id')->toArray();

                $query = Indent::leftJoin('items', 'indents.item_id', '=', 'items.id')
                    ->leftJoin('dte_managments', 'indents.sender', '=', 'dte_managments.id')
                    ->leftJoin('sections', 'indents.sec_id', '=', 'sections.id')
                    ->select('indents.*', 'items.name as item_name', 'dte_managments.name as dte_managment_name', 'sections.name as section_name')
                    ->whereIn('indents.id', $indentIds)
                    ->where('indents.status', 3)
                    ->get();

                //......Start for DataTable Forward and Details btn change
                $indentId = [];
                if ($query) {
                    foreach ($query as $indent) {
                        array_push($indentId, $indent->id);
                    }
                }

                $document_tracks_receiver_id = DocumentTrack::whereIn('doc_ref_id', $indentId)
                    ->where('reciever_desig_id', $designation_id)
                    ->where('track_status', '3')
                    ->first();

                if (!$document_tracks_receiver_id) {
                    $query = Indent::where('id', 'no data')->get();
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
                    $DocumentTrack = DocumentTrack::where('doc_ref_id', $data->id)->where('doc_type_id',  3)->latest()->first();
                    $designation_id = AdminSection::where('admin_id', Auth::user()->id)->pluck('desig_id')->first();
                    // start Forward Btn Change for index

                    if ($DocumentTrack) {
                        if ($designation_id  ==  $DocumentTrack->reciever_desig_id) {
                            $actionBtn = '<div class="btn-group" role="group">
                            <a href="' . url('admin/indent/doc_status/' . $data->id) . '" class="doc">Doc Status</a>
                            <a href="' . url('admin/indent_approved/details/' . $data->id) . '" class="edit">Forward</a>
                            </div>';
                        } else {
                            $actionBtn = '<div class="btn-group" role="group">
                            <a href="' . url('admin/indent/doc_status/' . $data->id) . '" class="doc">Doc Status</a>
                            <a href="' . url('admin/indent_approved/details/' . $data->id) . '" class="update">Forwarded</a>
                            </div>';
                        }

                        if ($designation_id  ==  $DocumentTrack->sender_designation_id) {
                            $actionBtn = '<div class="btn-group" role="group">
                            <a href="' . url('admin/indent/doc_status/' . $data->id) . '" class="doc">Doc Status</a>
                            <a href="' . url('admin/indent_approved/details/' . $data->id) . '" class="update">Forwarded</a>
                            </div>';
                        }
                    } else {
                        $actionBtn = '<div class="btn-group" role="group">
                        <a href="' . url('admin/indent/doc_status/' . $data->id) . '" class="doc">Doc Status</a>
                        <a href="' . url('admin/indent_approved/details/' . $data->id) . '" class="edit">Forward</a>
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

        $details = Indent::leftJoin('item_types', 'indents.item_type_id', '=', 'item_types.id')
            ->leftJoin('items', 'indents.item_id', '=', 'items.id')
            ->leftJoin('dte_managments', 'indents.sender', '=', 'dte_managments.id')
            ->leftJoin('additional_documents', 'indents.additional_documents', '=', 'additional_documents.id')
            ->leftJoin('fin_years', 'indents.fin_year_id', '=', 'fin_years.id')
            ->select(
                'indents.*',
                'item_types.name as item_type_name',
                'items.name as item_name',
                'indents.*',
                'dte_managments.name as dte_managment_name',
                'additional_documents.name as additional_documents_name',
                'fin_years.year as fin_year_name'
            )
            ->where('indents.id', $id)
            ->first();
        // Attached File
        $files = File::where('doc_type_id', 3)->where('reference_no', $details->reference_no)->get();
        // Attached File End
        $details->additional_documents = json_decode($details->additional_documents, true);
        $additional_documents_names = [];

        if ($details->additional_documents) {
            foreach ($details->additional_documents as $document_id) {
                $additional_names = Additional_document::where('id', $document_id)->pluck('name')->first();
                array_push($additional_documents_names, $additional_names);
            }
        }



        $designations = Designation::all();
        $admin_id = Auth::user()->id;
        $section_ids = $section_ids = AdminSection::where('admin_id', $admin_id)->pluck('sec_id')->toArray();

        $document_tracks = DocumentTrack::where('doc_ref_id', $details->id)
            ->leftJoin('designations as sender_designation', 'document_tracks.sender_designation_id', '=', 'sender_designation.id')
            ->leftJoin('designations as receiver_designation', 'document_tracks.reciever_desig_id', '=', 'receiver_designation.id')
            ->whereIn('track_status', [1, 3])
            ->where('doc_type_id',  3)
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

        //Start blade notes section....
        $notes = '';

        $document_tracks_notes = DocumentTrack::where('doc_ref_id', $details->id)
            ->where('track_status', 1)
            ->where('reciever_desig_id', $desig_id)->get();

        if ($document_tracks_notes->isNotEmpty()) {
            $notes = $document_tracks_notes;
        }

        //End blade notes section....

        //Start blade forward on off section....
        $DocumentTrack_hidden = DocumentTrack::where('doc_ref_id',  $details->id)
            ->where('doc_type_id', 3)->latest()->first();

        //End blade forward on off section....


        return view('backend.indent.indent_incomming_approved.indent_approved_details', compact('details', 'designations', 'document_tracks', 'desig_id',  'auth_designation_id', 'sender_designation_id', 'additional_documents_names', 'DocumentTrack_hidden','files'));
    }

    public function indentTracking(Request $request)
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
        $doc_type_id = 3; //...... 3 for indent from indents table doc_serial.
        $doc_ref_id = $request->doc_ref_id;
        $remarks = $request->remarks;
        $doc_reference_number = $request->doc_reference_number;
        $reciever_desig_id = $request->reciever_desig_id;
        $sender_designation_id = AdminSection::where('admin_id', $admin_id)->pluck('desig_id')->first();
        $section_id = Indent::where('reference_no', $doc_reference_number)->pluck('sec_id')->first();
        $desig_position = Designation::where('id', $sender_designation_id)->first();

        if ($validator) {
            if ($reciever_desig_id == $sender_designation_id) {
                return response()->json(['error' => ['reciever_desig_id' => ['You cannot send to your own designation.']]], 422);
            }
        }

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

            $data = Indent::find($doc_ref_id);

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


    public function parameter(Request $request)
    {
        $indent = Indent::find($request->indent_id);
        $item_id = $indent->item_id;
        $item_type_id = $indent->item_type_id;
        return view('backend.indent.parameter', compact('item_id', 'item_type_id'));
    }
}