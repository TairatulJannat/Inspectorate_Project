<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminSection;
use App\Models\Designation;
use App\Models\DocType;
use App\Models\Indent;
use App\Models\ReportReturn;
use Carbon\Carbon;
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
        $section_ids = AdminSection::where('admin_id', $admin_id)->pluck('sec_id')->toArray();
        $designation_id = AdminSection::where('admin_id', $admin_id)->pluck('desig_id')->first();
        $desig_position = Designation::where('id', $designation_id)->first();

        $startDate = $request->fromDate;
        $endDate = $request->toDate;
        $doc_types = DocType::all();

        foreach ($doc_types as $doc_type) {
            $modelClass = 'App\\Models\\' . $doc_type->name;
            $table = $doc_type->table_name;
            $doc_name = $doc_type->doc_name;

            // Check if the class exists before proceeding
            if (!class_exists($modelClass) || $modelClass == 'App\\Models\\Tender') {
                continue; // Skip this iteration if class not found
            }


            $tableColumns = \Schema::getColumnListing($table);

            // Check if insp_id or inspectorate_id exists in the table
            if (in_array('insp_id', $tableColumns)) {
                $column = 'insp_id';
            } elseif (in_array('inspectorate_id', $tableColumns)) {
                $column = 'inspectorate_id';
            } else {
                continue; // Skip if neither column exists
            }

            $TotalReceivedData = $modelClass::leftJoin('items', $table . '.item_id', '=', 'items.id')
                ->whereBetween($table . '.created_at', [$startDate, $endDate])
                ->where($table . '.' . $column, $insp_id)
                ->count();
            $TotalCtrlData = $modelClass::leftJoin('items', $table . '.item_id', '=', 'items.id')
                ->whereBetween($table . '.created_at', [$startDate, $endDate])
                ->where($table . '.' . $column, $insp_id)
                ->where('items.attribute', 'controlled')
                ->count();
            $TotalUnCtrlData = $modelClass::leftJoin('items', $table . '.item_id', '=', 'items.id')
                ->whereBetween($table . '.created_at', [$startDate, $endDate])
                ->where($table . '.' . $column, $insp_id)
                ->where('items.attribute', 'uncontrolled')
                ->count();

            $TotalVattedReceivedData = $modelClass::leftJoin('items', $table . '.item_id', '=', 'items.id')
                ->whereBetween($table . '.created_at', [$startDate, $endDate])
                ->where($table . '.' . $column, $insp_id)
                ->whereIn('status', [1, 2])
                ->count();
            $TotalVattedCtrlData = $modelClass::leftJoin('items', $table . '.item_id', '=', 'items.id')
                ->whereBetween($table . '.created_at', [$startDate, $endDate])
                ->where($table . '.' . $column, $insp_id)
                ->whereIn('status', [1, 2])
                ->where('items.attribute', 'controlled')
                ->count();
            $TotalVattedUnCtrlData = $modelClass::leftJoin('items', $table . '.item_id', '=', 'items.id')
                ->whereBetween($table . '.created_at', [$startDate, $endDate])
                ->where($table . '.' . $column, $insp_id)
                ->whereIn('status', [1, 2])
                ->where('items.attribute', 'uncontrolled')
                ->count();

            $TotalUnderVattedReceivedData = $modelClass::leftJoin('items', $table . '.item_id', '=', 'items.id')
                ->whereBetween($table . '.created_at', [$startDate, $endDate])
                ->where($table . '.' . $column, $insp_id)
                ->whereIn('status', [0, 3])
                ->count();
            $TotalUnderVattedCtrlData = $modelClass::leftJoin('items', $table . '.item_id', '=', 'items.id')
                ->whereBetween($table . '.created_at', [$startDate, $endDate])
                ->where($table . '.' . $column, $insp_id)
                ->whereIn('status', [0, 3])
                ->where('items.attribute', 'controlled')
                ->count();
            $TotalUnderVattedUnCtrlData = $modelClass::leftJoin('items', $table . '.item_id', '=', 'items.id')
                ->whereBetween($table . '.created_at', [$startDate, $endDate])
                ->where($table . '.' . $column, $insp_id)
                ->whereIn('status', [0, 3])
                ->where('items.attribute', 'uncontrolled')
                ->count();

            $reports[$doc_name] = [
                'receive' => ['total' => $TotalReceivedData, 'controll' => $TotalCtrlData, 'uncontroll' => $TotalUnCtrlData],
                'vetted' => ['total' => $TotalVattedReceivedData, 'controll' => $TotalVattedCtrlData, 'uncontroll' => $TotalVattedUnCtrlData],
                'undervetted' => ['total' => $TotalUnderVattedReceivedData, 'controll' => $TotalUnderVattedCtrlData, 'uncontroll' => $TotalUnderVattedUnCtrlData],

            ]; // Add count to data array with table name as key

        }

        // Returning JSON response
        return response()->json(['success' => "Data Found", 'reports' => $reports]);
    }
    public function weekly_report_pdf(Request $request)
    {
        // $insp_id = Auth::user()->inspectorate_id;
        // $admin_id = Auth::user()->id;
        // $section_ids = AdminSection::where('admin_id', $admin_id)->pluck('sec_id')->toArray();
        // $designation_id = AdminSection::where('admin_id', $admin_id)->pluck('desig_id')->first();
        // $desig_position = Designation::where('id', $designation_id)->first();

        // $startDate = $request->fromDate;
        // $endDate = $request->toDate;
        // $doc_types = DocType::all();

        // foreach ($doc_types as $doc_type) {
        //     $modelClass = 'App\\Models\\' . $doc_type->name;
        //     $table = $doc_type->table_name;
        //     $doc_name = $doc_type->doc_name;

        //     // Check if the class exists before proceeding
        //     if (!class_exists($modelClass) || $modelClass == 'App\\Models\\Tender') {
        //         continue; // Skip this iteration if class not found
        //     }


        //     $tableColumns = \Schema::getColumnListing($table);

        //     // Check if insp_id or inspectorate_id exists in the table
        //     if (in_array('insp_id', $tableColumns)) {
        //         $column = 'insp_id';
        //     } elseif (in_array('inspectorate_id', $tableColumns)) {
        //         $column = 'inspectorate_id';
        //     } else {
        //         continue; // Skip if neither column exists
        //     }

        //     $TotalReceivedData = $modelClass::leftJoin('items', $table . '.item_id', '=', 'items.id')
        //         ->whereBetween($table . '.created_at', [$startDate, $endDate])
        //         ->where($table . '.' . $column, $insp_id)
        //         ->count();
        //     $TotalCtrlData = $modelClass::leftJoin('items', $table . '.item_id', '=', 'items.id')
        //         ->whereBetween($table . '.created_at', [$startDate, $endDate])
        //         ->where($table . '.' . $column, $insp_id)
        //         ->where('items.attribute', 'controlled')
        //         ->count();
        //     $TotalUnCtrlData = $modelClass::leftJoin('items', $table . '.item_id', '=', 'items.id')
        //         ->whereBetween($table . '.created_at', [$startDate, $endDate])
        //         ->where($table . '.' . $column, $insp_id)
        //         ->where('items.attribute', 'uncontrolled')
        //         ->count();

        //     $TotalVattedReceivedData = $modelClass::leftJoin('items', $table . '.item_id', '=', 'items.id')
        //         ->whereBetween($table . '.created_at', [$startDate, $endDate])
        //         ->where($table . '.' . $column, $insp_id)
        //         ->whereIn('status', [0, 1, 3])
        //         ->count();
        //     $TotalVattedCtrlData = $modelClass::leftJoin('items', $table . '.item_id', '=', 'items.id')
        //         ->whereBetween($table . '.created_at', [$startDate, $endDate])
        //         ->where($table . '.' . $column, $insp_id)
        //         ->whereIn('status', [0, 1, 3])
        //         ->where('items.attribute', 'controlled')
        //         ->count();
        //     $TotalVattedUnCtrlData = $modelClass::leftJoin('items', $table . '.item_id', '=', 'items.id')
        //         ->whereBetween($table . '.created_at', [$startDate, $endDate])
        //         ->where($table . '.' . $column, $insp_id)
        //         ->whereIn('status', [0, 1, 3])
        //         ->where('items.attribute', 'uncontrolled')
        //         ->count();

        //     $TotalVattedReceivedData = $modelClass::leftJoin('items', $table . '.item_id', '=', 'items.id')
        //         ->whereBetween($table . '.created_at', [$startDate, $endDate])
        //         ->where($table . '.' . $column, $insp_id)
        //         ->whereIn('status', [2, 4])
        //         ->count();
        //     $TotalVattedCtrlData = $modelClass::leftJoin('items', $table . '.item_id', '=', 'items.id')
        //         ->whereBetween($table . '.created_at', [$startDate, $endDate])
        //         ->where($table . '.' . $column, $insp_id)
        //         ->whereIn('status', [2, 4])
        //         ->where('items.attribute', 'controlled')
        //         ->count();
        //     $TotalVattedUnCtrlData = $modelClass::leftJoin('items', $table . '.item_id', '=', 'items.id')
        //         ->whereBetween($table . '.created_at', [$startDate, $endDate])
        //         ->where($table . '.' . $column, $insp_id)
        //         ->whereIn('status', [2, 4])
        //         ->where('items.attribute', 'uncontrolled')
        //         ->count();

        //     $reports[$doc_name] = [
        //         'receive' => ['total' => $TotalReceivedData, 'controll' => $TotalCtrlData, 'uncontroll' => $TotalUnCtrlData],
        //         'vetted' => ['total' => $TotalVattedReceivedData, 'controll' => $TotalVattedCtrlData, 'uncontroll' => $TotalVattedUnCtrlData],
        //         'undervetted' => ['total' => $TotalVattedReceivedData, 'controll' => $TotalVattedCtrlData, 'uncontroll' => $TotalVattedUnCtrlData],

        //     ]; // Add count to data array with table name as key

        // }

        // Returning JSON response
        return response()->json(['success' => "Data Found", 'reports' => $reports]);
    }


    public function store(Request $request)
    {

        $admin_id = Auth::user()->id;
        $inspectorate_id = Auth::user()->inspectorate_id;
        $section_ids = AdminSection::where('admin_id', $admin_id)->pluck('sec_id')->toArray();

        $data = new ReportReturn();
        $data->inspectorate_id = $inspectorate_id;
        $data->doc_type_id = $request->doc_type_id;
        $data->section_id = '6';
        $data->letter_reference_no = '23.01.901.051.' . $request->letter_reference_no . '.' . Carbon::now()->format('d.m.y');
        $data->inspectorate_name = $request->inspectorate_name;
        $data->inspectorate_place = $request->place;
        $data->mobile = $request->mobile;
        $data->fax = $request->fax;
        $data->email = $request->email;
        $data->letter_date = $request->date;
        $data->subject = $request->subject;
        $data->body_1 = $request->body_1;
        $data->body_2 = $request->report_html;
        $data->signature = $request->signature;
        $data->anxs = $request->anxs;
        $data->distr = $request->distr;
        $data->extl = $request->extl;
        $data->act = $request->act;
        $data->info = $request->info;
        $data->internal = $request->internal;
        $data->internal_act = $request->internal_act;
        $data->internal_info = $request->internal_info;
        $data->page_size = $request->page_size;
        $data->header_footer = $request->header_footer;
        $data->report_type = $request->report_type;
        $data->from_date = $request->from_date;
        $data->to_date = $request->to_date;

        $data->save();

        return response()->json(['success' => $request->all()]);
    }

    public function index()
    {
        $rr_lists = ReportReturn::orderBy('id', 'desc')->get();
        return view('backend.report_return.index', compact('rr_lists'));
    }

    public function monthly_report_data(Request $request)
    {
        $insp_id = Auth::user()->inspectorate_id;
        $admin_id = Auth::user()->id;
        $section_ids = AdminSection::where('admin_id', $admin_id)->pluck('sec_id')->toArray();
        $designation_id = AdminSection::where('admin_id', $admin_id)->pluck('desig_id')->first();
        $desig_position = Designation::where('id', $designation_id)->first();

        $startDate = $request->fromDate;
        $endDate = $request->toDate;
        $doc_types = DocType::all();

        foreach ($doc_types as $doc_type) {
            $modelClass = 'App\\Models\\' . $doc_type->name;
            $table = $doc_type->table_name;
            $doc_name = $doc_type->doc_name;

            // Check if the class exists before proceeding
            if (!class_exists($modelClass) || $modelClass == 'App\\Models\\Tender') {
                continue; // Skip this iteration if class not found
            }


            $tableColumns = \Schema::getColumnListing($table);

            // Check if insp_id or inspectorate_id exists in the table
            if (in_array('insp_id', $tableColumns)) {
                $column = 'insp_id';
            } elseif (in_array('inspectorate_id', $tableColumns)) {
                $column = 'inspectorate_id';
            } else {
                continue; // Skip if neither column exists
            }

            $TotalReceivedData = $modelClass::leftJoin('items', $table . '.item_id', '=', 'items.id')
                ->whereBetween($table . '.created_at', [$startDate, $endDate])
                ->where($table . '.' . $column, $insp_id)
                ->get();

            // dd($TotalReceivedData);
            $TotalCtrlData = $modelClass::leftJoin('items', $table . '.item_id', '=', 'items.id')
                ->whereBetween($table . '.created_at', [$startDate, $endDate])
                ->where($table . '.' . $column, $insp_id)
                ->where('items.attribute', 'controlled')
                ->get();
            $TotalUnCtrlData = $modelClass::leftJoin('items', $table . '.item_id', '=', 'items.id')
                ->whereBetween($table . '.created_at', [$startDate, $endDate])
                ->where($table . '.' . $column, $insp_id)
                ->where('items.attribute', 'uncontrolled')
                ->get();

            $TotalVattedReceivedData = $modelClass::leftJoin('items', $table . '.item_id', '=', 'items.id')
                ->whereBetween($table . '.created_at', [$startDate, $endDate])
                ->where($table . '.' . $column, $insp_id)
                ->whereIn('status', [1, 2])
                ->get();
            $TotalVattedCtrlData = $modelClass::leftJoin('items', $table . '.item_id', '=', 'items.id')
                ->whereBetween($table . '.created_at', [$startDate, $endDate])
                ->where($table . '.' . $column, $insp_id)
                ->whereIn('status', [1, 2])
                ->where('items.attribute', 'controlled')
                ->get();
            $TotalVattedUnCtrlData = $modelClass::leftJoin('items', $table . '.item_id', '=', 'items.id')
                ->whereBetween($table . '.created_at', [$startDate, $endDate])
                ->where($table . '.' . $column, $insp_id)
                ->whereIn('status', [1, 2])
                ->where('items.attribute', 'uncontrolled')
                ->get();

            $TotalUnderVattedReceivedData = $modelClass::leftJoin('items', $table . '.item_id', '=', 'items.id')
                ->whereBetween($table . '.created_at', [$startDate, $endDate])
                ->where($table . '.' . $column, $insp_id)
                ->whereIn('status', [0, 3])
                ->get();
            $TotalUnderVattedCtrlData = $modelClass::leftJoin('items', $table . '.item_id', '=', 'items.id')
                ->whereBetween($table . '.created_at', [$startDate, $endDate])
                ->where($table . '.' . $column, $insp_id)
                ->whereIn('status', [0, 3])
                ->where('items.attribute', 'controlled')
                ->get();
            $TotalUnderVattedUnCtrlData = $modelClass::leftJoin('items', $table . '.item_id', '=', 'items.id')
                ->whereBetween($table . '.created_at', [$startDate, $endDate])
                ->where($table . '.' . $column, $insp_id)
                ->whereIn('status', [0, 3])
                ->where('items.attribute', 'uncontrolled')
                ->get();

            $reports[$doc_name] = [
                'receive' => ['total' => $TotalReceivedData, 'controll' => $TotalCtrlData, 'uncontroll' => $TotalUnCtrlData],
                'vetted' => ['total' => $TotalVattedReceivedData, 'controll' => $TotalVattedCtrlData, 'uncontroll' => $TotalVattedUnCtrlData],
                'undervetted' => ['total' => $TotalUnderVattedReceivedData, 'controll' => $TotalUnderVattedCtrlData, 'uncontroll' => $TotalUnderVattedUnCtrlData],

            ]; // Add count to data array with table name as key

        }

        // Returning JSON response
        return response()->json(['success' => "Data Found", 'reports' => $reports]);
    }

    public function monthly_store(Request $request)
    {

        $admin_id = Auth::user()->id;
        $inspectorate_id = Auth::user()->inspectorate_id;
        $section_ids = AdminSection::where('admin_id', $admin_id)->pluck('sec_id')->toArray();
        $data = new ReportReturn();
        $data->inspectorate_id = $inspectorate_id;
        $data->doc_type_id = $request->doc_type_id;
        $data->section_id = '6';
        $data->letter_reference_no = '23.01.901.051.' . $request->letter_reference_no . '.' . Carbon::now()->format('d.m.y');
        $data->inspectorate_name = $request->inspectorate_name;
        $data->inspectorate_place = $request->place;
        $data->mobile = $request->mobile;
        $data->fax = $request->fax;
        $data->email = $request->email;
        $data->letter_date = $request->date;
        $data->subject = $request->subject;
        $data->body_1 = $request->body_1;
        $data->body_2 = $request->body_2;
        $data->signature = $request->signature;
        $data->anxs = $request->anxs;
        $data->distr = $request->distr;
        $data->extl = $request->extl;
        $data->act = $request->act;
        $data->info = $request->info;
        $data->internal = $request->internal;
        $data->internal_act = $request->internal_act;
        $data->internal_info = $request->internal_info;
        $data->page_size = $request->page_size;
        $data->header_footer = $request->header_footer;

        $data->save();

        return response()->json(['success' => "Report saved"]);
    }
    public function ReportReturnView($id)
    {
        $rr_list = ReportReturn::find($id);
        return view('backend.report_return.view', compact('rr_list'));
    }
    public function ReportReturnedit($id)
    {

        $rr_list = ReportReturn::find($id);
        return view('backend.report_return.edit', compact('rr_list'));
    }

    public function ReportReturndetails($id)
    {
        $rr_list = ReportReturn::find($id);
        $doc_types = DocType::all();

        foreach ($doc_types as $doc_type) {
            $modelClass = 'App\\Models\\' . $doc_type->name;
            $table = $doc_type->table_name;
            $doc_name = $doc_type->doc_name;

            // Check if the class exists before proceeding
            if (!class_exists($modelClass) || $modelClass == 'App\\Models\\Tender') {
                continue; // Skip this iteration if class not found
            }

            $tableColumns = \Schema::getColumnListing($table);

            // Check if insp_id or inspectorate_id exists in the table
            if (in_array('insp_id', $tableColumns)) {
                $column = 'insp_id';
            } elseif (in_array('inspectorate_id', $tableColumns)) {
                $column = 'inspectorate_id';
            } 

            if (in_array('sec_id', $tableColumns)) {
                $sec_column = 'sec_id';
            } elseif (in_array('section_id', $tableColumns)) {
                $sec_column = 'section_id';
            } 

            // dd($rr_list->insp_id);
            $TotalReceivedData = $modelClass::leftJoin('items', $table . '.item_id', '=', 'items.id')
                // ->whereBetween($table . '.created_at', [$rr_list->from_date, $rr_list->to_date])
                ->whereDate($table . '.created_at', '>=', date($rr_list->from_date))
                ->whereDate($table . '.created_at', '<=', date($rr_list->to_date))
                ->where($table . '.' . $column, $rr_list->inspectorate_id)
                ->get();

            $SigSec = $TotalReceivedData->where("$sec_column", '3');
            $EnggSec = $TotalReceivedData->where("$sec_column", '4');
            $FicSec = $TotalReceivedData->where("$sec_column", '5');
            $EmSec = $TotalReceivedData->where("$sec_column", '1');
            $DevSec = $TotalReceivedData->where("$sec_column", '2');

            
            $reports[$doc_name] = [
                'TotalReceived' => $TotalReceivedData,
                'SIG Sec'=> $SigSec,
                'ENGG Sec'=> $EnggSec,
                'FIC Sec'=> $FicSec,
                'EM Sec'=> $EmSec,
                'DEV Sec'=> $DevSec,
            ]; // Add count to data array with table name as key

        }
        
        // return response()->json($reports);
        return view('backend.report_return.details', compact('rr_list', 'reports'));
    }
    public function ReportReturndetete($id)
    {
    }
}
