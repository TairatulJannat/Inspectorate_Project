<?php

namespace App\Http\Controllers\Admin;

use PDF;
use Carbon\Carbon;
use App\Models\Items;
use App\Models\Indent;
use App\Models\Section;
use App\Models\Contract;
use App\Models\Item_type;
use App\Models\Designation;
use App\Models\AdminSection;
use Illuminate\Http\Request;
use App\Models\DocumentTrack;
use App\Models\Dte_managment;
use App\Models\FinancialYear;
use App\Models\ParameterGroup;
use Illuminate\Support\Facades\DB;
use App\Models\Additional_document;
use App\Http\Controllers\Controller;
use App\Models\ContractProgress;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class ContractController extends Controller
{
    public function index()
    {
        $insp_id = Auth::user()->inspectorate_id;
        $admin_id = Auth::user()->id;
        $section_ids = AdminSection::where('admin_id', $admin_id)->pluck('sec_id')->toArray();
        $designation_id = AdminSection::where('admin_id', $admin_id)->pluck('desig_id')->first();
        $desig_position = Designation::where('id', $designation_id)->first();

        if ($designation_id == 1 || $designation_id == 0) {
            $contractNew = Contract::where('status', 0)->count();
            $contractOnProcess = '0';
            $contractCompleted = '0';
            $contractDispatch = DocumentTrack::where('doc_type_id', 3)
                ->leftJoin('contracts', 'document_tracks.doc_ref_id', '=', 'contracts.id')
                ->where('reciever_desig_id', $designation_id)
                ->where('track_status', 4)
                ->where('contracts.status', 4)
                ->whereIn('document_tracks.section_id', $section_ids)
                ->count();
        } else {

            $contractNew = DocumentTrack::where('doc_type_id', 3)
                ->leftJoin('contracts', 'document_tracks.doc_ref_id', '=', 'contracts.id')
                ->where('reciever_desig_id', $designation_id)
                ->where('track_status', 1)
                ->where('contracts.status', 0)
                ->whereIn('document_tracks.section_id', $section_ids)
                ->count();

            $contractOnProcess = DocumentTrack::where('doc_type_id', 3)
                ->leftJoin('contracts', 'document_tracks.doc_ref_id', '=', 'contracts.id')
                ->where('reciever_desig_id', $designation_id)
                ->where('track_status', 3)
                ->where('contracts.status', 3)
                ->whereIn('document_tracks.section_id', $section_ids)
                ->count();

            $contractCompleted = DocumentTrack::where('doc_type_id', 3)
                ->leftJoin('contracts', 'document_tracks.doc_ref_id', '=', 'contracts.id')
                ->where('reciever_desig_id', $designation_id)
                ->where('track_status', 2)
                ->where('contracts.status', 1)
                ->whereIn('document_tracks.section_id', $section_ids)
                ->count();

            $contractDispatch = DocumentTrack::where('doc_type_id', 3)
                ->leftJoin('contracts', 'document_tracks.doc_ref_id', '=', 'contracts.id')
                ->where('reciever_desig_id', $designation_id)
                ->where('track_status', 4)
                ->where('contracts.status', 4)
                ->whereIn('document_tracks.section_id', $section_ids)
                ->count();
        }
        return view('backend.contracts.contract_incomming_new.index', compact('contractNew', 'contractOnProcess', 'contractCompleted', 'contractDispatch'));
    }

    public function getAllData(Request $request)
    {
        if ($request->ajax()) {

            $insp_id = Auth::user()->inspectorate_id;
            $admin_id = Auth::user()->id;
            $section_ids = AdminSection::where('admin_id', $admin_id)->pluck('sec_id')->toArray();
            $designation_id = AdminSection::where('admin_id', $admin_id)->pluck('desig_id')->first();
            $desig_position = Designation::where('id', $designation_id)->first();

            if (Auth::user()->id == 92) {
                $query = Contract::leftJoin('item_types', 'contracts.item_type_id', '=', 'item_types.id')
                    ->leftJoin('dte_managments', 'contracts.sender', '=', 'dte_managments.id')
                    ->leftJoin('sections', 'contracts.sec_id', '=', 'sections.id')
                    ->where('contracts.status', 0)
                    ->select('contracts.*', 'item_types.name as item_type_name', 'contracts.*', 'dte_managments.name as dte_managment_name', 'sections.name as section_name')
                    ->get();
            } elseif ($desig_position->id == 1) {
                $contractIds = Contract::leftJoin('document_tracks', 'contracts.id', '=', 'document_tracks.doc_ref_id')
                    ->where('document_tracks.reciever_desig_id', $designation_id)
                    ->where('contracts.insp_id', $insp_id)
                    ->where('contracts.status', 0)
                    ->whereIn('contracts.sec_id', $section_ids)->pluck('contracts.id', 'contracts.id')->toArray();

                $query = Contract::leftJoin('item_types', 'contracts.item_type_id', '=', 'item_types.id')
                    ->leftJoin('dte_managments', 'contracts.sender', '=', 'dte_managments.id')
                    ->leftJoin('sections', 'contracts.sec_id', '=', 'sections.id')
                    ->select('contracts.*', 'item_types.name as item_type_name', 'contracts.*', 'dte_managments.name as dte_managment_name', 'sections.name as section_name')
                    ->where('contracts.status', 0)
                    ->get();
            } else {
                $contractIds = Contract::leftJoin('document_tracks', 'contracts.id', '=', 'document_tracks.doc_ref_id')
                    ->where('document_tracks.reciever_desig_id', $designation_id)
                    ->where('contracts.insp_id', $insp_id)
                    ->where('contracts.status', 0)
                    ->whereIn('contracts.sec_id', $section_ids)->pluck('contracts.id', 'contracts.id')->toArray();

                $query = Contract::leftJoin('item_types', 'contracts.item_type_id', '=', 'item_types.id')
                    ->leftJoin('dte_managments', 'contracts.sender', '=', 'dte_managments.id')
                    ->leftJoin('sections', 'contracts.sec_id', '=', 'sections.id')
                    ->select('contracts.*', 'item_types.name as item_type_name', 'contracts.*', 'dte_managments.name as dte_managment_name', 'sections.name as section_name')
                    ->whereIn('contracts.id', $contractIds)
                    ->where('contracts.status', 0)
                    ->get();

                $contractId = [];
                if ($query) {
                    foreach ($query as $contract) {
                        array_push($contractId, $contract->id);
                    }
                }

                $document_tracks_receiver_id = DocumentTrack::whereIn('doc_ref_id', $contractId)
                    ->where('reciever_desig_id', $designation_id)
                    ->first();


                //......start for showing data for receiver designation
                if (!$document_tracks_receiver_id) {
                    $query = Contract::where('id', 'no data')->get();
                }
                //......End for showing data for receiver designation
            }

            return DataTables::of($query)
                ->setTotalRecords($query->count())
                ->addIndexColumn()
                ->addColumn('status', function ($contract) {
                    if ($contract->status == '0') {
                        return '<span class="badge badge-success">New</span>';
                    } else {
                        return '<span class="badge badge-warning">None</span>';
                    }
                })
                ->addColumn('action', function ($contract) {
                    $DocumentTrack = DocumentTrack::where('doc_ref_id', $contract->id)->latest()->first();
                    $designation_id = AdminSection::where('admin_id', Auth::user()->id)->pluck('desig_id')->first();
                    if ($DocumentTrack) {
                        if ($designation_id  ==  $DocumentTrack->reciever_desig_id) {
                            $actionBtn = '<div class="btn-group" role="group">';

                            if ($designation_id == 3) {
                                $actionBtn .= '<a href="' . url('admin/contract/edit/' . $contract->id) . '" class="edit2 ">Update</a>';
                            }
                            $actionBtn .= '<a href="' . url('admin/contract/index-doc/' . $contract->id) . '" class="doc">Doc Status</a>
                            <a href="' . url('admin/contract/details/' . $contract->id) . '" class="edit ">Forward</a>
                            </div>';
                        } else {
                            $actionBtn = '<div class="btn-group" role="group">';
                            if ($designation_id == 3) {
                                $actionBtn .= '<a href="' . url('admin/contract/edit/' . $contract->id) . '" class="edit2 ">Update</a>';
                            }
                            $actionBtn .= '
                            <a href="' . url('admin/contract/index-doc/' . $contract->id) . '" class="doc">Doc Status</a>
                            <a href="' . url('admin/contract/details/' . $contract->id) . '" class="update">Forwarded</a>
                            </div>';
                        }

                        if ($designation_id  ==  $DocumentTrack->sender_designation_id) {
                            $actionBtn = '<div class="btn-group" role="group">';
                            if ($designation_id == 3) {
                                $actionBtn .= '<a href="' . url('admin/contract/edit/' . $contract->id) . '" class="edit2 ">Update</a>';
                            }
                            $actionBtn .= '
                            <a href="' . url('admin/contract/index-doc/' . $contract->id) . '" class="doc">Doc Status</a>
                            <a href="' . url('admin/contract/details/' . $contract->id) . '" class="update">Forwarded</a>
                            </div>';
                        }
                    } else {
                        $actionBtn = '<div class="btn-group" role="group">';
                        if ($designation_id == 3) {
                            $actionBtn .= '<a href="' . url('admin/contract/edit/' . $contract->id) . '" class="edit2 ">Update</a>';
                        }
                        $actionBtn .= '
                        <a href="' . url('admin/contract/index-doc/' . $contract->id) . '" class="doc">Doc Status</a>
                        <a href="' . url('admin/contract/details/' . $contract->id) . '" class="edit ">Forward</a>
                        </div>';
                    }
                    return $actionBtn;
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        }
    }

    public function create()
    {
        $admin_id = Auth::user()->id;
        $inspectorate_id = Auth::user()->inspectorate_id;
        $section_ids = AdminSection::where('admin_id', $admin_id)->pluck('sec_id')->toArray();
        $sections = Section::whereIn('id', $section_ids)->get();
        $dte_managments = Dte_managment::where('status', 1)->get();
        $item_types = Item_type::where('status', 1)->where('inspectorate_id', $inspectorate_id)->get();
        $item = Items::all();
        $fin_years = FinancialYear::all();
        return view('backend.contracts.contract_incomming_new.create', compact('sections', 'item', 'dte_managments', 'item_types', 'fin_years'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'sender' => 'required',
            'admin-section' => 'required',
            'ltr-no-contract' => 'required',
            'ltr-date-contract' => 'required',
            'contract-reference-no' => 'required',
            'contract-number' => 'required',
            'contract-date' => 'required',
            'received-by' => 'required',
        ], [
            'sender.required' => 'Please select Sender',
            'admin-section.required' => 'Please select Admin Section',
            'ltr-no-contract.required' => 'Please enter letter Number of Contract',
            'ltr-date-contract.required' => 'Please select letter Date of Contract',
            'contract-reference-no.required' => 'Please enter Contract Reference Number',
            'contract-number.required' => 'Please select Contract Number',
            'contract-date.required' => 'Please select Contract Date',
            'received-by.required' => 'Please select Received By',
        ]);

        DB::beginTransaction();

        try {
            $formData = $request->all();

            $inspId = Auth::user()->inspectorate_id;
            $secId = $formData['admin-section'];

            $contractData = new Contract();
            $contractData->insp_id = $inspId;
            $contractData->sec_id = $secId;
            $contractData->sender = $formData['sender'];
            $contractData->ltr_no_of_contract = $formData['ltr-no-contract'];
            $contractData->ltr_date_contract = $formData['ltr-date-contract'];
            $contractData->reference_no = $formData['contract-reference-no'];
            $contractData->contract_no = $formData['contract-number'];
            $contractData->contract_date = $formData['contract-date'];
            $contractData->received_by = Auth::user()->id;
            $contractData->status = 0;
            $contractData->created_at = Carbon::now()->format('Y-m-d');
            $contractData->updated_at = Carbon::now()->format('Y-m-d');

            $contractData->save();

            DB::commit();

            return response()->json([
                'isSuccess' => true,
                'Message' => "Contract saved successfully!"
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'isSuccess' => false,
                'Message' => "Something went wrong!",
                'error' => $e->getMessage()
            ], 200);
        }
    }

    public function edit($id)
    {
        $indent = Indent::find($id);
        $admin_id = Auth::user()->id;
        $inspectorate_id = Auth::user()->inspectorate_id;
        // $section_ids = $section_ids = AdminSection::where('admin_id', $admin_id)->pluck('sec_id')->toArray();
        // $sections = Section::whereIn('id', $section_ids)->get();

        $dte_managments = Dte_managment::where('status', 1)->get();
        $additional_documnets = Additional_document::where('status', 1)->get();

        // $selected_document =$indent->additional_documents;
        // dd( $selected_document);
        $item_types = Item_type::where('status', 1)->where('inspectorate_id', $inspectorate_id)->get();
        $item = Items::where('id', $indent->item_id)->first();
        $fin_years = FinancialYear::all();
        return view('backend.indent.indent_incomming_new.edit', compact('indent', 'item', 'dte_managments', 'additional_documnets', 'item_types', 'fin_years'));
    }

    public function update(Request $request)
    {

        $data = Indent::findOrFail($request->editId);

        $data->sender = $request->sender;
        $data->reference_no = $request->reference_no;
        $data->indent_number = $request->indent_number;

        $data->additional_documents = json_encode($request->additional_documents);
        $data->item_id = $request->item_id;
        $data->item_type_id = $request->item_type_id;
        $data->qty = $request->qty;
        $data->estimated_value = $request->estimated_value;
        $data->indent_received_date = $request->indent_received_date;
        $data->indent_reference_date = $request->indent_reference_date;
        $data->fin_year_id = $request->fin_year_id;
        $data->attribute = $request->attribute;
        $data->spare = $request->spare;
        $data->checked_standard = $request->checked_standard;
        $data->nomenclature = $request->nomenclature;
        $data->make = $request->make;
        $data->model = $request->model;
        $data->country_of_origin = $request->country_of_origin;
        $data->country_of_assembly = $request->country_of_assembly;
        $data->remark = $request->remark;
        $data->updated_by = Auth::user()->id;

        $data->updated_at = Carbon::now()->format('Y-m-d');

        if ($request->hasFile('doc_file')) {

            $path = $request->file('doc_file')->store('uploads', 'public');
            $data->doc_file = $path;
        }

        // $data->created_by = auth()->id();
        // $data->updated_by = auth()->id();

        $data->save();

        return response()->json(['success' => 'Done']);
    }

    public function details($id)
    {
        $details = Indent::leftJoin('item_types', 'indents.item_type_id', '=', 'item_types.id')
            ->leftJoin('dte_managments', 'indents.sender', '=', 'dte_managments.id')
            ->leftJoin('items', 'indents.item_id', '=', 'items.id')
            ->leftJoin('additional_documents', 'indents.additional_documents', '=', 'additional_documents.id')
            ->leftJoin('fin_years', 'indents.fin_year_id', '=', 'fin_years.id')
            ->select(
                'indents.*',
                'item_types.name as item_type_name',
                'items.name as item_name',
                'indents.*',
                'dte_managments.name as dte_managment_name',
                'additional_documents.name as additional_documents_name',
                'fin_years.year as fin_year_name'
            )
            ->where('indents.id', $id)
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
            ->leftJoin('designations as sender_designation', 'document_tracks.sender_designation_id', '=', 'sender_designation.id')
            ->leftJoin('designations as receiver_designation', 'document_tracks.reciever_desig_id', '=', 'receiver_designation.id')
            ->where('track_status', 1)
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

        //Start blade notes section....
        $notes = '';

        $document_tracks_notes = DocumentTrack::where('doc_ref_id', $details->id)
            ->where('track_status', 1)
            ->where('reciever_desig_id', $desig_id)->get();

        if ($document_tracks_notes->isNotEmpty()) {
            $notes = $document_tracks_notes;
        }

        //End blade notes section....

        //Start blade forward on off section....
        $DocumentTrack_hidden = DocumentTrack::where('doc_ref_id',  $details->id)->latest()->first();

        //End blade forward on off section....

        return view('backend.indent.indent_incomming_new.details', compact('details', 'designations', 'document_tracks', 'desig_id', 'notes', 'auth_designation_id', 'sender_designation_id', 'additional_documents_names', 'DocumentTrack_hidden'));
    }

    public function indentTracking(Request $request)
    {
        $ins_id = Auth::user()->inspectorate_id;
        $admin_id = Auth::user()->id;
        $section_ids = AdminSection::where('admin_id', $admin_id)->pluck('sec_id')->toArray();
        $doc_type_id = 3; //...... 3 for indent from indents table doc_serial.
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
        $data->track_status = 1;
        $data->reciever_desig_id = $reciever_desig_id;
        $data->sender_designation_id = $sender_designation_id;
        $data->remarks = $remarks;
        $data->created_at = Carbon::now('Asia/Dhaka');
        $data->updated_at = Carbon::now('Asia/Dhaka');
        $data->save();

        if ($desig_position->position == 7) {

            $data = Indent::find($doc_ref_id);

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

    public function progress()
    {
        return view('backend.indent.progress');
    }

    public function parameter(Request $request)
    {
        $indent = Indent::find($request->indent_id);
        $item_id = $indent->item_id;
        $item_type_id = $indent->item_type_id;
        return view('backend.indent.parameter', compact('item_id', 'item_type_id'));
    }

    public function parameterPdf(Request $request)
    {
        $indent = Indent::find($request->indent_id);
        $item_id = $indent->item_id;
        $item_type_id = $indent->item_type_id;

        $item = Items::find($item_id);
        $itemName = $item ? $item->name : 'Unknown Item';

        $itemType = Item_Type::find($item_type_id);
        $itemTypeName = $itemType ? $itemType->name : 'Unknown Item Type';
        $parameterGroups = ParameterGroup::with('assignParameterValues')
            ->where('item_id', $item_id)
            ->get();
        dd($parameterGroups);

        // if ( $item_id ) {
        //     $pdf = PDF::loadView('backend.pdf.cover_letter',  ['cover_letter' => $cover_letter])->setPaper('a4');
        //     return $pdf->stream('cover_letter.pdf');
        // }

    }

    public function indexDoc($id)
    {
        $contractId = $id;
        $additional_documents = Additional_document::all();
        return view('backend.contracts.documents.index', compact('contractId', 'additional_documents'));
    }

    public function getAllDataDoc(Request $request)
    {
        $query = ContractProgress::where('contract_id', $request->contractId)
            ->leftJoin('additional_documents', 'contract_progress.additional_doc_type_id', '=', 'additional_documents.id')
            ->select('contract_progress.*', 'additional_documents.name as additional_documents_name')
            ->get();

        return DataTables::of($query)
            ->setTotalRecords($query->count())
            ->addIndexColumn()
            ->addColumn('receive_status', function ($data) {
                if ($data->receive_status == '0') {
                    return '<span class="badge badge-success">Received</span>';
                }
                if ($data->receive_status == '1') {
                    return '<span class="badge badge-warning">Not Received</span>';
                }
            })
            ->addColumn('action', function ($data) {
                $actionBtn = '<div class="" role="group">
                        <a href="javascript:void(0)" class="edit_doc btn btn-secondary-gradien btn-sm fa fa-edit" data-id="' . $data->id . '"  data-bs-toggle="modal"
                        data-bs-target="#editContractModal"> Edit</a>
                        <a href="javascript:void(0)" class="delete btn btn-danger-gradien btn-sm fa fa-trash-o" onclick="delete_data(' . $data->id . ')"> Delete</a>
                        </div>';
                return $actionBtn;
            })
            ->rawColumns(['receive_status', 'action'])
            ->make(true);
    }

    public function storeDoc(Request $request)
    {
        $this->validate($request, [
            'additionalDocTypeId' => 'required',
            'duration' => 'required',
            'member' => 'required',
        ], [
            'additionalDocTypeId.required' => 'Please select Document Type',
            'duration.required' => 'Please select Duration',
            'member.required' => 'Please select Member Number',
        ]);

        DB::beginTransaction();

        try {
            $formData = $request->all();

            $data = new ContractProgress();
            $data->contract_id = $formData['contractId'];
            $data->additional_doc_type_id = $formData['additionalDocTypeId'];
            $data->duration = $formData['duration'];
            $data->receive_status = $request->receiveStatus == "on" ? 1 : 0;
            $data->receive_date = $request->receiveDate ? Carbon::parse($request->receiveDate)->toDateTimeString() : null;
            $data->asking_date = $request->askingDate ? Carbon::parse($request->askingDate)->toDateTimeString() : null;
            $data->member = $formData['member'];
            $data->created_at = Carbon::now()->format('Y-m-d');
            $data->updated_at = Carbon::now()->format('Y-m-d');

            $data->save();

            DB::commit();

            return response()->json([
                'isSuccess' => true,
                'Message' => "Additional Document saved successfully!"
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'isSuccess' => false,
                'Message' => "Something went wrong!",
                'error' => $e->getMessage()
            ], 200);
        }
    }
}
