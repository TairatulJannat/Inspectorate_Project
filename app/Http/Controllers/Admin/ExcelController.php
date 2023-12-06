<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Exceptions\UnreadableFileException;
use Maatwebsite\Excel\Exceptions\SheetNotFoundException;
use App\Imports\TestsImport;
use App\Models\Items;
use App\Models\Item_type;
use App\Models\ParameterGroup;
use App\Models\Inspectorate;
use Illuminate\Support\Facades\Auth;

class ExcelController extends Controller
{
    public function index()
    {
        try {
            $items = Items::all();
            $itemTypes = Item_type::all();
        } catch (\Exception $e) {
            return back()->withError('Failed to retrieve from Database.');
        }
        return view('backend.excel-files.excel-csv-import', compact('items', 'itemTypes'));
    }

    public function import(Request $request)
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
            $importedData = Excel::toCollection(new TestsImport, $request->file('file'))->first();

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

            return view('backend.excel-files.display-imported-data', [
                'parameterGroups' => $parameterGroups,
                'itemTypeId' => $itemTypeId,
                'itemTypeName' => $itemTypeName,
                'itemId' => $itemId,
                'itemName' => $itemName,
            ]);
        } catch (UnreadableFileException $e) {
            return redirect()->to('admin/excel-csv-index')->with('error', 'The uploaded file is unreadable.');
        } catch (SheetNotFoundException $e) {
            return redirect()->to('admin/excel-csv-index')->with('error', 'Sheet not found in the Excel file.');
        } catch (\Exception $e) {
            return redirect()->to('admin/excel-csv-index')->with('error', 'Error importing Excel file: ' . $e->getMessage());
        }
    }

    public function saveIndentEditedData(Request $request)
    {
        $requestData = $request->input('editedData');
        $processedGroupNames = [];

        foreach ($requestData as $groupName => $parameterGroup) {
            foreach ($parameterGroup as $parameter) {
                if (!in_array($groupName, $processedGroupNames)) {
                    $parameterGroupModel = new ParameterGroup();
                    $parameterGroupModel->item_id = $request->input('item-id');
                    $parameterGroupModel->item_type_id = $request->input('item-type-id');
                    $parameterGroupModel->name = $groupName;

                    $parameterGroupModel->inspectorate_id = Auth::user()->inspectorate_id;
                    $id = $parameterGroupModel->inspectorate_id;

                    if (Auth::user()->id === 92) {
                        $parameterGroupModel->section_id = 92;
                    } else {
                        $inspectorate = Inspectorate::find($id);
                        $section = $inspectorate->section;
                        $parameterGroupModel->section_id = $section->id;
                    }

                    $parameterGroupModel->status = 1;

                    // $parameterGroupModel->save();

                    $processedGroupNames[] = $groupName;
                }
            }
        }

        dd($processedGroupNames);

        try {
            // Retrieve edited data from the form
            $editedData = $request->input('editedData');

            // Perform your logic to save the edited data to the database
            // ...

            // Redirect back with success message
            return redirect()->back()->with('success', 'Changes saved successfully.');
        } catch (\Exception $e) {
            // Redirect back with an error message if something goes wrong
            return redirect()->back()->with('error', 'Error saving changes: ' . $e->getMessage());
        }
    }
}
