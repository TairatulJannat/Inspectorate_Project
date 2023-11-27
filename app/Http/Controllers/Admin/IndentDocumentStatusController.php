<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\IndentDocumentStatus;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class IndentDocumentStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

    }

    public function all_data(Request $request){


        $query = IndentDocumentStatus::where('indent_id',$request->indentId)->get();

        return DataTables::of($query)
                ->setTotalRecords($query->count())
                ->addIndexColumn()

                ->addColumn('action', function ($data)  {


                        $actionBtn = '<div class="btn-group" role="group">
                        <a href="" class="edit btn btn-info btn-sm">Edit</a>
                        <a href="" class="edit btn btn-warning btn-sm">Delete</a>
                        </div>';


                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);




    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show( $id)
    {
        $indentId=$id;
        return view('backend.indent.document_status.index', compact('indentId'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
