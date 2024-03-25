@extends('backend.app')
@section('title', 'Report Return View')
@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend/css/datatables.css') }}">
    <style>
        table p {
            margin-top: 10px;
            padding: 100px;
        }

        .body_2_serial {
            display: none;
        }

        @media print {
            body>*:not(#printTableCart) {
                display: none !important;
            }
        }
    </style>
@endpush
@section('main_menu', 'Report Return ')
@section('active_menu', 'view')
@section('content')

    <div class="col-sm-12 col-xl-12">
        <div class="card">
            <div class="card-body" id="printTableCart">
                {!! $rr_list->report_summery !!}
            </div>

        </div>
        <div class="d-flex justify-content-center">
            <button class="btn btn-success borderd mb-2 col-1 ">Print</button>
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
