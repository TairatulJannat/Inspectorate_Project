<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminSection;
use Illuminate\Http\Request;
use App\Models\Items;
use App\Models\Item_type;
use DataTables;
use Validator;
use Illuminate\Support\Facades\Auth;

class ItemsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $inspectorate_id = Auth::user()->inspectorate_id;
        try {
            $item_types = Item_type::where('inspectorate_id', $inspectorate_id)->get();
        } catch (\Exception $e) {
            return back()->withError('Failed to retrieve Item Type.');
        }

        return view('backend.items.index', compact('item_types'));
    }

    public function getAllData()
    {
        $admin_id = Auth::user()->id;
        $section_ids = AdminSection::where('admin_id', $admin_id)->pluck('sec_id')->toArray();

        $items = Items::select('id', 'name', 'item_type_id', 'attribute')
            ->with('item_type')
            ->get();

        return DataTables::of($items)
            ->addColumn('DT_RowIndex', function ($item) {
                return $item->id; // You can use any unique identifier here
            })
            ->addColumn('item_type_name', function ($item) {
                return $item->item_type ? $item->item_type->name : '';
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
            'item_type_id' => ['required', 'exists:item_types,id'],
            'attribute' => ['required', 'string', 'max:255'],
        ]);

        if ($validator->passes()) {

            $item = new Items();
            $item->name = $request->name;
            $item->item_type_id = $request->item_type_id;
            $item->inspectorate_id = Auth::user()->inspectorate_id;
            $item->attribute = $request->attribute;

            if ($item->save()) {
                return response()->json([
                    'isSuccess' => true,
                    'Message' => "Item Saved successfully!"
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
            $item = Items::findOrFail($id);

            return response()->json([
                'id' => $item->id,
                'inspectorate_id' => $item->inspectorate_id,
                'name' => $item->name,
                'item_type_id' => $item->item_type->name,
                'attribute' => $item->attribute,
                'created_at' => $item->created_at,
                'updated_at' => $item->updated_at,
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
            $item = Items::findOrFail($id);
            return response()->json($item);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Item not found'], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'edit_name' => ['required', 'string', 'max:255'],
            'edit_item_type_id' => ['required', 'exists:item_types,id'],
            'edit_attribute' => ['required', 'string', 'max:255'],
        ]);

        if ($validator->passes()) {
            try {
                $id = $request->edit_item_id;
                $item = Items::findOrFail($id);

                $item->name = $request->edit_name;
                $item->item_type_id = $request->edit_item_type_id;
                $item->inspectorate_id = $request->edit_item_inspectorate_id;
                $item->attribute = $request->edit_attribute;

                if ($item->save()) {
                    return response()->json([
                        'isSuccess' => true,
                        'Message' => "Item updated successfully!"
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
                    'Message' => "Item not found!"
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

        $item = Items::find($id);

        if ($item) {
            if ($item->delete()) {
                return response()->json([
                    'isSuccess' => true,
                    'Message' => 'Item deleted successfully!'
                ], 200); // Status code here
            } else {
                return response()->json([
                    'isSuccess' => false,
                    'Message' => 'Failed to delete Item!'
                ], 200); // Status code here
            }
        } else {
            return response()->json([
                'isSuccess' => false,
                'Message' => 'Item not found!'
            ], 200); // Status code here
        }
    }
}
