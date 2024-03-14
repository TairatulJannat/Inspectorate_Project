<?php

namespace App\Http\Controllers\Admin;

use App\Models\Items;
use App\Models\Item_type;
use App\Models\ParameterLog;
use Illuminate\Http\Request;
use App\Models\ParameterGroup;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\AssignParameterValue;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

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
            'parameter_name.required' => 'Please enter a Parameter Name.',
            'parameter_value.required' => 'Please enter a Parameter Value.',
            'indentRefNo.required' => 'Indent Ref. No. required.',
        ];

        $validator = Validator::make($request->all(), [
            'assign_parameter_group_id' => ['required', 'exists:parameter_groups,id'],
            'parameter_name' => ['required', 'string', 'max:255'],
            'parameter_value' => ['required', 'string', 'max:999'],
            'indentRefNo' => ['required', 'string', 'max:255'],
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

            $assignParameterValues = [];

            foreach ($parameterNames as $key => $parameterName) {
                $assignParameterValue = new AssignParameterValue();

                $assignParameterValue->parameter_name = $parameterName;
                $assignParameterValue->parameter_value = $parameterValues[$key];
                $assignParameterValue->parameter_group_id = $parameterGroup->id;
                $assignParameterValue->doc_type_id = 3;
                $assignParameterValue->reference_no = $request->input('indentRefNo');

                $assignParameterValues[] = $assignParameterValue;
            }

            foreach ($assignParameterValues as $assignParameterValue) {
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
            DB::rollBack();
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
        $customMessages = [
            'item-type-id.required' => 'Please select an Item Type.',
            'item-id.required' => 'Please select an Item.',
            'indentRefNo.required' => 'Indent Ref No. is required.',
        ];

        $validator = Validator::make($request->all(), [
            'item-type-id' => ['required', 'exists:item_types,id'],
            'item-id' => ['required', 'exists:items,id'],
            'indentRefNo' => ['required', 'exists:indents,reference_no'],
        ], $customMessages);

        if ($validator->passes()) {
            $itemId = $request->input('item-id');
            $itemTypeId = $request->input('item-type-id');
            $indentRefNo = $request->input('indentRefNo');

            $item = Items::find($itemId);
            $itemName = $item ? $item->name : 'Unknown Item';

            $itemType = Item_Type::find($itemTypeId);
            $itemTypeName = $itemType ? $itemType->name : 'Unknown Item Type';

            $parameterGroups = ParameterGroup::with(['assignParameterValues' => function ($query) {
                $query->where('doc_type_id', 3);
            }])
                ->where('item_id', $itemId)
                ->where('reference_no', $indentRefNo)
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
                'message' => 'Parameters Data successfully retrieved!',
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
            $data = AssignParameterValue::where('parameter_group_id', $id)->where('doc_type_id', 3)->get();

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

        DB::beginTransaction();

        try {
            $parameterValue = AssignParameterValue::findOrFail($validatedData['id']);
            $parameterValue->id = $validatedData['id'];
            $parameterValue->parameter_name = $validatedData['parameter_name'];
            $parameterValue->parameter_value = $validatedData['parameter_value'];

            // $parameterLog = new ParameterLog();

            // $parameterLog->item_type_id = $request->item_type_id;
            // $parameterLog->item_id = $request->item_id;
            // $parameterLog->parameter_group_id = $request->group_id;
            // $parameterLog->parameter_id = $request->id;
            // $parameterLog->parameter_name = $request->parameter_name;
            // $parameterLog->user_id = Auth::user()->id;
            // $parameterLog->action_type = "Update";

            $result = $parameterValue->update();

            // if ($parameterValue->update() && $parameterLog->save()) {
            if ($result) {
                DB::commit();
                return response()->json([
                    'isSuccess' => true,
                    'message' => 'Parameters updated successfully!'
                ], 200);
            } else {
                DB::rollBack();
                return response()->json([
                    'isSuccess' => false,
                    'message' => 'Failed to update Parameters!'
                ], 200);
            }
        } catch (\Exception $e) {
            DB::rollBack();
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

        DB::beginTransaction();

        try {
            $parameterValue = AssignParameterValue::findOrFail($id);

            // $parameterLog = new ParameterLog();

            // $parameterLog->item_type_id = $request->item_type_id;
            // $parameterLog->item_id = $request->item_id;
            // $parameterLog->parameter_group_id = $request->group_id;
            // $parameterLog->parameter_id = $request->id;
            // $parameterLog->parameter_name = $request->parameter_name;
            // $parameterLog->user_id = Auth::user()->id;
            // $parameterLog->action_type = "Delete";

            $result = $parameterValue->delete();


            if ($result) {
                DB::commit();
                return response()->json([
                    'isSuccess' => true,
                    'message' => 'Parameters deleted successfully!'
                ], 200);
            } else {
                DB::rollBack();
                return response()->json([
                    'isSuccess' => false,
                    'message' => 'Failed to delete Parameters!'
                ], 200);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            // Handle the exception, log the error, etc.
            return response()->json([
                'isSuccess' => false,
                'message' => 'Error deleting Parameters!'
            ], 200);
        }
    }
}
