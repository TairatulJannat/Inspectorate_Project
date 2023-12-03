<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ParameterGroup;
use App\Models\AssignParameterValue;
use App\Models\Items;
use App\Models\Item_type;
use App\Models\ParameterLog;
use Illuminate\Support\Facades\DB;
use Validator;
use Illuminate\Support\Facades\Auth;

class AssignParameterValueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $items = Items::all();
            $itemTypes = Item_type::all();
        } catch (\Exception $e) {
            return back()->withError('Failed to retrieve from Database.');
        }
        return view('backend.item-parameters.index', compact('items', 'itemTypes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        try {
            $id = $request->id;
            $parameterGroup = ParameterGroup::findOrFail($id);

            return response()->json($parameterGroup);
        } catch (\Exception $e) {
            // Log detailed error information for debugging purposes
            \Log::error('Error in show method: ' . $e->getMessage());

            return response()->json(['error' => 'Parameter Group not found'], 404);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $customMessages = [
            'assign_parameter_group_id.required' => 'Please select a Parameter Group.',
            'parameter_name.*.required' => 'Please enter a Parameter Name.',
            'parameter_value.*.required' => 'Please enter a Parameter Value.',
        ];

        $validator = Validator::make($request->all(), [
            'assign_parameter_group_id' => ['required', 'exists:parameter_groups,id'],
            'parameter_name.*' => ['required', 'string', 'max:255'],
            'parameter_value.*' => ['required', 'string', 'max:999'],
        ], $customMessages);

        if ($validator->fails()) {
            return response()->json([
                'isSuccess' => false,
                'message' => 'Validation failed. Please check the inputs.',
                'errors' => $validator->errors()->toArray(),
            ], 200);
        }

        try {
            DB::beginTransaction();

            $parameterGroup = ParameterGroup::find($request->input('assign_parameter_group_id'));

            if (!$parameterGroup) {
                return response()->json([
                    'isSuccess' => false,
                    'message' => 'Invalid Parameter Group selected!',
                ], 200);
            }

            $parameterNames = (array) $request->input('parameter_name');
            $parameterValues = (array) $request->input('parameter_value');

            foreach ($parameterNames as $key => $parameterName) {
                $assignParameterValue = new AssignParameterValue();

                $assignParameterValue->parameter_name = $parameterName;
                $assignParameterValue->parameter_value = $parameterValues[$key];
                $assignParameterValue->parameter_group_id = $parameterGroup->id;

                if (!$assignParameterValue->save()) {
                    DB::rollBack();

                    return response()->json([
                        'isSuccess' => false,
                        'message' => 'Something went wrong while storing data!',
                    ], 200);
                }
            }

            DB::commit();

            return response()->json([
                'isSuccess' => true,
                'message' => 'Parameter Names and Values saved successfully!',
            ], 200);
        } catch (\Exception $e) {
            // Log detailed error information for debugging purposes
            \Log::error('Error in store method: ' . $e->getMessage());

            return response()->json([
                'isSuccess' => false,
                'message' => 'Something went wrong!',
                'error' => $e->getMessage(),
            ], 200);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        // dd($request->all());
        $customMessages = [
            'item-type-id.required' => 'Please select an Item Type.',
            'item-id.required' => 'Please select an Item.',
        ];

        $validator = Validator::make($request->all(), [
            'item-type-id' => ['required', 'exists:item_types,id'],
            'item-id' => ['required', 'exists:items,id'],
        ], $customMessages);

        if ($validator->passes()) {
            $itemId = $request->input('item-id');
            $itemTypeId = $request->input('item-type-id');

            $item = Items::find($itemId);
            $itemName = $item ? $item->name : 'Unknown Item';

            $itemType = Item_Type::find($itemTypeId);
            $itemTypeName = $itemType ? $itemType->name : 'Unknown Item Type';

            $parameterGroups = ParameterGroup::with('assignParameterValues')
                ->where('item_id', $itemId)
                ->get();

            foreach ($parameterGroups as $parameterGroup) {
                $treeNode = [
                    'parameterGroupId' => $parameterGroup->id,
                    'parameterGroupName' => $parameterGroup->name,
                    'parameterValues' => $parameterGroup->assignParameterValues->toArray(),
                ];

                $treeViewData[] = $treeNode;
            }

            return response()->json([
                'isSuccess' => true,
                'message' => 'Parameter Groups data successfully retrieved.',
                'treeViewData' => $treeViewData,
                'itemTypeId' => $itemTypeId,
                'itemTypeName' => $itemTypeName,
                'itemId' => $itemId,
                'itemName' => $itemName,
            ], 200);
        } else {
            return response()->json([
                'isSuccess' => false,
                'message' => "Validation failed. Please check the inputs!",
                'error' => $validator->errors()->toArray()
            ], 200);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        try {
            $id = $request->id;
            $data = AssignParameterValue::where('parameter_group_id', $id)->get();

            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Parameter Group Data not found'], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'id' => 'required',
            'parameter_name' => 'required',
            'parameter_value' => 'required',
        ]);

        try {
            $parameterValue = AssignParameterValue::findOrFail($validatedData['id']);
            $parameterValue->id = $validatedData['id'];
            $parameterValue->parameter_name = $validatedData['parameter_name'];
            $parameterValue->parameter_value = $validatedData['parameter_value'];

            $parameterLog = new ParameterLog();

            $parameterLog->item_type_id = $request->item_type_id;
            $parameterLog->item_id = $request->item_id;
            $parameterLog->parameter_group_id = $request->group_id;
            $parameterLog->parameter_id = $request->id;
            $parameterLog->parameter_name = $request->parameter_name;
            $parameterLog->user_id = Auth::user()->id;
            $parameterLog->action_type = "Update";

            if ($parameterValue->update()) {
                return response()->json([
                    'isSuccess' => true,
                    'message' => 'Parameters updated successfully!'
                ], 200);
            } else {
                return response()->json([
                    'isSuccess' => false,
                    'message' => 'Failed to update Parameters!'
                ], 200);
            }
        } catch (\Exception $e) {
            // Handle the exception, log the error, etc.
            return response()->json([
                'isSuccess' => false,
                'message' => 'Error updating Parameters!'
            ], 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id = $request->id;

        $parameterValue = AssignParameterValue::findOrFail($id);

        $parameterLog = new ParameterLog();

        $parameterLog->item_type_id = $request->item_type_id;
        $parameterLog->item_id = $request->item_id;
        $parameterLog->parameter_group_id = $request->group_id;
        $parameterLog->parameter_id = $request->id;
        $parameterLog->parameter_name = $request->parameter_name;
        $parameterLog->user_id = Auth::user()->id;
        $parameterLog->action_type = "Delete";

        if ($parameterValue) {
            if ($parameterValue->delete() ) {
                return response()->json([
                    'isSuccess' => true,
                    'message' => 'Parameters deleted successfully!'
                ], 200);
            } else {
                return response()->json([
                    'isSuccess' => false,
                    'message' => 'Failed to delete Parameters!'
                ], 200);
            }
        } else {
            return response()->json([
                'isSuccess' => false,
                'message' => 'Parameters not found!'
            ], 200);
        }
    }
}
