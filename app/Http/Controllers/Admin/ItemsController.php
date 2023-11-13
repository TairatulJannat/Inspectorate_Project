<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Items;
use DataTables;
use Validator;

class ItemsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('backend.items.index');
    }

    public function getAllData()
    {
        $items = Items::select('id', 'name', 'attribute');

        return DataTables::of($items)
            ->addColumn('DT_RowIndex', function ($item) {
                return $item->id; // You can use any unique identifier here
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
            'attribute' => ['required', 'string', 'max:255'],
        ]);

        if ($validator->passes()) {

            $item = new Items();

            $item->name = $request->name;
            $item->attribute = $request->attribute;

            // dd($item);

            if ($item->save()) {
                return response()->json([
                    'isSuccess' => true,
                    'Message' => "Item Saved successfully!",
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
            'edit_attribute' => ['required', 'string', 'max:255'],
        ]);

        if ($validator->passes()) {
            try {
                $id = $request->edit_item_id;
                $item = Items::findOrFail($id);

                $item->name = $request->edit_name;
                $item->attribute = $request->edit_attribute;

                if ($item->save()) {
                    return response()->json([
                        'isSuccess' => true,
                        'Message' => "Item updated successfully!",
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
                    'Message' => "Item not found!",
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
