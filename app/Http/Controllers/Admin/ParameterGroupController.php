<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ParameterGroup;
use App\Models\Section;
use DataTables;
use Validator;
use Illuminate\Support\Facades\Auth;

class ParameterGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $sections = Section::all();
        } catch (\Exception $e) {
            return back()->withError('Failed to retrieve Sections.');
        }

        return view('backend.parameter-groups.index', compact('sections'));
    }

    public function getAllData()
    {
        $parameter_groups = ParameterGroup::select('id', 'inspectorate_id', 'section_id', 'name', 'description', 'status');

        return DataTables::of($parameter_groups)
            ->addColumn('DT_RowIndex', function ($parameter_group) {
                return $parameter_group->id; // You can use any unique identifier here
            })
            ->addColumn('name', function ($parameter_group) {
                return $parameter_group->name;
            })
            ->addColumn('inspectorate_id', function ($parameter_group) {
                return $parameter_group->inspectorate_id;
            })
            ->addColumn('section_id', function ($parameter_group) {
                return $parameter_group->section_id;
            })
            ->addColumn('description', function ($parameter_group) {
                return $parameter_group->description;
            })
            ->addColumn('status', function ($parameter_group) {
                return $parameter_group->status;
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
            'section_id' => ['required', 'exists:sections,id'],
            'description' => ['required', 'string', 'max:255'],
        ]);

        if ($validator->passes()) {

            $parameterGroup = new ParameterGroup();

            $parameterGroup->name = $request->name;
            $parameterGroup->inspectorate_id = Auth::user()->inspectorate_id;
            $parameterGroup->section_id = $request->section_id;
            $parameterGroup->description = $request->description;
            $parameterGroup->status = $request->has('status') ? 1 : 0;

            if ($parameterGroup->save()) {
                return response()->json([
                    'isSuccess' => true,
                    'Message' => "Parameter Group Saved successfully!"
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
    public function show(Request $request)
    {
        try {
            $id = $request->id;
            $parameterGroup = ParameterGroup::findOrFail($id);

            return response()->json([
                'id' => $parameterGroup->id,
                'name' => $parameterGroup->name,
                'inspectorate_id' => $parameterGroup->inspectorate_id,
                'section_id' => $parameterGroup->section_id,
                'description' => $parameterGroup->description,
                'status' => $parameterGroup->status,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Parameter Group not found'], 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        try {
            $id = $request->id;
            $parameterGroup = ParameterGroup::findOrFail($id);

            return response()->json([
                'id' => $parameterGroup->id,
                'name' => $parameterGroup->name,
                'inspectorate_id' => $parameterGroup->inspectorate_id,
                'section_id' => $parameterGroup->section_id,
                'description' => $parameterGroup->description,
                'status' => $parameterGroup->status,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Parameter Group not found'], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'edit_name' => ['required', 'string', 'max:255'],
            'edit_section_id' => ['required', 'exists:sections,id'],
            'edit_description' => ['required', 'string', 'max:255'],
        ]);

        if ($validator->passes()) {
            try {
                $id = $request->edit_parameter_group_id;
                $parameterGroup = ParameterGroup::findOrFail($id);

                $parameterGroup->name = $request->edit_name;
                $parameterGroup->inspectorate_id = $request->edit_inspectorate_id;
                $parameterGroup->section_id = $request->edit_section_id;
                $parameterGroup->description = $request->edit_description;
                $parameterGroup->status = $request->has('edit_status') ? 1 : 0;

                if ($parameterGroup->save()) {
                    return response()->json([
                        'isSuccess' => true,
                        'Message' => "Parameter Group updated successfully!"
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
                    'Message' => "Parameter Group not found!"
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

        $parameterGroup = ParameterGroup::find($id);

        if ($parameterGroup) {
            if ($parameterGroup->delete()) {
                return response()->json([
                    'isSuccess' => true,
                    'Message' => 'Parameter Group deleted successfully!'
                ], 200); // Status code here
            } else {
                return response()->json([
                    'isSuccess' => false,
                    'Message' => 'Failed to delete Parameter Group!'
                ], 200); // Status code here
            }
        } else {
            return response()->json([
                'isSuccess' => false,
                'Message' => 'Parameter Group not found!'
            ], 200); // Status code here
        }
    }
}
