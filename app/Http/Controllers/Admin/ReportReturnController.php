<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminSection;
use App\Models\Designation;
use App\Models\DocType;
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
                ->whereIn('status', [1,2])
                ->count();
            $TotalVattedCtrlData = $modelClass::leftJoin('items', $table . '.item_id', '=', 'items.id')
                ->whereBetween($table . '.created_at', [$startDate, $endDate])
                ->where($table . '.' . $column, $insp_id)
                ->whereIn('status', [1,2])
                ->where('items.attribute', 'controlled')
                ->count();
            $TotalVattedUnCtrlData = $modelClass::leftJoin('items', $table . '.item_id', '=', 'items.id')
                ->whereBetween($table . '.created_at', [$startDate, $endDate])
                ->where($table . '.' . $column, $insp_id)
                ->whereIn('status', [1,2])
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


}
