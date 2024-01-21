@extends('backend.app')
@section('title', 'JPSI (On Process)')
@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend/css/datatables.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend/css/doc_design/doc.css') }}">
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
            background: #BA895D;
            color: #ffff
        }
        .table thead tr th{

            color: #ffff
        }
        .dt-buttons{
            margin-left:8px;
        }
        .badge-secondary{
            background-color: #BA895D !important;
        }
        .dt-buttons .buttons-html5{
            background-color: #A1B53A !important;
            border:none;
        }
        .btn-danger{
            background-color: #b53f4b !important;
        }
    </style>
@endpush
@section('main_menu', 'JPSI (On Process)')
@section('active_menu', 'All Data')
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
                            <a href="{{ route('admin.jpsi/view') }}" type="button" class="btn btn-success btn-sm">New
                                Arrival ({{$jpsiNew}})</a>
                            <a href="{{ route('admin.jpsi_approved/view') }}" type="button"
                                class="btn btn-secondary btn-sm">On Process ({{$jpsiOnProcess}})</a>
                            <a href="{{ route('admin.jpsi/outgoing') }}" type="button"
                                class="btn btn-info text-white btn-sm">Completed ({{$jpsiCompleted}})</a>
                            <a href="{{ route('admin.jpsi_dispatch/view') }}" type="button"
                                class="btn btn-danger btn-sm">Dispatch ({{$jpsiDispatch}})</a>

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
                        <thead >
                            <tr>
                                <th>SL No</th>
                                <th>Reference Number</th>
                                <th>Name of Eqpt</th>
                                <th>User Directorate</th>
                                <th>Receive Date</th>
                                <th>Section Name</th>
                                <th>Present state of JPSI</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="8">

                                    <span class="icon p-3 m-2" style="color: #1B4C43;">&#11044; New Arrival</span>
                                    <span class="icon p-3 m-2" style="color: #BA895D;">&#11044; On Process</span>
                                    <span class="icon p-3 m-2" style="color: #0DCAF0;">&#11044; Completed</span>
                                    <span class="icon p-3 m-2" style="color: #B53F4B;">&#11044; Dispatch</span>
                                    <span class="icon p-3 m-2" style="color: #FF8E36;">&#11044; Forward</span>
                                    <span class="icon p-3 m-2" style="color: #0D6DA8;">&#11044; Forwarded</span>
                                </td>
                            </tr>
                        </tfoot>
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
    @include('backend.jpsi.jpsi_incomming_approved.jpsi_approved_index_js')
@endpush
