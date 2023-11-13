<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Additional_document;
use App\Models\DocType;
use App\Models\Designation;
use App\Models\Dte_managment;
use App\Models\Item_type;
use App\Models\Items;
use App\Models\PrelimGeneral;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class PrelimGeneralController extends Controller
{
    //
    public function index()
    {
        // $doc_type = DocType::where('name', 'Indent')->first();
        // $doc_type =  $doc_type->id;
        // dd( $doc_type);
        return view('backend.specification.prelimgeneral.index');
    }
    public function all_data(Request $request)
    {

        if ($request->ajax()) {
            $query = PrelimGeneral::leftJoin('item_types', 'prelim_gen_specs.item_type_id', '=', 'item_types.id')
            ->leftJoin('dte_managments', 'prelim_gen_specs.sender', '=', 'dte_managments.id')
            ->select('prelim_gen_specs.*', 'item_types.name as item_type_name', 'prelim_gen_specs.*', 'dte_managments.name as dte_managment_name')
            ->get();
            // $query->orderBy('id', 'asc');

            return DataTables::of($query)
                ->setTotalRecords($query->count())
                ->addIndexColumn()
                // ->addColumn('photo', function ($data) {
                //     if ($data->image_one) {
                //         $url = asset("assets/backend/images/hall/$data->image_one");
                //     } else {
                //         $url = asset("assets/backend/images/no.jpg");
                //     }
                //     return '<img src=' . $url . ' border="0" width="70" class="img-rounded" align="center" />';
                // })
                ->addColumn('status', function ($data) {
                    if ($data->status == '0') {
                        return '<button class="btn btn-success btn-sm">New</button>';
                    }
                    if ($data->status == '1') {
                        return '<button class="btn btn-waring btn-sm">Seen</button>';
                    }
                    if ($data->status == '2') {
                        return '<button class="btn btn-danger btn-sm">Delivered</button>';
                    }
                })
                ->addColumn('action', function ($data) {

                    $actionBtn = '<div class="btn-group" role="group">
                            <a href="' . url('admin/prelimgeneral/details/' . $data->id) . '" class="edit btn btn-secondary btn-lg">Details</a>';
                    return $actionBtn;
                })
                // ->addColumn('photo', function ($data) {
                //     $url = asset("uploads/member_Photograph/$data->photo");
                //     return '<img src=' . $url . ' border="0" width="40" class="img-rounded" align="center" />';
                // })
                ->rawColumns(['action' ,'status'])
                ->make(true);
        }
    }
    public function details($id)
    {

        $details = PrelimGeneral::leftJoin('item_types', 'prelim_gen_specs.item_type_id', '=', 'item_types.id')
        ->leftJoin('dte_managments', 'prelim_gen_specs.sender', '=', 'dte_managments.id')
        ->select('prelim_gen_specs.*', 'item_types.name as item_type_name', 'prelim_gen_specs.*', 'dte_managments.name as dte_managment_name')
        ->where('prelim_gen_specs.id', $id)
        ->first();

        $designations=Designation::all();
        return view('backend.specification.prelimgeneral.details', compact('details','designations'));
    }


    public function create()
    {
        $dte_managments = Dte_managment::where('status', 1)->get();
        $additional_documnets = Additional_document::where('status', 1)->get();
        $item_types = Item_type::where('status', 1)->get();
        return view('backend.specification.prelimgeneral.create', compact('dte_managments', 'additional_documnets', 'item_types'));
    }
    public function item_name($id)
    {
        $items = Items::where('item_type_id', $id)->get();
        return response()->json($items);
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'sender' => 'required',
            'reference_no' => 'required',
            'spec_type' => 'required',
            'additional_documents' => 'required',
            'item_type_id' => 'required',
            'spec_received_date' => 'required',

        ]);
        $insp_id = Auth::user()->inspectorate_id;
        $sec_id = Auth::user()->section_id;
      
        
        $data = new PrelimGeneral();
        $data->insp_id = $insp_id;
        $data->sec_id = $sec_id;
        $data->sender = $request->sender;
        $data->reference_no = $request->reference_no;
        $data->spec_type = $request->spec_type;
        $data->additional_documents = $request->additional_documents;
        $data->item_id = $request->item_id;
        $data->item_type_id = $request->item_type_id;
        $data->spec_received_date = $request->spec_received_date;
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
}