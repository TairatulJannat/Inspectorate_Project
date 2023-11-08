<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Additional_document;
use App\Models\Dte_managment;
use App\Models\Item_type;
use App\Models\Items;
use Illuminate\Http\Request;

class PrelimGeneralController extends Controller
{
    //
    public function index()
    {
        return view('backend.specification.prelimgeneral.index');
    }

    public function create()
    {
        $dte_managments=Dte_managment::where('status',1)->get();
        $additional_documnets=Additional_document::where('status',1)->get();
        $item_types=Item_type::where('status',1)->get();
        // dd($item_types);
        // $items = Items::leftJoin('item_types', 'items.item_type_id', '=', 'item_types.id')
        // ->select('items.*', 'item_types.name as item_type_name')
        // ->get();
        // dd($items);
        return view('backend.specification.prelimgeneral.create' , compact('dte_managments','additional_documnets','item_types'));
        
    }
    public function item_name($id)
    {
        $items = Items::where('item_type_id', $id)->get();
        return response()->json($items);
    }
    

    
}