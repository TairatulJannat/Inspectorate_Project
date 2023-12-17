<style>
    @font-face {
        font-family: 'Siyam Rupali';
        src: url('/fonts/Siyamrupali.ttf') format('truetype');
    }

    body {
        font-family: 'Siyam Rupali', sans-serif;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }

    table,
    th,
    td {
        border: 1px solid #ddd;
        padding: 8px;
    }
</style>

<div class="p-md-3 paper-document" style="font-family: Arial, sans-serif;">
    <div class="header" style="margin-bottom: 20px;">
        <div style="padding: 3px; text-align: center; font-size: 20px;">{{ $itemName }}</div>
        <div style="padding: 3px; text-align: center; font-size: 18px;">Item Type: {{ $itemTypeName }}</div>
        <div style="padding: 3px; text-align: center;">Tender Reference No: {{ $tenderRefNo }}
        </div>
        <div style="padding: 3px; text-align: center;">Indent Reference No:
            {{ $tenderData->indent_reference_no }}</div>
        <div style="padding: 3px; text-align: right; margin-top: 10px;">Tender Receive Date:
            {{ $tenderData->receive_date }}</div>
        <div style="padding: 3px; padding-bottom: 10px; text-align: right;">Tender Onening
            Date:
            {{ $tenderData->opening_date }}</div>
    </div>
    <div class="content" style="font-family: 'SiyamRupali', sans-serif;">
        <table class="table table-bordered" style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr>
                    <th style="border: 1px solid #ddd; padding: 8px; text-align: center;">Index</th>
                    <th style="border: 1px solid #ddd; padding: 8px; text-align: center;">Suppliers Specification
                        Details</th>
                    <th style="border: 1px solid #ddd; padding: 8px; text-align: center;">Final Remarks</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($combinedData as $index => $supplier)
                    <tr>
                        <td style="border: 1px solid #ddd; padding: 8px; text-align: center;">{{ $index + 1 }}</td>
                        <td style="border: 1px solid #ddd; padding: 8px;">
                            {{ $supplier['firm_name'] }}<br><br>
                            <div style="border: 1px solid #ddd; padding: 8px;">
                                Offer Offer Remarks:<br>
                                {!! $supplier['supplier_offers'][0]['offer_remarks'] ?? '' !!}
                            </div>
                        </td>
                        <td style="border: 1px solid #ddd; padding: 8px;">
                            {{ $supplier['supplier_offers'][0]['final_remarks'] ?? '' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" style="border: 1px solid #ddd; padding: 8px; text-align: center;">No data
                            available</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
