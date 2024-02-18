<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DocType;
use DataTables;
use Validator;
use Illuminate\Support\Facades\DB;

class DocTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $docTypes = DocType::all();
        return view('backend.doc-types.index', compact('docTypes'));
    }

    public function getAllData()
    {
        $docTypes = DocType::select('id', 'name', 'doc_serial', 'processing_day');

        return DataTables::of($docTypes)
            ->addColumn('DT_RowIndex', function ($docType) {
                return $docType->id;
            })
            ->addColumn('name', function ($docType) {
                return $docType->name;
            })
            ->addColumn('doc_serial', function ($docType) {
                return $docType->doc_serial;
            })
            ->addColumn('processing_day', function ($docType) {
                return $docType->processing_day;
            })
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('doc-types.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $customMessages = [
            'doc-type-name' => 'Please enter Doc Type name.',
            'doc-serial' => 'Please enter Doc Serial number.',
            'processing-day' => 'Please enter Processing Day.',
        ];

        $validator = Validator::make($request->all(), [
            'doc-type-name' => 'required|string|max:255',
            'doc-serial' => 'required|integer',
            'processing-day' => 'required|integer',
        ], $customMessages);

        if ($validator->passes()) {
            try {
                DB::beginTransaction();

                $docType = new DocType();
                $docType->name = $request->input('doc-type-name');
                $docType->doc_serial = $request->input('doc-serial');
                $docType->processing_day = $request->input('processing-day');

                if (!$docType->save()) {
                    DB::rollBack();

                    return response()->json([
                        'isSuccess' => false,
                        'Message' => "Something went wrong while storing data!",
                    ], 200);
                }

                DB::commit();

                return response()->json([
                    'isSuccess' => true,
                    'Message' => "Doc Type saved successfully!"
                ], 200);
            } catch (\Illuminate\Database\QueryException $e) {
                DB::rollBack();

                \Log::error($e);

                return response()->json([
                    'isSuccess' => false,
                    'Message' => "Database error occurred!",
                ], 200);
            } catch (\Exception $e) {
                DB::rollBack();

                \Log::error($e);

                return response()->json([
                    'isSuccess' => false,
                    'Message' => "Something went wrong!",
                ], 200);
            }
        } else {
            return response()->json([
                'isSuccess' => false,
                'Message' => "Please check the inputs!",
                'error' => $validator->errors()->toArray()
            ], 200);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(DocType $docType)
    {
        return view('doc-types.show', compact('docType'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DocType $docType)
    {
        return view('doc-types.edit', compact('docType'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DocType $docType)
    {
        $request->validate([
            'edit-doc-type-name' => 'required|string|max:255',
            'edit-doc-serial' => 'required|integer',
            'edit-processing-day' => 'required|integer',
        ]);

        $docType->update($request->all());

        return redirect()->route('doc-types.index')
            ->with('success', 'DocType updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DocType $docType)
    {
        $docType->delete();

        return redirect()->route('doc-types.index')
            ->with('success', 'DocType deleted successfully.');
    }
}
