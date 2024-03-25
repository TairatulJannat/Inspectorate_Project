@extends('backend.app')
@section('title', 'Report Return Destails')
@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend/css/datatables.css') }}">
    <style>
        .table-row-fixed td {
            width: calc(100% / 9);
            /* Assuming 9 columns, adjust the value accordingly */
            white-space: nowrap;
            /* Optional: Prevent wrapping text */
        }
    </style>
@endpush
@section('main_menu', 'Report Return ')
@section('active_menu', 'details')
@section('content')

    <div class="col-sm-12 col-xl-12">
        <div class="card p-3">
            <div class="mt-3 pt-3">
                <?php
                $i = 97;
                ?>
                @foreach ($reports as $doc_name => $report)
                    <div class="mt-3">
                        <h5>{{ $serial = chr($i++) }}. {{ $doc_name }} Vetting Report</h5>
                        <table class="table table-bordered table-fixed">
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
                                <tr class="table-row-fixed">
                                    <td colspan="2"><strong>SIG Sec</strong> </td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>

                                <?php
                                $j = 1;
                                ?>
                                @foreach ($report['SIG Sec'] as $sigData)
                                    <tr>
                                        <td>{{ $j++ }}</td>
                                        <td>{{ $sigData->item_name }}</td>
                                        <td>{{ $sigData->tender_reference_no }}</td>
                                        <td>{{ $sigData->qty }}</td>
                                        <td>{{ $sigData->userDte }}</td>
                                        <td>Local\Foreign</td>
                                        <td>{{ $sigData->created_at }}</td>
                                        <td>
                                            {{ $sigData->status == 0 ? 'New Arrival' : ($sigData->status == 2 ? 'On Process' : ($sigData->status == 1 ? 'Completed' : ($sigData->status == 4 ? 'Dispatched' : ''))) }}
                                        </td>
                                        <td>{{ $sigData->item_attribute }}</td>

                                        <!-- Display more columns based on your data structure -->
                                    </tr>
                                @endforeach
                                <tr class="table-row-fixed">
                                    <td colspan="2"><strong>ENGG Sec</strong></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                @foreach ($report['ENGG Sec'] as $sigData)
                                    <tr>
                                        <td>{{ $j++ }}</td>
                                        <td>{{ $sigData->item_name }}</td>
                                        <td>{{ $sigData->tender_reference_no }}</td>
                                        <td>{{ $sigData->qty }}</td>
                                        <td>{{ $sigData->userDte }}</td>
                                        <td>Local\Foreign</td>
                                        <td>{{ $sigData->created_at }}</td>
                                        <td>
                                            {{ $sigData->status == 0 ? 'New Arrival' : ($sigData->status == 2 ? 'On Process' : ($sigData->status == 1 ? 'Completed' : ($sigData->status == 4 ? 'Dispatched' : ''))) }}
                                        </td>
                                        <td>{{ $sigData->item_attribute }}</td>

                                        <!-- Display more columns based on your data structure -->
                                    </tr>
                                @endforeach
                                <tr class="table-row-fixed">
                                    <td colspan="2"><strong>FIC Sec</strong></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                @foreach ($report['FCI Sec'] as $sigData)
                                    <tr>
                                        <td>{{ $j++ }}</td>
                                        <td>{{ $sigData->item_name }}</td>
                                        <td>{{ $sigData->tender_reference_no }}</td>
                                        <td>{{ $sigData->qty }}</td>
                                        <td>{{ $sigData->userDte }}</td>
                                        <td>Local\Foreign</td>
                                        <td>{{ $sigData->created_at }}</td>
                                        <td>
                                            {{ $sigData->status == 0 ? 'New Arrival' : ($sigData->status == 2 ? 'On Process' : ($sigData->status == 1 ? 'Completed' : ($sigData->status == 4 ? 'Dispatched' : ''))) }}
                                        </td>
                                        <td>{{ $sigData->item_attribute }}</td>

                                        <!-- Display more columns based on your data structure -->
                                    </tr>
                                @endforeach
                                <tr class="table-row-fixed">
                                    <td colspan="2"><strong>EM Sec</strong></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                @foreach ($report['EM Sec'] as $sigData)
                                    <tr>
                                        <td>{{ $j++ }}</td>
                                        <td>{{ $sigData->item_name }}</td>
                                        <td>{{ $sigData->tender_reference_no }}</td>
                                        <td>{{ $sigData->qty }}</td>
                                        <td>{{ $sigData->userDte }}</td>
                                        <td>Local\Foreign</td>
                                        <td>{{ $sigData->created_at }}</td>
                                        <td>
                                            {{ $sigData->status == 0 ? 'New Arrival' : ($sigData->status == 2 ? 'On Process' : ($sigData->status == 1 ? 'Completed' : ($sigData->status == 4 ? 'Dispatched' : ''))) }}
                                        </td>
                                        <td>{{ $sigData->item_attribute }}</td>

                                        <!-- Display more columns based on your data structure -->
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endforeach

            </div>
            <div class="d-flex justify-content-center mt-2">
                <!-- Form for sending reports data via POST -->
                <form id="printForm" method="POST" action="{{ url('admin/report_returns/detailsprint') }}">
                    @csrf <!-- CSRF protection -->
                    <input type="hidden" name="reports" value="{{ json_encode($reports) }}">
                    <button type="submit" class="btn btn-success borderd mb-2 ">Print</button>
                </form>
            </div>
        </div>

    </div>
@endsection
@push('js')
    <script src="{{ asset('assets/backend/js/select2/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/backend/js/datatable/datatables/plugin/datatables.min.js') }}"></script>
    <script src="https://unpkg.com/sweetalert2@7.19.1/dist/sweetalert2.all.js"></script>
    <script src="{{ asset('assets/backend/js/select2/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/backend/js/notify/bootstrap-notify.min.js') }}"></script>
    @include('backend.report_return.report_js')
    <script></script>
@endpush
