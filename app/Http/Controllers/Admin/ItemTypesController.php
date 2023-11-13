<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Item_type;
use App\Models\Items;
use DataTables;
use Validator;

class ItemTypesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $items = Items::all();
        } catch (\Exception $e) {
            // Handle the exception (e.g., log it or show a user-friendly error message)
            return back()->withError('Failed to retrieve items.');
        }

        return view('backend.item-types.index', compact('items'));
    }

    public function getAllData()
    {
        $item_types = Item_type::select('id', 'item_id', 'name', 'status');

        return DataTables::of($item_types)
            ->addColumn('DT_RowIndex', function ($item_type) {
                return $item_type->id; // You can use any unique identifier here
            })
            ->addColumn('item_name', function ($item_type) {
                return $item_type->item ? $item_type->item->name : '';
            })
            ->addColumn('status', function ($item_type) {
                return $item_type->status == 1 ? 'Active' : 'Inactive';
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
            'item_id' => ['required', 'exists:items,id'],
        ]);

        if ($validator->passes()) {
            $itemType = new Item_type();

            $itemType->name = $request->name;
            $itemType->item_id = $request->item_id;
            $itemType->status = $request->has('status') ? 1 : 0;

            if ($itemType->save()) {
                return response()->json([
                    'isSuccess' => true,
                    'Message' => "Item Type Saved successfully!",
                    'code' => 1,
                ], 200);
            } else {
                return response()->json([
                    'isSuccess' => false,
                    'Message' => "Something went wrong!",
                    'code' => 0,
                ], 200);
            }
        } else {
            return response()->json([
                'isSuccess' => false,
                'Message' => "Please check the inputs!",
                'code' => 0,
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
            $itemType = Item_type::findOrFail($id);

            // Access the associated item
            $item = $itemType->item;

            if (!$item) {
                return response()->json(['error' => 'Associated item not found'], 404);
            }

            // Adjust the response as needed
            return response()->json([
                'id' => $itemType->id,
                'item_id' => $itemType->item_id,
                'name' => $itemType->name,
                'status' => $itemType->status,
                'created_at' => $itemType->created_at,
                'updated_at' => $itemType->updated_at,
                'item_name' => $item->name,
                'item_attribute' => $item->attribute,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Item Type not found'], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'edit_item_id' => ['required', 'exists:item_types,item_id'],
            'edit_name' => ['required', 'string', 'max:255'],
        ]);

        if ($validator->passes()) {
            try {
                $id = $request->edit_item_type_id;
                $itemType = Item_type::findOrFail($id);

                $itemType->item_id = $request->edit_item_id;
                $itemType->name = $request->edit_name;
                $itemType->status = $request->has('status') ? 1 : 0;

                if ($itemType->save()) {
                    return response()->json([
                        'isSuccess' => true,
                        'Message' => "Item Type updated successfully!",
                        'code' => 1,
                    ], 200);
                } else {
                    return response()->json([
                        'isSuccess' => false,
                        'Message' => "Something went wrong while updating!",
                        'code' => 0,
                    ], 200);
                }
            } catch (\Exception $e) {
                return response()->json([
                    'isSuccess' => false,
                    'Message' => "Item Type not found!",
                    'code' => 0,
                ], 404);
            }
        } else {
            return response()->json([
                'isSuccess' => false,
                'Message' => "Please check the inputs!",
                'code' => 0,
                'error' => $validator->errors()->toArray(),
            ], 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
