@extends('backend.app')
@section('title', 'Contract Documents')
@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend/css/datatables.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend/css/select2.min.css') }}">
    <style>
        .form-check-input {
            width: 50px !important;
            height: 30px;
            border-radius: 50px !important;
        }

        .required-field::before {
            content: '*';
            color: red;
            margin-right: 5px;
        }

        .select2 {
            width: 100% !important;
        }
    </style>
@endpush
@section('main_menu', 'Contract Documents')
@section('active_menu', 'All Documents')
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
                            data-bs-target="#createContractModal">
                            Add Document
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body" style="margin-top: 10px">
                <div class="table-responsive">
                    <table class="table table-bordered contract-doc-datatable">
                        <thead>
                            <tr>
                                <th>SL No</th>
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

    {{-- Create Contract Document Modal --}}
    @include('backend.contracts.documents.create')
    {{-- Edit Contract Document --}}
    @include('backend.contracts.documents.edit')
    {{-- Show Contract Document --}}
    @include('backend.contracts.documents.show')
@endsection

@push('custom-scripts')
    <script src="{{ asset('assets/backend/js/select2/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/backend/js/datatable/datatables/plugin/datatables.min.js') }}"></script>
    <script src="https://unpkg.com/sweetalert2@7.19.1/dist/sweetalert2.all.js"></script>
    <script src="{{ asset('assets/backend/js/notify/bootstrap-notify.min.js') }}"></script>
    <!-- Developer's JS file -->
    @include('backend.contracts.documents.index_js')
@endpush
