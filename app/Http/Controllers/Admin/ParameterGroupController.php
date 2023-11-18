<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ParameterGroup;
use App\Models\Section;
use App\Models\Items;
use App\Models\Item_type;
use DataTables;
use Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ParameterGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $sections = Section::all();
            $items = Items::all();
            $itemTypes = Item_type::all();
        } catch (\Exception $e) {
            return back()->withError('Failed to retrieve Sections.');
        }
        return view('backend.parameter-groups.index', compact('sections', 'items', 'itemTypes'));
    }

    public function getAllData()
    {
        $parameter_groups = ParameterGroup::select('id', 'name', 'item_type_id', 'item_id', 'status')->with('itemType', 'item')->get();

        return DataTables::of($parameter_groups)
            ->addColumn('DT_RowIndex', function ($parameter_group) {
                return $parameter_group->id; // You can use any unique identifier here
            })
            ->addColumn('name', function ($parameter_group) {
                return $parameter_group->name;
            })
            ->addColumn('item_type_id_name', function ($parameter_group) {
                return $parameter_group->itemType ? $parameter_group->itemType->name : '';
            })
            ->addColumn('item_id_name', function ($parameter_group) {
                return $parameter_group->item ? $parameter_group->item->name : '';
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
        $customMessages = [
            'item-type-id.required' => 'Please select an Item Type.',
            'item-id.required' => 'Please select an Item.',
            'parameter-group-name.*.required' => 'Please enter a Parameter Group Name.',
        ];

        $validator = Validator::make($request->all(), [
            'item-type-id' => ['required', 'exists:item_types,id'],
            'item-id' => ['required', 'exists:items,id'],
            'parameter-group-name.*' => ['required', 'string', 'max:255'],
        ], $customMessages);

        if ($validator->passes()) {
            try {
                DB::beginTransaction();

                $parameterNames = $request->input('parameter-group-name');

                foreach ($parameterNames as $parameterName) {
                    $parameterGroup = new ParameterGroup();

                    $parameterGroup->item_type_id = $request->input('item-type-id');
                    $parameterGroup->item_id = $request->input('item-id');
                    $parameterGroup->inspectorate_id = Auth::user()->inspectorate_id;
                    $parameterGroup->section_id = 1;
                    $parameterGroup->status = $request->has('status') ? 1 : 0;
                    $parameterGroup->name = $parameterName;

                    if (!$parameterGroup->save()) {
                        DB::rollBack();

                        return response()->json([
                            'isSuccess' => false,
                            'Message' => "Something went wrong while storing data!",
                        ], 200);
                    }
                }

                DB::commit();

                return response()->json([
                    'isSuccess' => true,
                    'Message' => "Parameter Groups saved successfully!"
                ], 200);
            } catch (\Exception $e) {
                return response()->json([
                    'isSuccess' => false,
                    'Message' => "Something went wrong!",
                    'Error' => $e,
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
