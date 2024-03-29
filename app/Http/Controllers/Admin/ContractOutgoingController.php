<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Additional_document;
use App\Models\AdminSection;
use App\Models\CoverLetter;
use App\Models\Designation;
use App\Models\DocumentTrack;
use App\Models\Contract;
use App\Models\File;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;


class ContractOutgoingController extends Controller
{
    public function index()
    {
        $insp_id = Auth::user()->inspectorate_id;
        $admin_id = Auth::user()->id;
        $section_ids = AdminSection::where('admin_id', $admin_id)->pluck('sec_id')->toArray();
        $designation_id = AdminSection::where('admin_id', $admin_id)->pluck('desig_id')->first();
        $desig_position = Designation::where('id', $designation_id)->first();

        if ($designation_id == 1 || $designation_id == 0) {
            $contractNew = Contract::where('status', 0)->count();
            $contractOnProcess = '0';
            $contractCompleted = '0';
            $contractDispatch = DocumentTrack::where('doc_type_id', 10)
                ->leftJoin('contract', 'document_tracks.doc_ref_id', '=', 'contracts.id')
                ->where('reciever_desig_id', $designation_id)
                ->where('track_status', 4)
                ->where('contracts.status', 4)
                ->whereIn('document_tracks.section_id', $section_ids)
                ->count();
        } else {

            $contractNew = DocumentTrack::where('doc_type_id', 10)
                ->leftJoin('contracts', 'document_tracks.doc_ref_id', '=', 'contracts.id')
                ->where('reciever_desig_id', $designation_id)
                ->where('track_status', 1)
                ->where('contracts.status', 0)
                ->whereIn('document_tracks.section_id', $section_ids)
                ->count();

            $contractOnProcess = DocumentTrack::where('doc_type_id', 10)
                ->leftJoin('contracts', 'document_tracks.doc_ref_id', '=', 'contracts.id')
                ->where('reciever_desig_id', $designation_id)
                ->where('track_status', 3)
                ->where('contracts.status', 3)
                ->whereIn('document_tracks.section_id', $section_ids)
                ->count();

            $contractCompleted = DocumentTrack::where('doc_type_id', 10)
                ->leftJoin('contracts', 'document_tracks.doc_ref_id', '=', 'contracts.id')
                ->where('reciever_desig_id', $designation_id)
                ->where('track_status', 2)
                ->where('contracts.status', 1)
                ->whereIn('document_tracks.section_id', $section_ids)
                ->count();

            $contractDispatch = DocumentTrack::where('doc_type_id', 10)
                ->leftJoin('contracts', 'document_tracks.doc_ref_id', '=', 'contracts.id')
                ->where('reciever_desig_id', $designation_id)
                ->where('track_status', 4)
                ->where('contracts.status', 4)
                ->whereIn('document_tracks.section_id', $section_ids)
                ->count();
        }
        return view('backend.contract.contract_outgoing.outgoing', compact('contractNew', 'contractOnProcess', 'contractCompleted', 'contractDispatch'));
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
                $query = Contract::leftJoin('items', 'contracts.item_id', '=', 'items.id')
                    ->leftJoin('dte_managments', 'contracts.sender_id', '=', 'dte_managments.id')
                    ->leftJoin('sections', 'contracts.section_id', '=', 'sections.id')
                    ->select('contracts.*', 'items.name as item_name', 'dte_managments.name as dte_managment_name', 'sections.name as section_name')
                    ->where('contracts.status', '=', 1)
                    ->get();
            } else {
                $contractIds = Contract::leftJoin('document_tracks', 'contracts.id', '=', 'document_tracks.doc_ref_id')
                    ->where('document_tracks.reciever_desig_id', $designation_id)
                    ->where('contracts.inspectorate_id', $insp_id)
                    ->where('contracts.status', 1)
                    ->where('document_tracks.doc_type_id', 10)
                    ->whereIn('contracts.section_id', $section_ids)->pluck('contracts.id', 'contracts.id')->toArray();

                $query = Contract::leftJoin('items', 'contracts.item_id', '=', 'items.id')
                    ->leftJoin('dte_managments', 'contracts.sender_id', '=', 'dte_managments.id')
                    ->leftJoin('sections', 'contracts.section_id', '=', 'sections.id')
                    ->select('contracts.*', 'items.name as item_name', 'dte_managments.name as dte_managment_name', 'sections.name as section_name')
                    ->whereIn('contracts.id', $contractIds)
                    ->where('contracts.status', '=', 1)
                    ->get();

                //......Start for DataTable Forward and Details btn change
                $contractId = [];
                if ($query) {
                    foreach ($query as $contract) {
                        array_push($contractId, $contract->id);
                    }
                }

                //......Start for showing data for receiver designation

                $document_tracks_receiver_id = DocumentTrack::whereIn('doc_ref_id', $contractId)
                    ->where('reciever_desig_id', $designation_id)
                    ->where('track_status', 2)
                    ->first();

                if (!$document_tracks_receiver_id) {
                    $query = Contract::where('id', 'no data')->get();
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
                    $DocumentTrack = DocumentTrack::where('doc_ref_id', $data->id)->where('doc_type_id', 10)->latest()->first();
                    $designation_id = AdminSection::where('admin_id', Auth::user()->id)->pluck('desig_id')->first();
                    // start Forward Btn Change for index

                    if ($DocumentTrack) {
                        if ($designation_id  ==  $DocumentTrack->reciever_desig_id) {
                            $actionBtn = '<div class="btn-group" role="group">

                    <a href="' . url('admin/outgoing_contract/details/' . $data->id) . '" class="edit">Forward</a>
                    </div>';
                        } else {
                            $actionBtn = '<div class="btn-group" role="group">

                            <a href="' . url('admin/outgoing_contract/details/' . $data->id) . '" class="update">Forwarded</a>
                            </div>';
                        }

                        if ($designation_id  ==  $DocumentTrack->sender_designation_id) {
                            $actionBtn = '<div class="btn-group" role="group">

                            <a href="' . url('admin/outgoing_contract/details/' . $data->id) . '" class="update">Forwarded</a>
                            </div>';
                        }
                    } else {
                        $actionBtn = '<div class="btn-group" role="group">

                    <a href="' . url('admin/outgoing_contract/details/' . $data->id) . '" class="edit">forward</a>
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

        $details = Contract::leftJoin('item_types', 'contracts.item_type_id', '=', 'item_types.id')
            ->leftJoin('dte_managments', 'contracts.sender_id', '=', 'dte_managments.id')
            ->leftJoin('items', 'contracts.item_id', '=', 'items.id')
            ->leftJoin('fin_years', 'contracts.fin_year_id', '=', 'fin_years.id')
            ->select('contracts.*', 'item_types.name as item_type_name', 'items.name as item_name', 'dte_managments.name as dte_managment_name','fin_years.year as fin_year_name')
            ->where('contracts.id', $id)
            ->where('contracts.status', 1)
            ->first();
        // Attached File
        $files = File::where('doc_type_id', 10)->where('reference_no', $details->reference_no)->get();
        // Attached File End
        $designations = Designation::all();
        $admin_id = Auth::user()->id;
        $section_ids = $section_ids = AdminSection::where('admin_id', $admin_id)->pluck('sec_id')->toArray();

        $document_tracks = DocumentTrack::where('doc_ref_id', $details->id)
            ->leftJoin('designations as sender_designation', 'document_tracks.sender_designation_id', '=', 'sender_designation.id')
            ->leftJoin('designations as receiver_designation', 'document_tracks.reciever_desig_id', '=', 'receiver_designation.id')
            ->where('track_status', 2)
            ->where('doc_type_id', 10)
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
            ->where('doc_type_id', 10)->latest()->first();

        //End blade forward on off section....

        // start cover letter start

        $cover_letter = CoverLetter::where('doc_reference_id', $details->reference_no)->first();

        // end cover letter start


        return view('backend.contract.contract_outgoing.outgoing_details', compact('details', 'designations', 'document_tracks', 'desig_id', 'desig_position',  'auth_designation_id', 'sender_designation_id', 'DocumentTrack_hidden', 'cover_letter', 'files'));
    }

    public function ContractTracking(Request $request)
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
        $doc_type_id = 10; // 10 for contract from doctype table column doc_serial
        $doc_ref_id = $request->doc_ref_id;
        $doc_reference_number = $request->doc_reference_number;
        $remarks = $request->remarks;
        $reciever_desig_id = $request->reciever_desig_id;
        $section_id = Contract::where('reference_no', $doc_reference_number)->pluck('section_id')->first();
        $sender_designation_id = AdminSection::where('admin_id', $admin_id)->pluck('desig_id')->first();

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
        $data->track_status = 2;
        $data->remarks = $remarks;

        $data->reciever_desig_id = $reciever_desig_id;
        $data->sender_designation_id = $sender_designation_id;
        $data->created_at = Carbon::now('Asia/Dhaka');
        $data->updated_at = Carbon::now('Asia/Dhaka');
        $data->save();

        // ----delay_cause and terms and conditions start here
        if ($desig_position->position == 3) {
            $contract_data = Contract::find($doc_ref_id);
            $contract_data->delay_cause = $request->delay_cause;
            $contract_data->delivery_date = $request->delivery_date;


            $contract_data->delivery_by = Auth::user()->id;
            $contract_data->save();
        }
        // ----delay_cause and terms and conditions end here

        if ($desig_position->position == 7) {

            $data = Contract::find($doc_ref_id);

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