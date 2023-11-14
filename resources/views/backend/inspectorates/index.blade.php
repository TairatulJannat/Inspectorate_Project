@extends('backend.app')
@section('title', 'Inspectorates')
@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend/css/datatables.css') }}">
@endpush
@section('main_menu', 'Inspectorates')
@section('active_menu', 'Inspectorates Index')
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
                        <button type="button" class="btn btn-primary float-md-end" data-bs-toggle="modal"
                            data-bs-target="#createInspectorateModal">
                            Create Inspectorate
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
                                <th>Inspectorate Name</th>
                                <th>Inspectorate Attribute</th>
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

    {{-- Create Inspectorate Modal --}}
    @include('backend.inspectorates.create')
    {{-- Edit Inspectorate Modal --}}
    @include('backend.inspectorates.edit')
@endsection

@push('custom-scripts')
    <script src="{{ asset('assets/backend/js/select2/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/backend/js/datatable/datatables/plugin/datatables.min.js') }}"></script>
    <script src="https://unpkg.com/sweetalert2@7.19.1/dist/sweetalert2.all.js"></script>
    <script src="{{ asset('assets/backend/js/notify/bootstrap-notify.min.js') }}"></script>
    <!-- Developer's JS file for brand page -->
    @include('backend.inspectorates.index_js')
@endpush
