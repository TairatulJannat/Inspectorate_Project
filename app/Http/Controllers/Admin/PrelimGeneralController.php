<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dte_managment;
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
        return view('backend.specification.prelimgeneral.create' , compact('dte_managments'));
    }
}
