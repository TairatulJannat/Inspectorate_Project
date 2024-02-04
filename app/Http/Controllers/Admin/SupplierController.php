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

    public function edit($id)
    {
        $supplier = Supplier::find($id);
        if (!$supplier) {
            return response()->json(['error' => 'Supplier not found'], 404);
        }

        return response()->json(['supplier' => $supplier]);
    }
    public function update(Request $request)
    {

        // Validate the request data
        $request->validate([
            'update_id' => 'required|exists:suppliers,id',
            'editfirm_name' => 'required|string',
            'editprincipal_name' => 'required|string',
            'editaddress_of_local_agent' => 'required|string',
            'editaddress_of_principal' => 'required|string',
            'editcontact_no' => 'required|string',
            'editemail' => 'required|email',
            // Add other validation rules for your fields
        ]);

        // Find the supplier by ID
        $supplier = Supplier::find($request->update_id);

        if (!$supplier) {
            return response()->json(['error' => 'Supplier not found'], 404);
        }

        // Update the supplier fields based on the request data
        $supplier->firm_name = $request->editfirm_name;
        $supplier->principal_name = $request->editprincipal_name;
        $supplier->address_of_local_agent = $request->editaddress_of_local_agent;
        $supplier->address_of_principal = $request->editaddress_of_principal;
        $supplier->contact_no = $request->editcontact_no;
        $supplier->email = $request->editemail;

        // Add other fields as needed

        // Save the changes
        $supplier->save();

        // Return a success response
        return response()->json(['success' => 'Supplier updated successfully']);
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
