<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ParameterGroup;
use App\Models\AssignParameterValue;
use App\Models\Items;
use App\Models\Item_type;
use Illuminate\Support\Facades\DB;
use Validator;

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
            'assign-parameter-group-id.required' => 'Please select a Parameter Group.',
            'parameter-name.*.required' => 'Please enter a Parameter Name.',
            'parameter-value.*.required' => 'Please enter a Parameter Value.',
        ];

        $validator = Validator::make($request->all(), [
            'assign-parameter-group-id' => ['required', 'exists:parameter_groups,id'],
            'parameter-name.*' => ['required', 'string', 'max:255'],
            'parameter-value.*' => ['required', 'string', 'max:999'],
        ], $customMessages);

        if ($validator->passes()) {
            try {
                DB::beginTransaction();

                $parameterGroup = ParameterGroup::find($request->input('assign-parameter-group-id'));

                if (!$parameterGroup) {
                    return response()->json([
                        'isSuccess' => false,
                        'Message' => "Invalid Parameter Group selected!",
                    ], 200);
                }

                $parameterNames = $request->input('parameter-name');
                $parameterValues = $request->input('parameter-value');

                foreach ($parameterNames as $key => $parameterName) {
                    $assignParameterValue = new AssignParameterValue();

                    $assignParameterValue->parameter_name = $parameterName;
                    $assignParameterValue->parameter_value = $parameterValues[$key];
                    $assignParameterValue->parameter_group_id = $parameterGroup->id;

                    // Additional logic as needed

                    if (!$assignParameterValue->save()) {
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
                    'Message' => "Parameter Names and Values saved successfully!",
                ], 200);
            } catch (\Exception $e) {
                // Log detailed error information for debugging purposes
                \Log::error('Error in store method: ' . $e->getMessage());

                return response()->json([
                    'isSuccess' => false,
                    'Message' => "Something went wrong!",
                    'Error' => $e->getMessage(),
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
                'Message' => 'Parameter Groups data successfully retrieved.',
                'treeViewData' => $treeViewData,
                'itemTypeId' => $itemTypeId,
                'itemTypeName' => $itemTypeName,
                'itemId' => $itemId,
                'itemName' => $itemName,
            ], 200);
        } else {
            return response()->json([
                'isSuccess' => false,
                'Message' => "Validation failed. Please check the inputs!",
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
