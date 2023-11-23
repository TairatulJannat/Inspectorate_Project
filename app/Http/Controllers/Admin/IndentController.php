<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Additional_document;
use App\Models\AdminSection;
use App\Models\Designation;
use App\Models\DocumentTrack;
use App\Models\Dte_managment;
use App\Models\FinancialYear;
use App\Models\Indent;
use App\Models\Item_type;
use App\Models\Items;
use App\Models\Section;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class IndentController extends Controller
{
    //
    public function index()
    {

        return view('backend.indent.index');
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
                $query = Indent::leftJoin('item_types', 'indents.item_type_id', '=', 'item_types.id')
                    ->leftJoin('dte_managments', 'indents.sender', '=', 'dte_managments.id')
                    ->leftJoin('sections', 'indents.sec_id', '=', 'sections.id')
                    ->where('indents.status', 0)
                    ->select('indents.*', 'item_types.name as item_type_name', 'indents.*', 'dte_managments.name as dte_managment_name', 'sections.name as section_name')

                    ->get();
            } elseif ($desig_position->id == 1) {

                $query = Indent::leftJoin('item_types', 'indents.item_type_id', '=', 'item_types.id')
                    ->leftJoin('dte_managments', 'indents.sender', '=', 'dte_managments.id')
                    ->leftJoin('sections', 'indents.sec_id', '=', 'sections.id')
                    ->select('indents.*', 'item_types.name as item_type_name', 'indents.*', 'dte_managments.name as dte_managment_name', 'sections.name as section_name')
                    ->where('indents.status', 0)
                    ->get();
            } else {

                $query = Indent::leftJoin('item_types', 'indents.item_type_id', '=', 'item_types.id')
                    ->leftJoin('dte_managments', 'indents.sender', '=', 'dte_managments.id')
                    ->leftJoin('sections', 'indents.sec_id', '=', 'sections.id')
                    ->select('indents.*', 'item_types.name as item_type_name', 'indents.*', 'dte_managments.name as dte_managment_name', 'sections.name as section_name')
                    ->where('indents.insp_id', $insp_id)
                    ->whereIn('indents.sec_id', $section_ids)
                    ->where('indents.status', 0)
                    ->get();

                $designation_ids = AdminSection::where('admin_id', $admin_id)->select('desig_id')->first();

                $indentId = [];
                if ($query) {
                    foreach ($query as $indent) {
                        array_push($indentId, $indent->id);
                    }
                }

                $document_tracks_receiver_ids = DocumentTrack::whereIn('doc_ref_id', $indentId)
                    ->where('reciever_desig_id', $designation_ids->desig_id)
                    ->first();

                if (!$document_tracks_receiver_ids) {
                    $query = Indent::where('id', 'no data')->get();
                }
            }

            // $query->orderBy('id', 'asc');

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
                        <a href="' . url('admin/indent/progress/' . $data->id) . '" class="edit btn btn-secondary btn-sm">Doc Status</a>
                        <a href="" class="edit btn btn-success btn-sm" disable>Completed</a>';
                    } else {
                        $actionBtn = '<div class="btn-group" role="group">
                        <a href="' . url('admin/indent/progress/' . $data->id) . '" class="edit btn btn-info btn-sm">Doc Status</a>
                        <a href="' . url('admin/indent/details/' . $data->id) . '" class="edit btn btn-secondary btn-sm">Forward</a>
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
        $additional_documnets = Additional_document::where('status', 1)->get();
        $item_types = Item_type::where('status', 1)->get();
        $item = Items::all();
        $fin_years = FinancialYear::all();
        return view('backend.indent.create', compact('sections', 'item', 'dte_managments', 'additional_documnets', 'item_types', 'fin_years'));
    }

    public function store(Request $request)
    {
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

        $data = new Indent();
        $data->insp_id = $insp_id;
        $data->sec_id = $sec_id;
        $data->sender = $request->sender;
        $data->reference_no = $request->reference_no;
        $data->indent_number = $request->indent_number;

        $data->additional_documents = $request->additional_documents;
        $data->item_id = $request->item_id;
        $data->item_type_id = $request->item_type_id;
        $data->qty = $request->qty;
        $data->estimated_value = $request->estimated_value;
        $data->indent_received_date = $request->indent_received_date;
        $data->fin_year_id = $request->fin_year_id;
        $data->attribute = $request->attribute;
        $data->spare = $request->spare;
        $data->checked_standard = $request->checked_standard == 'on' ? 0 : 1;
        $data->nomenclature = $request->nomenclature;
        $data->make = $request->make;
        $data->model = $request->model;
        $data->country_of_origin = $request->country_of_origin;
        $data->country_of_assembly = $request->country_of_assembly;

        $data->received_by = Auth::user()->id;
        $data->remark = $request->remark;
        $data->status = 0;
        $data->created_at = Carbon::now()->format('Y-m-d');
        $data->updated_at = Carbon::now()->format('Y-m-d');;

        // $data->created_by = auth()->id();
        // $data->updated_by = auth()->id();

        $data->save();

        return response()->json(['success' => 'Done']);
    }
    public function details($id)
    {


        $details = Indent::leftJoin('item_types', 'indents.item_type_id', '=', 'item_types.id')
            ->leftJoin('dte_managments', 'indents.sender', '=', 'dte_managments.id')
            ->leftJoin('additional_documents', 'indents.additional_documents', '=', 'additional_documents.id')
            ->leftJoin('fin_years', 'indents.fin_year_id', '=', 'fin_years.id')
            ->select(
                'indents.*',
                'item_types.name as item_type_name',
                'indents.*',
                'dte_managments.name as dte_managment_name',
                'additional_documents.name as additional_documents_name',
                'fin_years.name as fin_year_name'
            )
            ->where('indents.id', $id)
            ->first();


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

        if ($document_tracks->isNotEmpty()) {
            $notes = $document_tracks->last();
        }

        //End blade notes section....


        return view('backend.indent.details', compact('details', 'designations', 'document_tracks', 'desig_id', 'notes' ,'auth_designation_id'));
    }

    public function indentTracking(Request $request)
    {

        $ins_id = Auth::user()->inspectorate_id;
        $admin_id = Auth::user()->id;
        $section_ids = AdminSection::where('admin_id', $admin_id)->pluck('sec_id')->toArray();
        $doc_type_id = 3; //...... 3 for indent from indents table doc_serial.
        $doc_ref_id = $request->doc_ref_id;
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
        $data->track_status = 1;
        $data->reciever_desig_id = $reciever_desig_id;
        $data->sender_designation_id = $sender_designation_id;
        $data->remarks = $remarks;
        $data->created_at = Carbon::now();
        $data->updated_at = Carbon::now();
        $data->save();


        if ($desig_position->position == 7) {

            $data = Indent::find($doc_ref_id);

            if ($data) {

                $data->status = 1;
                $data->save();

                $value = new DocumentTrack();
                $value->ins_id = $ins_id;
                $value->section_id = $section_id;
                $value->doc_type_id = $doc_type_id;
                $value->doc_ref_id = $doc_ref_id;
                $value->track_status = 2;
                $value->reciever_desig_id = $reciever_desig_id;
                $value->sender_designation_id = $sender_designation_id;
                $value->created_at = Carbon::now();
                $value->updated_at = Carbon::now();
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
}
