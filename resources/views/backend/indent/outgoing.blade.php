@extends('backend.app')
@section('title', 'Indent')
@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend/css/datatables.css') }}">
    <style>
        .card .card-header {
            padding: 0px;
            border-bottom: 1px solid rgba(182, 182, 182, .6);

        }
        <style>
        .card .card-header {
            padding: 0px;
            border-bottom: 1px solid rgba(182, 182, 182 , .6);

        }
        .table{
            border-radius:10px !important;
            box-shadow: rgba(0, 0, 0, 0.1) 0px 4px 12px;
        }
        .table thead{
            background: #006A4E;
            color: #ffff
        }
        .table thead tr th{

            color: #ffff
        }
    </style>

@endpush
@section('main_menu', 'Indent')
@section('active_menu', 'Outgoing')
@section('content')

    <div class="col-sm-12 col-xl-12">
        <div class="card">
            <div class="card-header">
                <div class="row justify-content-between align-items-center">

                    <div class="d-flex justify-content-between px-4 py-2">
                        <div class="col-6">
                            <a href="{{ route('admin.indent/view') }}" type="button"
                                class="btn btn-success">Incoming</a>
                            <a href="{{ route('admin.indent/outgoing') }}" type="button"
                                class="btn btn-danger">OutGoing</a>
                        </div>
                        <div>
                            <h6 class="card-title">Total: <span class="badge badge-secondary" id="total_data"></span></h6>
                        </div>
                    </div>

                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered yajra-datatable">
                        <thead>
                            <tr>
                                <th>SL No</th>
                                <th>Indent Number</th>
                                <th>Name of Eqpt</th>
                                <th>User Directorate</th>
                                <th>Receive Date</th>
                                <th>Section Name</th>
                                <th>Item QTY</th>
                                <th>Present state of spec</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
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
    @include('backend.indent.outgoing_index_js')
@endpush
