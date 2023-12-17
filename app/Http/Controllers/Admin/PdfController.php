<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Mpdf\Mpdf;

class PDFController extends Controller
{
    public function generatePDF()
    {
        $mpdf = new Mpdf();
        $html = view('backend.pdf.indent_pdf')->render(); // Render Blade view content

        $mpdf->WriteHTML($html);
        $mpdf->Output('filename.pdf', 'D');
    }
}
