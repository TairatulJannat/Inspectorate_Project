<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CoverLetter;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Mpdf\Mpdf;
use PDF;



class CoverLetterController extends Controller
{
    public function store(Request $request)
    {

        $data = new CoverLetter();
        $data->inspectorate_id = $request->insp_id;
        $data->section_id = $request->sec_id;
        $data->doc_reference_id = $request->doc_reference_no;
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

        $data->save();

        return response()->json(['success' => "Letter information saved"]);
    }
    public function coverLetterGeneratePdf($doc_reference_id)
    {
        $cover_letter = CoverLetter::where('doc_reference_id', $doc_reference_id)->first();
        if ($cover_letter) {
            $pdf = PDF::loadView('backend.pdf.cover_letter',  ['cover_letter' => $cover_letter])->setPaper('a4');
            return $pdf->stream('cover_letter.pdf');
        }
        // $fontPath = public_path('fonts');

        // // Create an mPDF object
        // $mpdf = new Mpdf([
        //     'fontDir' => [public_path('fonts')],
        //     'fontdata' => [
        //         'nikosh' => [
        //             'R' => 'Nikosh.ttf',
        //         ],
        //     ],
        // ]);

        // // Add content to the PDF
        // $html = view('backend.pdf.cover_letter',  ['cover_letter' => $cover_letter])->render();
        // $mpdf->WriteHTML($html);

        // // Output or download the PDF
        // $mpdf->Output('sample.pdf', 'D');
    }

    public function edit(Request $request)
    {

        $data = CoverLetter::find($request->editId);
        // dd( $request->all());
        $data->letter_reference_no = $request->letter_reference_no;
        $data->inspectorate_name = $request->inspectorate_name;
        $data->inspectorate_place = $request->place;
        $data->mobile = $request->mobile;
        $data->fax = $request->fax;
        $data->email = $request->email;
        $data->letter_date = $request->date;
        $data->subject = $request->subject;
        $data->body_1 = $request->bodyEdit_1;
        $data->body_2 = $request->bodyEdit_2;
        $data->signature = $request->signatureEdit;
        $data->anxs = $request->anxsEdit;
        $data->distr = $request->distr;
        $data->extl = $request->extl;
        $data->act = $request->act;
        $data->info = $request->info;
        $data->internal = $request->internal;
        $data->internal_act = $request->internal_act;
        $data->internal_info = $request->internal_info;


        $data->save();

        return response()->json(['success' => "Letter information updated"]);
    }


    public function GenerateINotePdf($doc_reference_id)
    {

        // $pdf = PDF::loadView('backend.pdf.inote')->setPaper('a4', 'landscape');
        // return $pdf->stream('cover_letter.pdf');
        return view('backend.pdf.inote');
    }
}
