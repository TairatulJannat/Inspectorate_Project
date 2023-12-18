<style>
    @font-face {
        font-family: 'Nikosh';
        src: url('http://sonnetdp.github.io/nikosh/css/nikosh.css') format('truetype');
    }

    .bn {
        font-family: 'Nikosh', sans-serif;
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

    .credit {
        position: fixed;
        bottom: 20px;
        /* Adjust the value to change the distance from the bottom */
        left: 0;
        right: 0;
        font-size: 12px;
    }
</style>

<div class="p-md-3 paper-document" style="font-family: Arial, sans-serif;">
    <div class="header" style="margin-bottom: 20px;">
        <div style="padding: 3px; text-align: center; font-size: 25px;">Inspectorate of Electrical Equipments &
            Instruments</div><br>
        <div style="padding: 3px; text-align: center; font-size: 18px;">{{ $itemName }}</div>
        <div style="padding: 3px; text-align: center;">Item Type: {{ $itemTypeName }}</div>
        <div style="padding: 3px; text-align: center;">Tender Reference No: {{ $tenderRefNo }}
        </div>
        <div style="padding: 3px; text-align: center;">Indent Reference No:
            {{ $tenderData->indent_reference_no }}</div>
        <div style="padding: 3px; padding-bottom: 10px; text-align: right; margin-top: 10px;">Tender Opening
            Date:
            {{ $tenderData->opening_date }}</div>
    </div>
    <div class="content" style="font-family: 'SiyamRupali', sans-serif;">
        <table class="table table-bordered" style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr>
                    <th style="border: 1px solid #ddd; padding: 8px; text-align: center; white-space: nowrap">Sl. No.
                    </th>
                    <th style="border: 1px solid #ddd; padding: 8px; text-align: center;">Details</th>
                    <th style="border: 1px solid #ddd; padding: 8px; text-align: center;">Remarks</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($combinedData as $index => $supplier)
                    <tr>
                        <td style="border: 1px solid #ddd; padding: 8px; text-align: center;">{{ $index + 1 }}</td>
                        <td style="border: 1px solid #ddd; padding: 8px; font-weight: bold;">
                            {{ $supplier['firm_name'] }}<br>
                            <div class="bn" style="font-weight: regular;">
                                {!! $supplier['supplier_offers'][0]['remarks_summary'] ?? '' !!}
                            </div>
                        </td>
                        <td style="border: 1px solid #ddd; padding: 8px;">
                            {{ $supplier['supplier_offers'][0]['offer_status'] ?? '' }}</td>
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
    <div class="credit">
        System Developed by Trust Innovation Limited
    </div>
</div>
