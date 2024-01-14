@extends('backend.app')
@section('title', 'Contract')
@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend/css/datatables.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend/css/doc_design/doc.css') }}">
    <style>
        .card .card-header {
            padding: 0px;
            border-bottom: 1px solid rgba(182, 182, 182, .6);
        }

        .table {
            border-radius: 10px !important;
            box-shadow: rgba(0, 0, 0, 0.1) 0px 4px 12px;
        }

        .table thead {
            background: #1B4C43;
            color: #ffff
        }

        .table thead tr th {
            color: #ffff
        }

        .dt-buttons {
            margin-left: 8px;
        }

        .badge-secondary {
            background-color: #1B4C43 !important;
        }

        .dt-buttons .buttons-html5 {
            background-color: #A1B53A !important;
            border: none;
        }

        .btn-danger {
            background-color: #b53f4b !important;
        }
    </style>
@endpush

@section('main_menu', 'Contract (New Arrival)')
@section('active_menu', 'All Data')
@section('content')

    <div class="col-sm-12 col-xl-12">
        <div class="card">
            @if (Auth::user()->id == 128)
                <div>
                    <a href="create" type="button" class="btn btn-success m-3 float-md-end">Create Contract</a>
                </div>
            @endif
            <div class="card-header">
                <div class="row justify-content-between align-items-center">
                    <div class="d-flex justify-content-between px-4 py-2">
                        <div class="col-9">
                            <a href="{{ url('admin/contract/index') }}" type="button" class="btn btn-success btn-sm">New
                                Arrival</a>
                            <a href="{{ url('admin/contract_approved/view') }}" type="button"
                                class="btn btn-secondary btn-sm">On Process </a>
                            <a href="{{ url('admin/contract/outgoing') }}" type="button"
                                class="btn btn-info text-white btn-sm">Completed</a>
                            <a href="{{ url('admin/contract_dispatch/view') }}" type="button"
                                class="btn btn-danger btn-sm">Dispatch</a>
                        </div>
                        <div>
                            <h6 class="card-title">Total: <span class="badge badge-secondary" id="total_data"></span></h6>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered contract-datatable">
                        <thead>
                            <tr>
                                <th>SL No</th>
                                <th>Ltr No of Contract</th>
                                <th>Ltr Date Contract</th>
                                <th>Contract No</th>
                                <th>Contract Date</th>
                                <th>Contract State</th>
                                <th>Con Fin Year</th>
                                <th>Supplier Id</th>
                                <th>Contracted Value</th>
                                <th>Delivery Schedule</th>
                                <th>Currency Unit</th>
                                <th>Status</th>
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
    @include('backend.contracts.contract_incomming_new.index_js')
@endpush
