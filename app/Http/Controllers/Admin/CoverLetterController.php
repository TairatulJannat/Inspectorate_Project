<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CoverLetter;
use Illuminate\Http\Request;

class CoverLetterController extends Controller
{
    public function store(Request $request){

     $data = new CoverLetter();

    $data->inspectorate_id = $request->insp_id;
    $data->section_id = $request->sec_id;
    $data->doc_reference_id = $request->doc_reference_no;
    $data->letter_reference_no = $request->letter_reference_no;
    $data->inspectorate_name = $request->inspectorate_name;
    $data->inspectorate_place = $request->place;
    $data->mobile = $request->mobile;
    $data->fax = $request->fax;
    $data->email = $request->email;
    $data->letter_date = $request->date;
    $data->subject = $request->subject;
    $data->body_1 = $request->body_1;
    $data->body_2 = $request->body_2;
    $data->name = $request->name;
    $data->designation = $request->designation;
    $data->anxs = $request->anxs;
    $data->distr = $request->distr;
    $data->extl = $request->extl;
    $data->act = $request->act;
    $data->info = $request->info;

    $data->save();

    return response()->json(['success' => "Letter information saved"]);
    }
}
