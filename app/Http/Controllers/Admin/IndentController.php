<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Additional_document;
use App\Models\AdminSection;
use App\Models\Dte_managment;
use App\Models\FinancialYear;
use App\Models\Indent;
use App\Models\Item_type;
use App\Models\Items;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IndentController extends Controller
{
    //
    public function index()
    {

        return view('backend.indent.index');
    }

    // public function all_data(Request $request)
    // {

    //     if ($request->ajax()) {

    //         $insp_id = Auth::user()->inspectorate_id;
    //         $admin_id = Auth::user()->id;
    //         $section_ids = AdminSection::where('admin_id', $admin_id)->pluck('sec_id')->toArray();

    //         $designation_id = AdminSection::where('admin_id', $admin_id)->pluck('desig_id')->first();

    //         $desig_position = Designation::where('id', $designation_id)->first();




    //         if (Auth::user()->id == 92) {
    //             $query = PrelimGeneral::leftJoin('item_types', 'prelim_gen_specs.item_type_id', '=', 'item_types.id')
    //                 ->leftJoin('dte_managments', 'prelim_gen_specs.sender', '=', 'dte_managments.id')
    //                 ->leftJoin('sections', 'prelim_gen_specs.sec_id', '=', 'sections.id')
    //                 ->select('prelim_gen_specs.*', 'item_types.name as item_type_name', 'prelim_gen_specs.*', 'dte_managments.name as dte_managment_name', 'sections.name as section_name')
    //                 ->get();
    //         } elseif($desig_position->id==1){

    //             $query = PrelimGeneral::leftJoin('item_types', 'prelim_gen_specs.item_type_id', '=', 'item_types.id')
    //             ->leftJoin('dte_managments', 'prelim_gen_specs.sender', '=', 'dte_managments.id')
    //             ->leftJoin('sections', 'prelim_gen_specs.sec_id', '=', 'sections.id')
    //             ->select('prelim_gen_specs.*', 'item_types.name as item_type_name', 'prelim_gen_specs.*', 'dte_managments.name as dte_managment_name', 'sections.name as section_name')
    //             ->get();
    //         }
    //         else {

    //             $query = PrelimGeneral::leftJoin('item_types', 'prelim_gen_specs.item_type_id', '=', 'item_types.id')
    //                 ->leftJoin('dte_managments', 'prelim_gen_specs.sender', '=', 'dte_managments.id')
    //                 ->leftJoin('sections', 'prelim_gen_specs.sec_id', '=', 'sections.id')
    //                 ->select('prelim_gen_specs.*', 'item_types.name as item_type_name', 'prelim_gen_specs.*', 'dte_managments.name as dte_managment_name', 'sections.name as section_name')
    //                 ->where('prelim_gen_specs.insp_id', $insp_id)
    //                 ->whereIn('prelim_gen_specs.sec_id', $section_ids)
    //                 ->get();

    //             $designation_ids = AdminSection::where('admin_id', $admin_id)->select('desig_id')->first();

    //             $prelimGenId = [];
    //             if ($query) {
    //                 foreach ($query as $prelimGen) {
    //                     array_push($prelimGenId, $prelimGen->id);
    //                 }
    //             }

    //             $document_tracks_receiver_ids = DocumentTrack::whereIn('doc_ref_id', $prelimGenId)
    //                 ->where('reciever_desig_id', $designation_ids->desig_id)
    //                 ->first();

    //             if (!$document_tracks_receiver_ids) {
    //                 $query = PrelimGeneral::where('id', 'no data')->get();
    //             }
    //         }

    //         // $query->orderBy('id', 'asc');

    //         return DataTables::of($query)
    //             ->setTotalRecords($query->count())
    //             ->addIndexColumn()

    //             ->addColumn('status', function ($data) {
    //                 if ($data->status == '0') {
    //                     return '<button class="btn btn-success btn-sm">New</button>';
    //                 }
    //                 if ($data->status == '1') {
    //                     return '<button class="btn btn-danger  btn-sm">Under Vatted</button>';
    //                 }
    //                 if ($data->status == '2') {
    //                     return '<button class="btn btn-danger btn-sm">Delivered</button>';
    //                 }
    //             })
    //             ->addColumn('action', function ($data) {
    //                 if ($data->status == '2') {
    //                     $actionBtn = '<div class="btn-group" role="group">
    //                     <button href="" class="edit btn btn-success btn-lg" disable>Completed</button>';
    //                 } else {
    //                     $actionBtn = '<div class="btn-group" role="group">
    //                     <a href="' . url('admin/prelimgeneral/details/' . $data->id) . '" class="edit btn btn-secondary btn-lg">Forward</a>';
    //                 }


    //                 return $actionBtn;
    //             })
    //             ->rawColumns(['action', 'status'])
    //             ->make(true);
    //     }
    // }
    // public function details($id)
    // {


    //     $details = PrelimGeneral::leftJoin('item_types', 'prelim_gen_specs.item_type_id', '=', 'item_types.id')
    //         ->leftJoin('dte_managments', 'prelim_gen_specs.sender', '=', 'dte_managments.id')
    //         ->select('prelim_gen_specs.*', 'item_types.name as item_type_name', 'prelim_gen_specs.*', 'dte_managments.name as dte_managment_name')
    //         ->where('prelim_gen_specs.id', $id)
    //         ->first();

    //     $designations = Designation::all();

    //     $admin_id = Auth::user()->id;
    //     $section_ids = $section_ids = AdminSection::where('admin_id', $admin_id)->pluck('sec_id')->toArray();

    //     $document_tracks = DocumentTrack::where('doc_ref_id', $details->id)
    //         ->leftJoin('designations', 'document_tracks.sender_designation_id', '=', 'designations.id')
    //         ->where('track_status', 1)
    //         ->select('document_tracks.*', 'designations.name as designations_name')->get();

    //     $auth_designation_id = AdminSection::where('admin_id', $admin_id)->first();
    //     if ($auth_designation_id) {
    //         $desig_id = $auth_designation_id->desig_id;
    //     }



    //     return view('backend.specification.prelimgeneral.details', compact('details', 'designations', 'document_tracks', 'desig_id'));
    // }

    // public function prelimGenTracking(Request $request)
    // {
    //     // dd($request->id);
    //     $ins_id = Auth::user()->inspectorate_id;
    //     $admin_id = Auth::user()->id;
    //     $section_ids = AdminSection::where('admin_id', $admin_id)->pluck('sec_id')->toArray();
    //     $doc_type_id = $request->doc_type_id;
    //     $doc_ref_id = $request->doc_ref_id;
    //     $reciever_desig_id = $request->reciever_desig_id;
    //     $section_id = $section_ids[0];
    //     $sender_designation_id = AdminSection::where('admin_id', $admin_id)->pluck('desig_id')->first();

    //     $desig_position = Designation::where('id', $sender_designation_id)->first();
    //     // dd( $desig_position);
    //     $data = new DocumentTrack();
    //     $data->ins_id = $ins_id;
    //     $data->section_id = $section_id;
    //     $data->doc_type_id = $doc_type_id;
    //     $data->doc_ref_id = $doc_ref_id;
    //     $data->track_status = 1;
    //     $data->reciever_desig_id = $reciever_desig_id;
    //     $data->sender_designation_id = $sender_designation_id;
    //     $data->created_at = Carbon::now();
    //     $data->updated_at = Carbon::now();
    //     $data->save();


    //     if ($desig_position->position == 7) {

    //         $data = PrelimGeneral::find($doc_ref_id);

    //         if ($data) {

    //             $data->status = 1;
    //             $data->save();

    //             $value = new DocumentTrack();
    //             $value->ins_id = $ins_id;
    //             $value->section_id = $section_id;
    //             $value->doc_type_id = $doc_type_id;
    //             $value->doc_ref_id = $doc_ref_id;
    //             $value->track_status = 2;
    //             $value->reciever_desig_id = $reciever_desig_id;
    //             $value->sender_designation_id = $sender_designation_id;
    //             $value->created_at = Carbon::now();
    //             $value->updated_at = Carbon::now();
    //             $value->save();
    //         }
    //     }




    //     return response()->json(['success' => 'Done']);
    // }


    public function create()
    {
        $admin_id = Auth::user()->id;
        $section_ids = $section_ids = AdminSection::where('admin_id', $admin_id)->pluck('sec_id')->toArray();
        $sections = Section::whereIn('id', $section_ids)->get();

        $dte_managments = Dte_managment::where('status', 1)->get();
        $additional_documnets = Additional_document::where('status', 1)->get();
        $item_types = Item_type::where('status', 1)->get();
        $item=Items::all();
        $fin_years=FinancialYear::all();
        return view('backend.indent.create',compact('sections', 'item','dte_managments', 'additional_documnets','item_types','fin_years'));
    }
    public function item_name($id)
    {
        $items = Items::where('item_type_id', $id)->get();
        return response()->json($items);
    }
    // public function store(Request $request)
    // {
    //     // $this->validate($request, [
    //     //     'sender' => 'required',
    //     //     'admin_section' => 'required',
    //     //     'reference_no' => 'required',
    //     //     'spec_type' => 'required',
    //     //     'additional_documents' => 'required',
    //     //     'item_type_id' => 'required',
    //     //     'spec_received_date' => 'required',

    //     // ]);
    //     $insp_id = Auth::user()->inspectorate_id;
    //     $sec_id = $request->admin_section;

    //     $data = new PrelimGeneral();
    //     $data->insp_id = $insp_id;
    //     $data->sec_id = $sec_id;
    //     $data->sender = $request->sender;
    //     $data->reference_no = $request->reference_no;
    //     $data->spec_type = $request->spec_type;
    //     $data->additional_documents = $request->additional_documents;
    //     $data->item_id = $request->item_id;
    //     $data->item_type_id = $request->item_type_id;
    //     $data->spec_received_date = $request->spec_received_date;
    //     $data->received_by = Auth::user()->id;
    //     $data->remark = $request->remark;
    //     $data->status = 0;
    //     $data->created_at = Carbon::now()->format('Y-m-d');
    //     $data->updated_at = Carbon::now()->format('Y-m-d');;

    //     // $data->created_by = auth()->id();
    //     // $data->updated_by = auth()->id();

    //     $data->save();

    //     return response()->json(['success' => 'Done']);
    // }
}
