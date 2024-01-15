<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
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
use App\Models\Additional_document;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class FinalSpecController extends Controller
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


        return view('backend.finalSpec.finalSpec_incomming_new.index', compact('finalSpecNew','finalSpecOnProcess','finalSpecCompleted','finalSpecDispatch'));
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
                $query = FinalSpec::leftJoin('item_types', 'final_specs.item_type_id', '=', 'item_types.id')
                    ->leftJoin('dte_managments', 'final_specs.sender', '=', 'dte_managments.id')
                    ->leftJoin('sections', 'final_specs.sec_id', '=', 'sections.id')
                    ->where('final_specs.status', 0)
                    ->select('final_specs.*', 'item_types.name as item_type_name', 'final_specs.*', 'dte_managments.name as dte_managment_name', 'sections.name as section_name')
                    ->get();
            } elseif ($desig_position->id == 1) {

                $query = FinalSpec::leftJoin('item_types', 'final_specs.item_type_id', '=', 'item_types.id')
                    ->leftJoin('dte_managments', 'final_specs.sender', '=', 'dte_managments.id')
                    ->leftJoin('sections', 'final_specs.sec_id', '=', 'sections.id')
                    ->select('final_specs.*', 'item_types.name as item_type_name', 'final_specs.*', 'dte_managments.name as dte_managment_name', 'sections.name as section_name')
                    ->where('final_specs.status', 0)
                    ->get();
            } else {

                $FinalSpecs = FinalSpec::leftJoin('document_tracks', 'final_specs.id', '=', 'document_tracks.doc_ref_id')
                    ->where('document_tracks.reciever_desig_id', $designation_id)
                    ->where('final_specs.insp_id', $insp_id)
                    ->where('final_specs.status', 0)
                    ->whereIn('final_specs.sec_id', $section_ids)->pluck('final_specs.id', 'final_specs.id')->toArray();

                $query = FinalSpec::leftJoin('item_types', 'final_specs.item_type_id', '=', 'item_types.id')
                    ->leftJoin('dte_managments', 'final_specs.sender', '=', 'dte_managments.id')
                    ->leftJoin('sections', 'final_specs.sec_id', '=', 'sections.id')
                    ->select('final_specs.*', 'item_types.name as item_type_name', 'final_specs.*', 'dte_managments.name as dte_managment_name', 'sections.name as section_name')
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

                    $DocumentTrack = DocumentTrack::where('doc_ref_id', $data->id)->where('doc_ref_id',6)->latest()->first();
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
        $finalspec = FinalSpec::find($id);
        $admin_id = Auth::user()->id;
        $inspectorate_id = Auth::user()->inspectorate_id;
        $dte_managments = Dte_managment::where('status', 1)->get();
        $item_types = Item_type::where('status', 1)->where('inspectorate_id', $inspectorate_id)->get();
        $item = Items::where('id', $finalspec->item_id)->first();
        $fin_years = FinancialYear::all();
        $suppliers = Supplier::all();
        $tender_reference_numbers = Tender::all();
        $indent_reference_numbers = Indent::all();
        $offer_reference_numbers = Offer::all();
        return view('backend.finalSpec.finalSpec_incomming_new.edit', compact('finalspec', 'item', 'dte_managments',  'item_types', 'fin_years', 'tender_reference_numbers', 'indent_reference_numbers', 'suppliers', 'offer_reference_numbers'));
    }


    public function update(Request $request)
    {
        // $insp_id = Auth::user()->inspectorate_id;
        // $sec_id = $request->admin_section;

        $data = FinalSpec::findOrFail($request->editId);
        // $data->insp_id = $insp_id;
        // $data->sec_id = $sec_id;
        $data->sender = $request->sender;
        $data->reference_no = $request->reference_no;
        $data->offer_reference_no = $request->offer_reference_no;
        $data->tender_reference_no = $request->tender_reference_no;
        $data->indent_reference_no = $request->indent_reference_no;
        $data->item_id = $request->item_id;
        $data->item_type_id = $request->item_type_id;
        $data->supplier_id = $request->supplier_id;
        $data->fin_year_id = $request->fin_year_id;
        // $data->pdf_file = $request->file('pdf_file')->store('pdf', 'public');

        if ($request->hasFile('pdf_file')) {

            $path = $request->file('pdf_file')->store('uploads', 'public');
            $data->pdf_file = $path;
        }

        $data->received_by = Auth::user()->id;
        $data->remark = $request->remark;
        $data->status = 0;
        $data->created_at = Carbon::now()->format('Y-m-d');
        $data->updated_at = Carbon::now()->format('Y-m-d');


        $data->save();

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




        //     $details->additional_documents = json_decode($details->additional_documents, true);
        //         $additional_documents_names = [];

        // if($details->additional_documents){
        //     foreach ($details->additional_documents as $document_id) {
        //         $additional_names = Additional_document::where('id', $document_id)->pluck('name')->first();

        //         array_push($additional_documents_names, $additional_names);
        //     }

        // }


        // $details->suppliers = json_decode($details->supplier_id, true);

        // $supplier_names_names = [];
        // if ($details->suppliers) {
        //     foreach ($details->suppliers as $Supplier_id) {
        //         $supplier_names = Supplier::where('id', $Supplier_id)->pluck('firm_name')->first();

        //         array_push($supplier_names_names, $supplier_names);
        //     }
        // }




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


        return view('backend.finalSpec.finalSpec_incomming_new.details', compact('details', 'designations', 'document_tracks', 'desig_id',  'auth_designation_id', 'sender_designation_id', 'DocumentTrack_hidden'));
    }

    public function finalSpecTracking(Request $request)
    {

        $ins_id = Auth::user()->inspectorate_id;
        $admin_id = Auth::user()->id;
        $section_ids = AdminSection::where('admin_id', $admin_id)->pluck('sec_id')->toArray();
        $doc_type_id = 6; //...... 5 for indent from offers table doc_serial.
        $doc_ref_id = $request->doc_ref_id;
        $doc_reference_number = $request->doc_reference_number;
        $remarks = $request->remarks;
        $reciever_desig_id = $request->reciever_desig_id;
        $section_id = FinalSpec::where('reference_no', $doc_reference_number)->pluck('sec_id')->first();
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
        $offer = Offer::where('reference_no' ,$offerReferenceNo)->first();
// dd($offer);
        $item=Items::where('id' , $offer->item_id)->first();
        $item_type=Item_type::where('id' , $offer->item_type_id)->first();
        $tender_reference_no = Tender::where('reference_no',$offer->tender_reference_no)->first();
        
        $indent_reference_no = Indent::where('reference_no',$offer->indent_reference_no)->first();
        
        $offer->suppliers = json_decode($offer->supplier_id, true);
     
    
        $suppliers = Supplier::whereIn('id',  $offer->suppliers)->get();
        
        return response()->json(['item' =>$item, 'itemType' =>$item_type,'tenderReferenceNo'=>$tender_reference_no,'indentReferenceNo'=> $indent_reference_no,'suppliernames'=> $suppliers]);

    }
}