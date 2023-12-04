@extends('backend.app')
@section('title', 'indent Document Status')
@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend/css/datatables.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend/css/select2.min.css') }}">
@endpush
@section('main_menu', 'Document Status')
@section('active_menu', 'details')
@section('content')

    <div class="col-sm-12 col-xl-12">
        <div class="card">
            <div class="card-header">
                <div class="row justify-content-between align-items-center">
                    <div class="col-6">
                        <h6 class="card-title">Total: <span class="badge badge-secondary" id="total_data"></span></h6>
                    </div>
                    <!-- Button to trigger the modal -->
                    <div class="col-6">
                        <button type="button" class="btn btn-success float-md-end" data-bs-toggle="modal"
                            data-bs-target="#createItemTypeModal">
                           Add Document
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body" style="margin-top: 10px">
                <div class="table-responsive">
                    <table class="table table-bordered yajra-datatable">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Document</th>
                                <th>Duration</th>
                                <th>Receive Status</th>
                                <th>Receive Date</th>
                                <th>Asking Date</th>
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

    {{-- Create Item Type Modal --}}
    @include('backend.indent.document_status.create')
    {{-- Edit Item Type --}}
    @include('backend.indent.document_status.edit')
    {{-- Show Item Type --}}
    @include('backend.indent.document_status.show')
@endsection

@push('custom-scripts')
    <script src="{{ asset('assets/backend/js/select2/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/backend/js/datatable/datatables/plugin/datatables.min.js') }}"></script>
    <script src="https://unpkg.com/sweetalert2@7.19.1/dist/sweetalert2.all.js"></script>
    <script src="{{ asset('assets/backend/js/notify/bootstrap-notify.min.js') }}"></script>
    <!-- Developer's JS file for brand page -->
    @include('backend.indent.document_status.index_js')
@endpush
