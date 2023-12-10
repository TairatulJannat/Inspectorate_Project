<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Exceptions\UnreadableFileException;
use Maatwebsite\Excel\Exceptions\SheetNotFoundException;
use App\Imports\IndentSpecImport;
use App\Imports\SupplierSpecImport;
use App\Models\Items;
use App\Models\Item_type;
use App\Models\ParameterGroup;
use App\Models\AssignParameterValue;
use App\Models\Inspectorate;
use App\Models\Indent;
use App\Models\Supplier;
use App\Models\Tender;
use App\Models\SupplierSpecData;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Validator;

class ExcelController extends Controller
{
    protected function csrIndex()
    {
        try {
            $items = Items::all();
            $itemTypes = Item_type::all();
        } catch (\Exception $e) {
            return back()->withError('Failed to retrieve from Database.');
        }
        return view('backend.csr.csr-index', compact('items', 'itemTypes'));
    }

    public function getCSRData(Request $request)
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

            $item = Items::findOrFail($itemId);
            $itemName = $item ? $item->name : 'Unknown Item';

            $itemType = Item_Type::findOrFail($itemTypeId);
            $itemTypeName = $itemType ? $itemType->name : 'Unknown Item Type';

            $parameterGroups = ParameterGroup::with('assignParameterValues')
                ->where('item_id', $itemId)
                ->get();

            $supplierParameterGroups = ParameterGroup::with('supplierSpecData')
                ->where('item_id', $itemId)
                ->get();

            $treeViewData = [];
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
                'message' => 'Parameters Data successfully retrieved!',
                'treeViewData' => $treeViewData,
                'itemTypeId' => $itemTypeId,
                'itemTypeName' => $itemTypeName,
                'itemId' => $itemId,
                'itemName' => $itemName,
            ], 200);
        } else {
            return response()->json([
                'isSuccess' => false,
                'message' => "Validation failed. Please check the inputs!",
                'error' => $validator->errors()->toArray()
            ], 200);
        }
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
                $groupName = $row[0];

                if ($groupName !== null) {
                    $currentGroupName = $groupName;
                    $parameterGroups[$currentGroupName] = [];
                    continue;
                } else {
                    $groupName = $currentGroupName;
                }

                $parameterGroups[$groupName][] = [
                    'parameter_name' => $row[1],
                    'parameter_value' => $row[2],
                ];
            }

            $itemId = $request->input('item-id');
            $itemTypeId = $request->input('item-type-id');

            $item = Items::find($itemId);
            $itemName = $item ? $item->name : 'Unknown Item';

            $itemType = Item_Type::find($itemTypeId);
            $itemTypeName = $itemType ? $itemType->name : 'Unknown Item Type';

            return view('backend.excel-files.display-imported-indent-data', [
                'parameterGroups' => $parameterGroups,
                'itemTypeId' => $itemTypeId,
                'itemTypeName' => $itemTypeName,
                'itemId' => $itemId,
                'itemName' => $itemName,
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

            $this->deleteAllParameterGroupsAndValues($itemId);

            foreach ($jsonData as $groupName => $parameterGroup) {
                $modifiedGroupName = $request->input("editedData.$groupName.parameter_group_name");

                $existingGroup = $this->getParameterGroup($modifiedGroupName, $itemId, $itemTypeId);

                if (!$existingGroup) {
                    $newGroup = $this->createParameterGroup($modifiedGroupName, $itemId, $itemTypeId);
                    $lastInsertedId = $newGroup->id;
                } else {
                    $lastInsertedId = $existingGroup->id;
                }

                $this->saveAssignParameterValues($lastInsertedId, $parameterGroup);
            }

            DB::commit();

            return redirect()->to('admin/import-indent-spec-data-index')->with('success', 'Changes saved successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error saving data: ' . $e->getMessage());

            return redirect()->back()->with('error', 'Error saving data. Please check the logs for details.');
        }
    }

    private function deleteAllParameterGroupsAndValues($itemId)
    {
        $parameterGroups = ParameterGroup::where('item_id', $itemId)->get();

        foreach ($parameterGroups as $group) {
            $group->assignParameterValues()->delete();
            $group->delete();
        }
    }

    protected function getParameterGroup($name, $itemId, $itemTypeId)
    {
        return ParameterGroup::where('name', $name)
            ->where('item_id', $itemId)
            ->where('item_type_id', $itemTypeId)
            ->first();
    }

    protected function createParameterGroup($name, $itemId, $itemTypeId)
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
        $newGroup->status = 1;

        $newGroup->save();

        return $newGroup;
    }

    protected function saveAssignParameterValues($parameterGroupId, $parameterGroup)
    {
        foreach ($parameterGroup as $parameterName => $parameterData) {
            if (is_array($parameterData)) {
                $parameterValue = $parameterData['parameter_value'];

                AssignParameterValue::create([
                    'parameter_group_id' => $parameterGroupId,
                    'parameter_name' => $parameterName,
                    'parameter_value' => $parameterValue,
                ])->fresh();

                // try {
                //     // Try to update the existing record
                //     AssignParameterValue::updateOrCreate(
                //         [
                //             'parameter_group_id' => $parameterGroupId,
                //             'parameter_name' => $parameterName,
                //         ],
                //         [
                //             'parameter_value' => $parameterValue,
                //         ]
                //     );
                // } catch (ModelNotFoundException $e) {
                //     // If the record doesn't exist, catch the exception and create a new one
                //     AssignParameterValue::create([
                //         'parameter_group_id' => $parameterGroupId,
                //         'parameter_name' => $parameterName,
                //         'parameter_value' => $parameterValue,
                //     ]);
                // }
            }
        }
    }

    protected function exportIndentEditedData()
    {
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
                $groupName = $row[0];

                if ($groupName !== null) {
                    $currentGroupName = $groupName;
                    $parameterGroups[$currentGroupName] = [];
                    continue;
                } else {
                    $groupName = $currentGroupName;
                }

                $parameterGroups[$groupName][] = [
                    'parameter_name' => $row[1],
                    'parameter_value' => $row[3],
                ];
            }

            $itemId = $request->input('item-id');
            $itemTypeId = $request->input('item-type-id');
            $indentId = $request->input('indent-id');
            $supplierId = $request->input('supplier-id');
            $tenderId = $request->input('tender-id');

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
            $supplierId = $request->input('supplier-id');

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
                foreach ($indentParameterGroups as $indentParameterGroup) {
                    $parameterGroupId = $indentParameterGroup->id;

                    foreach ($jsonData as $groupName => $parameterGroup) {
                        if ($indentParameterGroup->name == $groupName) {
                            foreach ($parameterGroup as $pGroup) {
                                $newParameter = new SupplierSpecData();
                                $newParameter->parameter_group_id = $parameterGroupId;
                                $newParameter->parameter_name = $pGroup['parameter_name'];
                                $newParameter->parameter_value = $pGroup['parameter_value'];
                                $newParameter->indent_id = $indentId;
                                $newParameter->supplier_id = $supplierId;
                                $newParameter->tender_id = $tenderId;

                                $newParameter->save();
                            }
                        }
                    }
                }
                DB::commit();
                return redirect()->to('admin/import-supplier-spec-data-index')->with('success', 'Supplier\'s Spec saved successfully.');
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

    protected function exportSupplierEditedData()
    {
    }
}
