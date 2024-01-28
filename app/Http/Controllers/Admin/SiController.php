<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Additional_document;
use App\Models\AdminSection;
use App\Models\Contract;
use App\Models\Designation;
use App\Models\DocumentTrack;
use App\Models\DraftContract;
use App\Models\Dte_managment;
use App\Models\FinancialYear;
use App\Models\Indent;
use App\Models\Item_type;
use App\Models\Items;
use App\Models\Offer;
use App\Models\Section;
use App\Models\Si;
use App\Models\Supplier;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use PDF;
use Yajra\DataTables\Facades\DataTables;

class SiController extends Controller
{
    //
    protected $fileController;
    public function __construct(FileController $fileController)
    {
        $this->fileController = $fileController;
    }
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


        return view('backend.si.si_incomming_new.index', compact('siNew', 'siOnProcess', 'siCompleted', 'siDispatch'));
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
                    ->where('stage_inspections.status', 0)
                    ->select('stage_inspections.*', 'item_types.name as item_type_name', 'dte_managments.name as dte_managment_name', 'sections.name as section_name')
                    ->get();
            } elseif ($desig_position->id == 1) {

                $query = Si::leftJoin('item_types', 'stage_inspections.item_type_id', '=', 'item_types.id')
                    ->leftJoin('dte_managments', 'stage_inspections.sender_id', '=', 'dte_managments.id')
                    ->leftJoin('sections', 'stage_inspections.section_id', '=', 'sections.id')
                    ->where('stage_inspections.inspectorate_id', $insp_id)
                    ->where('stage_inspections.status', 0)
                    ->whereIn('stage_inspections.section_id', $section_ids)
                    ->select('stage_inspections.*', 'item_types.name as item_type_name', 'dte_managments.name as dte_managment_name', 'sections.name as section_name')
                    ->get();
            } else {

                // si ids from document tracks table
                $siIds = Si::leftJoin('document_tracks', 'stage_inspections.id', '=', 'document_tracks.doc_ref_id')
                    ->where('document_tracks.reciever_desig_id', $designation_id)
                    ->where('stage_inspections.inspectorate_id', $insp_id)
                    ->where('stage_inspections.status', 0)
                    ->whereIn('stage_inspections.section_id', $section_ids)->pluck('stage_inspections.id')->toArray();

                $query = Si::leftJoin('item_types', 'stage_inspections.item_type_id', '=', 'item_types.id')
                    ->leftJoin('dte_managments', 'stage_inspections.sender_id', '=', 'dte_managments.id')
                    ->leftJoin('sections', 'stage_inspections.section_id', '=', 'sections.id')
                    ->select('stage_inspections.*', 'item_types.name as item_type_name',  'dte_managments.name as dte_managment_name', 'sections.name as section_name')
                    ->whereIn('stage_inspections.id', $siIds)
                    ->where('stage_inspections.status', 0)
                    ->get();

                $siId = [];
                if ($query) {
                    foreach ($query as $indent) {
                        array_push($siId, $indent->id);
                    }
                }

                $document_tracks_receiver_id = DocumentTrack::whereIn('doc_ref_id', $siId)
                    ->where('reciever_desig_id', $designation_id)
                    ->first();


                //......start for showing data for receiver designation
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

                    if ($data->status == '0') {
                        return '<button class="btn btn-success btn-sm">New</button>';
                    } else {
                        return '<button class="btn btn-success btn-sm">None</button>';
                    }
                })

                ->addColumn('action', function ($data) {
                    $DocumentTrack = DocumentTrack::where('doc_ref_id', $data->id)->where('doc_ref_id',11)->latest()->first();
                    $DesignationId = AdminSection::where('admin_id', Auth::user()->id)->pluck('desig_id')->first();
                    // dd($DocumentTrack);
                    if ($DocumentTrack) {
                        if ($DesignationId  ==  $DocumentTrack->reciever_desig_id) {
                            $actionBtn = '<div class="btn-group" role="group">';

                            if ($DesignationId == 3) {
                                $actionBtn .= '<a href="' . url('admin/si/edit/' . $data->id) . '" class="edit2 ">Update</a>';
                            }
                            $actionBtn .= '<a href="' . url('admin/si/details/' . $data->id) . '" class="edit ">Forward</a>
                            </div>';
                        } else {
                            $actionBtn = '<div class="btn-group" role="group">';
                            if ($DesignationId == 3) {
                                $actionBtn .= '<a href="' . url('admin/si/edit/' . $data->id) . '" class="edit2 ">Update</a>';
                            }
                            $actionBtn .= '<a href="' . url('admin/si/details/' . $data->id) . '" class="update">Forwarded</a>
                            </div>';
                        }

                        if ($DesignationId  ==  $DocumentTrack->sender_designation_id) {
                            $actionBtn = '<div class="btn-group" role="group">';
                            if ($DesignationId == 3) {
                                $actionBtn .= '<a href="' . url('admin/si/edit/' . $data->id) . '" class="edit2 ">Update</a>';
                            }
                            $actionBtn .= '<a href="' . url('admin/si/details/' . $data->id) . '" class="update">Forwarded</a>
                            </div>';
                        }
                    } else {
                        $actionBtn = '<div class="btn-group" role="group">';
                        if ($DesignationId == 3) {
                            $actionBtn .= '<a href="' . url('admin/si/edit/' . $data->id) . '" class="edit2 ">Update</a>';
                        }
                        $actionBtn .= '<a href="' . url('admin/si/details/' . $data->id) . '" class="edit ">Forward</a>
                        </div>';
                    }

                    return $actionBtn;
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        }
    }

    public function create()
    {
        $admin_id = Auth::user()->id;
        $inspectorate_id = Auth::user()->inspectorate_id;
        $section_ids = $section_ids = AdminSection::where('admin_id', $admin_id)->pluck('sec_id')->toArray();
        $sections = Section::whereIn('id', $section_ids)->get();

        $dte_managments = Dte_managment::where('status', 1)->get();
        $item_types = Item_type::where('status', 1)->where('inspectorate_id', $inspectorate_id)->get();
        $item = Items::all();
        $fin_years = FinancialYear::all();
        return view('backend.si.si_incomming_new.create', compact('sections', 'item', 'dte_managments', 'item_types', 'fin_years'));
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'sender' => 'required',
            'admin_section' => 'required',
            'reference_no' => 'required',
            'received_date' => 'required',
            'reference_date' => 'required',
        ]);

        try {
            $insp_id = Auth::user()->inspectorate_id;

            $data = new si();
            $data->inspectorate_id = $insp_id;
            $data->section_id = $request->admin_section;
            $data->sender_id = $request->sender;
            $data->reference_no = $request->reference_no;
            $data->item_id = $request->item_id;
            $data->item_type_id = $request->item_type_id;
            $data->received_date = $request->received_date;
            $data->supplier_id = $request->supplier_id;
            $data->reference_date = $request->reference_date;
            $data->fin_year_id = $request->fin_year_id;
            $data->created_by = Auth::user()->id;
            $data->updated_by = Auth::user()->id;
            $data->remarks = $request->remark;
            $data->status = 0;
            $data->created_at = Carbon::now()->format('Y-m-d');
            $data->updated_at = Carbon::now()->format('Y-m-d');



            $data->save();

            return response()->json(['success' => 'si entry created successfully']);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }
    public function edit($id)
    {
        $si = Si::find($id);
        $admin_id = Auth::user()->id;
        $inspectorate_id = Auth::user()->inspectorate_id;
        $section_ids = $section_ids = AdminSection::where('admin_id', $admin_id)->pluck('sec_id')->toArray();
        // $sections = Section::whereIn('id', $section_ids)->get();
        $item_types = Item_type::where('status', 1)->where('inspectorate_id', $inspectorate_id)->get();
        $item = Items::where('id', $si->item_id)->first();

        $dte_managments = Dte_managment::where('status', 1)->get();


        // $selected_document =$indent->additional_documents;
        $item_types = Item_type::where('status', 1)
            ->where('inspectorate_id', $inspectorate_id)
            ->whereIn('section_id', $section_ids)
            ->get();
        $item = Items::where('id', $si->item_id)->first();
        $fin_years = FinancialYear::all();
        $contracts = Contract::all();
        return view('backend.si.si_incomming_new.edit', compact('si', 'item', 'dte_managments', 'item_types', 'fin_years','contracts'));
    }

    public function update(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'editId' => 'required',
            'reference_no' => 'required',
            'contract_reference_no' => 'required',
            'item_type_id' => 'required',
            'item_id' => 'required',

        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 422);
        }

        $data = Si::findOrFail($request->editId);

        $data->sender_id = $request->sender;
        $data->reference_no = $request->reference_no;
        $data->contract_reference_no = $request->contract_reference_no;
        $data->offer_reference_no = $request->offer_reference_no;
        $data->indent_reference_no = $request->indent_reference_no;
        $data->item_id = $request->item_id;
        $data->supplier_id = $request->supplier_id;
        $data->item_type_id = $request->item_type_id;
        $data->received_date = $request->received_date;
        $data->reference_date = $request->reference_date;
        $data->fin_year_id = $request->fin_year_id;
        $data->remarks = $request->remark;
        $data->updated_by = Auth::user()->id;
        $data->updated_at = Carbon::now()->format('Y-m-d');

        // $path = '';
        // if ($request->hasFile('doc_file')) {

        //     $path = $request->file('doc_file')->store('uploads', 'public');
        // }
        // $data->doc_file = $path ? $path : $data->doc_file;

        $data->save();
        //Multipule File Upload in files table
        $save_id = $data->id;
        if ($save_id) {
            $this->fileController->SaveFile($data->inspectorate_id, $data->section_id, $request->file_name, $request->file, 11, $request->reference_no);
        }

        return response()->json(['success' => 'Done']);
    }

    public function details($id)
    {
        $designations = Designation::all();
        $admin_id = Auth::user()->id;
        $section_ids = $section_ids = AdminSection::where('admin_id', $admin_id)->pluck('sec_id')->toArray();

        $details = Si::leftJoin('item_types', 'stage_inspections.item_type_id', '=', 'item_types.id')
            ->leftJoin('dte_managments', 'stage_inspections.sender_id', '=', 'dte_managments.id')
            ->leftJoin('items', 'stage_inspections.item_id', '=', 'items.id')
            ->leftJoin('fin_years', 'stage_inspections.fin_year_id', '=', 'fin_years.id')
            ->leftJoin('suppliers', 'stage_inspections.supplier_id', '=', 'suppliers.id')
            ->select(
                'stage_inspections.*',
                'item_types.name as item_type_name',
                'items.name as item_name',
                'dte_managments.name as dte_managment_name',
                'fin_years.year as fin_year_name',
                'suppliers.firm_name as firm_name_name'
            )
            ->where('stage_inspections.id', $id)
            ->first();

        $document_tracks = DocumentTrack::where('doc_ref_id', $details->id)
            ->leftJoin('designations as sender_designation', 'document_tracks.sender_designation_id', '=', 'sender_designation.id')
            ->leftJoin('designations as receiver_designation', 'document_tracks.reciever_desig_id', '=', 'receiver_designation.id')
            ->where('track_status', 1)
            ->where('doc_type_id', 11)
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
            ->where('doc_type_id',  11)
            ->latest()->first();

        //End blade forward on off section....


        return view('backend.si.si_incomming_new.details', compact('details', 'designations', 'document_tracks', 'desig_id',  'auth_designation_id', 'sender_designation_id',  'DocumentTrack_hidden'));
    }

    public function SiTracking(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'doc_ref_id' => 'required',
            'doc_reference_number' => 'required',
            'reciever_desig_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 422);
        }


        $ins_id = Auth::user()->inspectorate_id;
        $admin_id = Auth::user()->id;
        $sender_designation_id = AdminSection::where('admin_id', $admin_id)->pluck('desig_id')->first();
        $desig_position = Designation::where('id', $sender_designation_id)->first();

        $doc_type_id = 11; //...... 11 for si from  table doc_serial.
        $doc_ref_id = $request->doc_ref_id;
        $doc_reference_number = $request->doc_reference_number;
        $remarks = $request->remarks;
        $reciever_desig_id = $request->reciever_desig_id;
        $section_id = Si::where('reference_no', $doc_reference_number)->pluck('section_id')->first();

        $data = new DocumentTrack();
        $data->ins_id = $ins_id;
        $data->section_id = $section_id;
        $data->doc_type_id = $doc_type_id;
        $data->doc_ref_id = $doc_ref_id;
        $data->doc_reference_number = $doc_reference_number;
        $data->track_status = 1;
        $data->reciever_desig_id = $reciever_desig_id;
        $data->sender_designation_id = $sender_designation_id;
        $data->remarks = $remarks;
        $data->created_at = Carbon::now('Asia/Dhaka');
        $data->updated_at = Carbon::now('Asia/Dhaka');
        $data->save();

        if ($desig_position->position == 7) {
            $data = Si::find($doc_ref_id);

            if ($data) {

                $data->status = 3;
                $data->save();

                $value = new DocumentTrack();
                $value->ins_id = $ins_id;
                $value->section_id = $section_id;
                $value->doc_type_id = $doc_type_id;
                $value->doc_ref_id = $doc_ref_id;
                $value->doc_reference_number = $doc_reference_number;
                $value->track_status = 3;
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

    public function get_contract_details($contractReferenceNo)
    {
        $contract = Contract::where('reference_no' ,$contractReferenceNo)->first();
        // dd($contract);
        $item=Items::where('id' , $contract->item_id)->first();
        $item_type=Item_type::where('id' , $contract->item_type_id)->first();
        $offer_reference_no = $contract->offer_reference_no;

        $indent_reference_no = $contract->indent_reference_no;

        $supplier = Supplier::where('id',$contract->supplier_id)->first();

        return response()->json(['item' =>$item, 'itemType' =>$item_type,'offerReferenceNo'=>$offer_reference_no,'indentReferenceNo'=> $indent_reference_no, 'supplier'=>$supplier]);

    }

}
