@extends('backend.app')

@section('title', 'Import Final Spec')

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
@section('active_menu', 'Import Final Spec')

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
        <form method="POST" action="{{ url('admin/import-final-spec-data') }}"
            enctype="multipart/form-data">
            @csrf
            <div class="row">
                <input type="hidden" name="document_id" id="document_id" value="{{ $documentDetails->reference_no }}">
                <input type="hidden" name="doc_type_id" id="doc_type_id" value="{{ $doc_type_id }}">
                <input type="hidden" name="supplierId" id="supplierId" value="{{ $supplier->id }}">
                <div class="col-md-12 d-flex justify-content-center">
                    <div class="text-center text-light">
                        <p>Final Spec Reference No: {{ $documentDetails->reference_no }}</p>
                        <p>Item Type: {{ $itemType->name }}</p>
                        <p>Nomenclature: {{ $item->name }}</p>
                        <p>Supplier: {{ $supplier->firm_name }}</p>

                    </div>

                </div>
                <div class="col-md-12">
                    <div class="mb-3">
                        <label for="file" class="form-label mb-2 f-20 fw-bold bg-success p-1 required-field">Choose
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
        </form>
        {{-- <form id="import-final-spec-data-form" method="POST" action="{{ url('admin/import-final-spec-data') }}"
            accept-charset="utf-8" enctype="multipart/form-data">
            @csrf
            <div class="card-header p-5 pb-3" style="background-color: #b6e9b6 !important;">
                <div class="f-20">
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label for="finalSpecRefNo">Final Spec Reference Number:</label>
                        </div>
                        <div class="col-md-3">
                            <span id="finalSpecRefNoDisplay" class="text-display fw-bold text-danger"></span>
                            <input type="hidden" name="finalSpecRefNo" id="finalSpecRefNo" class="final-spec-ref-no"
                                oninput="displayText(this.value, 'finalSpecRefNoDisplay')" readonly>
                        </div>
                        <div class="col-md-3">
                            <label for="offerRefNo">Offer Reference Number:</label>
                        </div>
                        <div class="col-md-3">
                            <span id="offerRefNoDisplay" class="text-display fw-bold text-danger"></span>
                            <input type="hidden" name="offerRefNo" id="offerRefNo" class="offer-ref-no"
                                oninput="displayText(this.value, 'offerRefNoDisplay')" readonly>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label for="tenderRefNo">Tender Reference Number:</label>
                        </div>
                        <div class="col-md-3"><span id="tenderRefNoDisplay" class="text-display fw-bold text-danger"></span>
                            <input type="hidden" name="tenderRefNo" id="tenderRefNo" class="tender-ref-no"
                                oninput="displayText(this.value, 'tenderRefNoDisplay')" readonly>
                        </div>
                        <div class="col-md-3">
                            <label for="indentRefNo">Indent Reference Number:</label>
                        </div>
                        <div class="col-md-3"><span id="indentRefNoDisplay" class="text-display fw-bold text-danger"></span>
                            <input type="hidden" name="indentRefNo" id="indentRefNo" class="indent-ref-no"
                                oninput="displayText(this.value, 'indentRefNoDisplay')" readonly>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body f-20">
                <div class="row mb-3">
                    <div class="col-md-2">
                        <label for="supplierId" class="fw-bold bg-success p-1 required-field">Selected Supplier:</label>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <select class="form-control select2 supplier-id" id="supplierId" name="supplierId"
                                style="width: 100% !important;">
                                <option value="" selected disabled>Select Supplier</option>
                                @foreach ($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}">{{ $supplier->firm_name }}</option>
                                @endforeach
                            </select>
                            @error('supplierId')
                                <div class="invalid-feedback d-block f-14">{{ $message }}</div>
                            @enderror
                        </div>
                        <span class="text-danger error-text supplierId-error"></span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="file" class="form-label mb-2 f-20 fw-bold bg-success p-1 required-field">Choose
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
        </form> --}}
    </div>
@endsection

@push('custom-scripts')
    <script src="{{ asset('assets/backend/js/select2/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/backend/js/datatable/datatables/plugin/datatables.min.js') }}"></script>
    <script src="https://unpkg.com/sweetalert2@7.19.1/dist/sweetalert2.all.js"></script>
    <script src="{{ asset('assets/backend/js/notify/bootstrap-notify.min.js') }}"></script>
    <!-- Developer's JS file for brand page -->
    {{-- @include('backend.excel-files.final-spec-index-js') --}}
@endpush
