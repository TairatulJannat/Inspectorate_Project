<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Additional_document;
use App\Models\AdminSection;
use App\Models\Designation;
use App\Models\DocumentTrack;
use App\Models\Dte_managment;
use App\Models\File;
use App\Models\FinalSpec;
use App\Models\FinancialYear;
use App\Models\Item_type;
use App\Models\Items;
use App\Models\Offer;
use App\Models\Section;
use App\Models\Supplier;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class FinalSpecDispatchController extends Controller
{
    //

    public function index()
    {

        $insp_id = Auth::user()->inspectorate_id;
        $admin_id = Auth::user()->id;
        $section_ids = AdminSection::where('admin_id', $admin_id)->pluck('sec_id')->toArray();
        $designation_id = AdminSection::where('admin_id', $admin_id)->pluck('desig_id')->first();
        $desig_position = Designation::where('id', $designation_id)->first();

        if ($designation_id == 1 || $designation_id == 0) {
            $finalSpecNew = FinalSpec::where('status', 0)->count();
            $finalSpecOnProcess = '0';
            $finalSpecCompleted = '0';
            $finalSpecDispatch = DocumentTrack::where('doc_type_id', 6)
                ->leftJoin('final_specs', 'document_tracks.doc_ref_id', '=', 'final_specs.id')
                ->where('reciever_desig_id', $designation_id)
                ->where('track_status', 4)
                ->where('final_specs.status', 4)
                ->whereIn('document_tracks.section_id', $section_ids)
                ->count();
        } else {

            $finalSpecNew = DocumentTrack::where('doc_type_id', 6)
                ->leftJoin('final_specs', 'document_tracks.doc_ref_id', '=', 'final_specs.id')
                ->where('reciever_desig_id', $designation_id)
                ->where('track_status', 1)
                ->where('final_specs.status', 0)
                ->whereIn('document_tracks.section_id', $section_ids)
                ->count();

            $finalSpecOnProcess = DocumentTrack::where('doc_type_id', 6)
                ->leftJoin('final_specs', 'document_tracks.doc_ref_id', '=', 'final_specs.id')
                ->where('reciever_desig_id', $designation_id)
                ->where('track_status', 3)
                ->where('final_specs.status', 3)
                ->whereIn('document_tracks.section_id', $section_ids)
                ->count();

            $finalSpecCompleted = DocumentTrack::where('doc_type_id', 6)
                ->leftJoin('final_specs', 'document_tracks.doc_ref_id', '=', 'final_specs.id')
                ->where('reciever_desig_id', $designation_id)
                ->where('track_status', 2)
                ->where('final_specs.status', 1)
                ->whereIn('document_tracks.section_id', $section_ids)
                ->count();

            $finalSpecDispatch = DocumentTrack::where('doc_type_id', 6)
                ->leftJoin('final_specs', 'document_tracks.doc_ref_id', '=', 'final_specs.id')
                ->where('reciever_desig_id', $designation_id)
                ->where('track_status', 4)
                ->where('final_specs.status', 4)
                ->whereIn('document_tracks.section_id', $section_ids)
                ->count();
        }


        return view('backend.finalSpec.finalSpec_dispatch.finalSpec_dispatch_index', compact('finalSpecNew', 'finalSpecOnProcess', 'finalSpecCompleted', 'finalSpecDispatch'));
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
                    ->where('final_specs.status', 4)
                    ->select('final_specs.*', 'item_types.name as item_type_name', 'final_specs.*', 'dte_managments.name as dte_managment_name', 'sections.name as section_name')
                    ->get();
            } else {

                $FinalspecIds = FinalSpec::leftJoin('document_tracks', 'final_specs.id', '=', 'document_tracks.doc_ref_id')
                    ->where('document_tracks.reciever_desig_id', $designation_id)
                    ->where('final_specs.insp_id', $insp_id)
                    ->where('final_specs.status', 4)
                    ->whereIn('final_specs.sec_id', $section_ids)->pluck('final_specs.id', 'final_specs.id')->toArray();

                $query = FinalSpec::leftJoin('item_types', 'final_specs.item_type_id', '=', 'item_types.id')
                    ->leftJoin('dte_managments', 'final_specs.sender', '=', 'dte_managments.id')
                    ->leftJoin('sections', 'final_specs.sec_id', '=', 'sections.id')
                    ->select('final_specs.*', 'item_types.name as item_type_name', 'final_specs.*', 'dte_managments.name as dte_managment_name', 'sections.name as section_name')
                    ->whereIn('final_specs.id', $FinalspecIds)
                    ->where('final_specs.status', 4)
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
                    ->where('track_status', 4)
                    ->first();

                if (!$document_tracks_receiver_id) {
                    $query = FinalSpec::where('id', 'no data')->get();
                }
                //......End for showing data for receiver designation
            }

            $query=$query->sortByDesc('id');

            return DataTables::of($query)
                ->setTotalRecords($query->count())
                ->addIndexColumn()

                ->addColumn('status', function ($data) {
                    if ($data->status == '4') {
                        return '<button class="btn btn-danger btn-sm">Dispatched</button>';
                    } else {
                        return '<button class="btn btn-danger btn-sm">None</button>';
                    }
                })
                ->addColumn('action', function ($data) {

                    // start Forward Btn Change for index
                    $DocumentTrack = DocumentTrack::where('doc_ref_id', $data->id)->where('doc_type_id', 6)->latest()->first();
                    $designation_id = AdminSection::where('admin_id', Auth::user()->id)->pluck('desig_id')->first();
                    // start Forward Btn Change for index
                    if ($DocumentTrack) {
                        if ($designation_id  ==  $DocumentTrack->reciever_desig_id) {
                            $actionBtn = '<div class="btn-group" role="group">

                            <a href="' . url('admin/FinalSpec_dispatch/details/' . $data->id) . '" class="edit btn btn-secondary btn-sm">Forward</a>
                            </div>';
                        } else {
                            $actionBtn = '<div class="btn-group" role="group">

                        <a href="' . url('admin/FinalSpec_dispatch/details/' . $data->id) . '" class="edit btn btn-success btn-sm">Forwarded</a>
                        </div>';
                        }

                        if ($designation_id  ==  $DocumentTrack->sender_designation_id) {
                            $actionBtn = '<div class="btn-group" role="group">

                        <a href="' . url('admin/FinalSpec_dispatch/details/' . $data->id) . '" class="edit btn btn-success btn-sm">Forwarded</a>
                        </div>';
                        }
                    } else {
                        $actionBtn = '<div class="btn-group" role="group">

                        <a href="' . url('admin/FinalSpec_dispatch/details/' . $data->id) . '" class="edit btn btn-secondary btn-sm">Forward</a>
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
        // Attached File
        $files = File::where('doc_type_id', 6)->where('reference_no', $details->reference_no)->get();
        // Attached File End


        $designations = Designation::all();
        $admin_id = Auth::user()->id;
        $section_ids = $section_ids = AdminSection::where('admin_id', $admin_id)->pluck('sec_id')->toArray();

        $document_tracks = DocumentTrack::where('doc_ref_id', $details->id)
            ->leftJoin('designations as sender_designation', 'document_tracks.sender_designation_id', '=', 'sender_designation.id')
            ->leftJoin('designations as receiver_designation', 'document_tracks.reciever_desig_id', '=', 'receiver_designation.id')
            ->whereIn('track_status', [2, 4])
            ->where('doc_type_id', 6)
            ->whereNot(function ($query) {
                $query->where('sender_designation.id', 7)
                    ->where('receiver_designation.id', 3)
                    ->where('document_tracks.track_status', 2);
            })
            ->skip(1) // Skip the first row
            ->take(PHP_INT_MAX)
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
        $DocumentTrack_hidden = DocumentTrack::where('doc_ref_id',  $details->id)->where('doc_type_id', 6)->latest()->first();

        //End blade forward on off section....

        return view('backend.finalSpec.finalSpec_dispatch.finalSpec_dispatch_details', compact('details', 'designations', 'document_tracks', 'desig_id', 'auth_designation_id', 'sender_designation_id', 'desig_position', 'DocumentTrack_hidden', 'files'));
    }

    public function FinalSpecDispatchTracking(Request $request)
    {
        // dd($request->all());

        $validator = Validator::make($request->all(), [
            'doc_ref_id' => 'required',
            'doc_reference_number' => 'required',
            // 'reciever_desig_id' => 'required',
        ], [
            'reciever_desig_id.required' => 'The receiver designation field is required.'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }


        $ins_id = Auth::user()->inspectorate_id;
        $admin_id = Auth::user()->id;
        $section_ids = AdminSection::where('admin_id', $admin_id)->pluck('sec_id')->toArray();
        $doc_type_id = 6; //...... 6 for Final Spec from final_specs table doc_serial.
        $doc_ref_id = $request->doc_ref_id;
        $doc_reference_number =htmlspecialchars_decode($request->doc_reference_number);
        $remarks = $request->remarks;
        $forward_date = $request->final_spec_fwd_date;
        $reciever_desig_id = $request->reciever_desig_id;
        $section_id = FinalSpec::where('reference_no', $doc_reference_number)->pluck('sec_id')->first();
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
        $data->track_status = 4;
        $data->reciever_desig_id = $reciever_desig_id;
        $data->sender_designation_id = $sender_designation_id;
        $data->remarks = $remarks;
        $data->final_spec_fwd_date = $forward_date;
        $data->created_at =  Carbon::now('Asia/Dhaka');
        $data->updated_at =  Carbon::now('Asia/Dhaka');
        $data->save();


        if ($desig_position->position == 1) {

            $data = FinalSpec::find($doc_ref_id);

            if ($data) {

                $data->status = 2;
                $data->save();

                $value = new DocumentTrack();
                $value->ins_id = $ins_id;
                $value->section_id = $section_id;
                $value->doc_type_id = $doc_type_id;
                $value->doc_ref_id = $doc_ref_id;
                // $value->doc_reference_number = $doc_reference_number;
                $value->track_status = 4;
                $value->reciever_desig_id = $reciever_desig_id;
                $value->sender_designation_id = $sender_designation_id;
                $value->remarks = $remarks;
                $value->final_spec_fwd_date = $forward_date;
                $value->created_at =  Carbon::now('Asia/Dhaka');
                $value->updated_at =  Carbon::now('Asia/Dhaka');
                $value->save();
            }
        }

        return response()->json(['success' => 'Done']);
    }
}