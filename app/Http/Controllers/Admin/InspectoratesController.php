<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Inspectorate;
use DataTables;
use Validator;

class InspectoratesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('backend.inspectorates.index');
    }

    public function getAllData()
    {
        $inspectorates = Inspectorate::select('id', 'name', 'slag');

        return DataTables::of($inspectorates)
            ->addColumn('DT_RowIndex', function ($inspectorate) {
                return $inspectorate->id; // You can use any unique identifier here
            })
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
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'slag' => ['required', 'string', 'max:255'],
        ]);

        if ($validator->passes()) {

            $inspectorate = new Inspectorate();

            $inspectorate->name = $request->name;
            $inspectorate->slag = $request->slag;

            if ($inspectorate->save()) {
                return response()->json([
                    'isSuccess' => true,
                    'Message' => "Inspectorate Saved successfully!"
                ], 200);
            } else {
                return response()->json([
                    'isSuccess' => false,
                    'Message' => "Something went wrong!"
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        try {
            $id = $request->id;
            $inspectorate = Inspectorate::findOrFail($id);
            return response()->json($inspectorate);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Inspectorate not found'], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'edit_name' => ['required', 'string', 'max:255'],
            'edit_slag' => ['required', 'string', 'max:255'],
        ]);

        if ($validator->passes()) {
            try {
                $id = $request->edit_inspectorate_id;
                $inspectorate = Inspectorate::findOrFail($id);

                $inspectorate->name = $request->edit_name;
                $inspectorate->slag = $request->edit_slag;

                if ($inspectorate->save()) {
                    return response()->json([
                        'isSuccess' => true,
                        'Message' => "Inspectorate updated successfully!"
                    ], 200);
                } else {
                    return response()->json([
                        'isSuccess' => false,
                        'Message' => "Something went wrong while updating!"
                    ], 200);
                }
            } catch (\Exception $e) {
                return response()->json([
                    'isSuccess' => false,
                    'Message' => "Inspectorate not found!"
                ], 404);
            }
        } else {
            return response()->json([
                'isSuccess' => false,
                'Message' => "Please check the inputs!",
                'error' => $validator->errors()->toArray(),
            ], 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id = $request->id;

        $inspectorate = Inspectorate::find($id);

        if ($inspectorate) {
            if ($inspectorate->delete()) {
                return response()->json([
                    'isSuccess' => true,
                    'Message' => 'Inspectorate deleted successfully!'
                ], 200); // Status code here
            } else {
                return response()->json([
                    'isSuccess' => false,
                    'Message' => 'Failed to delete Inspectorate!'
                ], 200); // Status code here
            }
        } else {
            return response()->json([
                'isSuccess' => false,
                'Message' => 'Inspectorate not found!'
            ], 200); // Status code here
        }
    }
}
