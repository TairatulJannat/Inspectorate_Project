@extends('backend.app')

@section('title', 'Import Supplier Spec')

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
@section('active_menu', 'Import Supplier Spec')

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

    <div class="card" style="background-color: darkseagreen;">
        <form id="import-supplier-spec-data-form" method="POST" action="{{ url('admin/import-supplier-spec-data') }}"
            accept-charset="utf-8" enctype="multipart/form-data">
            @csrf
            <div class="card-header p-5 pb-0" style="background-color: darkseagreen !important;">
                <div class="row">
                    <div class="col-md-2 mt-2">
                        <h6>Tender Reference No.: </h6>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <select class="form-control select2 tender-id" id="tenderId" name="tender-id"
                                style="width: 100% !important;" disabled>
                                <option value="" selected disabled>Select Tender Reference No.</option>
                                @foreach ($tenders as $tender)
                                    <option value="{{ $tender->id }}">{{ $tender->reference_no }}</option>
                                @endforeach
                            </select>
                            @error('tender-id')
                                <div class="invalid-feedback d-block f-14">{{ $message }}</div>
                            @enderror
                        </div>
                        <span class="text-danger error-text tender-id-error"></span>
                    </div>
                    <div class="col-md-2 mt-2">
                        <h6>Indent Reference No.: </h6>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <select class="form-control indent-id" id="indentId" name="indent-id"
                                style="width: 100% !important;" disabled>
                                <option value="" selected disabled>Indent Reference No.</option>
                                @foreach ($indents as $indent)
                                    <option value="{{ $indent->id }}">{{ $indent->reference_no }}</option>
                                @endforeach
                            </select>
                            @error('indent-id')
                                <div class="invalid-feedback d-block f-14">{{ $message }}</div>
                            @enderror
                        </div>
                        <span class="text-danger error-text indent-id-error"></span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2 mt-2">
                        <h6>Item Type: </h6>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <select class="form-control item-type-id" id="itemTypeId" name="item-type-id"
                                style="width: 100% !important;" disabled>
                                <option value="" selected disabled>Item Type</option>
                                @foreach ($itemTypes as $itemType)
                                    <option value="{{ $itemType->id }}">{{ $itemType->name }}</option>
                                @endforeach
                            </select>
                            @error('item-type-id')
                                <div class="invalid-feedback d-block f-14">{{ $message }}</div>
                            @enderror
                        </div>
                        <span class="text-danger error-text item-type-id-error"></span>
                    </div>
                    <div class="col-md-2 mt-2">
                        <h6 class="card-title">Item: </h6>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <select class="form-control item-id" id="itemId" name="item-id"
                                style="width: 100% !important;" disabled>
                                <option value="" selected disabled>Item</option>
                                @foreach ($items as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                            @error('item-id')
                                <div class="invalid-feedback d-block f-14">{{ $message }}</div>
                            @enderror
                        </div>
                        <span class="text-danger error-text item-id-error"></span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2 mt-2">
                        <h6 class="card-title required-field">Supplier: </h6>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <select class="form-control select2 supplier-id" id="supplierId" name="supplier-id"
                                style="width: 100% !important;">
                                <option value="" selected disabled>Select Supplier</option>
                                @foreach ($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}">{{ $supplier->firm_name }}</option>
                                @endforeach
                            </select>
                            @error('supplier-id')
                                <div class="invalid-feedback d-block f-14">{{ $message }}</div>
                            @enderror
                        </div>
                        <span class="text-danger error-text supplier-id-error"></span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6"></div>
                    <div class="col-md-6">
                        <div class="supplier-data" id="supplierTableContainer">
                            <table class="table-bordered w-100" style="background-color: burlywood;">
                                <thead>
                                    <tr>
                                        <th class="text-center f-16">Already Submitted Supplier:</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Existing rows will be appended here -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="file" class="form-label mb-2 text-white f-22">Choose Excel/CSV File:</label>
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
        </form>
    </div>
@endsection

@push('custom-scripts')
    <script src="{{ asset('assets/backend/js/select2/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/backend/js/datatable/datatables/plugin/datatables.min.js') }}"></script>
    <script src="https://unpkg.com/sweetalert2@7.19.1/dist/sweetalert2.all.js"></script>
    <script src="{{ asset('assets/backend/js/notify/bootstrap-notify.min.js') }}"></script>
    <!-- Developer's JS file for brand page -->
    @include('backend.excel-files.supplier-index-js')
@endpush
