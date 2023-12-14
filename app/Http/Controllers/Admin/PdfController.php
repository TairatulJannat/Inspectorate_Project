<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Items;
use App\Models\Item_type;
use App\Models\ParameterGroup;
use App\Models\Supplier;
use PDF;

class PdfController extends Controller
{
    public function csrGeneratePdf(Request $request)
    {
        $itemId = $request->input('item-id');
        $itemTypeId = $request->input('item-type-id');

        $item = Items::findOrFail($itemId);
        $itemName = $item ? $item->name : 'Unknown Item';

        $itemType = Item_Type::findOrFail($itemTypeId);
        $itemTypeName = $itemType ? $itemType->name : 'Unknown Item Type';

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

            $data = [
                'title' => 'Item Type ID: ' . $itemTypeId . 'Item ID: ' . $itemId,
                'content' => 'Tree View function need to implement here',
            ];

            $pdf = PDF::loadView('backend.csr.csr-pdf', $data)->setPaper('a4');

            return $pdf->stream('csr-pdf.pdf');
        } else {
            $data = [
                'title' => 'Error Found',
                'content' => 'Parameter Group not found for this Item. Please check the inputs!',
            ];

            $pdf = PDF::loadView('backend.csr.csr-pdf', $data)->setPaper('a4');

            return $pdf->stream('csr-pdf.pdf');
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
}
