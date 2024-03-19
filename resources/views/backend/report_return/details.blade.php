@extends('backend.app')
@section('title', 'Report Return Destails')
@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend/css/datatables.css') }}">
@endpush
@section('main_menu', 'Report Return ')
@section('active_menu', 'details')
@section('content')

    <div class="col-sm-12 col-xl-12">
        <div class="m-3">
            <?php
            $i = 1;
            ?>
            @foreach ($reports as $doc_name => $report)
                <h3>{{ $i = $i++ }}. {{ $doc_name }} Vetting Report</h3>

                <h5>SIG Sec</h5>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Item ID</th>
                            <th>Reference No</th>
                            <!-- Add more columns as needed -->
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($report['SIG Sec'] as $sigData)
                            <tr>
                                <td>{{ $sigData->item_id }}</td>
                                <td>{{ $sigData->reference_no }}</td>
                                <!-- Display more columns based on your data structure -->
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Repeat the above structure for other sections like ENGG Sec, FIC Sec, etc. -->
            @endforeach
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
