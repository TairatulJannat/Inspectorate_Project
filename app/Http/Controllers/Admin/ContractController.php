<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Contract;
use App\Models\Supplier;
use Validator;


class ContractController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        return view('backend.contracts.index');

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            $suppliers = Supplier::all();
        } catch (\Exception $e) {
            return back()->withError('Failed to retrieve from Database.');
        }
        return view('backend.contracts.create', compact('suppliers'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $customMessages = [
            'ltr-no-of-contract.required' => 'The letter No. of Contract field is required.',
            'ltr-date-contract.required' => 'The letter Date Contract field is required.',
            'ltr-date-contract.date' => 'The letter Date Contract must be a valid date.',
            'contract-no.required' => 'The Contract No. field is required.',
            'contract-date.required' => 'The Contract Date field is required.',
            'contract-date.date' => 'The Contract Date must be a valid date.',
            'contract-state.required' => 'The Contract State field is required.',
            'con-fin-year.required' => 'The Contract Financial Year field is required.',
            'supplier-id.required' => 'The Supplier field is required.',
            'supplier-id.integer' => 'The Supplier must be an integer.',
            'supplier-id.exists' => 'The selected Supplier is invalid.',
            'contracted-value.required' => 'The Contracted Value field is required.',
            'contracted-value.numeric' => 'The Contracted Value must be a number.',
            'delivery-schedule.required' => 'The Delivery Schedule field is required.',
            'currency-unit.required' => 'The Currency Unit field is required.',
        ];

        $validator = Validator::make($request->all(), [
            'ltr-no-of-contract' => ['required', 'string', 'max:255'],
            'ltr-date-contract' => ['required', 'date'],
            'contract-no' => ['required', 'string', 'max:255'],
            'contract-date' => ['required', 'date'],
            'contract-state' => ['required', 'string', 'max:255'],
            'con-fin-year' => ['required', 'string', 'max:255'],
            'supplier-id' => ['required', 'integer', 'exists:suppliers,id'],
            'contracted-value' => ['required', 'numeric'],
            'delivery-schedule' => ['required', 'string'],
            'currency-unit' => ['required', 'string', 'max:255'],
        ], $customMessages);


        if ($validator->passes()) {
            try {
                DB::beginTransaction();

                $contract = new Contract();
                $contract->ltr_no_of_contract = $request->input('ltr-no-of-contract');
                $contract->ltr_date_contract = $request->input('ltr-date-contract');
                $contract->contract_no = $request->input('contract-no');
                $contract->contract_date = $request->input('contract-date');
                $contract->contract_state = $request->input('contract-state');
                $contract->con_fin_year = $request->input('con-fin-year');
                $contract->supplier_id = $request->input('supplier-id');
                $contract->contracted_value = $request->input('contracted-value');
                $contract->delivery_schedule = $request->input('delivery-schedule');
                $contract->currency_unit = $request->input('currency-unit');

                if (!$contract->save()) {
                    DB::rollBack();

                    return response()->json([
                        'isSuccess' => false,
                        'Message' => "Something went wrong while storing data!",
                    ], 200);
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
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
