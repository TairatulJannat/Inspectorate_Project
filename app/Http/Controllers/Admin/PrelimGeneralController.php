<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Additional_document;
use App\Models\Dte_managment;
use App\Models\Item_type;
use App\Models\Items;
use App\Models\PrelimGeneral;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PrelimGeneralController extends Controller
{
    //
    public function index()
    {
        return view('backend.specification.prelimgeneral.index');
    }

    public function create()
    {
        $dte_managments = Dte_managment::where('status', 1)->get();
        $additional_documnets = Additional_document::where('status', 1)->get();
        $item_types = Item_type::where('status', 1)->get();
        // dd($item_types);
        // $items = Items::leftJoin('item_types', 'items.item_type_id', '=', 'item_types.id')
        // ->select('items.*', 'item_types.name as item_type_name')
        // ->get();
        // dd($items);
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
