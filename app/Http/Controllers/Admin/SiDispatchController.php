<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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
use App\Models\Si;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use PDF;
use Yajra\DataTables\Facades\DataTables;

class SiDispatchController extends Controller
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
            $siNew = Si::where('status', 0)->count();
            $siOnProcess = '0';
            $siCompleted = '0';
            $siDispatch = DocumentTrack::where('doc_type_id', 11)
                ->leftJoin('stage_inspections', 'document_tracks.doc_ref_id', '=', 'stage_inspections.id')
                ->where('reciever_desig_id', $designation_id)
                ->where('track_status', 4)
                ->where('stage_inspections.status', 4)
                ->whereIn('document_tracks.section_id', $section_ids)
                ->count();
        } else {

            $siNew = DocumentTrack::where('doc_type_id', 11)
                ->leftJoin('stage_inspections', 'document_tracks.doc_ref_id', '=', 'stage_inspections.id')
                ->where('reciever_desig_id', $designation_id)
                ->where('track_status', 1)
                ->where('stage_inspections.status', 0)
                ->whereIn('document_tracks.section_id', $section_ids)
                ->count();

            $siOnProcess = DocumentTrack::where('doc_type_id', 11)
                ->leftJoin('stage_inspections', 'document_tracks.doc_ref_id', '=', 'stage_inspections.id')
                ->where('reciever_desig_id', $designation_id)
                ->where('track_status', 3)
                ->where('stage_inspections.status', 3)
                ->whereIn('document_tracks.section_id', $section_ids)
                ->count();

            $siCompleted = DocumentTrack::where('doc_type_id', 11)
                ->leftJoin('stage_inspections', 'document_tracks.doc_ref_id', '=', 'stage_inspections.id')
                ->where('reciever_desig_id', $designation_id)
                ->where('track_status', 2)
                ->where('stage_inspections.status', 1)
                ->whereIn('document_tracks.section_id', $section_ids)
                ->count();

            $siDispatch = DocumentTrack::where('doc_type_id', 11)
                ->leftJoin('stage_inspections', 'document_tracks.doc_ref_id', '=', 'stage_inspections.id')
                ->where('reciever_desig_id', $designation_id)
                ->where('track_status', 4)
                ->where('stage_inspections.status', 4)
                ->whereIn('document_tracks.section_id', $section_ids)
                ->count();
        }
        return view('backend.si.si_dispatch.si_dispatch_index', compact('siNew', 'siOnProcess', 'siCompleted', 'siDispatch'));
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
                $query = Si::leftJoin('item_types', 'stage_inspections.item_type_id', '=', 'item_types.id')
                    ->leftJoin('dte_managments', 'stage_inspections.sender_id', '=', 'dte_managments.id')
                    ->leftJoin('sections', 'stage_inspections.section_id', '=', 'sections.id')
                    ->where('stage_inspections.status', 4)
                    ->select('stage_inspections.*', 'item_types.name as item_type_name', 'stage_inspections.*', 'dte_managments.name as dte_managment_name', 'sections.name as section_name')
                    ->get();
            } else {

                $siIds = Si::leftJoin('document_tracks', 'stage_inspections.id', '=', 'document_tracks.doc_ref_id')
                    ->where('document_tracks.reciever_desig_id', $designation_id)
                    ->where('stage_inspections.inspectorate_id', $insp_id)
                    ->where('stage_inspections.status', 4)
                    ->whereIn('stage_inspections.section_id', $section_ids)->pluck('stage_inspections.id', 'stage_inspections.id')->toArray();

                $query = Si::leftJoin('item_types', 'stage_inspections.item_type_id', '=', 'item_types.id')
                    ->leftJoin('dte_managments', 'stage_inspections.sender_id', '=', 'dte_managments.id')
                    ->leftJoin('sections', 'stage_inspections.section_id', '=', 'sections.id')
                    ->select('stage_inspections.*', 'item_types.name as item_type_name', 'stage_inspections.*', 'dte_managments.name as dte_managment_name', 'sections.name as section_name')
                    ->whereIn('stage_inspections.id', $siIds)
                    ->where('stage_inspections.status', 4)
                    ->get();

                //......Start for DataTable Forward and Details btn change
                $siId = [];
                if ($query) {
                    foreach ($query as $si) {
                        array_push($siId, $si->id);
                    }
                }

                $document_tracks_receiver_id = DocumentTrack::whereIn('doc_ref_id', $siId)
                    ->where('reciever_desig_id', $designation_id)
                    ->where('track_status', 4)
                    ->first();

                if (!$document_tracks_receiver_id) {
                    $query = Si::where('id', 'no data')->get();
                }
                //......End for showing data for receiver designation
            }

            // $query->orderBy('id', 'asc');

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
                    $DocumentTrack = DocumentTrack::where('doc_ref_id', $data->id)->where('doc_type_id',  11)->latest()->first();
                    $designation_id = AdminSection::where('admin_id', Auth::user()->id)->pluck('desig_id')->first();
                    // start Forward Btn Change for index
                    if ($DocumentTrack) {
                        if ($designation_id  ==  $DocumentTrack->reciever_desig_id) {
                            $actionBtn = '<div class="btn-group" role="group">

                            <a href="' . url('admin/si_dispatch/details/' . $data->id) . '" class="edit">Forward</a>
                            </div>';
                        } else {
                            $actionBtn = '<div class="btn-group" role="group">

                        <a href="' . url('admin/si_dispatch/details/' . $data->id) . '" class="update">Forwarded</a>
                        </div>';
                        }

                        if ($designation_id  ==  $DocumentTrack->sender_designation_id) {
                            $actionBtn = '<div class="btn-group" role="group">

                        <a href="' . url('admin/si_dispatch/details/' . $data->id) . '" class="update">Forwarded</a>
                        </div>';
                        }
                    } else {
                        $actionBtn = '<div class="btn-group" role="group">

                        <a href="' . url('admin/si_dispatch/details/' . $data->id) . '" class="edit">Forward</a>
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

        $details = Si::leftJoin('items', 'stage_inspections.item_id', '=', 'items.id')
            ->leftJoin('dte_managments', 'stage_inspections.sender_id', '=', 'dte_managments.id')
            ->leftJoin('fin_years', 'stage_inspections.fin_year_id', '=', 'fin_years.id')
            ->leftJoin('suppliers', 'stage_inspections.supplier_id', '=', 'suppliers.id')
            ->select(
                'stage_inspections.*',
                'item_types.name as item_type_name',
                'dte_managments.name as dte_managment_name',
                'fin_years.year as fin_year_name'

            )
            ->where('stage_inspections.id', $id)
            ->first();
        // Attached File
        $files = File::where('doc_type_id', 11)->where('reference_no', $details->reference_no)->get();
        // Attached File End
        $designations = Designation::all();
        $admin_id = Auth::user()->id;
        $section_ids = $section_ids = AdminSection::where('admin_id', $admin_id)->pluck('sec_id')->toArray();

        $document_tracks = DocumentTrack::where('doc_ref_id', $details->id)
            ->leftJoin('designations as sender_designation', 'document_tracks.sender_designation_id', '=', 'sender_designation.id')
            ->leftJoin('designations as receiver_designation', 'document_tracks.reciever_desig_id', '=', 'receiver_designation.id')
            ->where('doc_type_id',  11)
            ->whereIn('track_status', [2, 4])
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
        $DocumentTrack_hidden = DocumentTrack::where('doc_ref_id',  $details->id)
            ->where('doc_type_id',  11)->latest()->first();

        //End blade forward on off section....


        return view('backend.si.si_dispatch.si_dispatch_details', compact('details', 'designations', 'document_tracks', 'desig_id',  'auth_designation_id', 'sender_designation_id', 'desig_position',  'DocumentTrack_hidden' , 'files'));
    }

    public function siDispatchTracking(Request $request)
    {
        $ins_id = Auth::user()->inspectorate_id;
        $admin_id = Auth::user()->id;
        $section_ids = AdminSection::where('admin_id', $admin_id)->pluck('sec_id')->toArray();
        $doc_type_id = 11; //...... 11for si from stage_inspections table doc_serial.
        $doc_ref_id = $request->doc_ref_id;
        $doc_reference_number = $request->doc_reference_number;
        $remarks = $request->remarks;
        $reciever_desig_id = $request->reciever_desig_id;
        $section_id = $section_ids[0];
        $sender_designation_id = AdminSection::where('admin_id', $admin_id)->pluck('desig_id')->first();

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
        $data->created_at = Carbon::now('Asia/Dhaka');
        $data->updated_at = Carbon::now('Asia/Dhaka');
        $data->save();


        if ($desig_position->position == 1) {

            $data = Si::find($doc_ref_id);

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
                $value->created_at = Carbon::now('Asia/Dhaka');
                $value->updated_at = Carbon::now('Asia/Dhaka');
                $value->save();
            }
        }

        return response()->json(['success' => 'Done']);
    }


    public function parameter(Request $request)
    {
        $si = Si::find($request->si_id);
        $item_id = $si->item_id;
        $item_type_id = $si->item_type_id;
        return view('backend.si.parameter', compact('item_id', 'item_type_id'));
    }
}
