<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Additional_document;
use App\Models\AdminSection;
use App\Models\Designation;
use App\Models\DocumentTrack;
use App\Models\DraftContract;
use App\Models\Dte_managment;
use App\Models\FinalSpec;
use App\Models\FinancialYear;
use App\Models\Item_type;
use App\Models\Items;
use App\Models\Section;
use App\Models\Supplier;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use PDF;
use Yajra\DataTables\Facades\DataTables;

class DraftContractController extends Controller
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


        return view('backend.draft_contract.draft_contract_incomming_new.index', compact('draft_contractNew', 'draft_contractOnProcess', 'draft_contractCompleted', 'draft_contractDispatch'));
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
                    ->where('draft_contracts.status', 0)
                    ->select('draft_contracts.*', 'item_types.name as item_type_name', 'dte_managments.name as dte_managment_name', 'sections.name as section_name')
                    ->get();
            } elseif ($desig_position->id == 1) {

                $query = DraftContract::leftJoin('item_types', 'draft_contracts.item_type_id', '=', 'item_types.id')
                    ->leftJoin('dte_managments', 'draft_contracts.sender_id', '=', 'dte_managments.id')
                    ->leftJoin('sections', 'draft_contracts.section_id', '=', 'sections.id')
                    ->where('draft_contracts.inspectorate_id', $insp_id)
                    ->where('draft_contracts.status', 0)
                    ->whereIn('draft_contracts.section_id', $section_ids)
                    ->select('draft_contracts.*', 'item_types.name as item_type_name', 'dte_managments.name as dte_managment_name', 'sections.name as section_name')
                    ->get();
            } else {

                // draft_contract ids from document tracks table
                $draft_contractIds = DraftContract::leftJoin('document_tracks', 'draft_contracts.id', '=', 'document_tracks.doc_ref_id')
                    ->where('document_tracks.reciever_desig_id', $designation_id)
                    ->where('draft_contracts.inspectorate_id', $insp_id)
                    ->where('draft_contracts.status', 0)
                    ->whereIn('draft_contracts.section_id', $section_ids)->pluck('draft_contracts.id')->toArray();

                $query = DraftContract::leftJoin('item_types', 'draft_contracts.item_type_id', '=', 'item_types.id')
                    ->leftJoin('dte_managments', 'draft_contracts.sender_id', '=', 'dte_managments.id')
                    ->leftJoin('sections', 'draft_contracts.section_id', '=', 'sections.id')
                    ->select('draft_contracts.*', 'item_types.name as item_type_name',  'dte_managments.name as dte_managment_name', 'sections.name as section_name')
                    ->whereIn('draft_contracts.id', $draft_contractIds)
                    ->where('draft_contracts.status', 0)
                    ->get();

                $draft_contractId = [];
                if ($query) {
                    foreach ($query as $indent) {
                        array_push($draft_contractId, $indent->id);
                    }
                }

                $document_tracks_receiver_id = DocumentTrack::whereIn('doc_ref_id', $draft_contractId)
                    ->where('reciever_desig_id', $designation_id)
                    ->first();


                //......start for showing data for receiver designation
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

                    if ($data->status == '0') {
                        return '<button class="btn btn-success btn-sm">New</button>';
                    } else {
                        return '<button class="btn btn-success btn-sm">None</button>';
                    }
                })

                ->addColumn('action', function ($data) {
                    $DocumentTrack = DocumentTrack::where('doc_ref_id', $data->id)->latest()->first();
                    $DesignationId = AdminSection::where('admin_id', Auth::user()->id)->pluck('desig_id')->first();
                    // dd($DocumentTrack);
                    if ($DocumentTrack) {
                        if ($DesignationId  ==  $DocumentTrack->reciever_desig_id) {
                            $actionBtn = '<div class="btn-group" role="group">';

                            if ($DesignationId == 3) {
                                $actionBtn .= '<a href="' . url('admin/draft_contract/edit/' . $data->id) . '" class="edit2 ">Update</a>';
                            }
                            $actionBtn .= '<a href="' . url('admin/draft_contract/details/' . $data->id) . '" class="edit ">Forward</a>
                            </div>';
                        } else {
                            $actionBtn = '<div class="btn-group" role="group">';
                            if ($DesignationId == 3) {
                                $actionBtn .= '<a href="' . url('admin/draft_contract/edit/' . $data->id) . '" class="edit2 ">Update</a>';
                            }
                            $actionBtn .= '<a href="' . url('admin/draft_contract/details/' . $data->id) . '" class="update">Forwarded</a>
                            </div>';
                        }

                        if ($DesignationId  ==  $DocumentTrack->sender_designation_id) {
                            $actionBtn = '<div class="btn-group" role="group">';
                            if ($DesignationId == 3) {
                                $actionBtn .= '<a href="' . url('admin/draft_contract/edit/' . $data->id) . '" class="edit2 ">Update</a>';
                            }
                            $actionBtn .= '<a href="' . url('admin/draft_contract/details/' . $data->id) . '" class="update">Forwarded</a>
                            </div>';
                        }
                    } else {
                        $actionBtn = '<div class="btn-group" role="group">';
                        if ($DesignationId == 3) {
                            $actionBtn .= '<a href="' . url('admin/draft_contract/edit/' . $data->id) . '" class="edit2 ">Update</a>';
                        }
                        $actionBtn .= '<a href="' . url('admin/draft_contract/details/' . $data->id) . '" class="edit ">Forward</a>
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
        return view('backend.draft_contract.draft_contract_incomming_new.create', compact('sections', 'item', 'dte_managments', 'item_types', 'fin_years'));
    }

    public function store(Request $request)
    {

        $this->validate($request, [
            'sender' => 'required',
            'admin_section' => 'required',
            'reference_no' => 'required',
            'draft_contract_received_date' => 'required',
            'draft_contract_reference_date' => 'required',
        ]);

        try {
            $insp_id = Auth::user()->inspectorate_id;

            $data = new DraftContract();
            $data->inspectorate_id = $insp_id;
            $data->section_id = $request->admin_section;
            $data->sender_id = $request->sender;
            $data->reference_no = $request->reference_no;
            $data->item_id = $request->item_id;
            $data->item_type_id = $request->item_type_id;
            $data->received_date = $request->draft_contract_received_date;
            $data->reference_date = $request->draft_contract_reference_date;
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

            return response()->json(['success' => 'draft_contract entry created successfully']);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }
    public function edit($id)
    {
        $draft_contract = DraftContract::find($id);
        $admin_id = Auth::user()->id;
        $inspectorate_id = Auth::user()->inspectorate_id;
        $section_ids = $section_ids = AdminSection::where('admin_id', $admin_id)->pluck('sec_id')->toArray();
        // $sections = Section::whereIn('id', $section_ids)->get();
        $finalSpecs = FinalSpec::all();

        $dte_managments = Dte_managment::where('status', 1)->get();


        // $selected_document =$indent->additional_documents;
        $item_types = Item_type::where('status', 1)
            ->where('inspectorate_id', $inspectorate_id)
            ->whereIn('section_id', $section_ids)
            ->get();
        $item = Items::where('id', $draft_contract->item_id)->first();
        $fin_years = FinancialYear::all();
        return view('backend.draft_contract.draft_contract_incomming_new.edit', compact('draft_contract', 'item', 'dte_managments', 'item_types', 'fin_years', 'finalSpecs'));
    }

    public function update(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'editId' => 'required',
            'reference_no' => 'required',
            'final_spec_reference_no' => 'required',
            'item_type_id' => 'required',
            'item_id' => 'required',
            'supplier_id' => 'required',

        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 422);
        }

        $data = DraftContract::findOrFail($request->editId);
        $data->sender_id = $request->sender;
        $data->reference_no = $request->reference_no;
        $data->item_id = $request->item_id;
        $data->item_type_id = $request->item_type_id;
        $data->received_date = $request->draft_contract_received_date;
        $data->reference_date = $request->draft_contract_reference_date;
        $data->fin_year_id = $request->fin_year_id;
        $data->supplier_id = $request->supplier_id;
        $data->final_spec_reference_no = $request->final_spec_reference_no;
        $data->offer_reference_no = $request->offer_reference_no;
        $data->indent_reference_no = $request->indent_reference_no;
        $data->remarks = $request->remark;
        $data->updated_by = Auth::user()->id;
        $data->updated_at = Carbon::now()->format('Y-m-d');

        $path = '';
        if ($request->hasFile('doc_file')) {

            $path = $request->file('doc_file')->store('uploads', 'public');
        }
        $data->attached_file = $path ? $path : $data->attached_file;

        $data->save();

        return response()->json(['success' => 'Done']);
    }

    public function details($id)
    {
        $designations = Designation::all();
        $admin_id = Auth::user()->id;
        $section_ids = $section_ids = AdminSection::where('admin_id', $admin_id)->pluck('sec_id')->toArray();

        $details = DraftContract::leftJoin('item_types', 'draft_contracts.item_type_id', '=', 'item_types.id')
            ->leftJoin('dte_managments', 'draft_contracts.sender_id', '=', 'dte_managments.id')
            ->leftJoin('items', 'draft_contracts.item_id', '=', 'items.id')
            ->leftJoin('fin_years', 'draft_contracts.fin_year_id', '=', 'fin_years.id')
            ->select(
                'draft_contracts.*',
                'item_types.name as item_type_name',
                'items.name as item_name',
                'dte_managments.name as dte_managment_name',
                'fin_years.year as fin_year_name'
            )
            ->where('draft_contracts.id', $id)
            ->first();

        $document_tracks = DocumentTrack::where('doc_ref_id', $details->id)
            ->leftJoin('designations as sender_designation', 'document_tracks.sender_designation_id', '=', 'sender_designation.id')
            ->leftJoin('designations as receiver_designation', 'document_tracks.reciever_desig_id', '=', 'receiver_designation.id')
            ->where('track_status', 1)
            ->where('doc_type_id', 9)
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
            ->where('doc_type_id', 9)
            ->latest()->first();

        //End blade forward on off section....


        return view('backend.draft_contract.draft_contract_incomming_new.details', compact('details', 'designations', 'document_tracks', 'desig_id',  'auth_designation_id', 'sender_designation_id',  'DocumentTrack_hidden'));
    }

    public function Tracking(Request $request)
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

        $doc_type_id = 9; //...... 9 for Draft Contract from  table doc_serial.
        $doc_ref_id = $request->doc_ref_id;
        $doc_reference_number = $request->doc_reference_number;
        $remarks = $request->remarks;
        $reciever_desig_id = $request->reciever_desig_id;
        $section_id = DraftContract::where('reference_no', $doc_reference_number)->pluck('section_id')->first();

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
            $data = DraftContract::find($doc_ref_id);

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
    public function finalSpecData($referenceNo)
    {

        $finalSpec=FinalSpec::where('reference_no', $referenceNo)->first();
        $item=Items::where('id',$finalSpec->item_id)->first();
        $itemType=Item_type::where('id',$finalSpec->item_type_id)->first();
        $supplier=Supplier::where('id',$finalSpec->supplier_id)->first();

        return response()->json(['item' => $item,'itemType' => $itemType, 'supplier' => $supplier, 'finalSpec'=>$finalSpec]);
    }
}
