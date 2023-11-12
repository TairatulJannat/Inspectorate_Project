@extends('backend.app')
@section('title', 'Prelim/general')
@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend/css/datatables.css') }}">
@endpush
@section('main_menu', 'Prelim/general')
@section('active_menu', 'Prelim/general')
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
                    <div class="col-6">
                        <h6 class="card-title">Total: <span class="badge badge-secondary" id="total_data"></span></h6>
                    </div>
                    <div class="col-6">
                        <a href="{{ route('admin.prelimgeneral/create') }}" type="button" class="btn-sm btn-success"
                            style="margin-left: 70%">Add Prelim/general</a>
                    </div>
                </div>
            </div>
            <div class="card-body" style="margin-top: 10px">
                <div class="table-responsive">
                    <table class="table table-bordered yajra-datatable">
                        <thead>
                            <tr>
                                <th>SL No</th>
                                <th>Name of Eqpt</th>
                               <th>User Directorate</th>
                                <th>Receive Date</th>
                                <th>Present state of spec</th>
                                <th>Remark</th>
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
    @include('backend.specification.prelimgeneral.index_js')
@endpush
