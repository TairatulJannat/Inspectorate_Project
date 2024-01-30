<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Items;
use App\Models\Offer;
use App\Models\Indent;
use App\Models\Tender;
use App\Models\Section;
use App\Models\Supplier;
use App\Models\Item_type;
use App\Models\Designation;
use App\Models\AdminSection;
use Illuminate\Http\Request;
use App\Models\DocumentTrack;
use App\Models\Dte_managment;
use App\Models\FinancialYear;
use App\Models\Additional_document;
use App\Http\Controllers\Controller;
use App\Models\File;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class OfferController extends Controller
{
    //
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
            $offerNew = Offer::where('status', 0)->count();
            $offerOnProcess = '0';
            $offerCompleted = '0';
            $offerDispatch = DocumentTrack::where('doc_type_id', 5)
                ->leftJoin('offers', 'document_tracks.doc_ref_id', '=', 'offers.id')
                ->where('reciever_desig_id', $designation_id)
                ->where('track_status', 4)
                ->where('offers.status', 4)
                ->whereIn('document_tracks.section_id', $section_ids)
                ->count();
        } else {

            $offerNew = DocumentTrack::where('doc_type_id', 5)
                ->leftJoin('offers', 'document_tracks.doc_ref_id', '=', 'offers.id')
                ->where('reciever_desig_id', $designation_id)
                ->where('track_status', 1)
                ->where('offers.status', 0)
                ->whereIn('document_tracks.section_id', $section_ids)
                ->count();

            $offerOnProcess = DocumentTrack::where('doc_type_id', 5)
                ->leftJoin('offers', 'document_tracks.doc_ref_id', '=', 'offers.id')
                ->where('reciever_desig_id', $designation_id)
                ->where('track_status', 3)
                ->where('offers.status', 3)
                ->whereIn('document_tracks.section_id', $section_ids)
                ->count();

            $offerCompleted = DocumentTrack::where('doc_type_id', 5)
                ->leftJoin('offers', 'document_tracks.doc_ref_id', '=', 'offers.id')
                ->where('reciever_desig_id', $designation_id)
                ->where('track_status', 2)
                ->where('offers.status', 1)
                ->whereIn('document_tracks.section_id', $section_ids)
                ->count();

            $offerDispatch = DocumentTrack::where('doc_type_id', 5)
                ->leftJoin('offers', 'document_tracks.doc_ref_id', '=', 'offers.id')
                ->where('reciever_desig_id', $designation_id)
                ->where('track_status', 4)
                ->where('offers.status', 4)
                ->whereIn('document_tracks.section_id', $section_ids)
                ->count();
        }
        return view('backend.offer.offer_incomming_new.index', compact('offerNew', 'offerOnProcess', 'offerCompleted', 'offerDispatch'));
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
                $query = Offer::leftJoin('items', 'offers.item_id', '=', 'items.id')
                    ->leftJoin('dte_managments', 'offers.sender', '=', 'dte_managments.id')
                    ->leftJoin('sections', 'offers.sec_id', '=', 'sections.id')
                    ->where('offers.status', 0)
                    ->select('offers.*', 'items.name as item_name', 'offers.*', 'dte_managments.name as dte_managment_name', 'sections.name as section_name')
                    ->get();
            } elseif ($desig_position->id == 1) {
                $query = Offer::leftJoin('items', 'offers.item_id', '=', 'items.id')
                    ->leftJoin('dte_managments', 'offers.sender', '=', 'dte_managments.id')
                    ->leftJoin('sections', 'offers.sec_id', '=', 'sections.id')
                    ->select('offers.*', 'items.name as item_name', 'offers.*', 'dte_managments.name as dte_managment_name', 'sections.name as section_name')
                    ->where('offers.status', 0)
                    ->get();
            } else {
                $offerIds = Offer::leftJoin('document_tracks', 'offers.id', '=', 'document_tracks.doc_ref_id')
                    ->where('document_tracks.reciever_desig_id', $designation_id)
                    ->where('offers.insp_id', $insp_id)
                    ->where('offers.status', 0)
                    ->whereIn('offers.sec_id', $section_ids)->pluck('offers.id', 'offers.id')->toArray();

                $query = Offer::leftJoin('items', 'offers.item_id', '=', 'items.id')
                    ->leftJoin('dte_managments', 'offers.sender', '=', 'dte_managments.id')
                    ->leftJoin('sections', 'offers.sec_id', '=', 'sections.id')
                    ->select('offers.*', 'items.name as item_name', 'offers.*', 'dte_managments.name as dte_managment_name', 'sections.name as section_name')
                    ->whereIn('offers.id', $offerIds)
                    ->where('offers.status', 0)
                    ->get();

                //......Start for DataTable Forward and Details btn change
                $offerId = [];
                if ($query) {
                    foreach ($query as $offer) {
                        array_push($offerId, $offer->id);
                    }
                }

                $document_tracks_receiver_id = DocumentTrack::whereIn('doc_ref_id', $offerId)
                    ->where('reciever_desig_id', $designation_id)
                    ->first();

                if (!$document_tracks_receiver_id) {
                    $query = Offer::where('id', 'no data')->get();
                }
                //......End for showing data for receiver designation
            }

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

                    $DocumentTrack = DocumentTrack::where('doc_ref_id', $data->id)->where('doc_ref_id', 5)->latest()->first();

                    $designation_id = AdminSection::where('admin_id', Auth::user()->id)->pluck('desig_id')->first();
                    // dd($DocumentTrack);
                    if ($DocumentTrack) {
                        if ($designation_id  ==  $DocumentTrack->reciever_desig_id) {
                            $actionBtn = '<div class="btn-group" role="group">';

                            if ($designation_id == 3) {
                                $actionBtn .= '<a href="' . url('admin/offer/edit/' . $data->id) . '" class="edit2 ">Update</a>';
                            }

                            $actionBtn .= '<a href="' . url('admin/offfer/details/' . $data->id) . '" class="edit ">Forward</a>

                            </div>';
                        } else {
                            $actionBtn = '<div class="btn-group" role="group">';

                            if ($designation_id == 3) {
                                $actionBtn .= '<a href="' . url('admin/offer/edit/' . $data->id) . '" class="edit2 ">Update</a>';
                            }

                            $actionBtn .= ' <a href="' . url('admin/offfer/details/' . $data->id) . '" class="update">Forwarded</a>

                            </div>';
                        }

                        if ($designation_id  ==  $DocumentTrack->sender_designation_id) {
                            $actionBtn = '<div class="btn-group" role="group">';

                            if ($designation_id == 3) {
                                $actionBtn .= '<a href="' . url('admin/offer/edit/' . $data->id) . '" class="edit2 ">Update</a>';
                            }

                            $actionBtn .= ' <a href="' . url('admin/offfer/details/' . $data->id) . '" class="update">Forwarded</a>

                            </div>';
                        }
                    } else {
                        $actionBtn = '<div class="btn-group" role="group">';

                        if ($designation_id == 3) {
                            $actionBtn .= '<a href="' . url('admin/offer/edit/' . $data->id) . '" class="edit2 ">Update</a>';
                        }

                        $actionBtn .= ' <a href="' . url('admin/offfer/details/' . $data->id) . '" class="edit ">Forward</a>

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
        $suppliers = Supplier::all();
        $tender_reference_numbers = Tender::all();
        $indent_reference_numbers = Indent::all();
        return view('backend.offer.offer_incomming_new.create', compact('sections', 'item', 'dte_managments', 'additional_documnets', 'item_types', 'fin_years', 'suppliers', 'tender_reference_numbers', 'indent_reference_numbers'));
    }

    public function store(Request $request)
    {
        $insp_id = Auth::user()->inspectorate_id;
        $sec_id = $request->admin_section;
        $data = new Offer();
        $data->insp_id = $insp_id;
        $data->sec_id = $sec_id;
        $data->sender = $request->sender;
        $data->reference_no = $request->reference_no;
        $data->offer_reference_date = $request->offer_reference_date;
        $data->tender_reference_no = $request->tender_reference_no;
        $data->indent_reference_no = $request->indent_reference_no;
        $data->attribute = $request->attribute;
        $data->additional_documents = json_encode($request->additional_documents);
        $data->item_id = $request->item_id;
        $data->item_type_id = $request->item_type_id;
        $data->qty = $request->qty;
        $data->supplier_id = json_encode($request->supplier_id);
        $data->offer_rcv_ltr_dt = $request->offer_rcv_ltr_dt;
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
        $offer = Offer::find($id);
        $admin_id = Auth::user()->id;
        $inspectorate_id = Auth::user()->inspectorate_id;
        $dte_managments = Dte_managment::where('status', 1)->get();
        $additional_documnets = Additional_document::where('status', 1)->get();
        $item_types = Item_type::where('status', 1)->where('inspectorate_id', $inspectorate_id)->get();
        $item = Items::where('id', $offer->item_id)->first();
        $fin_years = FinancialYear::all();
        $suppliers = Supplier::all();
        $tender_reference_numbers = Tender::all();
        $indent_reference_numbers = Indent::all();
        return view('backend.offer.offer_incomming_new.edit', compact('offer', 'item', 'dte_managments', 'additional_documnets', 'item_types', 'fin_years', 'tender_reference_numbers', 'indent_reference_numbers', 'suppliers'));
    }

    public function update(Request $request)
    {
        $data = Offer::findOrFail($request->editId);
        $data->sender = $request->sender;
        $data->reference_no = $request->reference_no;
        $data->offer_reference_date = $request->offer_reference_date;
        $data->tender_reference_no = $request->tender_reference_no;
        $data->indent_reference_no = $request->indent_reference_no;
        $data->attribute = $request->attribute;
        $data->additional_documents = json_encode($request->additional_documents);
        $data->item_id = $request->item_id;
        $data->item_type_id = $request->item_type_id;
        $data->qty = $request->qty;
        $data->supplier_id = json_encode($request->supplier_id);
        // $data->offer_rcv_ltr_dt = $request->offer_rcv_ltr_dt;
        $data->fin_year_id = $request->fin_year_id;

        // $data->pdf_file = $request->file('pdf_file')->store('pdf', 'public');

        $data->received_by = Auth::user()->id;
        $data->remark = $request->remark;
        $data->status = 0;
        $data->created_at = Carbon::now()->format('Y-m-d');
        $data->updated_at = Carbon::now()->format('Y-m-d');;

        $data->save();

        //Multipule File Upload in files table
        $save_id = $data->id;
        if ($save_id) {
            $this->fileController->SaveFile($data->insp_id, $data->sec_id, $request->file_name, $request->file, 5,  $request->reference_no);
        }

        return response()->json(['success' => 'Done']);
    }

    public function details($id)
    {
        $details = Offer::leftJoin('item_types', 'offers.item_type_id', '=', 'item_types.id')
            ->leftJoin('dte_managments', 'offers.sender', '=', 'dte_managments.id')
            ->leftJoin('additional_documents', 'offers.additional_documents', '=', 'additional_documents.id')
            ->leftJoin('fin_years', 'offers.fin_year_id', '=', 'fin_years.id')
            ->leftJoin('suppliers', 'offers.supplier_id', '=', 'suppliers.id')
            ->select(
                'offers.*',
                'item_types.name as item_type_name',
                'offers.*',
                'dte_managments.name as dte_managment_name',
                'additional_documents.name as additional_documents_name',
                'fin_years.year as fin_year_name',
                'suppliers.firm_name as suppliers_name'
            )
            ->where('offers.id', $id)
            ->first();
        // Attached File
        $files = File::where('doc_type_id', 5)->where('reference_no', $details->reference_no)->get();
        // Attached File End
        $details->additional_documents = json_decode($details->additional_documents, true);
        $additional_documents_names = [];

        if ($details->additional_documents) {
            foreach ($details->additional_documents as $document_id) {
                $additional_names = Additional_document::where('id', $document_id)->pluck('name')->first();

                array_push($additional_documents_names, $additional_names);
            }
        }


        $details->suppliers = json_decode($details->supplier_id, true);

        $supplier_names_names = [];
        if ($details->suppliers) {
            foreach ($details->suppliers as $Supplier_id) {
                $supplier_names = Supplier::where('id', $Supplier_id)->pluck('firm_name')->first();

                array_push($supplier_names_names, $supplier_names);
            }
        }

        $designations = Designation::all();
        $admin_id = Auth::user()->id;
        $section_ids = $section_ids = AdminSection::where('admin_id', $admin_id)->pluck('sec_id')->toArray();

        $document_tracks = DocumentTrack::where('doc_ref_id', $details->id)
            ->leftJoin('designations as sender_designation', 'document_tracks.sender_designation_id', '=', 'sender_designation.id')
            ->leftJoin('designations as receiver_designation', 'document_tracks.reciever_desig_id', '=', 'receiver_designation.id')
            ->where('track_status', 1)
            ->where('doc_type_id', 5)
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
        $DocumentTrack_hidden = DocumentTrack::where('doc_ref_id',  $details->id)->where('doc_type_id', 5)->latest()->first();

        //End blade forward on off section....
        return view('backend.offer.offer_incomming_new.details', compact('details', 'designations', 'document_tracks', 'desig_id', 'auth_designation_id', 'sender_designation_id', 'DocumentTrack_hidden', 'additional_documents_names', 'supplier_names_names', 'files'));
    }

    public function offerTracking(Request $request)
    {
        $ins_id = Auth::user()->inspectorate_id;
        $admin_id = Auth::user()->id;
        $section_ids = AdminSection::where('admin_id', $admin_id)->pluck('sec_id')->toArray();
        $doc_type_id = 5; //...... 5 for indent from offers table doc_serial.
        $doc_ref_id = $request->doc_ref_id;
        $doc_reference_number = $request->doc_reference_number;
        $remarks = $request->remarks;
        $reciever_desig_id = $request->reciever_desig_id;
        $section_id = Offer::where('reference_no', $doc_reference_number)->pluck('sec_id')->first();
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

            $data = Offer::find($doc_ref_id);

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

    public function getOfferDetails(Request $request)
    {
        try {
            $offerRefNo = $request->input('offerRefNo');

            $offerDetails = Offer::where('reference_no', $offerRefNo)->first();

            if (!$offerDetails) {
                return response()->json([
                    'isSuccess' => false,
                    'Message' => 'Offer Details not found.',
                ], 200);
            }

            $tenderDetails = Tender::where('reference_no', $offerDetails->tender_reference_no)->first();

            return response()->json([
                'isSuccess' => true,
                'Message' => 'Offered supplier retrieved successfully.',
                'offerDetails' => $offerDetails,
                'tenderDetails' => $tenderDetails,
            ], 200);
        } catch (\Exception $e) {
            \Log::error('Error in Get Offer Details: ' . $e->getMessage());

            return response()->json([
                'isSuccess' => false,
                'Message' => 'An error occurred while processing the request.',
                'error' => $e->getMessage(),
            ], 200);
        }
    }

    public function get_indent_details($indentReferenceNo)
    {

        $indent = Indent::where('reference_no', $indentReferenceNo)->first();
        $item = Items::where('id', $indent->item_id)->first();
        $item_type = Item_type::where('id', $indent->item_type_id)->first();


        return response()->json(['item' => $item, 'itemType' => $item_type]);
    }
}
