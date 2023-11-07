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
        $items=Items::all();
        $item_types = Item_type::leftJoin('items', 'item_types.item_id', '=', 'items.id')
        ->select('item_types.*', 'items.name as item_name')
        ->get();
        return view('backend.specification.prelimgeneral.create' , compact('dte_managments','additional_documnets','items'));
        
    }
}