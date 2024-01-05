<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Additional_document;
use App\Models\AdminSection;
use App\Models\Designation;
use App\Models\DocumentTrack;
use App\Models\Dte_managment;
use App\Models\FinancialYear;
use App\Models\Indent;
use App\Models\Item_type;
use App\Models\Items;
use App\Models\ParameterGroup;
use App\Models\Qac;
use App\Models\Section;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use PDF;
use Yajra\DataTables\Facades\DataTables;

class QacController extends Controller
{
    public function index()
    {

        return view('backend.qac.qac_incomming_new.index');
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
                $query = Qac::leftJoin('item_types', 'qacs.item_type_id', '=', 'item_types.id')
                    ->leftJoin('dte_managments', 'qacs.sender_id', '=', 'dte_managments.id')
                    ->leftJoin('sections', 'qacs.section_id', '=', 'sections.id')
                    ->where('qacs.status', 0)
                    ->select('qacs.*', 'item_types.name as item_type_name', 'dte_managments.name as dte_managment_name', 'sections.name as section_name')
                    ->get();
            } elseif ($desig_position->id == 1) {

                $query = Qac::leftJoin('item_types', 'qacs.item_type_id', '=', 'item_types.id')
                    ->leftJoin('dte_managments', 'qacs.sender_id', '=', 'dte_managments.id')
                    ->leftJoin('sections', 'qacs.section_id', '=', 'sections.id')
                    ->where('qacs.inspectorate_id', $insp_id)
                    ->where('qacs.status', 0)
                    ->whereIn('qacs.section_id', $section_ids)
                    ->select('qacs.*', 'item_types.name as item_type_name', 'dte_managments.name as dte_managment_name', 'sections.name as section_name')
                    ->get();
            } else {

                $indentIds = Qac::leftJoin('document_tracks', 'qacs.id', '=', 'document_tracks.doc_ref_id')
                    ->where('document_tracks.reciever_desig_id', $designation_id)
                    ->where('qacs.inspectorate_id', $insp_id)
                    ->where('qacs.status', 0)
                    ->whereIn('qacs.sec_id', $section_ids)->pluck('qacs.id')->toArray();

                $query = Qac::leftJoin('item_types', 'qacs.item_type_id', '=', 'item_types.id')
                    ->leftJoin('dte_managments', 'qacs.sender_id', '=', 'dte_managments.id')
                    ->leftJoin('sections', 'qacs.section_id', '=', 'sections.id')
                    ->select('qacs.*', 'item_types.name as item_type_name',  'dte_managments.name as dte_managment_name', 'sections.name as section_name')
                    ->whereIn('qacs.id', $indentIds)
                    ->where('qacs.status', 0)
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
                    $query = Qac::where('id', 'no data')->get();
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
                                $actionBtn .= '<a href="' . url('admin/qac/edit/' . $data->id) . '" class="edit2 ">Update</a>';
                            }
                            $actionBtn .= '<a href="' . url('admin/qac/doc_status/' . $data->id) . '" class="doc">Doc Status</a>
                            <a href="' . url('admin/qac/details/' . $data->id) . '" class="edit ">Forward</a>
                            </div>';
                        } else {
                            $actionBtn = '<div class="btn-group" role="group">';
                            if ($DesignationId == 3) {
                                $actionBtn .= '<a href="' . url('admin/qac/edit/' . $data->id) . '" class="edit2 ">Update</a>';
                            }
                            $actionBtn .= '
                           
                            <a href="' . url('admin/qac/details/' . $data->id) . '" class="update">Forwarded</a>
                            </div>';
                        }

                        if ($DesignationId  ==  $DocumentTrack->sender_designation_id) {
                            $actionBtn = '<div class="btn-group" role="group">';
                            if ($DesignationId == 3) {
                                $actionBtn .= '<a href="' . url('admin/qac/edit/' . $data->id) . '" class="edit2 ">Update</a>';
                            }
                            $actionBtn .= '
                           
                            <a href="' . url('admin/qac/details/' . $data->id) . '" class="update">Forwarded</a>
                            </div>';
                        }
                    } else {
                        $actionBtn = '<div class="btn-group" role="group">';
                        if ($DesignationId == 3) {
                            $actionBtn .= '<a href="' . url('admin/qac/edit/' . $data->id) . '" class="edit2 ">Update</a>';
                        }
                        $actionBtn .= '
                       
                        <a href="' . url('admin/qac/details/' . $data->id) . '" class="edit ">Forward</a>
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
        return view('backend.qac.qac_incomming_new.create', compact('sections', 'item', 'dte_managments', 'additional_documnets', 'item_types', 'fin_years'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'sender' => 'required',
            'admin_section' => 'required',
            'reference_no' => 'required',
            'qac_received_date' => 'required',
            'qac_reference_date' => 'required',
        ]);

        try {
            $insp_id = Auth::user()->inspectorate_id;

            $data = new Qac();
            $data->inspectorate_id = $insp_id;
            $data->section_id = $request->admin_section;
            $data->sender_id = $request->sender;
            $data->reference_no = $request->reference_no;
            $data->item_id = $request->item_id;
            $data->item_type_id = $request->item_type_id;
            $data->received_date = $request->qac_received_date;
            $data->reference_date = $request->qac_reference_date;
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

            return response()->json(['success' => 'QAC entry created successfully']);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }
    public function edit($id)
    {
        $indent = Indent::find($id);
        $admin_id = Auth::user()->id;
        $inspectorate_id = Auth::user()->inspectorate_id;
        $section_ids = $section_ids = AdminSection::where('admin_id', $admin_id)->pluck('sec_id')->toArray();
        // $sections = Section::whereIn('id', $section_ids)->get();

        $dte_managments = Dte_managment::where('status', 1)->get();
        $additional_documnets = Additional_document::where('status', 1)->get();

        // $selected_document =$indent->additional_documents;
        $item_types = Item_type::where('status', 1)
            ->where('inspectorate_id', $inspectorate_id)
            ->whereIn('section_id', $section_ids)
            ->get();
        $item = Items::where('id', $indent->item_id)->first();
        $fin_years = FinancialYear::all();
        return view('backend.qac.qac_incomming_new.edit', compact('indent', 'item', 'dte_managments', 'additional_documnets', 'item_types', 'fin_years'));
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
        $designations = Designation::all();
        $admin_id = Auth::user()->id;
        $section_ids = $section_ids = AdminSection::where('admin_id', $admin_id)->pluck('sec_id')->toArray();

        $details = Qac::leftJoin('item_types', 'qacs.item_type_id', '=', 'item_types.id')
            ->leftJoin('dte_managments', 'qacs.sender_id', '=', 'dte_managments.id')
            ->leftJoin('items', 'qacs.item_id', '=', 'items.id')
            ->leftJoin('fin_years', 'qacs.fin_year_id', '=', 'fin_years.id')
            ->select(
                'qacs.*',
                'item_types.name as item_type_name',
                'items.name as item_name',
                'dte_managments.name as dte_managment_name',
                'fin_years.year as fin_year_name'
            )
            ->where('qacs.id', $id)
            ->first();

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


        //Start blade forward on off section....
        $DocumentTrack_hidden = DocumentTrack::where('doc_ref_id',  $details->id)->latest()->first();

        //End blade forward on off section....


        return view('backend.qac.qac_incomming_new.details', compact('details', 'designations', 'document_tracks', 'desig_id',  'auth_designation_id', 'sender_designation_id',  'DocumentTrack_hidden'));
    }

    public function qacTracking(Request $request)
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

        $doc_type_id = 7; //...... 3 for indent from indents table doc_serial.
        $doc_ref_id = $request->doc_ref_id;
        $doc_reference_number = $request->doc_reference_number;
        $remarks = $request->remarks;
        $reciever_desig_id = $request->reciever_desig_id;
        $section_id = Qac::where('reference_no', $doc_reference_number)->pluck('section_id')->first();

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
            $data = Qac::find($doc_ref_id);

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
}
