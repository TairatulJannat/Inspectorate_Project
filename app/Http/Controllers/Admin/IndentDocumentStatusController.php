<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Additional_document;
use App\Models\IndentDocumentStatus;
use Carbon\Carbon;
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

    public function all_data(Request $request)
    {
        $query = IndentDocumentStatus::where('indent_id', $request->indentId)
            ->leftJoin('additional_documents', 'indent_progresses.indent_item_id', '=', 'additional_documents.id')
            ->select('indent_progresses.*', 'additional_documents.name as additional_documents_name')
            ->get();

        return DataTables::of($query)
            ->setTotalRecords($query->count())
            ->addIndexColumn()
            ->addColumn('receive_status', function ($data) {
                if ($data->receive_status == '0') {
                    return '<button class="btn btn-primary btn-sm">Received</button>';
                }
                if ($data->receive_status == '1') {
                    return '<button class="btn btn-info  btn-sm">Not Received</button>';
                }
            })
            ->addColumn('action', function ($data) {
                // <button type="button" class="btn btn-success float-md-end" data-bs-toggle="modal"
                //             data-bs-target="#createItemTypeModal">
                //            Add Document
                //         </button>


                $actionBtn = '<div class="btn-group" role="group">
                        <a href="javascript:void(0)" class="edit_doc btn btn-info btn-sm" data-id="'. $data->id.'"  data-bs-toggle="modal"
                        data-bs-target="#editItemTypeModal">Edit</a>

                        <a href="javascript:void(0)" class="delete btn btn-danger btn-sm" onclick="delete_data('.$data->id.')">Delete</a>
                        </div>';
                return $actionBtn;
            })
            ->rawColumns(['action', 'receive_status'])
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

        $data = new IndentDocumentStatus();

        $data->indent_id = $request->indent_id;
        $data->indent_item_id = $request->indent_doc_id;
        $data->duration = $request->duration;
        $data->member = $request->member;
        $data->receive_status = $request->receive_status == 'on' ? '0' : '1';
        $data->receive_date = $request->receive_date;
        $data->asking_date = $request->asking_date;
        $data->created_at = Carbon::now();
        $data->updated_at = Carbon::now();

        $data->save();

        return response()->json(['success' => 'Done']);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $indentId = $id;
        $additional_documents = Additional_document::all();
        return view('backend.indent.document_status.index', compact('indentId', 'additional_documents'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit( $id)
    {
        // $indentId = $id;
        // $additional_documents
        $additional_documents = Additional_document::where('id', $id )->first();
        return view('backend.indent.document_status.index', compact( 'additional_documents'));
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
    public function delete($id)
    {
        $data = IndentDocumentStatus::find($id);
        if ($data) {
            $data->delete();
            return response()->json(['success' => 'Record deleted']);
        } else {
            return response()->json(['success' => 'Record not found'], 404);
        }
    }
}
