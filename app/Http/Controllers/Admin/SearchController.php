<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DocType;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index()
    {
        $doc_types=DocType::all();
        return view('backend.search.index' , compact('doc_types'));
    }
}
