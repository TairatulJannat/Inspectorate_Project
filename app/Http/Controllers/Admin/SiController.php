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

class SiController extends Controller
{
    //

    public function index()
    {
        $insp_id = Auth::user()->inspectorate_id;
        $admin_id = Auth::user()->id;
        $section_ids = AdminSection::where('admin_id', $admin_id)->pluck('sec_id')->toArray();
        $designation_id = AdminSection::where('admin_id', $admin_id)->pluck('desig_id')->first();
        $desig_position = Designation::where('id', $designation_id)->first();

        if ($designation_id == 1 || $designation_id == 0) {
            $siNew = DraftContract::where('status', 0)->count();
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

        // $this->validate($request, [
        //     'sender' => 'required',
        //     'admin_section' => 'required',
        //     'reference_no' => 'required',
        //     'draft_contract_received_date' => 'required',
        //     'draft_contract_reference_date' => 'required',
        // ]);

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
}