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
        return view('backend.finalSpec.finalSpec_incomming_new.index');
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

    public function edit($id)
    {
        $finalSpec = FinalSpec::find($id);
        $admin_id = Auth::user()->id;
        $inspectorate_id = Auth::user()->inspectorate_id;
        $dte_managments = Dte_managment::where('status', 1)->get();
        $additional_documnets = Additional_document::where('status', 1)->get();
        $item_types = Item_type::where('status', 1)->where('inspectorate_id', $inspectorate_id)->get();
        $item = Items::where('id', $finalSpec->item_id)->first();
        $fin_years = FinancialYear::all();
        $suppliers = Supplier::all();
        $tender_reference_numbers = Tender::all();
        $indent_reference_numbers = Indent::all();
        return view('backend.finalSpec.finalSpec_incomming_new.edit', compact('finalSpec', 'item', 'dte_managments', 'additional_documnets', 'item_types', 'fin_years', 'tender_reference_numbers', 'indent_reference_numbers', 'suppliers'));
    }
}
