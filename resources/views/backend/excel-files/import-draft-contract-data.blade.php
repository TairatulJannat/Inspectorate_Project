@extends('backend.app')

@section('title', 'Import Draft Contract Spec')

@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend/css/datatables.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend/css/select2.min.css') }}">
    <style>
        .required-field::before {
            content: '*';
            color: red;
            margin-right: 5px;
        }
    </style>
@endpush

@section('main_menu', 'Excel Files')
@section('active_menu', 'Import Draft Contract Spec')

@section('content')
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="card shadow-lg" style="background-color: darkseagreen;">
        <form id="import-draft-contract-spec-data-form" method="post"
            action="{{ url('admin/import-draft-contract-spec-data') }}" accept-charset="utf-8"
            enctype="multipart/form-data">
            @csrf
            <div class="card-header p-5 pb-3" style="background-color: #b6e9b6 !important;">
                <div class="f-18">
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label for="dcRefNo">Draft Contract Reference Number:</label>
                        </div>
                        <div class="col-md-3">
                            <span id="dcRefNoDisplay" class="text-display fw-bold text-danger"></span>
                            <span class="text-danger fw-bold">{{ $dcData['reference_no'] }}</span>
                            <input type="hidden" name="dcRefNo" id="dcRefNo" class="dc-ref-no"
                                value="{{ $dcData['reference_no'] }}" readonly>
                        </div>
                        <div class="col-md-3">
                            <label for="finalSpecRefNo">Final Spec Reference Number:</label>
                        </div>
                        <div class="col-md-3">
                            <span id="finalSpecRefNoDisplay" class="text-display fw-bold text-danger"></span>
                            <span class="text-danger fw-bold">{{ $dcData['final_spec_reference_no'] }}</span>
                            <input type="hidden" name="finalSpecRefNo" id="finalSpecRefNo" class="final-spec-ref-no"
                                value="{{ $dcData['final_spec_reference_no'] }}" readonly>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label for="offerRefNo">Offer Reference Number:</label>
                        </div>
                        <div class="col-md-3">
                            <span id="offerRefNoDisplay" class="text-display fw-bold text-danger"></span>
                            <span class="text-danger fw-bold">{{ $dcData['offer_reference_no'] }}</span>
                            <input type="hidden" name="offerRefNo" id="offerRefNo" class="offer-ref-no"
                                value="{{ $dcData['offer_reference_no'] }}" readonly>
                        </div>
                        <div class="col-md-3">
                            <label for="indentRefNo">Indent Reference Number:</label>
                        </div>
                        <div class="col-md-3">
                            <span id="indentRefNoDisplay" class="text-display fw-bold text-danger"></span>
                            <span class="text-danger fw-bold">{{ $dcData['indent_reference_no'] }}</span>
                            <input type="hidden" name="indentRefNo" id="indentRefNo" class="indent-ref-no"
                                value="{{ $dcData['indent_reference_no'] }}" readonly>
                        </div>
                        <div>
                            <input type="hidden" name="itemId" id="itemId" class="indent-ref-no"
                                value="{{ $dcData['item_id'] }}" readonly>
                            <input type="hidden" name="itemTypeId" id="itemTypeId" class="indent-ref-no"
                                value="{{ $dcData['item_type_id'] }}" readonly>
                            <input type="hidden" name="supplierId" id="supplierId" class="indent-ref-no"
                                value="{{ $dcData['supplier_id'] }}" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="file"
                                    class="form-label mb-2 f-20 fw-bold bg-success p-1 required-field">Choose
                                    Excel/CSV File:</label>
                                <input class="form-control" type="file" id="file" name="file">
                                @error('file')
                                    <div class="invalid-feedback d-block f-14">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary float-end">Import</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('custom-scripts')
    <script src="{{ asset('assets/backend/js/select2/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/backend/js/datatable/datatables/plugin/datatables.min.js') }}"></script>
    <script src="https://unpkg.com/sweetalert2@7.19.1/dist/sweetalert2.all.js"></script>
    <script src="{{ asset('assets/backend/js/notify/bootstrap-notify.min.js') }}"></script>
    <!-- Developer's JS file for brand page -->
    {{-- @include('backend.excel-files.draft-contract-index-js') --}}
@endpush
