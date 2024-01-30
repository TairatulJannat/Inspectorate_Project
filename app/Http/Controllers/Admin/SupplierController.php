<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminSection;
use Illuminate\Http\Request;


use App\Models\Section;
use App\Models\Supplier;
use Carbon\Carbon;
use DataTables;
use Validator;
use Illuminate\Support\Facades\Auth;

class SupplierController extends Controller
{
    //
    public function index()
    {
        $admin_id = Auth::user()->id;
        $inspectorate_id = Auth::user()->inspectorate_id;
        $section_ids = $section_ids = AdminSection::where('admin_id', $admin_id)->pluck('sec_id')->toArray();
        $suppliers = Supplier::where('insp_id', $inspectorate_id)->get();
        // try {
           

        // } catch (\Exception $e) {
        //     return back()->withError('Failed to retrieve Item Type.');
        // }
        

        return view('backend.supplier.index', compact('suppliers'));
    }

    // public function getAllData()
    // {
    //     $admin_id = Auth::user()->id;
    //     $inspectorate_id = Auth::user()->inspectorate_id;
    //     $section_ids = AdminSection::where('admin_id', $admin_id)->pluck('sec_id')->toArray();

    //     $items = Items::select('id', 'name', 'item_type_id', 'attribute')
    //         ->with('item_type')
    //         ->whereIn('section_id', $section_ids)
    //         ->where('inspectorate_id', $inspectorate_id )
    //         ->get();

    //     return DataTables::of($items)
    //         ->addColumn('DT_RowIndex', function ($item) {
    //             return $item->id; // You can use any unique identifier here
    //         })
    //         ->addColumn('item_type_name', function ($item) {
    //             return $item->item_type ? $item->item_type->name : '';
    //         })
    //         ->make(true);
    // }

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

       
       

            $item = new Supplier();
            $item->firm_name = $request->firm_name;
            $item->principal_name = $request->principal_name;
            $item->address_of_principal = $request->address_of_principal;
            $item->insp_id = Auth::user()->inspectorate_id;
            
            $item->contact_no = $request->contact_no;
            $item->email = $request->email;
            $item->created_at = Carbon::now();
            $item->updated_at = Carbon::now();
            $item->created_by = Auth::user()->id;
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
        
        return response()->json([
                    'isSuccess' => false,
                    'Message' => "Please check the inputs!",
                     
                 ], 200);
    }

    /**
     * Display the specified resource.
     */
    // public function show(Request $request)
    // {
    //     try {
    //         $id = $request->id;
    //         $item = Items::findOrFail($id);

    //         return response()->json([
    //             'id' => $item->id,
    //             'inspectorate_id' => $item->inspectorate_id,
    //             'name' => $item->name,
    //             'item_type_id' => $item->item_type->name,
    //             'attribute' => $item->attribute,
    //             'created_at' => $item->created_at,
    //             'updated_at' => $item->updated_at,
    //         ]);
    //     } catch (\Exception $e) {
    //         return response()->json(['error' => 'Item Type not found'], 404);
    //     }
    // }

    /**
     * Show the form for editing the specified resource.
     */
    // public function edit(Request $request)
    // {
    //     try {
    //         $id = $request->id;
    //         $item = Items::findOrFail($id);
    //         return response()->json($item);
    //     } catch (\Exception $e) {
    //         return response()->json(['error' => 'Item not found'], 404);
    //     }
    // }

    /**
     * Update the specified resource in storage.
     */
    // public function update(Request $request)
    // {

    //     $validator = Validator::make($request->all(), [
    //         'edit_name' => ['required', 'string', 'max:255'],
    //         'edit_item_type_id' => ['required', 'exists:item_types,id'],
    //         'edit_attribute' => ['required', 'string', 'max:255'],
    //         'editItemSection' => ['required','max:255'],
    //     ]);

    //     if ($validator->passes()) {
    //         try {
    //             $id = $request->edit_item_id;
    //             $item = Items::findOrFail($id);

    //             $item->name = $request->edit_name;
    //             $item->item_type_id = $request->edit_item_type_id;
    //             $item->inspectorate_id = $request->edit_item_inspectorate_id;
    //             $item->attribute = $request->edit_attribute;
    //             $item->section_id = $request->editItemSection;

    //             if ($item->save()) {
    //                 return response()->json([
    //                     'isSuccess' => true,
    //                     'Message' => "Item updated successfully!"
    //                 ], 200);
    //             } else {
    //                 return response()->json([
    //                     'isSuccess' => false,
    //                     'Message' => "Something went wrong while updating!"
    //                 ], 200);
    //             }
    //         } catch (\Exception $e) {
    //             return response()->json([
    //                 'isSuccess' => false,
    //                 'Message' => "Item not found!"
    //             ], 404);
    //         }
    //     } else {
    //         return response()->json([
    //             'isSuccess' => false,
    //             'Message' => "Please check the inputs!",
    //             'error' => $validator->errors()->toArray(),
    //         ], 200);
    //     }
    // }

    /**
     * Remove the specified resource from storage.
     */
    // public function destroy(Request $request)
    // {
    //     $id = $request->id;

    //     $item = Items::find($id);

    //     if ($item) {
    //         if ($item->delete()) {
    //             return response()->json([
    //                 'isSuccess' => true,
    //                 'Message' => 'Item deleted successfully!'
    //             ], 200); // Status code here
    //         } else {
    //             return response()->json([
    //                 'isSuccess' => false,
    //                 'Message' => 'Failed to delete Item!'
    //             ], 200); // Status code here
    //         }
    //     } else {
    //         return response()->json([
    //             'isSuccess' => false,
    //             'Message' => 'Item not found!'
    //         ], 200); // Status code here
    //     }
    // }
}