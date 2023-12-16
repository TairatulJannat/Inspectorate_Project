<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Items;
use App\Models\Item_type;
use App\Models\ParameterGroup;
use App\Models\Supplier;
use App\Models\Tender;
use App\Models\Indent;
use App\Models\SupplierSpecData;
use App\Models\SupplierOffer;
use PDF;

class PdfController extends Controller
{
    public function csrGeneratePdf(Request $request)
    {
        $tenderRefNo = $request->input('tenderRefNo');
        $tenderData = Tender::where('reference_no', $tenderRefNo)->first();

        $item = Items::findOrFail($tenderData->item_id);
        $itemName = $item ? $item->name : 'Unknown Item';

        $itemType = Item_Type::findOrFail($tenderData->item_type_id);
        $itemTypeName = $itemType ? $itemType->name : 'Unknown Item Type';

        $supplierIds = SupplierSpecData::where('tender_id', $tenderData->id)
            ->groupBy('supplier_id')
            ->pluck('supplier_id');

        $suppliers = Supplier::with('supplierOffers')
            ->whereIn('id', $supplierIds)
            ->get();

        foreach ($suppliers as $supplier) {
            $supplierData = $supplier->toArray();
            $supplierOffersData = $supplier->supplierOffers->toArray();

            $combinedData[] = array_merge($supplierData, ['supplier_offers' => $supplierOffersData]);
        }

        if ($combinedData) {
            $data = [
                'combinedData' => $combinedData,
                'itemTypeName' => $itemTypeName,
                'itemName' => $itemName,
                'tenderData' => $tenderData,
                'tenderRefNo' => $tenderRefNo,
            ];

            return $this->generatePdfView($data);
        } else {
            $data = [
                'title' => 'Error Found',
                'content' => 'Parameter Group not found for this Item. Please check the inputs!',
            ];

            $pdf = PDF::loadView('backend.csr.csr-pdf', $data)->setPaper('a4');

            return $pdf->stream('csr-pdf.pdf');
        }
    }

    private function generatePdfView($data)
    {
        $pdf = PDF::loadView('backend.csr.csr-pdf', $data)->setPaper('a4');

        return $pdf->stream('csr-pdf.pdf');
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
