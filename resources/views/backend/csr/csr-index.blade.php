@extends('backend.app')

@section('title', 'Comparative Statement Report')

@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend/css/datatables.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend/css/select2.min.css') }}">
@endpush

@section('main_menu', 'Comparative Statement Report (CSR)')
@section('active_menu', 'CSR Index')

@section('content')
    <form action="{{ url('admin/csr/get-csr-data') }}" method="POST" id="searchCSRForm" autocomplete="off">
        @csrf
        <div class="row bg-body p-3">
            <div class="col-md-2 text-center mt-2 infoHide">
                <h6>Tender Ref No: </h6>
            </div>
            <div class="col-md-3 infoHide">
                <div class="mb-2">
                    <select class="form-control select2 tender-id" id="tenderId" name="tender-id"
                        style="width: 100% !important;">
                        <option value="" selected disabled>Select here</option>
                        @foreach ($tenders as $tender)
                            <option value="{{ $tender->id }}">{{ $tender->reference_no }}</option>
                        @endforeach
                    </select>
                </div>
                <span class="text-danger error-text tender-id-error"></span>
            </div>
            <div class="col-md-5 infoShow" style="display: none"></div>
            <div class="col-md-4">
            </div>
            <!-- Search Button -->
            <div class="col-md-3">
                <button type="submit" class="btn btn-success-gradien search-button infoHide" id="searchButton">Search<span>
                        <i class="fa fa-search"></i></span></button>
                <a href="{{ url('admin/csr-generate-pdf') }}" type="button" id="printButton"
                    class="btn btn-success-gradien fa fa-print disabled"></a>
            </div>
        </div>
    </form>
    <div class="row bg-body p-3" style="background-color: honeydew !important;">
        <div class="text-success searched-data">
        </div>
    </div>
@endsection

@push('custom-scripts')
    <script src="{{ asset('assets/backend/js/select2/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/backend/js/datatable/datatables/plugin/datatables.min.js') }}"></script>
    <script src="https://unpkg.com/sweetalert2@7.19.1/dist/sweetalert2.all.js"></script>
    <script src="{{ asset('assets/backend/js/notify/bootstrap-notify.min.js') }}"></script>
    <!-- Developer's JS file for brand page -->
    @include('backend.csr.index-js')
@endpush
