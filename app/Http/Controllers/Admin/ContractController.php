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
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class ContractController extends Controller
{
    //
    public function index()
    {
        return view('backend.contracts.contract_incomming_new.index');
    }

    public function getAllData(Request $request)
    {
        if ($request->ajax()) {
            $contracts = Contract::all();

            return DataTables::of($contracts)
                ->addColumn('DT_RowIndex', function ($contract) {
                    return $contract->id;
                })
                ->addColumn('ltr_no_of_contract', function ($contract) {
                    return $contract->ltr_no_of_contract;
                })
                ->addColumn('ltr_date_contract', function ($contract) {
                    return $contract->ltr_date_contract;
                })
                ->addColumn('contract_no', function ($contract) {
                    return $contract->contract_no;
                })
                ->addColumn('contract_date', function ($contract) {
                    return $contract->contract_date;
                })
                ->addColumn('contract_state', function ($contract) {
                    return $contract->contract_state;
                })
                ->addColumn('con_fin_year', function ($contract) {
                    return $contract->con_fin_year;
                })
                ->addColumn('supplier_id', function ($contract) {
                    return $contract->supplier_id;
                })
                ->addColumn('contracted_value', function ($contract) {
                    return $contract->contracted_value;
                })
                ->addColumn('delivery_schedule', function ($contract) {
                    return $contract->delivery_schedule;
                })
                ->addColumn('currency_unit', function ($contract) {
                    return $contract->currency_unit;
                })
                ->addColumn('status', function ($contract) {
                    if ($contract->status == '0') {
                        return '<span class="badge badge-success">New</span>';
                    } else {
                        return '<span class="badge badge-warning">None</span>';
                    }
                })
                ->rawColumns(['status'])
                ->addColumn('action', function ($contract) {
                    return "action";
                })
                ->make(true);
        }

        if ($request->ajax()) {

            $insp_id = Auth::user()->inspectorate_id;
            $admin_id = Auth::user()->id;
            $section_ids = AdminSection::where('admin_id', $admin_id)->pluck('sec_id')->toArray();
            $designation_id = AdminSection::where('admin_id', $admin_id)->pluck('desig_id')->first();
            $desig_position = Designation::where('id', $designation_id)->first();

            if (Auth::user()->id == 92) {
                $query = Indent::leftJoin('item_types', 'indents.item_type_id', '=', 'item_types.id')
                    ->leftJoin('dte_managments', 'indents.sender', '=', 'dte_managments.id')
                    ->leftJoin('sections', 'indents.sec_id', '=', 'sections.id')
                    ->where('indents.status', 0)
                    ->select('indents.*', 'item_types.name as item_type_name', 'indents.*', 'dte_managments.name as dte_managment_name', 'sections.name as section_name')
                    ->get();
            } elseif ($desig_position->id == 1) {
                $indentIds = Indent::leftJoin('document_tracks', 'indents.id', '=', 'document_tracks.doc_ref_id')
                    ->where('document_tracks.reciever_desig_id', $designation_id)
                    ->where('indents.insp_id', $insp_id)
                    ->where('indents.status', 0)
                    ->whereIn('indents.sec_id', $section_ids)->pluck('indents.id', 'indents.id')->toArray();

                $query = Indent::leftJoin('item_types', 'indents.item_type_id', '=', 'item_types.id')
                    ->leftJoin('dte_managments', 'indents.sender', '=', 'dte_managments.id')
                    ->leftJoin('sections', 'indents.sec_id', '=', 'sections.id')
                    ->select('indents.*', 'item_types.name as item_type_name', 'indents.*', 'dte_managments.name as dte_managment_name', 'sections.name as section_name')
                    ->where('indents.status', 0)
                    ->get();
            } else {

                $indentIds = Indent::leftJoin('document_tracks', 'indents.id', '=', 'document_tracks.doc_ref_id')
                    ->where('document_tracks.reciever_desig_id', $designation_id)
                    ->where('indents.insp_id', $insp_id)
                    ->where('indents.status', 0)
                    ->whereIn('indents.sec_id', $section_ids)->pluck('indents.id', 'indents.id')->toArray();

                $query = Indent::leftJoin('item_types', 'indents.item_type_id', '=', 'item_types.id')
                    ->leftJoin('dte_managments', 'indents.sender', '=', 'dte_managments.id')
                    ->leftJoin('sections', 'indents.sec_id', '=', 'sections.id')
                    ->select('indents.*', 'item_types.name as item_type_name', 'indents.*', 'dte_managments.name as dte_managment_name', 'sections.name as section_name')
                    ->whereIn('indents.id', $indentIds)
                    ->where('indents.status', 0)
                    ->get();


                $indentId = [];
                if ($query) {
                    foreach ($query as $indent) {
                        array_push($indentId, $indent->id);
                    }
                }

                $document_tracks_receiver_id = DocumentTrack::whereIn('doc_ref_id', $indentId)
                    ->where('reciever_desig_id', $designation_id)
                    ->first();


                //......start for showing data for receiver designation
                if (!$document_tracks_receiver_id) {
                    $query = Indent::where('id', 'no data')->get();
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
                    $designation_id = AdminSection::where('admin_id', Auth::user()->id)->pluck('desig_id')->first();
                    // dd($DocumentTrack);
                    if ($DocumentTrack) {
                        if ($designation_id  ==  $DocumentTrack->reciever_desig_id) {
                            $actionBtn = '<div class="btn-group" role="group">';

                            if ($designation_id == 3) {
                                $actionBtn .= '<a href="' . url('admin/indent/edit/' . $data->id) . '" class="edit2 ">Update</a>';
                            }
                            $actionBtn .= '<a href="' . url('admin/indent/doc_status/' . $data->id) . '" class="doc">Doc Status</a>
                            <a href="' . url('admin/indent/details/' . $data->id) . '" class="edit ">Forward</a>
                            </div>';
                        } else {
                            $actionBtn = '<div class="btn-group" role="group">';
                            if ($designation_id == 3) {
                                $actionBtn .= '<a href="' . url('admin/indent/edit/' . $data->id) . '" class="edit2 ">Update</a>';
                            }
                            $actionBtn .= '
                            <a href="' . url('admin/indent/doc_status/' . $data->id) . '" class="doc">Doc Status</a>
                            <a href="' . url('admin/indent/details/' . $data->id) . '" class="update">Forwarded</a>
                            </div>';
                        }

                        if ($designation_id  ==  $DocumentTrack->sender_designation_id) {
                            $actionBtn = '<div class="btn-group" role="group">';
                            if ($designation_id == 3) {
                                $actionBtn .= '<a href="' . url('admin/indent/edit/' . $data->id) . '" class="edit2 ">Update</a>';
                            }
                            $actionBtn .= '
                            <a href="' . url('admin/indent/doc_status/' . $data->id) . '" class="doc">Doc Status</a>
                            <a href="' . url('admin/indent/details/' . $data->id) . '" class="update">Forwarded</a>
                            </div>';
                        }
                    } else {
                        $actionBtn = '<div class="btn-group" role="group">';
                        if ($designation_id == 3) {
                            $actionBtn .= '<a href="' . url('admin/indent/edit/' . $data->id) . '" class="edit2 ">Update</a>';
                        }
                        $actionBtn .= '
                        <a href="' . url('admin/indent/doc_status/' . $data->id) . '" class="doc">Doc Status</a>
                        <a href="' . url('admin/indent/details/' . $data->id) . '" class="edit ">Forward</a>
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
}
