<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Item_type;
use DataTables;
use Validator;

class ItemTypesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('backend.item-types.index');
    }

    public function getAllData()
    {
        $item_types = Item_type::select('id', 'name', 'status');

        return DataTables::of($item_types)
            ->addColumn('DT_RowIndex', function ($item_type) {
                return $item_type->id; // You can use any unique identifier here
            })
            ->addColumn('name', function ($item_type) {
                return $item_type->name;
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
        ]);

        if ($validator->passes()) {
            $itemType = new Item_type();

            $itemType->name = $request->name;
            $itemType->status = $request->has('status') ? 1 : 0;

            if ($itemType->save()) {
                return response()->json([
                    'isSuccess' => true,
                    'Message' => "Item Type Saved successfully!"
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
            $itemType = Item_type::findOrFail($id);

            return response()->json([
                'id' => $itemType->id,
                'name' => $itemType->name,
                'status' => $itemType->status,
                'created_at' => $itemType->created_at,
                'updated_at' => $itemType->updated_at,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Item Type not found'], 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        try {
            $id = $request->id;
            $itemType = Item_type::findOrFail($id);

            return response()->json([
                'id' => $itemType->id,
                'name' => $itemType->name,
                'status' => $itemType->status,
                'created_at' => $itemType->created_at,
                'updated_at' => $itemType->updated_at,
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
            'edit_name' => ['required', 'string', 'max:255'],
        ]);

        if ($validator->passes()) {
            try {
                $id = $request->edit_item_type_id;
                $itemType = Item_type::findOrFail($id);

                $itemType->name = $request->edit_name;
                $itemType->status = $request->has('status') ? 1 : 0;

                if ($itemType->save()) {
                    return response()->json([
                        'isSuccess' => true,
                        'Message' => "Item Type updated successfully!"
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
                    'Message' => "Item Type not found!"
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

        $item_type = Item_type::find($id);

        if ($item_type) {
            if ($item_type->delete()) {
                return response()->json([
                    'isSuccess' => true,
                    'Message' => 'Item Type deleted successfully!'
                ], 200); // Status code here
            } else {
                return response()->json([
                    'isSuccess' => false,
                    'Message' => 'Failed to delete Item Type!'
                ], 200); // Status code here
            }
        } else {
            return response()->json([
                'isSuccess' => false,
                'Message' => 'Item Type not found!'
            ], 200); // Status code here
        }
    }
}
