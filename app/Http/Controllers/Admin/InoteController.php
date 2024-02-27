<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Additional_document;
use App\Models\AdminSection;
use App\Models\Contract;
use App\Models\Designation;
use App\Models\DocumentTrack;
use App\Models\Dte_managment;
use App\Models\File;
use App\Models\FinancialYear;
use App\Models\Indent;
use App\Models\Item_type;
use App\Models\Items;
use App\Models\inote;
use App\Models\InoteDeviation;
use App\Models\InoteDPL;
use App\Models\InoteLetter;
use App\Models\Section;
use App\Models\Supplier;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Yajra\DataTables\Facades\DataTables;

class InoteController extends Controller
{
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

        return view('backend.inote.inote_incomming_new.index', compact('inoteNew', 'inoteOnProcess', 'inoteCompleted', 'inoteDispatch'));
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
                    ->where('inotes.status', 0)
                    ->select('inotes.*', 'items.name as item_name', 'dte_managments.name as dte_managment_name', 'sections.name as section_name')
                    ->get();
            } elseif ($desig_position->id == 1) {

                $query = Inote::leftJoin('items', 'inotes.item_id', '=', 'items.id')
                    ->leftJoin('dte_managments', 'inotes.sender_id', '=', 'dte_managments.id')
                    ->leftJoin('sections', 'inotes.section_id', '=', 'sections.id')
                    ->where('inotes.inspectorate_id', $insp_id)
                    ->where('inotes.status', 0)
                    ->whereIn('inotes.section_id', $section_ids)
                    ->select('inotes.*', 'items.name as item_name', 'dte_managments.name as dte_managment_name', 'sections.name as section_name')
                    ->get();
            } else {

                // inote ids from document tracks table
                $inoteIds = Inote::leftJoin('document_tracks', 'inotes.id', '=', 'document_tracks.doc_ref_id')
                    ->where('document_tracks.reciever_desig_id', $designation_id)
                    ->where('document_tracks.doc_type_id', 13)
                    ->where('inotes.inspectorate_id', $insp_id)
                    ->where('inotes.status', 0)
                    ->whereIn('inotes.section_id', $section_ids)->pluck('inotes.id')->toArray();

                $query = Inote::leftJoin('items', 'inotes.item_id', '=', 'items.id')
                    ->leftJoin('dte_managments', 'inotes.sender_id', '=', 'dte_managments.id')
                    ->leftJoin('sections', 'inotes.section_id', '=', 'sections.id')
                    ->select('inotes.*', 'items.name as item_name',  'dte_managments.name as dte_managment_name', 'sections.name as section_name')
                    ->whereIn('inotes.id', $inoteIds)
                    ->where('inotes.status', 0)
                    ->get();

                $inoteId = [];
                if ($query) {
                    foreach ($query as $indent) {
                        array_push($inoteId, $indent->id);
                    }
                }

                $document_tracks_receiver_id = DocumentTrack::whereIn('doc_ref_id', $inoteId)
                    ->where('reciever_desig_id', $designation_id)
                    ->first();

                //......start for showing data for receiver designation
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

                    if ($data->status == '0') {
                        return '<button class="btn btn-success btn-sm">New</button>';
                    } else {
                        return '<button class="btn btn-success btn-sm">None</button>';
                    }
                })

                ->addColumn('action', function ($data) {
                    $DocumentTrack = DocumentTrack::where('doc_ref_id', $data->id)->where('doc_type_id', 13)->latest()->first();
                    $DesignationId = AdminSection::where('admin_id', Auth::user()->id)->pluck('desig_id')->first();
                    // dd($DocumentTrack);
                    if ($DocumentTrack) {
                        if ($DesignationId  ==  $DocumentTrack->reciever_desig_id) {
                            $actionBtn = '<div class="btn-group" role="group">';

                            if ($DesignationId == 3) {
                                $actionBtn .= '<a href="' . url('admin/inote/edit/' . $data->id) . '" class="edit2 ">Update</a>';
                            }
                            $actionBtn .= '<a href="' . url('admin/inote/details/' . $data->id) . '" class="edit ">Forward</a>
                            </div>';
                        } else {
                            $actionBtn = '<div class="btn-group" role="group">';
                            if ($DesignationId == 3) {
                                $actionBtn .= '<a href="' . url('admin/inote/edit/' . $data->id) . '" class="edit2 ">Update</a>';
                            }
                            $actionBtn .= '<a href="' . url('admin/inote/details/' . $data->id) . '" class="update">Forwarded</a>
                            </div>';
                        }

                        if ($DesignationId  ==  $DocumentTrack->sender_designation_id) {
                            $actionBtn = '<div class="btn-group" role="group">';
                            if ($DesignationId == 3) {
                                $actionBtn .= '<a href="' . url('admin/inote/edit/' . $data->id) . '" class="edit2 ">Update</a>';
                            }
                            $actionBtn .= '<a href="' . url('admin/inote/details/' . $data->id) . '" class="update">Forwarded</a>
                            </div>';
                        }
                    } else {
                        $actionBtn = '<div class="btn-group" role="group">';
                        if ($DesignationId == 3) {
                            $actionBtn .= '<a href="' . url('admin/inote/edit/' . $data->id) . '" class="edit2 ">Update</a>';
                        }
                        $actionBtn .= '<a href="' . url('admin/inote/details/' . $data->id) . '" class="edit ">Forward</a>
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
        $additional_documnets = Additional_document::where('status', 1)->get();
        $item_types = Item_type::where('status', 1)->where('inspectorate_id', $inspectorate_id)->get();
        $item = Items::all();
        $fin_years = FinancialYear::all();
        return view('backend.inote.inote_incomming_new.create', compact('sections', 'item', 'dte_managments', 'additional_documnets', 'item_types', 'fin_years'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'sender' => 'required',
            'admin_section' => 'required',
            'reference_no' => 'required',
            'inote_received_date' => 'required',
            'inote_reference_date' => 'required',
        ]);

        try {
            $insp_id = Auth::user()->inspectorate_id;

            $data = new inote();
            $data->inspectorate_id = $insp_id;
            $data->section_id = $request->admin_section;
            $data->sender_id = $request->sender;
            $data->reference_no = $request->reference_no;
            $data->item_id = $request->item_id;
            $data->item_type_id = $request->item_type_id;
            $data->received_date = $request->inote_received_date;
            $data->reference_date = $request->inote_reference_date;
            $data->fin_year_id = $request->fin_year_id;
            $data->created_by = Auth::user()->id;
            $data->updated_by = Auth::user()->id;
            $data->remarks = $request->remark;
            $data->status = 0;
            $data->created_at = Carbon::now()->format('Y-m-d');
            $data->updated_at = Carbon::now()->format('Y-m-d');

            if ($request->hasFile('doc_file')) {

                $path = $request->file('doc_file')->store('uploads', 'public');
                $data->attached_file = $path;
            }

            $data->save();

            return response()->json(['success' => 'inote entry created successfully']);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }
    public function edit($id)
    {
        $inote = Inote::find($id);
        $admin_id = Auth::user()->id;
        $inspectorate_id = Auth::user()->inspectorate_id;
        $section_ids = $section_ids = AdminSection::where('admin_id', $admin_id)->pluck('sec_id')->toArray();
        // $sections = Section::whereIn('id', $section_ids)->get();

        $dte_managments = Dte_managment::where('status', 1)->get();

        $contracts = Contract::all();
        // $selected_document =$indent->additional_documents;
        $item_types = Item_type::where('status', 1)
            ->where('inspectorate_id', $inspectorate_id)
            ->whereIn('section_id', $section_ids)
            ->get();
        $item = Items::where('id', $inote->item_id)->first();
        $supplier = Supplier::where('id', $inote->supplier_id)->first();
        $fin_years = FinancialYear::all();
        return view('backend.inote.inote_incomming_new.edit', compact('inote', 'item', 'dte_managments', 'item_types', 'fin_years', 'contracts', 'supplier'));
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

        $data = Inote::findOrFail($request->editId);

        $data->sender_id = $request->sender;
        $data->reference_no = $request->reference_no;
        $data->contract_reference_no = $request->contract_reference_no;
        $data->indent_reference_no = $request->indent_reference_no;
        $data->offer_reference_no = $request->offer_reference_no;
        $data->contract_no = $request->contract_no;
        $data->contract_date = $request->contract_date;
        $data->item_id = $request->item_id;
        $data->supplier_id = $request->supplier_id;
        $data->item_type_id = $request->item_type_id;
        $data->received_date = $request->inote_received_date;
        $data->reference_date = $request->inote_reference_date;
        $data->fin_year_id = $request->fin_year_id;
        $data->remarks = $request->remark;
        $data->updated_by = Auth::user()->id;
        $data->updated_at = Carbon::now()->format('Y-m-d');

        $data->save();
        //Multipule File Upload in files table
        $save_id = $data->id;
        if ($save_id) {
            $this->fileController->SaveFile($data->inspectorate_id, $data->section_id, $request->file_name, $request->file, 13, $request->reference_no);
        }
        return response()->json(['success' => 'Done']);
    }

    public function details($id)
    {
        $designations = Designation::all();
        $admin_id = Auth::user()->id;
        $section_ids = $section_ids = AdminSection::where('admin_id', $admin_id)->pluck('sec_id')->toArray();

        $details = Inote::leftJoin('item_types', 'inotes.item_type_id', '=', 'item_types.id')
            ->leftJoin('dte_managments', 'inotes.sender_id', '=', 'dte_managments.id')
            ->leftJoin('items', 'inotes.item_id', '=', 'items.id')
            ->leftJoin('fin_years', 'inotes.fin_year_id', '=', 'fin_years.id')
            ->select(
                'inotes.*',
                'item_types.name as item_type_name',
                'items.name as item_name',
                'dte_managments.name as dte_managment_name',
                'fin_years.year as fin_year_name'
            )
            ->where('inotes.id', $id)
            ->first();
        // Attached File
        $files = File::where('doc_type_id', 13)->where('reference_no', $details->reference_no)->get();
        // Attached File End
        $document_tracks = DocumentTrack::where('doc_ref_id', $details->id)
            ->leftJoin('designations as sender_designation', 'document_tracks.sender_designation_id', '=', 'sender_designation.id')
            ->leftJoin('designations as receiver_designation', 'document_tracks.reciever_desig_id', '=', 'receiver_designation.id')
            ->where('track_status', 1)
            ->where('doc_type_id', 13)
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
            ->where('doc_type_id', 13)
            ->latest()->first();

        //End blade forward on off section....


        return view('backend.inote.inote_incomming_new.details', compact('details', 'designations', 'document_tracks', 'desig_id',  'auth_designation_id', 'sender_designation_id',  'DocumentTrack_hidden', 'files'));
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
        $sender_designation_id = AdminSection::where('admin_id', $admin_id)->pluck('desig_id')->first();
        $desig_position = Designation::where('id', $sender_designation_id)->first();

        $doc_type_id = 13; //...... 13 for inote from  table doc_serial.
        $doc_ref_id = $request->doc_ref_id;
        $doc_reference_number = $request->doc_reference_number;
        $remarks = $request->remarks;
        $reciever_desig_id = $request->reciever_desig_id;
        $section_id = Inote::where('reference_no', $doc_reference_number)->pluck('section_id')->first();

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
        $data->track_status = 1;
        $data->reciever_desig_id = $reciever_desig_id;
        $data->sender_designation_id = $sender_designation_id;
        $data->remarks = $remarks;
        $data->created_at = Carbon::now('Asia/Dhaka');
        $data->updated_at = Carbon::now('Asia/Dhaka');
        $data->save();

        if ($desig_position->position == 7) {
            $data = Inote::find($doc_ref_id);

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
    public function item_name($id)
    {
        $items = Items::where('item_type_id', $id)->get();
        return response()->json($items);
    }

    public function InoteIssu($id)
    {
        $inote = Inote::find($id);
        $supplier = Supplier::find($inote->supplier_id);
        $supplier_details = '';
        if ($supplier) {
            $supplier_details = $supplier->firm_name . ', ' . $supplier->address_of_local_agent;
        }
        // $inote_letter=InoteLetter::where("inote_reference_no", $inote->reference_no)->first();
        // $deviation=InoteDeviation::where("reference_no", $inote->reference_no)->first();
        // $dpl15=InoteDPL::where("reference_no", $inote->reference_no)->first();
        return view('backend.inote.inoteHtml', compact('inote', 'supplier_details'));
    }
    public function InoteLetterStore(Request $request)
    {

        $ins_id = Auth::user()->inspectorate_id;
        $admin_id = Auth::user()->id;
        $sender_designation_id = AdminSection::where('admin_id', $admin_id)->pluck('desig_id')->first();
        $desig_position = Designation::where('id', $sender_designation_id)->first();
        $inote_reference_no = $request->inote_reference_no;
        $reciever_desig_id = $request->reciever_desig_id;
        $section_id = Inote::where('reference_no', $inote_reference_no)->pluck('section_id')->first();



        $inote = new InoteLetter();

        $inote->inspectorate_id = $ins_id;
        $inote->section_id = $section_id;
        $inote->book_no = $request->book_no;
        $inote->book_no = $request->book_no;
        $inote->set_no = $request->set_no;
        $inote->copy_number = $request->copy_number;
        $inote->copy_no = $request->copy_no;
        $inote->visiting_letter_no = $request->visiting_letter_no;
        $inote->contract_reference_no = $request->contract_reference_no;
        $inote->inote_reference_no = $request->inote_reference_no;
        $inote->indent_reference_no = $request->indent_reference_no;
        $inote->supplier_info = $request->supplier_info;
        $inote->sender_id = $request->sender_id;
        $inote->cahidakari = $request->cahidakari;
        $inote->visiting_process = $request->visiting_process;
        $inote->status = $request->status;
        $inote->punishment = $request->punishment;
        $inote->slip_return = $request->slip_return;
        $inote->slip_return = $request->slip_return;
        $inote->slip_return = $request->slip_return;
        $inote->serial_1 = $request->serial_1;
        $inote->serial_2to4 = $request->serial_2to4;
        $inote->serial_5 = $request->serial_5;
        $inote->serial_6 = $request->serial_6;
        $inote->serial_7 = $request->serial_7;
        $inote->serial_8 = $request->serial_8;
        $inote->serial_9 = $request->serial_9;
        $inote->serial_10 = $request->serial_10;
        $inote->serial_11 = $request->serial_11;
        $inote->serial_12 = $request->serial_12;
        $inote->serial_13 = $request->serial_13;
        $inote->body_info = $request->body_info;
        $inote->station = $request->station;
        $inote->date = $request->date;
        $inote->save();
        return response()->json(['success' => 'Done']);
    }
    public function EditInoteLetter($id)
    {
        $inoteLetter = InoteLetter::where("inote_reference_no", $id)->first();
        $deviation = InoteDeviation::where("reference_no", $id)->first();
        $dpl_15 = InoteDPL::where("reference_no", $id)->first();
        $anx = InoteDPL::where("reference_no", $id)->first();
        
        return view('backend.inote.inoteHtmlEdit', compact('inoteLetter',  'deviation', 'dpl_15', 'anx' ));
    }

    public function InoteDeviation(Request $request)
    {

        $ins_id = Auth::user()->inspectorate_id;
        $admin_id = Auth::user()->id;
        $sender_designation_id = AdminSection::where('admin_id', $admin_id)->pluck('desig_id')->first();
        $desig_position = Designation::where('id', $sender_designation_id)->first();
        $inote_reference_no = $request->inote_reference_no;
        $reciever_desig_id = $request->reciever_desig_id;
        $section_id = Inote::where('reference_no', $inote_reference_no)->pluck('section_id')->first();

        $inote = new InoteDeviation();

        $inote->inspectorate_id = $ins_id;
        $inote->section_id = $section_id;
        $inote->reference_no = $request->inote_reference_no;
        $inote->file_no = $request->file_no;
        $inote->nomenclature = $request->nomenclature;
        $inote->contract_no_dt = $request->contract_no_dt;
        $inote->suppliers_name_address = $request->suppliers_name_address;
        $inote->qty = $request->qty;
        $inote->on_order = $request->on_order;
        $inote->deviation_required = $request->deviation_required;
        $inote->accepted_to_date = $request->accepted_to_date;
        $inote->others_particulars = $request->others_particulars;
        $inote->classification_of_deviation = $request->classification_of_deviation;
        $inote->contract_approved_simple_basis = $request->contract_approved_simple_basis;
        $inote->deviation_recommended = $request->deviation_recommended;
        $inote->stores_issue = $request->stores_issue;
        $inote->considered_that = $request->considered_that;
        $inote->others_remarks = $request->others_remarks;
        $inote->deviation_applied_above = $request->deviation_applied_above;
        $inote->copy = $request->copy;
        $inote->created_at = Carbon::now('Asia/Dhaka');
        $inote->updated_at = Carbon::now('Asia/Dhaka');
        $inote->save();
        return response()->json(['success' => 'Done']);

    }
    public function deviation($id)
    {

        $inote = Inote::find($id);
        $deviations = InoteDeviation::where('reference_no',$id)->first();
        // dd($deviations);
        
        return view('backend.pdf.inote_deviation_pdf', compact('deviations'));

    }
    public function dpl15($id)
    {
        $dpl15 = InoteDPL::where('reference_no',$id)->first();

        return view('backend.pdf.inote_dpl15_pdf', compact('dpl15'));
    }


    public function InoteDPL(Request $request)
    {
        $ins_id = Auth::user()->inspectorate_id;
        $admin_id = Auth::user()->id;
        $sender_designation_id = AdminSection::where('admin_id', $admin_id)->pluck('desig_id')->first();
        $desig_position = Designation::where('id', $sender_designation_id)->first();
        $inote_reference_no = $request->inote_reference_no;
        $reciever_desig_id = $request->reciever_desig_id;
        $section_id = Inote::where('reference_no', $inote_reference_no)->pluck('section_id')->first();

        $inote = new InoteDPL();

        $inote->inspectorate_id = $ins_id;
        $inote->section_id = $section_id;
        $inote->reference_no = $request->inote_reference_no;
        $inote->firms_name = $request->firms_name;
        $inote->nomenclature = $request->nomenclature;
        $inote->contract_no = $request->contract_no;
        $inote->action = $request->action;
        $inote->qty = $request->qty;
        $inote->warranty = $request->warranty;
        $inote->created_at = Carbon::now('Asia/Dhaka');
        $inote->updated_at = Carbon::now('Asia/Dhaka');
        $inote->save();
        return response()->json(['success' => 'Done']);

    }
}