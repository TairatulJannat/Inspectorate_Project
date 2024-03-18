<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\File;
use App\Models\Items;
use App\Models\Offer;
use App\Models\Indent;
use App\Models\Tender;
use App\Models\Section;
use App\Models\Supplier;
use App\Models\FinalSpec;
use App\Models\Item_type;
use App\Models\Designation;
use App\Models\AdminSection;
use Illuminate\Http\Request;
use App\Models\DocumentTrack;
use App\Models\Dte_managment;
use App\Models\FinancialYear;
use App\Models\ParameterGroup;
use App\Models\SupplierSpecData;
use Illuminate\Support\Facades\DB;
use App\Models\Additional_document;
use App\Http\Controllers\Controller;
use App\Models\AssignParameterValue;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class FinalSpecController extends Controller
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

        return view('backend.finalSpec.finalSpec_incomming_new.index', compact('finalSpecNew', 'finalSpecOnProcess', 'finalSpecCompleted', 'finalSpecDispatch'));
    }

    public function all_data(Request $request)
    {
        // dd($request->all());
        if ($request->ajax()) {

            $insp_id = Auth::user()->inspectorate_id;
            $admin_id = Auth::user()->id;
            $section_ids = AdminSection::where('admin_id', $admin_id)->pluck('sec_id')->toArray();
            $designation_id = AdminSection::where('admin_id', $admin_id)->pluck('desig_id')->first();
            $desig_position = Designation::where('id', $designation_id)->first();

            if (Auth::user()->id == 92) {
                $query = FinalSpec::leftJoin('items', 'final_specs.item_id', '=', 'items.id')
                    ->leftJoin('dte_managments', 'final_specs.sender', '=', 'dte_managments.id')
                    ->leftJoin('sections', 'final_specs.sec_id', '=', 'sections.id')
                    ->where('final_specs.status', 0)
                    ->select('final_specs.*', 'items.name as item_name', 'final_specs.*', 'dte_managments.name as dte_managment_name', 'sections.name as section_name')
                    ->get();
            } elseif ($desig_position->id == 1) {

                $query = FinalSpec::leftJoin('items', 'final_specs.item_id', '=', 'items.id')
                    ->leftJoin('dte_managments', 'final_specs.sender', '=', 'dte_managments.id')
                    ->leftJoin('sections', 'final_specs.sec_id', '=', 'sections.id')
                    ->select('final_specs.*', 'items.name as item_name', 'final_specs.*', 'dte_managments.name as dte_managment_name', 'sections.name as section_name')
                    ->where('final_specs.status', 0)
                    ->get();
            } else {

                $FinalSpecs = FinalSpec::leftJoin('document_tracks', 'final_specs.id', '=', 'document_tracks.doc_ref_id')
                    ->where('document_tracks.reciever_desig_id', $designation_id)
                    ->where('final_specs.insp_id', $insp_id)
                    ->where('final_specs.status', 0)
                    ->whereIn('final_specs.sec_id', $section_ids)->pluck('final_specs.id', 'final_specs.id')->toArray();

                $query = FinalSpec::leftJoin('items', 'final_specs.item_id', '=', 'items.id')
                    ->leftJoin('dte_managments', 'final_specs.sender', '=', 'dte_managments.id')
                    ->leftJoin('sections', 'final_specs.sec_id', '=', 'sections.id')
                    ->select('final_specs.*', 'items.name as item_name', 'final_specs.*', 'dte_managments.name as dte_managment_name', 'sections.name as section_name')
                    ->whereIn('final_specs.id', $FinalSpecs)
                    ->where('final_specs.status', 0)
                    ->get();

                //......Start for DataTable Forward and Details btn change
                $FinalSpecId = [];
                if ($query) {
                    foreach ($query as $Finalspec) {
                        array_push($FinalSpecId, $Finalspec->id);
                    }
                }

                $document_tracks_receiver_id = DocumentTrack::whereIn('doc_ref_id', $FinalSpecId)
                    ->where('reciever_desig_id', $designation_id)
                    ->first();

                if (!$document_tracks_receiver_id) {
                    $query = FinalSpec::where('id', 'no data')->get();
                }
                //......End for showing data for receiver designation
            }

            $query = $query->sortByDesc('id');

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

                    $DocumentTrack = DocumentTrack::where('doc_ref_id', $data->id)->where('doc_type_id', 6)->latest()->first();
                    $designation_id = AdminSection::where('admin_id', Auth::user()->id)->pluck('desig_id')->first();
                    // dd($DocumentTrack);
                    if ($DocumentTrack) {
                        if ($designation_id  ==  $DocumentTrack->reciever_desig_id) {
                            $actionBtn = '<div class="btn-group" role="group">';
                            if ($designation_id == 3) {
                                $actionBtn .= '<a href="' . url('admin/finalSpec/edit/' . $data->id) . '" class="edit2 ">Update</a>';
                            }

                            $actionBtn .= '<a href="' . url('admin/finalspec/details/' . $data->id) . '" class="edit">Forward</a>
                            </div>';
                        } else {
                            $actionBtn = '<div class="btn-group" role="group">';
                            if ($designation_id == 3) {
                                $actionBtn .= '<a href="' . url('admin/finalSpec/edit/' . $data->id) . '" class="edit2 ">Update</a>';
                            }
                            $actionBtn .= '<a href="' . url('admin/finalspec/details/' . $data->id) . '" class="update">Forwarded</a>
                            </div>';
                        }

                        if ($designation_id  ==  $DocumentTrack->sender_designation_id) {
                            $actionBtn = '<div class="btn-group" role="group">';
                            if ($designation_id == 3) {
                                $actionBtn .= '<a href="' . url('admin/finalSpec/edit/' . $data->id) . '" class="edit2 ">Update</a>';
                            }
                            $actionBtn .= '<a href="' . url('admin/finalspec/details/' . $data->id) . '" class="update">Forwarded</a>
                            </div>';
                        }
                    } else {
                        $actionBtn = '<div class="btn-group" role="group">';
                        if ($designation_id == 3) {
                            $actionBtn .= '<a href="' . url('admin/finalSpec/edit/' . $data->id) . '" class="edit2 ">Update</a>';
                        }
                        $actionBtn .= ' <a href="' . url('admin/finalspec/details/' . $data->id) . '" class="edit">Forward</a>
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
        $section_ids = $section_ids = AdminSection::where('admin_id', $admin_id)->pluck('sec_id')->toArray();
        $sections = Section::whereIn('id', $section_ids)->get();

        $dte_managments = Dte_managment::where('status', 1)->get();

        return view('backend.finalSpec.finalSpec_incomming_new.create', compact('sections', 'dte_managments'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        // $this->validate($request, [
        //     'sender' => 'required',
        //     'admin_section' => 'required',
        //     'reference_no' => 'required',
        //     'spec_type' => 'required',
        //     'additional_documents' => 'required',
        //     'item_type_id' => 'required',
        //     'spec_received_date' => 'required',

        // ]);
        $insp_id = Auth::user()->inspectorate_id;
        $sec_id = $request->admin_section;

        $data = new FinalSpec();
        $data->insp_id = $insp_id;
        $data->sec_id = $sec_id;
        $data->sender = $request->sender;
        $data->reference_no = $request->reference_no;
        $data->offer_reference_no = $request->offer_reference_no;
        $data->tender_reference_no = $request->tender_reference_no;
        $data->indent_reference_no = $request->indent_reference_no;
        $data->reference_date = $request->reference_date;
        $data->item_id = $request->item_id;
        $data->item_type_id = $request->item_type_id;
        $data->supplier_id = $request->supplier_id;
        $data->final_spec_receive_Ltr_dt = $request->final_spec_receive_Ltr_dt;
        $data->fin_year_id = $request->fin_year_id;

        $data->received_by = Auth::user()->id;
        $data->remark = $request->remark;
        $data->status = 0;
        $data->created_at = Carbon::now()->format('Y-m-d');
        $data->updated_at = Carbon::now()->format('Y-m-d');;

        $data->save();

        return response()->json(['success' => 'Done']);
    }

    public function edit($id)
    {
        $finalSpec = FinalSpec::find($id);

        $admin_id = Auth::user()->id;
        $inspectorate_id = Auth::user()->inspectorate_id;
        $dte_managments = Dte_managment::where('status', 1)->get();
        $section_ids = AdminSection::where('admin_id', $admin_id)->pluck('sec_id')->toArray();
        $item_types = Item_type::where('id', $finalSpec->item_type_id)->where('status', 1)->where('inspectorate_id', $inspectorate_id)->first();

        $item = Items::where('inspectorate_id', $inspectorate_id)
            ->whereIn('section_id', $section_ids)
            ->get();

        $fin_years = FinancialYear::all();

        $supplierIds = SupplierSpecData::where('offer_reference_no', $finalSpec->offer_reference_no)
            ->groupBy('supplier_id')
            ->pluck('supplier_id');

        $suppliers = Supplier::whereIn('id', $supplierIds)->get();

        $tender_reference_numbers = Tender::all();
        $indent_reference_numbers = Indent::all();
        $offer_reference_numbers = Offer::all();
        // dd($finalSpec);
        return view('backend.finalSpec.finalSpec_incomming_new.edit', compact('finalSpec', 'item', 'dte_managments',  'item_types', 'fin_years', 'tender_reference_numbers', 'indent_reference_numbers', 'suppliers', 'offer_reference_numbers'));
    }

    public function update(Request $request)
    {
        $data = FinalSpec::findOrFail($request->editId);

        $data->sender = $request->sender;
        $data->reference_no = $request->reference_no;
        $data->offer_reference_no = $request->offer_reference_no;
        $data->tender_reference_no = $request->tender_reference_no;
        $data->indent_reference_no = $request->indent_reference_no;
        $data->contract_no = $request->contract_no;
        $data->contract_date = $request->contract_date;
        $data->item_id = $request->item_id;
        $data->item_type_id = $request->item_type_id;
        $data->fin_year_id = $request->fin_year_id;
        $data->final_spec_receive_Ltr_dt = $request->final_spec_receive_Ltr_dt;
        $data->received_by = Auth::user()->id;
        $data->remark = $request->remark;
        $data->status = 0;
        $data->created_at = Carbon::now()->format('Y-m-d');
        $data->updated_at = Carbon::now()->format('Y-m-d');

        if ($data->supplier_id == null && $request->supplier_id == null) {
            $data->supplier_id = null;
            dd('Please select a supplier.');
            // No change needed
        } elseif ($data->supplier_id != null && $request->supplier_id == null) {
            dd('Please select a supplier.');
            // No change needed
        } elseif ($data->supplier_id == null && $request->supplier_id != null && $request->offer_reference_no != null) {
            // Begin a database transaction
            DB::beginTransaction();

            try {
                // Fetch SupplierSpecData based on the request
                $supplierSpecData = SupplierSpecData::where('supplier_id', $request->supplier_id)
                    ->where('offer_reference_no', $request->offer_reference_no)
                    ->get();

                // If matching data is found, save it to AssignParameterValue table
                if ($supplierSpecData->isNotEmpty()) {
                    foreach ($supplierSpecData as $supplierSpecSingleData) {
                        $assignParameterValue = new AssignParameterValue();
                        $assignParameterValue->parameter_group_id = $supplierSpecSingleData->parameter_group_id;
                        $assignParameterValue->parameter_name = $supplierSpecSingleData->parameter_name;
                        $assignParameterValue->parameter_value = $supplierSpecSingleData->parameter_value;
                        $assignParameterValue->doc_type_id = 6;
                        $assignParameterValue->reference_no = $request->offer_reference_no;
                        $assignParameterValue->save();
                    }
                } else {
                    // No matching data found
                }

                // Update supplier_id
                $data->supplier_id = $request->supplier_id;

                // Commit the transaction
                DB::commit();
            } catch (\Exception $e) {
                // Rollback the transaction in case of an error
                DB::rollback();

                // Handle the error
                return response()->json(['error' => $e->getMessage()], 500);
            }
        } elseif ($data->supplier_id == $request->supplier_id) {
            // dd($data->supplier_id, $request->supplier_id, 'hello in 3');
            // No change needed
        } elseif ($data->supplier_id != $request->supplier_id && $request->offer_reference_no != null) {
            // Begin a database transaction
            DB::beginTransaction();
            try {
                // Delete previously entered data with reference_no and doc_type = 6
                AssignParameterValue::where('reference_no', $request->offer_reference_no)
                    ->where('doc_type_id', 6)
                    ->delete();

                // Fetch new data based on the request
                $supplierSpecData = SupplierSpecData::where('supplier_id', $request->supplier_id)
                    ->where('offer_reference_no', $request->offer_reference_no)
                    ->get();

                if ($supplierSpecData->isNotEmpty()) {
                    // Enter new data
                    foreach ($supplierSpecData as $supplierSpecSingleData) {
                        $assignParameterValue = new AssignParameterValue();
                        $assignParameterValue->parameter_group_id = $supplierSpecSingleData->parameter_group_id;
                        $assignParameterValue->parameter_name = $supplierSpecSingleData->parameter_name;
                        $assignParameterValue->parameter_value = $supplierSpecSingleData->parameter_value;
                        $assignParameterValue->doc_type_id = 6;
                        $assignParameterValue->reference_no = $request->offer_reference_no;
                        $assignParameterValue->save();
                    }
                } else {
                    // No matching data found
                }

                // Update supplier_id
                $data->supplier_id = $request->supplier_id;

                // Commit the transaction
                DB::commit();
            } catch (\Exception $e) {
                // Rollback the transaction in case of an error
                DB::rollback();

                // Handle the error
                return response()->json(['error' => $e->getMessage()], 500);
            }
        }

        $data->save();

        //Multipule File Upload in files table
        $save_id = $data->id;

        if ($save_id) {
            $this->fileController->SaveFile($data->insp_id, $data->sec_id, $request->file_name, $request->file, 6,  $request->reference_no);
        }

        return response()->json(['success' => 'Done']);
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
            ->where('track_status', 1)
            ->where('doc_type_id', 6)
            ->select(
                'document_tracks.*',
                'sender_designation.name as sender_designation_name',
                'receiver_designation.name as receiver_designation_name'
            )
            ->get();
        // dd($document_tracks);
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
            ->where('doc_type_id', 6)
            ->latest()->first();
        //End blade forward on off section....



        return view('backend.finalSpec.finalSpec_incomming_new.details', compact('details', 'designations', 'document_tracks', 'desig_id',  'auth_designation_id', 'sender_designation_id', 'DocumentTrack_hidden', 'files'));
    }

    public function finalSpecTracking(Request $request)
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
        $section_ids = AdminSection::where('admin_id', $admin_id)->pluck('sec_id')->toArray();
        $doc_type_id = 6; //...... 5 for indent from offers table doc_serial.
        $doc_ref_id = $request->doc_ref_id;
        $doc_reference_number = htmlspecialchars_decode($request->doc_reference_number);
        $remarks = $request->remarks;
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
        $data->track_status = 1;
        $data->reciever_desig_id = $reciever_desig_id;
        $data->sender_designation_id = $sender_designation_id;
        $data->remarks = $remarks;
        $data->created_at =  Carbon::now('Asia/Dhaka');
        $data->updated_at =  Carbon::now('Asia/Dhaka');
        $data->save();

        if ($desig_position->position == 7) {

            $data = FinalSpec::find($doc_ref_id);

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
                $value->created_at =  Carbon::now('Asia/Dhaka');
                $value->updated_at =  Carbon::now('Asia/Dhaka');
                $value->save();
            }
        }
        return response()->json(['success' => 'Done']);
    }

    public function get_offer_details($offerReferenceNo)
    {

        $offer = Offer::where('reference_no', $offerReferenceNo)->first();
        $item = Items::where('id', $offer->item_id)->first();
        $item_type = Item_type::where('id', $offer->item_type_id)->first();

        $tender_reference_no = Tender::where('reference_no', $offer->tender_reference_no)->first();

        $indent_reference_no = Indent::where('reference_no', $offer->indent_reference_no)->first();

        $offer->suppliers = json_decode($offer->supplier_id, true);

        $suppliers = Supplier::whereIn('id',  $offer->suppliers)->get();

        return response()->json(['item' => $item, 'itemType' => $item_type, 'tenderReferenceNo' => $tender_reference_no, 'indentReferenceNo' => $indent_reference_no, 'suppliernames' => $suppliers]);
    }

    public function parameter($reference_number)
    {
        $reference_number = $reference_number;
        $finalspec = FinalSpec::where('reference_no', $reference_number)->first();

        $supplierAssignValue = SupplierSpecData::where('offer_reference_no', $finalspec->offer_reference_no)

            ->leftJoin('parameter_groups', 'supplier_spec_data.parameter_group_id', '=', 'parameter_groups.id')
            ->where('supplier_id', $finalspec->supplier_id)
            ->select('supplier_spec_data.*', 'parameter_groups.name as group_name')
            ->get();

        $groupedData = $supplierAssignValue->groupBy('parameter_group_id');

        return view('backend/finalspec/parameter', compact('supplierAssignValue', 'groupedData'));
    }

    public function finalSpecParameter(Request $request)
    {
        $finalSpec = FinalSpec::where('reference_no', $request->final_spec_ref_no)->first();
        $finalSpecRefNo = $request->final_spec_ref_no;
        $item_id = $finalSpec->item_id;
        $item_type_id = $finalSpec->item_type_id;

        return view('backend.finalSpec.final-spec-parameter', compact('item_id', 'item_type_id', 'finalSpecRefNo'));
    }

    public function getSpecData(Request $request)
    {
        $customMessages = [
            'item-type-id.required' => 'Please select an Item Type.',
            'item-id.required' => 'Please select an Item.',
            'finalSpecRefNo.required' => 'Final Spec Ref No. is required.',
        ];

        $validator = Validator::make($request->all(), [
            'item-type-id' => ['required', 'exists:item_types,id'],
            'item-id' => ['required', 'exists:items,id'],
            'finalSpecRefNo' => ['required', 'exists:final_specs,reference_no'],
        ], $customMessages);

        if ($validator->passes()) {
            $itemId = $request->input('item-id');
            $itemTypeId = $request->input('item-type-id');
            $finalSpecRefNo = $request->input('finalSpecRefNo');

            $finalSpec = FinalSpec::where('reference_no', $finalSpecRefNo)->first();

            $indentRefNo = $finalSpec->indent_reference_no;

            $item = Items::find($itemId);
            $itemName = $item ? $item->name : 'Unknown Item';

            $itemType = Item_Type::find($itemTypeId);
            $itemTypeName = $itemType ? $itemType->name : 'Unknown Item Type';

            $parameterGroups = ParameterGroup::with(['assignParameterValues' => function ($query) {
                $query->where('doc_type_id', 6);
            }])
                ->where('item_id', $itemId)
                ->where('reference_no', $indentRefNo)
                ->get();

            foreach ($parameterGroups as $parameterGroup) {
                $treeNode = [
                    'parameterGroupId' => $parameterGroup->id,
                    'parameterGroupName' => $parameterGroup->name,
                    'parameterValues' => $parameterGroup->assignParameterValues->toArray(),
                ];

                $treeViewData[] = $treeNode;
            }

            return response()->json([
                'isSuccess' => true,
                'message' => 'Parameters Data successfully retrieved!',
                'treeViewData' => $treeViewData,
                'itemTypeId' => $itemTypeId,
                'itemTypeName' => $itemTypeName,
                'itemId' => $itemId,
                'itemName' => $itemName,
            ], 200);
        } else {
            return response()->json([
                'isSuccess' => false,
                'message' => "Validation failed. Please check the inputs!",
                'error' => $validator->errors()->toArray()
            ], 200);
        }
    }

    public function editSpec(Request $request)
    {
        try {
            $id = $request->id;
            $data = AssignParameterValue::where('parameter_group_id', $id)->where('doc_type_id', 6)->get();

            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Parameter Group Data not found'], 404);
        }
    }

    public function storeSpec(Request $request)
    {
        $customMessages = [
            'assign_parameter_group_id.required' => 'Please select a Parameter Group.',
            'parameter_name.required' => 'Please enter a Parameter Name.',
            'parameter_value.required' => 'Please enter a Parameter Value.',
            'finalSpecRefNo.required' => 'Final Spec Ref. No. required.',
        ];

        $validator = Validator::make($request->all(), [
            'assign_parameter_group_id' => ['required', 'exists:parameter_groups,id'],
            'parameter_name' => ['required', 'string', 'max:255'],
            'parameter_value' => ['required', 'string', 'max:999'],
            'finalSpecRefNo' => ['required', 'string', 'max:255'],
        ], $customMessages);

        if ($validator->fails()) {
            return response()->json([
                'isSuccess' => false,
                'message' => 'Validation failed. Please check the inputs.',
                'errors' => $validator->errors()->toArray(),
            ], 200);
        }

        try {
            DB::beginTransaction();

            $parameterGroup = ParameterGroup::find($request->input('assign_parameter_group_id'));

            if (!$parameterGroup) {
                return response()->json([
                    'isSuccess' => false,
                    'message' => 'Invalid Parameter Group selected!',
                ], 200);
            }

            $parameterNames = (array) $request->input('parameter_name');
            $parameterValues = (array) $request->input('parameter_value');

            $assignParameterValues = [];

            $finalSpecData = FinalSpec::where("reference_no", $request->input('finalSpecRefNo'))->first();

            foreach ($parameterNames as $key => $parameterName) {
                $assignParameterValue = new AssignParameterValue();

                $assignParameterValue->parameter_name = $parameterName;
                $assignParameterValue->parameter_value = $parameterValues[$key];
                $assignParameterValue->parameter_group_id = $parameterGroup->id;
                $assignParameterValue->doc_type_id = 6;
                $assignParameterValue->reference_no = $finalSpecData->offer_reference_no;

                $assignParameterValues[] = $assignParameterValue;
            }

            foreach ($assignParameterValues as $assignParameterValue) {
                if (!$assignParameterValue->save()) {
                    DB::rollBack();

                    return response()->json([
                        'isSuccess' => false,
                        'message' => 'Something went wrong while storing data!',
                    ], 200);
                }
            }

            DB::commit();

            return response()->json([
                'isSuccess' => true,
                'message' => 'Parameter Names and Values saved successfully!',
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            // Log detailed error information for debugging purposes
            \Log::error('Error in store method: ' . $e->getMessage());

            return response()->json([
                'isSuccess' => false,
                'message' => 'Something went wrong!',
                'error' => $e->getMessage(),
            ], 200);
        }
    }

    public function updateSpec(Request $request)
    {
        $validatedData = $request->validate([
            'id' => 'required',
            'parameter_name' => 'required',
            'parameter_value' => 'required',
        ]);

        DB::beginTransaction();

        try {
            $parameterValue = AssignParameterValue::findOrFail($validatedData['id']);
            $parameterValue->id = $validatedData['id'];
            $parameterValue->parameter_name = $validatedData['parameter_name'];
            $parameterValue->parameter_value = $validatedData['parameter_value'];

            $result = $parameterValue->update();

            if ($result) {
                DB::commit();
                return response()->json([
                    'isSuccess' => true,
                    'message' => 'Parameters updated successfully!'
                ], 200);
            } else {
                DB::rollBack();
                return response()->json([
                    'isSuccess' => false,
                    'message' => 'Failed to update Parameters!'
                ], 200);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            // Handle the exception, log the error, etc.
            return response()->json([
                'isSuccess' => false,
                'message' => 'Error updating Parameters!'
            ], 200);
        }
    }

    public function destroySpec(Request $request)
    {
        $id = $request->id;

        DB::beginTransaction();

        try {
            $parameterValue = AssignParameterValue::findOrFail($id);

            $result = $parameterValue->delete();


            if ($result) {
                DB::commit();
                return response()->json([
                    'isSuccess' => true,
                    'message' => 'Parameters deleted successfully!'
                ], 200);
            } else {
                DB::rollBack();
                return response()->json([
                    'isSuccess' => false,
                    'message' => 'Failed to delete Parameters!'
                ], 200);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            // Handle the exception, log the error, etc.
            return response()->json([
                'isSuccess' => false,
                'message' => 'Error deleting Parameters!'
            ], 200);
        }
    }
}
