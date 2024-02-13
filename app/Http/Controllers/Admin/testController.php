<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PDF;

class testController extends Controller
{
    public function testPdf(){

        $pdf = PDF::loadView('backend.blank.pdf')->setOptions([
            'isHtml5ParserEnabled' => true,
            'isPhpEnabled' => true,
            'isRemoteEnabled' => true,
            'isCssFloatEnabled' => true,
            'defaultFont' => 'Arial',
            'enable_html5_parser' => true,
            'enable_remote' => true,
            'enable_css_float' => true,
            'isPhpEnabled' => true, // Enable PHP
            'isFixedPositionEnabled' => true, // Enable fixed positioning
        ]);
        return $pdf->stream('example.pdf');
    }
}
