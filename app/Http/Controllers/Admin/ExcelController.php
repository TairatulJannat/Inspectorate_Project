<?php

namespace App\Http\Controllers\Admin;

use Log;
use Validator;
use App\Models\Items;
use App\Models\Offer;
use App\Models\Indent;
use App\Models\Tender;
use App\Models\Supplier;
use App\Models\FinalSpec;
use App\Models\Item_type;
use App\Models\Inspectorate;
use Illuminate\Http\Request;
use App\Models\DraftContract;
use App\Models\SupplierOffer;
use App\Models\ParameterGroup;
use App\Imports\FinalSpecImport;
use App\Models\SupplierSpecData;
use App\Imports\IndentSpecImport;
use Illuminate\Support\Facades\DB;
use App\Imports\SupplierSpecImport;
use App\Http\Controllers\Controller;
use App\Models\AssignParameterValue;
use App\Models\Contract;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Maatwebsite\Excel\Exceptions\SheetNotFoundException;
use Maatwebsite\Excel\Exceptions\UnreadableFileException;

class ExcelController extends Controller
{
    protected function csrIndex()
    {
        try {
            $items = Items::all();
            $itemTypes = Item_type::all();
            $indents = Indent::all();
            $suppliers = Supplier::all();
            $tenders = Tender::with('indent')->get();
            // foreach ($tenders as $tender) {
            //     if ($tender->indent) {
            //         $tender->reference_no = $tender->reference_no . ' (' . $tender->indent->reference_no . ')';
            //     }
            // }
        } catch (\Exception $e) {
            return redirect()->to('admin/csr/index')->with('error', 'Failed to retrieve from Database.');
        }
        return view('backend.csr.csr-index', compact('items', 'itemTypes', 'tenders'));
    }


    public function getCSRData($request)
    {
        dd($request);
        $customMessages = [
            'tender-id.required' => 'Please select an Tender.',
        ];

        $validator = Validator::make($request->all(), [
            'tender-id' => ['required', 'exists:tenders,id'],
        ], $customMessages);

        if ($validator->passes()) {
            $tenderData = Tender::findOrFail($request->input('tender-id'));

            $offerData = Offer::where('tender_reference_no', $tenderData->id)->first();

            $itemId = $offerData->item_id;

            $itemTypeId = $offerData->item_type_id;

            $item = Items::findOrFail($itemId);
            $itemName = $item ? $item->name : 'Unknown Item';

            $itemType = Item_Type::findOrFail($itemTypeId);
            $itemTypeName = $itemType ? $itemType->name : 'Unknown Item Type';

            $indentData = Indent::where('item_id', $itemId)->get();

            if ($indentData->isNotEmpty()) {
                $indentRefNo = $indentData[0]['reference_no'];
            } else {
                $indentRefNo = 'Indent Reference Number not found';
            }

            $tenderData = Tender::where('id', $offerData->tender_reference_no)->get();


            if ($tenderData->isNotEmpty()) {
                $tenderRefNo = $tenderData[0]['reference_no'];
            } else {
                $tenderRefNo = 'Tender Reference Number not found';
            }

            $parameterGroupsExist = ParameterGroup::where('item_id', $itemId)
                ->exists();

            if ($parameterGroupsExist) {
                $supplierParameterGroups = ParameterGroup::with('supplierSpecData')
                    ->where('item_id', $itemId)
                    ->get();

                $organizedSupplierData = $this->organizeData($supplierParameterGroups);

                $parameterGroups = ParameterGroup::with('assignParameterValues')
                    ->where('item_id', $itemId)
                    ->get();

                $responseData = $parameterGroups->map(function ($parameterGroup) {
                    $groupName = $parameterGroup->name;

                    return [
                        $groupName => $parameterGroup->assignParameterValues->map(function ($parameter) {
                            return [
                                'id' => $parameter->id,
                                'parameter_name' => $parameter->parameter_name,
                                'parameter_value' => $parameter->parameter_value,
                            ];
                        })
                    ];
                })->values()->all();

                foreach ($responseData as $group => &$parameterGroup) {
                    if (is_array($parameterGroup)) {
                        foreach ($parameterGroup as &$parameters) {
                            for ($i = 0; $i < count($parameters); $i++) {
                                $parameter = $parameters[$i];

                                if (is_array($parameter) && isset($parameter['id'])) {
                                    $parameterId = $parameter['id'];

                                    if (isset($organizedSupplierData[$parameterId])) {
                                        $spValues = $organizedSupplierData[$parameterId];

                                        $newParameter = $parameter;

                                        foreach ($spValues as $index => $spValue) {
                                            $spName = Supplier::where('id', $spValue['supplier_id'])->first();
                                            $newParameter["Supplier_" . $spName->firm_name] = $spValue['parameter_value'];
                                        }

                                        $parameters[$i] = $newParameter;
                                    }
                                }
                            }
                        }
                    }
                }

                return response()->json([
                    'isSuccess' => true,
                    'message' => 'Parameters Data successfully retrieved!',
                    'combinedData' => $responseData,
                    'itemTypeId' => $itemTypeId,
                    'itemTypeName' => $itemTypeName,
                    'itemId' => $itemId,
                    'itemName' => $itemName,
                    'indentRefNo' => $indentRefNo,
                    'tenderRefNo' => $tenderRefNo,
                ], 200);
            } else {
                return response()->json([
                    'isSuccess' => false,
                    'message' => "Data not found for this Item. Please check the inputs!",
                ], 200);
            }
        } else {
            return response()->json([
                'isSuccess' => false,
                'message' => "Validation failed. Please check the inputs!",
                'error' => $validator->errors()->toArray()
            ], 200);
        }
    }

    private function organizeData($parameterGroups)
    {
        $result = [];

        foreach ($parameterGroups as $parameterGroup) {
            foreach ($parameterGroup->supplierSpecData as $parameter) {
                $parameterId = $parameter->parameter_id;

                if (!isset($result[$parameterId])) {
                    $result[$parameterId] = [];
                }

                $result[$parameterId][] = [
                    'parameter_value' => $parameter->parameter_value,
                    'supplier_id' => $parameter->supplier_id,
                ];
            }
        }
        return $result;
    }

    public function indentIndex()
    {
        try {
            $items = Items::all();
            $itemTypes = Item_type::all();
        } catch (\Exception $e) {
            return back()->withError('Failed to retrieve from Database.');
        }
        return view('backend.excel-files.import-indent-spec-data', compact('items', 'itemTypes'));
    }

    public function importIndentEditedData(Request $request)
    {
        $request->validate([
            'item-type-id' => ['required', 'exists:item_types,id'],
            'item-id' => ['required', 'exists:items,id'],
            'file' => 'required|mimes:xlsx,csv|max:2048',
        ], [
            'item-type-id.required' => __('Please choose an Item Type ID.'),
            'item-id.required' => __('Please choose an Item ID.'),
            'file.required' => __('Please choose an Excel/CSV file.'),
            'file.mimes' => __('The file must be of type: xlsx, csv.'),
            'file.max' => __('The file size must not exceed 2048 kilobytes.'),
        ]);

        try {
            $importedData = Excel::toCollection(new IndentSpecImport, $request->file('file'))->first();

            $parameterGroups = [];
            $currentGroupName = null;

            foreach ($importedData->toArray() as $row) {
                if (empty(array_filter($row))) {
                    continue;
                }

                $groupName = trim($row[1]);
                // $groupName = preg_replace('/^[^\w\(\)\{\}\[\]]+|[^\w\(\)\{\}\[\]]+$/', '', $groupName);

                if ($groupName != null) {
                    $currentGroupName = $groupName;
                    $parameterGroups[$currentGroupName] = [];
                    continue;
                } else {
                    $groupName = $currentGroupName;
                }

                $parameterGroups[$groupName][] = [
                    'parameter_name' => trim($row[2]),
                    'parameter_value' => trim($row[3]),
                ];
            }

            $itemId = $request->input('item-id');
            $itemTypeId = $request->input('item-type-id');

            $item = Items::find($itemId);
            $itemName = $item ? $item->name : 'Unknown Item';

            $itemType = Item_Type::find($itemTypeId);
            $itemTypeName = $itemType ? $itemType->name : 'Unknown Item Type';

            $indentNo = $request->indentNo;
            $indentData = Indent::where('indent_number', $indentNo)->first();

            return view('backend.excel-files.display-imported-indent-data', [
                'parameterGroups' => $parameterGroups,
                'itemTypeId' => $itemTypeId,
                'itemTypeName' => $itemTypeName,
                'itemId' => $itemId,
                'itemName' => $itemName,
                'indentNo' => $indentNo,
                'indentRefNo' => $indentData->reference_no,
            ]);
        } catch (UnreadableFileException $e) {
            return redirect()->to('admin/import-indent-spec-data-index')->with('error', 'The uploaded file is unreadable.');
        } catch (SheetNotFoundException $e) {
            return redirect()->to('admin/import-indent-spec-data-index')->with('error', 'Sheet not found in the Excel file.');
        } catch (\Exception $e) {
            return redirect()->to('admin/import-indent-spec-data-index')->with('error', 'Error importing Excel file: ' . $e->getMessage());
        }
    }

    public function saveIndentEditedData(Request $request)
    {
        try {
            DB::beginTransaction();

            $jsonData = $request->input('editedData');
            $itemId = $request->input('item-id');
            $itemTypeId = $request->input('item-type-id');
            $indentRefNo = $request->input('indent-ref-no');

            $this->deleteAllParameterGroupsAndValues($itemId, $indentRefNo);

            foreach ($jsonData as $groupIndex => $parameterGroup) {
                $modifiedGroupName = $request->input("editedData.$groupIndex.parameter_group_name");

                $newGroup = $this->createParameterGroup($modifiedGroupName, $itemId, $itemTypeId, $indentRefNo);
                $lastInsertedId = $newGroup->id;

                foreach ($parameterGroup as $paramIndex => $parameter) {
                    if ($paramIndex === 'parameter_group_name') {
                        continue;
                    }

                    $parameterName = $request->input("editedData.$groupIndex.$paramIndex.parameter_name");
                    $parameterValue = $request->input("editedData.$groupIndex.$paramIndex.parameter_value");

                    $this->saveAssignParameterValues($lastInsertedId, $parameterName, $parameterValue, $indentRefNo);
                }
            }

            DB::commit();

            return redirect()->to('admin/indent/view')->with('success', 'Indent data saved successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error saving data: ' . $e->getMessage());

            return redirect()->route('admin.import-indent-spec-data-index')->with('error', 'Error saving data. Please check the logs for details.');
        }
    }

    private function deleteAllParameterGroupsAndValues($itemId, $indentRefNo)
    {
        $parameterGroups = ParameterGroup::where('item_id', $itemId)->where('reference_no', $indentRefNo)->get();

        foreach ($parameterGroups as $group) {
            $group->assignParameterValues()->delete();
            $group->delete();
        }
    }

    protected function getParameterGroup($itemId, $itemTypeId, $indentRefNo)
    {
        return ParameterGroup::where('item_id', $itemId)
            ->where('item_type_id', $itemTypeId)
            ->where('reference_no', $indentRefNo)
            ->first();
    }

    protected function createParameterGroup($name, $itemId, $itemTypeId, $indentRefNo)
    {
        $newGroup = new ParameterGroup();
        $newGroup->name = $name;
        $newGroup->item_id = $itemId;
        $newGroup->item_type_id = $itemTypeId;
        $newGroup->inspectorate_id = Auth::user()->inspectorate_id;
        $id = $newGroup->inspectorate_id;
        if (Auth::user()->id === 92) {
            $newGroup->section_id = 92;
        } else {
            $inspectorate = Inspectorate::find($id);
            $section = $inspectorate->section;
            $newGroup->section_id = $section->id;
        }
        $newGroup->reference_no = $indentRefNo;
        $newGroup->status = 1;

        $newGroup->save();

        return $newGroup;
    }

    protected function saveAssignParameterValues($parameterGroupId, $parameterName, $parameterValue, $indentRefNo)
    {
        AssignParameterValue::create([
            'parameter_group_id' => $parameterGroupId,
            'parameter_name' => $parameterName,
            'parameter_value' => $parameterValue,
            'doc_type_id' => 3,
            'reference_no' => $indentRefNo,
        ])->fresh();
    }

    protected function exportIndentEditedData($indentRefNo)
    {
        $parameterGroups = ParameterGroup::where('reference_no', $indentRefNo)
            ->with('assignParameterValues')
            ->get();

        $excelData = [];
        $sNo = 1;

        foreach ($parameterGroups as $group) {
            $first = true;
            if (count($group->assignParameterValues) > 0) {
                foreach ($group->assignParameterValues as $value) {
                    if ($first) {
                        $excelData[] = [
                            'S. No.' => $sNo++,
                            'Parameter Group Name' => $group->name,
                            'Parameter Name' => '',
                            'Parameter Value' => '',
                        ];
                        $first = false;
                    }
                    $excelData[] = [
                        'S. No.' => '',
                        'Parameter Group Name' => '',
                        'Parameter Name' => $value->parameter_name,
                        'Parameter Value' => $value->parameter_value,
                    ];
                }
            } else {
                $excelData[] = [
                    'S. No.' => $sNo++,
                    'Parameter Group Name' => $group->name,
                    'Parameter Name' => '',
                    'Parameter Value' => '',
                ];
            }
        }

        $fileName = "indent_data_{$indentRefNo}.xlsx";

        return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\IndentExport($excelData), $fileName);
    }

    protected function supplierIndex()
    {
        try {
            $items = Items::all();
            $itemTypes = Item_type::all();
            $indents = Indent::all();
            $suppliers = Supplier::all();
            $tenders = Tender::all();
        } catch (\Exception $e) {
            return back()->withError('Failed to retrieve from Database.');
        }
        return view('backend.excel-files.import-supplier-spec-data', compact('items', 'itemTypes', 'indents', 'suppliers', 'tenders'));
    }

    public function importSupplierEditedData(Request $request)
    {
        $request->validate([
            'item-type-id' => ['required', 'exists:item_types,id'],
            'item-id' => ['required', 'exists:items,id'],
            'indent-id' => ['required', 'exists:indents,id'],
            'supplier-id' => ['required', 'exists:suppliers,id'],
            'tender-id' => ['required', 'exists:tenders,id'],
            'file' => 'required|mimes:xlsx,csv|max:2048',
        ], [
            'item-type-id.required' => __('Please choose an Item Type ID.'),
            'item-id.required' => __('Please choose an Item ID.'),
            'indent-id.required' => __('Please choose an Indent ID.'),
            'supplier-id.required' => __('Please choose an Supplier ID.'),
            'tender-id.required' => __('Please choose an Tender ID.'),
            'file.required' => __('Please choose an Excel/CSV file.'),
            'file.mimes' => __('The file must be of type: xlsx, csv.'),
            'file.max' => __('The file size must not exceed 2048 kilobytes.'),
        ]);

        try {
            $importedData = Excel::toCollection(new SupplierSpecImport, $request->file('file'))->first();

            $parameterGroups = [];
            $currentGroupName = null;

            foreach ($importedData->toArray() as $row) {
                if (empty(array_filter($row))) {
                    continue;
                }

                $groupName = $row[1];

                if ($groupName !== null) {
                    $currentGroupName = $groupName;
                    $parameterGroups[$currentGroupName] = [];
                    continue;
                } else {
                    $groupName = $currentGroupName;
                }

                $parameterGroups[$groupName][] = [
                    'parameter_name' => trim($row[2]),
                    'indent_parameter_value' => trim($row[3]),
                    'parameter_value' => trim($row[4]),
                ];
            }

            $itemId = $request->input('item-id');
            $itemTypeId = $request->input('item-type-id');
            $indentId = $request->input('indent-id');
            $supplierId = $request->input('supplier-id');
            $tenderId = $request->input('tender-id');
            $offerRefNo = $request->input('offerRefNo');

            $item = Items::find($itemId);
            $itemName = $item ? $item->name : 'Unknown Item';

            $itemType = Item_Type::find($itemTypeId);
            $itemTypeName = $itemType ? $itemType->name : 'Unknown Item Type';

            $indent = Indent::find($indentId);
            $indentRefNo = $indent ? $indent->reference_no : 'Unknown Indent';

            $supplier = Supplier::find($supplierId);
            $supplierFirmName = $supplier ? $supplier->firm_name : 'Unknown Supplier';

            $tender = Tender::find($tenderId);
            $tenderRefNo = $tender ? $tender->reference_no : 'Unknown Tender';

            return view('backend.excel-files.display-imported-supplier-data', [
                'parameterGroups' => $parameterGroups,
                'itemTypeId' => $itemTypeId,
                'itemTypeName' => $itemTypeName,
                'itemId' => $itemId,
                'itemName' => $itemName,
                'indentId' => $indentId,
                'indentRefNo' => $indentRefNo,
                'supplierId' => $supplierId,
                'supplierFirmName' => $supplierFirmName,
                'tenderId' => $tenderId,
                'tenderRefNo' => $tenderRefNo,
                'offerRefNo' => $offerRefNo,
            ]);
        } catch (UnreadableFileException $e) {
            return redirect()->to('admin/import-supplier-spec-data-index')->with('error', 'The uploaded file is unreadable.');
        } catch (SheetNotFoundException $e) {
            return redirect()->to('admin/import-supplier-spec-data-index')->with('error', 'Sheet not found in the Excel file.');
        } catch (\Exception $e) {
            return redirect()->to('admin/import-supplier-spec-data-index')->with('error', 'Error importing Excel file: ' . $e->getMessage());
        }
    }

    public function saveSupplierEditedData(Request $request)
    {
        try {
            DB::beginTransaction();

            $jsonData = $request->input('editedData');
            $itemId = $request->input('item-id');
            $indentId = $request->input('indent-id');
            $tenderId = $request->input('tender-id');
            $offerRefNo = $request->input('offerRefNo');
            $supplierId = $request->input('supplier-id');
            $offerStatus = request('offer_status');
            $offerSummary = request('offer_summary');
            $remarksSummary = request('remarks_summary');

            $indentParameterGroups = ParameterGroup::where('item_id', $itemId)->get();
            $databaseParameterGroupCount = $indentParameterGroups->count();

            $parameterGroupCount = count($jsonData);

            if ($parameterGroupCount !== $databaseParameterGroupCount) {
                DB::rollBack();
                return redirect()->to('admin/import-supplier-spec-data-index')->with('error', 'Parameter group count mismatch. Please check the Excel File.');
            }

            // Delete existing data for the supplier and parameter groups
            foreach ($indentParameterGroups as $indentParameterGroup) {
                $parameterGroupId = $indentParameterGroup->id;

                SupplierSpecData::where('supplier_id', $supplierId)
                    ->where('parameter_group_id', $parameterGroupId)
                    ->delete();
            }

            $flag = true;

            foreach ($jsonData as $groupName => $parameterGroup) {

                $flag = false;

                foreach ($indentParameterGroups as $indentParameterGroup) {
                    if ($groupName == $indentParameterGroup->name) {
                        $flag = true;
                        break;
                    }
                }
            }

            if ($flag) {
                $tableName = 'assign_parameter_values';
                foreach ($indentParameterGroups as $indentParameterGroup) {
                    $parameterGroupId = $indentParameterGroup->id;

                    foreach ($jsonData as $groupName => $parameterGroup) {
                        if ($indentParameterGroup->name == $groupName) {
                            foreach ($parameterGroup as $pGroup) {
                                $newParameter = new SupplierSpecData();
                                $newParameter->parameter_group_id = $parameterGroupId;
                                $newParameter->parameter_name = $pGroup['parameter_name'];
                                $result = DB::table($tableName)
                                    ->select('id')
                                    ->where('parameter_group_id', $parameterGroupId)
                                    ->where('parameter_name', $pGroup['parameter_name'])
                                    ->first();
                                $newParameter->parameter_id = $result->id;
                                $newParameter->parameter_value = $pGroup['parameter_value'];
                                $newParameter->compliance_status = $pGroup['compliance_status'];
                                $newParameter->remarks = $pGroup['remarks'];
                                $newParameter->indent_id = $indentId;
                                $newParameter->offer_reference_no = $offerRefNo;
                                $newParameter->supplier_id = $supplierId;
                                $newParameter->tender_id = $tenderId;

                                $newParameter->save();
                            }
                        }
                    }
                }

                DB::commit();

                $item = Items::find($itemId);
                $itemName = $item ? $item->name : 'Unknown Item';

                $indent = Indent::find($indentId);
                $indentRefNo = $indent ? $indent->reference_no : 'Unknown Indent';

                $tender = Tender::find($tenderId);
                $tenderRefNo = $tender ? $tender->reference_no : 'Unknown Tender';

                $supplier = Supplier::find($supplierId);
                $supplierFirmName = $supplier ? $supplier->firm_name : 'Unknown Supplier';

                $supplierSpecData = SupplierSpecData::where('offer_reference_no', $offerRefNo)->get();

                $nonEmptyRemarks = $supplierSpecData->pluck('remarks')->filter()->toArray();

                $mergedRemarks = empty($nonEmptyRemarks) ? '' : '<ol><li>' . implode('</li><li>', $nonEmptyRemarks) . '</li></ol>';

                return view('backend.excel-files.display-saved-supplier-data', compact('mergedRemarks', 'offerRefNo', 'itemId', 'itemName', 'indentId', 'indentRefNo', 'tenderId', 'tenderRefNo', 'supplierId', 'supplierFirmName'));
            } else {
                DB::rollBack();
                return redirect()->to('admin/import-supplier-spec-data-index')->with('error', 'Parameter group Name mismatch. Please check the Excel File.');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error saving data: ' . $e->getMessage());

            return redirect()->to('admin/import-supplier-spec-data-index')->with('error', 'Error saving data. ' . $e->getMessage());
        }
    }

    // protected function displaySupplierEditedData(Request $request)
    // {
    //     return view('backend.excel-files.display-imported-supplier-data');
    // }

    protected function saveRemarksForSupplier(Request $request)
    {
        $itemId = $request['item-id'];
        $supplierId = $request['supplier-id'];
        $offerStatus = $request['offer_status'];
        $offerSummary = $request['offer_summary'];
        $remarksSummary = $request['remarks_summary'];
        $supplierOfferTableName = 'supplier_offers';

        try {
            DB::beginTransaction();

            // Check if the record exists
            $existingRecord = DB::table($supplierOfferTableName)
                ->select('id')
                ->where('supplier_id', $supplierId)
                ->where('item_id', $itemId)
                ->lockForUpdate() // Optional: Lock the record for update
                ->first();

            if ($existingRecord) {
                // Update the existing record
                DB::table($supplierOfferTableName)
                    ->where('id', $existingRecord->id)
                    ->update([
                        'offer_status' => $offerStatus,
                        'offer_summary' => $offerSummary,
                        'remarks_summary' => $remarksSummary,
                    ]);
            } else {
                // Insert a new record
                $newSupplierOffer = new SupplierOffer();
                $newSupplierOffer->supplier_id = $supplierId;
                $newSupplierOffer->item_id = $itemId;
                $newSupplierOffer->offer_status = $offerStatus;
                $newSupplierOffer->offer_summary = $offerSummary;
                $newSupplierOffer->remarks_summary = $remarksSummary;
                $newSupplierOffer->save();
            }

            DB::commit();

            return redirect()->to('admin/offer/view')->with('success', 'Supplier\'s Spec saved successfully.');
        } catch (\Exception $e) {
            DB::rollBack();

            \Log::error('Error saving supplier data: ' . $e->getMessage());

            return redirect()->to('admin/offer/view')->with('error', 'An error occurred while saving data.');
        }
    }

    protected function exportSupplierEditedData()
    {
    }

    public function fetchSupplierData(Request $request)
    {
        $tenderId = $request->input('tenderId');

        $tendersData = Tender::findOrFail($tenderId);

        if (!$tendersData) {
            return response()->json([
                'isSuccess' => false,
                'message' => 'Tender not found!',
            ]);
        }

        $indentsData = Indent::where('reference_no', $tendersData->indent_reference_no)->first();

        if (!$indentsData) {
            return response()->json([
                'isSuccess' => false,
                'message' => 'Indent not found for this Tender!',
            ]);
        }

        $supplierIds = SupplierSpecData::where('tender_id', $tenderId)
            ->groupBy('supplier_id')
            ->pluck('supplier_id');

        $suppliersData = Supplier::whereIn('id', $supplierIds)->get();

        $offerData = Offer::where('tender_reference_no', $tendersData->reference_no)->first();
        $selectedSupplierIds = json_decode($offerData->supplier_id);
        $suppliers = Supplier::whereIn('id', $selectedSupplierIds)->get();

        if ($supplierIds->isEmpty()) {
            return response()->json([
                'isSuccess' => false,
                'message' => 'No supplier spec has been imported yet!',
                'suppliers' => $suppliers,
                'tendersData' => $tendersData->indent_reference_no,
                'indentId' => $indentsData->id,
                'itemTypeId' => $indentsData->item_type_id,
                'itemId' => $indentsData->item_id,
            ]);
        }

        return response()->json([
            'isSuccess' => true,
            'suppliers' => $suppliers,
            'suppliersData' => $suppliersData,
            'tendersData' => $tendersData->indent_reference_no,
            'indentId' => $indentsData->id,
            'itemTypeId' => $indentsData->item_type_id,
            'itemId' => $indentsData->item_id,
        ]);
    }

    protected function finalSpecIndex(Request $request)
    {
        try {
            $doc_type_id = $request->doc_type_id;
            if ($doc_type_id == 9) {
                $documentDetails = DraftContract::find($request->importId);
            } else {
                $documentDetails = Contract::find($request->importId);
            }

            $item = Items::find($documentDetails->item_id);
            $itemType = Item_type::find($documentDetails->item_type_id);
            $supplier = Supplier::find($documentDetails->supplier_id);
        } catch (\Exception $e) {
            return back()->withError('Failed to retrieve from Database.');
        }
        return view('backend.excel-files.import-final-spec-data', compact('doc_type_id', 'documentDetails', 'item', 'itemType', 'supplier'));
    }

    public function importFinalSpecEditedData(Request $request)
    {

        $request->validate([
            'supplierId' => ['required', 'exists:suppliers,id'],
            'file' => 'required|mimes:xlsx,csv|max:2048',
        ], [
            'supplierId.required' => 'Please choose an Supplier ID.',
            'file.required' => 'Please choose an Excel/CSV file.',
            'file.mimes' => 'The file must be of type: xlsx, csv.',
            'file.max' => 'The file size must not exceed 2048 kilobytes.',
        ]);


        try {

            $importedData = Excel::toCollection(new FinalSpecImport, $request->file('file'))->first();
            dd($importedData);
            $parameterGroups = [];
            $currentGroupName = null;

            foreach ($importedData->toArray() as $row) {
                if (empty(array_filter($row))) {
                    continue;
                }

                $groupName = $row[1];

                if ($groupName !== null) {
                    $currentGroupName = $groupName;
                    $parameterGroups[$currentGroupName] = [];
                    continue;
                } else {
                    $groupName = $currentGroupName;
                }

                $parameterGroups[$groupName][] = [
                    'parameter_name' => trim($row[2]),
                    'indent_parameter_value' => trim($row[3]),
                    'parameter_value' => trim($row[4]),
                ];
            }

            $finalSpecRefNo = $request->finalSpecRefNo;
            $finalSpecData = FinalSpec::where('reference_no', $finalSpecRefNo)->first();

            $itemId = $finalSpecData['item_id'];
            $itemTypeId = $finalSpecData['item_type_id'];
            $indentRefNo = $request['indentRefNo'];
            $tenderRefNo = $request['tenderRefNo'];
            $offerRefNo = $request['offerRefNo'];
            $supplierId = $request['supplierId'];

            $item = Items::find($itemId);
            $itemName = $item ? $item->name : 'Unknown Item';

            $itemType = Item_Type::find($itemTypeId);
            $itemTypeName = $itemType ? $itemType->name : 'Unknown Item Type';

            $indent = Indent::where('reference_no', $indentRefNo)->first();
            $indentId = $indent ? $indent->id : 'Unknown Indent';

            $tender = Tender::where('reference_no', $tenderRefNo)->first();
            $tenderId = $tender ? $tender->id : 'Unknown Tender';

            $offer = Offer::where('reference_no', $offerRefNo)->first();
            $offerId = $offer ? $tender->id : 'Unknown Offer';

            $supplier = Supplier::find($supplierId);
            $supplierFirmName = $supplier ? $supplier->firm_name : 'Unknown Supplier';

            return view('backend.excel-files.display-imported-final-spec-data', [
                'parameterGroups' => $parameterGroups,
                'itemTypeId' => $itemTypeId,
                'itemTypeName' => $itemTypeName,
                'itemId' => $itemId,
                'itemName' => $itemName,
                'indentId' => $indentId,
                'indentRefNo' => $indentRefNo,
                'tenderId' => $tenderId,
                'tenderRefNo' => $tenderRefNo,
                'offerId' => $offerId,
                'offerRefNo' => $offerRefNo,
                'supplierId' => $supplierId,
                'finalSpecRefNo' => $finalSpecRefNo,
                'supplierFirmName' => $supplierFirmName,
            ]);
        } catch (UnreadableFileException $e) {
            // return redirect()->to('admin/import-final-spec-data-index')->with('error', 'The uploaded file is unreadable.');
            return response()->json(['errors' => $e], 422);
        } catch (SheetNotFoundException $e) {
            // return redirect()->to('admin/import-final-spec-data-index')->with('error', 'Sheet not found in the Excel file.');
            return response()->json(['errors' => $e], 422);
        } catch (\Exception $e) {
            return response()->json(['errors' => $e], 422);
            // return redirect()->to('admin/import-final-spec-data-index')->with('error', 'Error importing Excel file: ' . $e->getMessage());
        }
    }

    public function saveFinalSpecEditedData(Request $request)
    {
        try {
            DB::beginTransaction();

            $jsonData = $request->input('editedData');
            $itemId = $request->input('item-id');
            $indentId = $request->input('indent-id');
            $tenderId = $request->input('tender-id');
            $tenderId = $request->input('tender-id');
            $finalSpecRefNo = $request->input('finalSpecRefNo');
            $supplierId = $request->input('supplier-id');

            $indentParameterGroups = ParameterGroup::where('item_id', $itemId)->get();
            $databaseParameterGroupCount = $indentParameterGroups->count();

            $parameterGroupCount = count($jsonData);

            if ($parameterGroupCount !== $databaseParameterGroupCount) {
                DB::rollBack();
                return redirect()->to('admin/import-final-spec-data-index')->with('error', 'Parameter group count mismatch. Please check the Excel File.');
            }

            foreach ($indentParameterGroups as $indentParameterGroup) {
                $parameterGroupId = $indentParameterGroup->id;

                AssignParameterValue::where('reference_no', $finalSpecRefNo)
                    ->where('parameter_group_id', $parameterGroupId)
                    ->delete();
            }

            $flag = true;

            foreach ($jsonData as $groupName => $parameterGroup) {

                $flag = false;

                foreach ($indentParameterGroups as $indentParameterGroup) {
                    if ($groupName == $indentParameterGroup->name) {
                        $flag = true;
                        break;
                    }
                }
            }

            if ($flag) {
                $tableName = 'assign_parameter_values';
                foreach ($indentParameterGroups as $indentParameterGroup) {
                    $parameterGroupId = $indentParameterGroup->id;

                    foreach ($jsonData as $groupName => $parameterGroup) {
                        if ($indentParameterGroup->name == $groupName) {
                            foreach ($parameterGroup as $pGroup) {
                                $newParameter = new AssignParameterValue();
                                $newParameter->parameter_group_id = $parameterGroupId;
                                $newParameter->parameter_name = $pGroup['parameter_name'];
                                $newParameter->parameter_value = $pGroup['parameter_value'];
                                $newParameter->doc_type_id = 6;
                                $newParameter->reference_no = $finalSpecRefNo;
                                $newParameter->remarks = $pGroup['remarks'];

                                $newParameter->save();
                            }
                        }
                    }
                }

                DB::commit();
                return redirect()->to('admin/FinalSpec/view')->with('success', 'Final Spec\'s file saved successfully.');
            } else {
                DB::rollBack();
                return redirect()->to('admin/import-final-spec-data-index')->with('error', 'Parameter group Name mismatch. Please check the Excel File.');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error saving data: ' . $e->getMessage());

            return redirect()->to('admin/import-supplier-spec-data-index')->with('error', 'Error saving data. ' . $e->getMessage());
        }
    }

    public function fetchFinalSpecData(Request $request)
    {
        $tenderId = $request->input('tenderId');

        $tendersData = Tender::findOrFail($tenderId);

        if (!$tendersData) {
            return response()->json([
                'isSuccess' => false,
                'message' => 'Tender not found!',
            ]);
        }

        $indentsData = Indent::where('reference_no', $tendersData->indent_reference_no)->first();

        if (!$indentsData) {
            return response()->json([
                'isSuccess' => false,
                'message' => 'Indent not found for this Tender!',
            ]);
        }

        $supplierIds = SupplierSpecData::where('tender_id', $tenderId)
            ->groupBy('supplier_id')
            ->pluck('supplier_id');

        $suppliersData = Supplier::whereIn('id', $supplierIds)->get();

        $offerData = Offer::where('tender_reference_no', $tenderId)->first();
        $selectedSupplierIds = json_decode($offerData->supplier_id);
        $suppliers = Supplier::whereIn('id', $selectedSupplierIds)->get();

        if ($supplierIds->isEmpty()) {
            return response()->json([
                'isSuccess' => false,
                'message' => 'No supplier spec has been imported yet!',
                'suppliers' => $suppliers,
                'tendersData' => $tendersData->indent_reference_no,
                'indentId' => $indentsData->id,
                'itemTypeId' => $indentsData->item_type_id,
                'itemId' => $indentsData->item_id,
            ]);
        }

        return response()->json([
            'isSuccess' => true,
            'suppliers' => $suppliers,
            'suppliersData' => $suppliersData,
            'tendersData' => $tendersData->indent_reference_no,
            'indentId' => $indentsData->id,
            'itemTypeId' => $indentsData->item_type_id,
            'itemId' => $indentsData->item_id,
        ]);
    }

    public function getOfferedSuppliers(Request $request)
    {
        try {
            $offerRefNo = $request->input('offerRefNo');

            $offeredSuppliers = Offer::where('reference_no', $offerRefNo)->first();

            if (!$offeredSuppliers) {
                return response()->json([
                    'isSuccess' => false,
                    'Message' => 'Offered suppliers not found.',
                ], 200);
            }

            $selectedSupplierIds = json_decode($offeredSuppliers->supplier_id);
            $offeredSupplier = Supplier::whereIn('id', $selectedSupplierIds)->get();

            return response()->json([
                'isSuccess' => true,
                'Message' => 'Offered supplier retrieved successfully.',
                'suppliers' => $offeredSupplier,
            ], 200);
        } catch (\Exception $e) {
            \Log::error('Error in getOfferedSuppliers: ' . $e->getMessage());

            return response()->json([
                'isSuccess' => false,
                'Message' => 'An error occurred while processing the request.',
                'error' => $e->getMessage(),
            ], 200);
        }
    }

    public function getDocData($referenceNo)
    {
        $draftContract = DraftContract::where('reference_no', $referenceNo)->first();
        $itemType = Item_type::where('id', $draftContract->item_type_id)->first();
        $item = Items::where('id', $draftContract->item_id)->first();
        return view('backend.excel-files.documet_data_import.view_page', compact('draftContract', 'itemType', 'item'));
    }
}
