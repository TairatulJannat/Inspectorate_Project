<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Indent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IndentController extends Controller
{
    public function index()
    {

        $auth_inspectptate_id = Auth::user()->inspectorate_id;
        if (Auth::user()->id == 92) {
            $indents = Indent::all();
            return view('backend.indent.view_page', compact('indents'));
        } else {
            $indents = Indent::all()->where('inspectorate_id', $auth_inspectptate_id);
            return view('backend.indent.view_page', compact('indents'));
        }
    }
}
