<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Additional_document;
use App\Models\AdminSection;
use App\Models\Designation;
use App\Models\DocumentTrack;
use App\Models\DraftContract;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;

class DraftContractApprovedController extends Controller
{
    public function index()
    {
        $insp_id = Auth::user()->inspectorate_id;
        $admin_id = Auth::user()->id;
        $section_ids = AdminSection::where('admin_id', $admin_id)->pluck('sec_id')->toArray();
        $designation_id = AdminSection::where('admin_id', $admin_id)->pluck('desig_id')->first();
        $desig_position = Designation::where('id', $designation_id)->first();

        if ($designation_id == 1 || $designation_id == 0) {
            $draft_contractNew = DraftContract::where('status', 0)->count();
            $draft_contractOnProcess = '0';
            $draft_contractCompleted = '0';
            $draft_contractDispatch = DocumentTrack::where('doc_type_id', 9)
                ->leftJoin('draft_contracts', 'document_tracks.doc_ref_id', '=', 'draft_contracts.id')
                ->where('reciever_desig_id', $designation_id)
                ->where('track_status', 4)
                ->where('draft_contracts.status', 4)
                ->whereIn('document_tracks.section_id', $section_ids)
                ->count();
        } else {

            $draft_contractNew = DocumentTrack::where('doc_type_id', 9)
                ->leftJoin('draft_contracts', 'document_tracks.doc_ref_id', '=', 'draft_contracts.id')
                ->where('reciever_desig_id', $designation_id)
                ->where('track_status', 1)
                ->where('draft_contracts.status', 0)
                ->whereIn('document_tracks.section_id', $section_ids)
                ->count();

            $draft_contractOnProcess = DocumentTrack::where('doc_type_id', 9)
                ->leftJoin('draft_contracts', 'document_tracks.doc_ref_id', '=', 'draft_contracts.id')
                ->where('reciever_desig_id', $designation_id)
                ->where('track_status', 3)
                ->where('draft_contracts.status', 3)
                ->whereIn('document_tracks.section_id', $section_ids)
                ->count();

            $draft_contractCompleted = DocumentTrack::where('doc_type_id', 9)
                ->leftJoin('draft_contracts', 'document_tracks.doc_ref_id', '=', 'draft_contracts.id')
                ->where('reciever_desig_id', $designation_id)
                ->where('track_status', 2)
                ->where('draft_contracts.status', 1)
                ->whereIn('document_tracks.section_id', $section_ids)
                ->count();

            $draft_contractDispatch = DocumentTrack::where('doc_type_id', 9)
                ->leftJoin('draft_contracts', 'document_tracks.doc_ref_id', '=', 'draft_contracts.id')
                ->where('reciever_desig_id', $designation_id)
                ->where('track_status', 4)
                ->where('draft_contracts.status', 4)
                ->whereIn('document_tracks.section_id', $section_ids)
                ->count();
        }
        return view('backend.draft_contract.draft_contract_approved.draft_contract_approved_index', compact('draft_contractNew', 'draft_contractOnProcess', 'draft_contractCompleted', 'draft_contractDispatch'));
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
                $query = DraftContract::leftJoin('item_types', 'draft_contracts.item_type_id', '=', 'item_types.id')
                    ->leftJoin('dte_managments', 'draft_contracts.sender_id', '=', 'dte_managments.id')
                    ->leftJoin('sections', 'draft_contracts.section_id', '=', 'sections.id')
                    ->where('draft_contracts.status', 3)
                    ->select('draft_contracts.*', 'item_types.name as item_type_name', 'dte_managments.name as dte_managment_name', 'sections.name as section_name')
                    ->get();
            } elseif ($desig_position->id == 1) {

                $query = DraftContract::leftJoin('item_types', 'draft_contracts.item_type_id', '=', 'item_types.id')
                    ->leftJoin('dte_managments', 'draft_contracts.sender_id', '=', 'dte_managments.id')
                    ->leftJoin('sections', 'draft_contracts.section_id', '=', 'sections.id')
                    ->select('draft_contracts.*', 'item_types.name as item_type_name','dte_managments.name as dte_managment_name', 'sections.name as section_name')
                    ->where('draft_contracts.status', 3)
                    ->get();
            } else {

                $draft_contractIds = DraftContract::leftJoin('document_tracks', 'draft_contracts.id', '=', 'document_tracks.doc_ref_id')
                    ->where('document_tracks.reciever_desig_id', $designation_id)
                    ->where('draft_contracts.inspectorate_id', $insp_id)
                    ->where('draft_contracts.status', 3)
                    ->whereIn('draft_contracts.section_id', $section_ids)->pluck('draft_contracts.id', 'draft_contracts.id')->toArray();

                $query = DraftContract::leftJoin('item_types', 'draft_contracts.item_type_id', '=', 'item_types.id')
                    ->leftJoin('dte_managments', 'draft_contracts.section_id', '=', 'dte_managments.id')
                    ->leftJoin('sections', 'draft_contracts.section_id', '=', 'sections.id')
                    ->select('draft_contracts.*', 'item_types.name as item_type_name',  'dte_managments.name as dte_managment_name', 'sections.name as section_name')
                    ->whereIn('draft_contracts.id', $draft_contractIds)
                    ->where('draft_contracts.status', 3)
                    ->get();

                //......Start for DataTable Forward and Details btn change
                $draft_contractId = [];
                if ($query) {
                    foreach ($query as $draft_contract) {
                        array_push($draft_contractId, $draft_contract->id);
                    }
                }

                $document_tracks_receiver_id = DocumentTrack::whereIn('doc_ref_id', $draft_contractId)
                    ->where('reciever_desig_id', $designation_id)
                    ->where('track_status', '3')
                    ->first();

                if (!$document_tracks_receiver_id) {
                    $query = DraftContract::where('id', 'no data')->get();
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
                    $DocumentTrack = DocumentTrack::where('doc_ref_id', $data->id)->where('doc_type_id', 9)->latest()->first();
                    $designation_id = AdminSection::where('admin_id', Auth::user()->id)->pluck('desig_id')->first();
                    // start Forward Btn Change for index

                    if ($DocumentTrack) {
                        if ($designation_id  ==  $DocumentTrack->reciever_desig_id) {
                            $actionBtn = '<div class="btn-group" role="group">
                            <a href="' . url('admin/draft_contract_approved/details/' . $data->id) . '" class="edit">Forward</a>
                            </div>';
                        } else {
                            $actionBtn = '<div class="btn-group" role="group">

                            <a href="' . url('admin/draft_contract_approved/details/' . $data->id) . '" class="update">Forwarded</a>
                            </div>';
                        }

                        if ($designation_id  ==  $DocumentTrack->sender_designation_id) {
                            $actionBtn = '<div class="btn-group" role="group">

                            <a href="' . url('admin/draft_contract_approved/details/' . $data->id) . '" class="update">Forwarded</a>
                            </div>';
                        }
                    } else {
                        $actionBtn = '<div class="btn-group" role="group">

                        <a href="' . url('admin/draft_contract_approved/details/' . $data->id) . '" class="edit">Forward</a>
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

        $details = DraftContract::leftJoin('item_types', 'draft_contracts.item_type_id', '=', 'item_types.id')
            ->leftJoin('dte_managments', 'draft_contracts.sender_id', '=', 'dte_managments.id')
            ->leftJoin('fin_years', 'draft_contracts.fin_year_id', '=', 'fin_years.id')
            ->select(
                'draft_contracts.*',
                'item_types.name as item_type_name',
                'dte_managments.name as dte_managment_name',
                'fin_years.year as fin_year_name'
            )
            ->where('draft_contracts.id', $id)
            ->first();





        $designations = Designation::all();
        $admin_id = Auth::user()->id;
        $section_ids = $section_ids = AdminSection::where('admin_id', $admin_id)->pluck('sec_id')->toArray();

        $document_tracks = DocumentTrack::where('doc_ref_id', $details->id)
            ->leftJoin('designations as sender_designation', 'document_tracks.sender_designation_id', '=', 'sender_designation.id')
            ->leftJoin('designations as receiver_designation', 'document_tracks.reciever_desig_id', '=', 'receiver_designation.id')
            ->where('doc_type_id', 9)
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
        ->where('doc_type_id', 9)->latest()->first();

        //End blade forward on off section....


        return view('backend.draft_contract.draft_contract_approved.draft_contract_approved_details', compact('details', 'designations', 'document_tracks', 'desig_id', 'auth_designation_id', 'sender_designation_id',  'DocumentTrack_hidden'));
    }

    public function ApprovedTracking(Request $request)
    {

        $ins_id = Auth::user()->inspectorate_id;
        $admin_id = Auth::user()->id;
        // $section_ids = AdminSection::where('admin_id', $admin_id)->pluck('sec_id')->toArray();
        $doc_type_id = 9; //...... 9 for draft_contract from draft_contract table doc_serial.
        $doc_ref_id = $request->doc_ref_id;
        $remarks = $request->remarks;
        $doc_reference_number = $request->doc_reference_number;
        $reciever_desig_id = $request->reciever_desig_id;
        $section_id = DraftContract::where('reference_no', $doc_reference_number)->pluck('section_id')->first();
        $sender_designation_id = AdminSection::where('admin_id', $admin_id)->pluck('desig_id')->first();

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

            $data = DraftContract::find($doc_ref_id);

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
