<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Items;
use App\Models\Offer;
use App\Models\Indent;
use App\Models\Tender;
use App\Models\DocType;
use App\Models\Section;
use App\Models\Supplier;
use App\Models\Item_type;
use App\Models\Designation;
use App\Models\AdminSection;
use Illuminate\Http\Request;
use App\Models\DocumentTrack;
use App\Models\Dte_managment;
use App\Models\FinancialYear;
use App\Models\PrelimGeneral;
use App\Models\ParameterGroup;
use App\Models\Additional_document;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class TenderController extends Controller
{
    //

    public function index()
    {
        return view('backend.tender.index');
    }

    public function all_data(Request $request)
    {
        if ($request->ajax()) {

            $insp_id = Auth::user()->inspectorate_id;
            $admin_id = Auth::user()->id;
            $section_ids = AdminSection::where('admin_id', $admin_id)->pluck('sec_id')->toArray();
            $designation_id = AdminSection::where('admin_id', $admin_id)->pluck('desig_id')->first();
            $desig_position = Designation::where('id', $designation_id)->first();

            $query = Tender::leftJoin('item_types', 'tenders.item_type_id', '=', 'item_types.id')
                ->leftJoin('dte_managments', 'tenders.sender', '=', 'dte_managments.id')
                ->leftJoin('fin_years', 'tenders.fin_year_id', '=', 'fin_years.id')
                ->leftJoin('sections', 'tenders.sec_id', '=', 'sections.id')
                ->where('tenders.status', 0)
                ->whereIn('tenders.sec_id', $section_ids)
                ->select('tenders.*', 'item_types.name as item_type_name', 'fin_years.year as fin_years_name', 'tenders.*', 'dte_managments.name as dte_managment_name', 'sections.name as section_name')
                ->get();

            $query = $query->sortByDesc('id');
            return DataTables::of($query)
                ->setTotalRecords($query->count())
                ->addIndexColumn()

                ->addColumn('status', function ($data) {
                    if ($data->status == '0') {
                        return '<button class="btn btn-primary btn-sm">New</button>';
                    }
                    if ($data->status == '1') {
                        return '<button class="btn btn-warning  btn-sm">Under Vetted</button>';
                    }
                    if ($data->status == '2') {
                        return '<button class="btn btn-success btn-sm">Delivered</button>';
                    }
                })
                ->addColumn('action', function ($data) {

                    if ($data->status == '2') {
                        $actionBtn = '<div class="btn-group" role="group">

                        <a href="" class="edit btn btn-success btn-sm" disable>Completed</a>';
                    } else {

                        $actionBtn = '<div class="btn-group" role="group">

                        <a href="' . url('admin/tender/details/' . $data->id) . '" class="edit btn btn-secondary btn-sm">Forward</a>
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
        $additional_documents = Additional_document::where('status', 1)->get();
        $item_types = Item_type::where('status', 1)->get();
        $fin_years = FinancialYear::all();
        $indent_reference_numbers = Indent::where('insp_id', $inspectorate_id)
            ->whereIn('sec_id', $section_ids)
            ->orderBy('id', 'desc')
            ->get();


        return view('backend.tender.create', compact('dte_managments', 'additional_documents', 'item_types', 'sections', 'fin_years', 'indent_reference_numbers'));
    }

    public function store(Request $request)
    {

        $this->validate($request, [
            'admin_section' => 'required',
            'reference_no' => [
                'required',
                Rule::unique('tenders')->where(function ($query) {
                    return $query->where('insp_id', Auth::user()->inspectorate_id);
                }),
            ],
            'indent_reference_no' => 'required',
            'tender_date' => 'required',
            'receive_date' => 'required',
        ]);

        $insp_id = Auth::user()->inspectorate_id;
        $sec_id = $request->admin_section;

        $data = new Tender();
        $data->insp_id = $insp_id;
        $data->sec_id = $sec_id;
        $data->sender = $request->sender;

        $data->reference_no = $request->reference_no;
        $data->tender_number = $request->tender_number;
        $data->indent_reference_no = $request->indent_reference_no;
        $data->receive_date = $request->receive_date;
        $data->additional_documents = json_encode($request->additional_documents);
        $data->item_id = $request->item_id;
        $data->item_type_id = $request->item_type_id;
        $data->fin_year_id = $request->fin_year_id;
        $data->qty = $request->qty;
        $data->tender_date = $request->tender_date;
        $data->opening_date = $request->opening_date;
        $data->received_by = Auth::user()->id;
        $data->remark = $request->remark;
        $data->status = 0;
        $data->created_at = Carbon::now()->format('Y-m-d');
        $data->updated_at = Carbon::now()->format('Y-m-d');;

        $data->save();

        return response()->json(['success' => 'Done']);
    }

    public function details($id)
    {
        $details = Tender::leftJoin('item_types', 'tenders.item_type_id', '=', 'item_types.id')
            ->leftJoin('dte_managments', 'tenders.sender', '=', 'dte_managments.id')
            // ->leftJoin('additional_documents', 'tenders.additional_documents', '=', 'additional_documents.id')
            ->select('tenders.*', 'item_types.name as item_type_name', 'tenders.*', 'dte_managments.name as dte_managment_name')
            ->where('tenders.id', $id)
            ->first();

        $details->additional_documents = json_decode($details->additional_documents, true);
        $details->additional_documents =  $details->additional_documents ?  $details->additional_documents : [];
        $additional_documents_names = [];

        foreach ($details->additional_documents as $document_id) {
            $additional_names = Additional_document::where('id', $document_id)->pluck('name')->first();

            array_push($additional_documents_names, $additional_names);
        }

        $designations = Designation::all();

        $admin_id = Auth::user()->id;
        $section_ids = $section_ids = AdminSection::where('admin_id', $admin_id)->pluck('sec_id')->toArray();

        $document_tracks = DocumentTrack::where('doc_ref_id', $details->id)
            ->leftJoin('designations', 'document_tracks.sender_designation_id', '=', 'designations.id')
            ->where('track_status', 1)
            ->select('document_tracks.*', 'designations.name as designations_name')->get();

        $auth_designation_id = AdminSection::where('admin_id', $admin_id)->first();
        if ($auth_designation_id) {
            $desig_id = $auth_designation_id->desig_id;
        }

        //Start blade notes section....
        $notes = '';

        $document_tracks_notes = DocumentTrack::where('doc_ref_id', $details->id)
            ->where('track_status', 1)
            ->where('reciever_desig_id', $desig_id)->get();

        if ($document_tracks_notes->isNotEmpty()) {
            $notes = $document_tracks_notes;
        }
        //End blade notes section....

        return view('backend.tender.details', compact('details', 'designations', 'document_tracks', 'desig_id', 'additional_documents_names', 'auth_designation_id', 'notes'));
    }

    public function tenderTracking(Request $request)
    {
        $ins_id = Auth::user()->inspectorate_id;
        $admin_id = Auth::user()->id;
        $section_ids = AdminSection::where('admin_id', $admin_id)->pluck('sec_id')->toArray();
        $doc_ref_id = $request->doc_ref_id;
        $remarks = $request->remarks;
        $reciever_desig_id = $request->reciever_desig_id;
        $section_id = $section_ids[0];
        $sender_designation_id = AdminSection::where('admin_id', $admin_id)->pluck('desig_id')->first();

        $desig_position = Designation::where('id', $sender_designation_id)->first();

        $data = new DocumentTrack();
        $data->ins_id = $ins_id;
        $data->section_id = $section_id;
        $data->doc_type_id = 4; //doc serial number
        $data->doc_ref_id = $doc_ref_id;
        $data->track_status = 1;
        $data->reciever_desig_id = $reciever_desig_id;
        $data->sender_designation_id = $sender_designation_id;
        $data->remarks = $remarks;
        $data->created_at = Carbon::now();
        $data->updated_at = Carbon::now();
        $data->save();

        if ($desig_position->position == 7) {

            $data = Tender::find($doc_ref_id);

            if ($data) {

                $data->status = 1;
                $data->save();

                $value = new DocumentTrack();
                $value->ins_id = $ins_id;
                $value->section_id = $section_id;
                $value->doc_type_id = 4; //doc serial number
                $value->doc_ref_id = $doc_ref_id;
                $value->track_status = 2;
                $value->reciever_desig_id = $reciever_desig_id;
                $value->sender_designation_id = $sender_designation_id;
                $data->remarks = $remarks;
                $value->created_at = Carbon::now();
                $value->updated_at = Carbon::now();
                $value->save();
            }
        }

        return response()->json(['success' => 'Done']);
    }

    public function info(Request $request)
    {
        $tenderData = Tender::where('reference_no', $request->tenderRefNo)->get();

        return response()->json([
            'isSuccess' => true,
            'Message' => "Tender Data fetched successfully!",
            'Data' => $tenderData
        ], 200);
    }

    public function infoToCSR(Request $request)
    {
        $offerData = Offer::where('reference_no', $request->offerRefNo)->first();

        $itemId = $offerData->item_id;
        $itemTypeId = $offerData->item_type_id;

        $item = Items::findOrFail($itemId);
        $itemName = $item ? $item->name : 'Unknown Item';

        $itemType = Item_Type::findOrFail($itemTypeId);
        $itemTypeName = $itemType ? $itemType->name : 'Unknown Item Type';

        $indentData = Indent::where('item_id', $itemId)->where('reference_no', $offerData->indent_reference_no)->get();

        if ($indentData->isNotEmpty()) {
            $indentRefNo = $indentData[0]['reference_no'];
        } else {
            $indentRefNo = 'Indent Reference Number not found';
        }

        $tenderData = Tender::where('reference_no', $offerData->tender_reference_no)->get();

        if ($tenderData->isNotEmpty()) {
            $tenderRefNo = $tenderData[0]['reference_no'];
        } else {
            $tenderRefNo = 'Tender Reference Number not found';
        }

        $parameterGroupsExist = ParameterGroup::where('item_id', $itemId)
            ->exists();

        if ($parameterGroupsExist) {
            $supplierParameterGroups = ParameterGroup::with('supplierSpecData')
                ->where('item_id', $itemId)
                ->where('reference_no', $indentRefNo)
                ->get();

            $organizedSupplierData = $this->organizeData($supplierParameterGroups);

            $parameterGroups = ParameterGroup::with('assignParameterValues')
                ->where('item_id', $itemId)
                ->where('reference_no', $indentRefNo)
                ->get();

            $responseData = $parameterGroups->map(function ($parameterGroup) {
                $groupName = $parameterGroup->name;

                return [
                    $groupName => $parameterGroup->assignParameterValues->map(function ($parameter) {
                        return [
                            'id' => $parameter->id,
                            'parameter_name' => $parameter->parameter_name,
                            'parameter_value' => $parameter->parameter_value,
                        ];
                    })
                ];
            })->values()->all();

            foreach ($responseData as $group => &$parameterGroup) {
                if (is_array($parameterGroup)) {
                    foreach ($parameterGroup as &$parameters) {
                        for ($i = 0; $i < count($parameters); $i++) {
                            $parameter = $parameters[$i];

                            if (is_array($parameter) && isset($parameter['id'])) {
                                $parameterId = $parameter['id'];

                                if (isset($organizedSupplierData[$parameterId])) {
                                    $spValues = $organizedSupplierData[$parameterId];

                                    $newParameter = $parameter;

                                    foreach ($spValues as $index => $spValue) {
                                        $spName = Supplier::where('id', $spValue['supplier_id'])->first();
                                        $newParameter["Supplier_" . $spName->firm_name] = $spValue['parameter_value'];
                                    }

                                    $parameters[$i] = $newParameter;
                                }
                            }
                        }
                    }
                }
            }

            return response()->json([
                'isSuccess' => true,
                'message' => 'Parameters Data successfully retrieved!',
                'combinedData' => $responseData,
                'itemTypeId' => $itemTypeId,
                'itemTypeName' => $itemTypeName,
                'itemId' => $itemId,
                'itemName' => $itemName,
                'indentRefNo' => $indentRefNo,
                'tenderRefNo' => $tenderRefNo,
                'offerRefNo' => $request->offerRefNo,
            ], 200);
        } else {
            return response()->json([
                'isSuccess' => false,
                'message' => "Data not found for this Item. Please check the inputs!",
            ], 200);
        }
    }

    private function organizeData($parameterGroups)
    {
        $result = [];

        foreach ($parameterGroups as $parameterGroup) {
            foreach ($parameterGroup->supplierSpecData as $parameter) {
                $parameterId = $parameter->parameter_id;

                if (!isset($result[$parameterId])) {
                    $result[$parameterId] = [];
                }

                if ($parameter->parameter_value == null) {
                    $parameter->parameter_value = "";
                }

                $result[$parameterId][] = [
                    'parameter_value' => $parameter->parameter_value,
                    'supplier_id' => $parameter->supplier_id,
                ];
            }
        }
        return $result;
    }
}
