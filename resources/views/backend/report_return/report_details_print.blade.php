<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Report Return Details</title>
    <style>
        *{
            font-size: 10px;
        }
        .custom-table {
            width: 100%;
            border-collapse: collapse;
        }

        .custom-table th,
        .custom-table td {
            border: 1px solid #3a3a3aef;
            padding: 5px;
        }
    </style>
</head>

<body>
    <div class="col-sm-12 col-xl-12">
        <div class="card p-3">
            <div class="mt-3 pt-3">
                <?php
                $i = 97;
                ?>
                @foreach ($reports as $doc_name => $report)
                    <div class="mt-3">
                        <h5>{{ $serial = chr($i++) }}. {{ $doc_name }} Vetting Report</h5>
                        <table class="table custom-table table-bordered table-fixed">
                            <thead>
                                <tr>
                                    <th>Ser No</th>
                                    <th>Name of Item</th>
                                    <th>Tender Ref No</th>
                                    <th>Qty</th>
                                    <th>User Dte</th>
                                    <th>Currency</th>
                                    <th>Present State Of Offer</th>
                                    <th>Likely Dt of Completion</th>
                                    <th>Rmks</th>
                                    <!-- Add more columns as needed -->
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $j = 1;
                                @endphp
                                @foreach ($report['SIG Sec'] as $sigData)
                                    <tr>
                                        <td>{{ $j++ }}</td>
                                        <td>{{ $sigData['item_name'] }}</td>
                                        <td></td>
                                        <td>{{ $sigData['qty'] }}</td>
                                        <td>{{ $sigData['userDte'] }}</td>
                                        <td>Local\Foreign</td>
                                        <td>{{ $sigData['created_at'] }}</td>
                                        <td>
                                            @if ($sigData['status'] == 0)
                                                New Arrival
                                            @elseif ($sigData['status'] == 2)
                                                On Process
                                            @elseif ($sigData['status'] == 1)
                                                Completed
                                            @elseif ($sigData['status'] == 4)
                                                Dispatched
                                            @endif
                                        </td>
                                        <td>{{ $sigData['item_attribute'] }}</td>
                                        <!-- Display more columns based on your data structure -->
                                    </tr>
                                @endforeach
                                <!-- Add more sections and their respective data -->
                            </tbody>
                        </table>
                    </div>
                @endforeach
            </div>


        </div>

    </div>
</body>

</html>
