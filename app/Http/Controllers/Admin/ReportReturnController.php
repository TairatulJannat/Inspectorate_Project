<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminSection;
use App\Models\Designation;
use App\Models\Indent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportReturnController extends Controller
{
    public function weekly_report()
    {
        return view('backend.report_return.weekly_report');
    }
    public function report_data(Request $request)
    {
        $insp_id = Auth::user()->inspectorate_id;
        $admin_id = Auth::user()->id;
        $inspectorate_id = Auth::user()->inspectorate_id;
        $section_ids = AdminSection::where('admin_id', $admin_id)->pluck('sec_id')->toArray();
        $designation_id = AdminSection::where('admin_id', $admin_id)->pluck('desig_id')->first();
        $desig_position = Designation::where('id', $designation_id)->first();

        $startDate = $request->fromDate;
        $endDate = $request->toDate;

        $indent =Indent::leftJoin('items', 'indents.item_id', '=', 'items.id')
            
            ->get();
        // Returning JSON response
        return response()->json(['success' => "Data Found", 'data'=>$indent]);
    }
}
