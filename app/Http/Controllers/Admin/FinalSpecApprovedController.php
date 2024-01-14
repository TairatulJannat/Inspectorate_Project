<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Additional_document;
use App\Models\AdminSection;
use App\Models\Designation;
use App\Models\DocumentTrack;
use App\Models\Dte_managment;
use App\Models\FinalSpec;
use App\Models\FinancialYear;

use App\Models\Item_type;
use App\Models\Items;
use App\Models\Offer;
use App\Models\Section;
use App\Models\Supplier;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class FinalSpecApprovedController extends Controller
{
    //

    public function index()
    {

        return view('backend.finalSpec.finalSpec_incomming_approved.finalspec_approved_index');
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
                $query = FinalSpec::leftJoin('item_types', 'final_specs.item_type_id', '=', 'item_types.id')
                    ->leftJoin('dte_managments', 'final_specs.sender', '=', 'dte_managments.id')
                    ->leftJoin('sections', 'final_specs.sec_id', '=', 'sections.id')
                    ->where('final_specs.status', 3)
                    ->select('final_specs.*', 'item_types.name as item_type_name', 'final_specs.*', 'dte_managments.name as dte_managment_name', 'sections.name as section_name')
                    ->get();
            } elseif ($desig_position->id == 1) {

                $query = FinalSpec::leftJoin('item_types', 'final_specs.item_type_id', '=', 'item_types.id')
                    ->leftJoin('dte_managments', 'final_specs.sender', '=', 'dte_managments.id')
                    ->leftJoin('sections', 'final_specs.sec_id', '=', 'sections.id')
                    ->select('final_specs.*', 'item_types.name as item_type_name', 'final_specs.*', 'dte_managments.name as dte_managment_name', 'sections.name as section_name')
                    ->where('final_specs.status', 3)
                    ->get();
            } else {

                $FinalspecIds = FinalSpec::leftJoin('document_tracks', 'final_specs.id', '=', 'document_tracks.doc_ref_id')
                    ->where('document_tracks.reciever_desig_id', $designation_id)
                    ->where('final_specs.insp_id', $insp_id)
                    ->where('final_specs.status', 3)
                    ->whereIn('final_specs.sec_id', $section_ids)->pluck('final_specs.id', 'final_specs.id')->toArray();

                $query = FinalSpec::leftJoin('item_types', 'final_specs.item_type_id', '=', 'item_types.id')
                    ->leftJoin('dte_managments', 'final_specs.sender', '=', 'dte_managments.id')
                    ->leftJoin('sections', 'final_specs.sec_id', '=', 'sections.id')
                    ->select('final_specs.*', 'item_types.name as item_type_name', 'final_specs.*', 'dte_managments.name as dte_managment_name', 'sections.name as section_name')
                    ->whereIn('final_specs.id', $FinalspecIds)
                    ->where('final_specs.status', 3)
                    ->get();

                //......Start for DataTable Forward and Details btn change
                $FinalSpecId = [];
                if ($query) {
                    foreach ($query as $FinalSpec) {
                        array_push($FinalSpecId, $FinalSpec->id);
                    }
                }

                $document_tracks_receiver_id = DocumentTrack::whereIn('doc_ref_id', $FinalSpecId)
                    ->where('reciever_desig_id', $designation_id)
                    ->where('track_status', '3')
                    ->first();

                if (!$document_tracks_receiver_id) {
                    $query = FinalSpec::where('id', 'no data')->get();
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

                    $DocumentTrack = DocumentTrack::where('doc_ref_id', $data->id)->where('doc_ref_id',6)->latest()->first();
                    $designation_id = AdminSection::where('admin_id', Auth::user()->id)->pluck('desig_id')->first();
                    // dd($DocumentTrack);
                    if ($DocumentTrack) {
                        if ($designation_id  ==  $DocumentTrack->reciever_desig_id) {
                            $actionBtn = '<div class="btn-group" role="group">

                            <a href="' . url('admin/FinalSpec_approved/details/' . $data->id) . '" class="edit">Forward</a>
                            </div>';
                        } else {
                            $actionBtn = '<div class="btn-group" role="group">

                            <a href="' . url('admin/FinalSpec_approved/details/' . $data->id) . '" class="update">Forwarded</a>
                            </div>';
                        }

                        if ($designation_id  ==  $DocumentTrack->sender_designation_id) {
                            $actionBtn = '<div class="btn-group" role="group">

                            <a href="' . url('admin/FinalSpec_approved/details/' . $data->id) . '" class="update">Forwarded</a>
                            </div>';
                        }
                    } else {
                        $actionBtn = '<div class="btn-group" role="group">

                        <a href="' . url('admin/FinalSpec_approved/details/' . $data->id) . '" class="edit">Forward</a>
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

        $details = FinalSpec::leftJoin('item_types', 'final_specs.item_type_id', '=', 'item_types.id')
            ->leftJoin('dte_managments', 'final_specs.sender', '=', 'dte_managments.id')
            ->leftJoin('fin_years', 'final_specs.fin_year_id', '=', 'fin_years.id')
            ->leftJoin('suppliers', 'final_specs.supplier_id', '=', 'suppliers.id')
            ->select(
                'final_specs.*',
                'item_types.name as item_type_name',
                'final_specs.*',
                'dte_managments.name as dte_managment_name',
                'fin_years.year as fin_year_name',
                'suppliers.firm_name as suppliers_name'
            )
            ->where('final_specs.id', $id)
            ->first();

        // $details->additional_documents = json_decode($details->additional_documents, true);
        // $additional_documents_names = [];

        // foreach ($details->additional_documents as $document_id) {
        //     $additional_names = Additional_document::where('id', $document_id)->pluck('name')->first();

        //     array_push($additional_documents_names, $additional_names);
        // }

        // $details->suppliers = json_decode($details->supplier_id, true);

        // $supplier_names_names = [];

        // foreach ($details->suppliers as $Supplier_id) {
        //     $supplier_names = Supplier::where('id', $Supplier_id)->pluck('firm_name')->first();

        //     array_push($supplier_names_names, $supplier_names);
        // }

        $designations = Designation::all();
        $admin_id = Auth::user()->id;
        $section_ids = $section_ids = AdminSection::where('admin_id', $admin_id)->pluck('sec_id')->toArray();

        $document_tracks = DocumentTrack::where('doc_ref_id', $details->id)
            ->leftJoin('designations as sender_designation', 'document_tracks.sender_designation_id', '=', 'sender_designation.id')
            ->leftJoin('designations as receiver_designation', 'document_tracks.reciever_desig_id', '=', 'receiver_designation.id')
            ->whereIn('track_status', [1, 3])
            ->where('doc_type_id',6)
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
        $DocumentTrack_hidden = DocumentTrack::where('doc_ref_id',  $details->id) ->where('doc_type_id',6)->latest()->first();

        //End blade forward on off section....



        return view('backend.finalSpec.finalSpec_incomming_approved.finalspec_approved_details', compact('details', 'designations', 'document_tracks', 'desig_id',  'auth_designation_id', 'sender_designation_id', 'DocumentTrack_hidden'));
    }

    public function FinalSpecApprovedTracking(Request $request)
    {

        $ins_id = Auth::user()->inspectorate_id;
        $admin_id = Auth::user()->id;
        $section_ids = AdminSection::where('admin_id', $admin_id)->pluck('sec_id')->toArray();
        $doc_type_id = 6; //...... 6 for Final Spec from finalspecs table doc_serial.
        $doc_ref_id = $request->doc_ref_id;
        $remarks = $request->remarks;
        $doc_reference_number = $request->doc_reference_number;
        $reciever_desig_id = $request->reciever_desig_id;
        $section_id = FinalSpec::where('reference_no', $doc_reference_number)->pluck('sec_id')->first();
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
        $data->created_at =  Carbon::now('Asia/Dhaka');
        $data->updated_at =  Carbon::now('Asia/Dhaka');
        $data->save();


        if ($desig_position->position == 5) {

            $data = FinalSpec::find($doc_ref_id);

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
                $value->updated_at =  Carbon::now('Asia/Dhaka');
                $value->save();
            }
        }

        return response()->json(['success' => 'Done']);
    }

    
}