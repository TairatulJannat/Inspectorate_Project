@extends('backend.app')
@section('title', 'Offer')
@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend/css/datatables.css') }}">
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
            background: #1B4C43;
            color: #ffff
        }
        .table thead tr th{

            color: #ffff
        }
        .dt-buttons .buttons-html5{
            background-color: #1B4C43 !important;
            border:none;
        }
        .dt-buttons{
            margin-left:8px;
        }
        .badge-secondary{
            background-color: #1B4C43 !important;
        }
    </style>
@endpush
@section('main_menu', 'Offer')
@section('active_menu', 'Incoming')
@section('content')

    <div class="panel-heading">
        <div class="invoice_date_filter" style="">

        </div>

    </div>
    <br>

    <div class="col-sm-12 col-xl-12">
        <div class="card">
            <div class="card-header">
                <div class="row justify-content-between align-items-center">

                    <div class="d-flex justify-content-between px-4 py-2">

                        <div class="col-9">
                            <a href="{{ route('admin.offer/view') }}" type="button"
                            class="btn btn-success btn-sm">New Arrival</a>
                            <a href="" type="button"
                                class="btn btn-secondary btn-sm">Incoming (Approved)</a>
                            <a href="" type="button"
                                class="btn btn-info text-white btn-sm">OutGoing</a>
                            <a href="" type="button"
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
                    <table class="table table-bordered yajra-datatable">
                        <thead>
                            <tr>
                                <th>SL No</th>
                                <th>Reference No</th>
                                <th>Tender Refernce No</th>
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
    @include('backend.offer.offer_incomming_new.index_js')
@endpush
