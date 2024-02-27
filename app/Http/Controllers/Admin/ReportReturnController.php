<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReportReturnController extends Controller
{
    public function weekly_report()
    {
        return view('backend.report_return.weekly_report');
    }
}
