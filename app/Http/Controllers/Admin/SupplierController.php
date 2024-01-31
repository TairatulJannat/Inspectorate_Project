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
            $item->address_of_local_agent = $request->address_of_local_agent;
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

    public function edit(){

    }
    public function update(){

    }
    public function destroy($id)
    {
        $supplier = Supplier::findOrFail($id);

        if ($supplier->delete()) {
            return response()->json([
                'isSuccess' => true,
                'Message' => 'supplier deleted successfully!',
            ], 200);
        } else {
            return response()->json([
                'isSuccess' => false,
                'Message' => 'Something went wrong!',
            ], 500);
        }
    }
}
