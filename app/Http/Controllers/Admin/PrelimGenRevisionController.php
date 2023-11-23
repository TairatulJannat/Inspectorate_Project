<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PrelimGenRevisionController extends Controller
{
   public function revision(){

    return view('backend.specification.prelimgeneral-revision.index');
   }
}
