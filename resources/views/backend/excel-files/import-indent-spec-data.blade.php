@extends('backend.app')

@section('title', 'Import Indent Spec')

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
@section('active_menu', 'Import Indent Spec')

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
        <form id="import-indent-spec-data-form" method="POST" action="{{ url('admin/import-indent-spec-data') }}"
            accept-charset="utf-8" enctype="multipart/form-data">
            @csrf
            <div class="card-header p-5 pb-0" style="background-color: #b6e9b6  !important;">
                <div class="row">
                    <input type="hidden" id="indentNo" name="indentNo" value="">
                    <div class="col-md-2 mt-2">
                        <h6>Item Type: </h6>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <select class="form-control select2 item-type-id" id="itemTypeId" name="item-type-id"
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
                            <select class="form-control select2 item-id" id="itemId" name="item-id"
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
            </div>
            <div class="card-body" style="background-color: #b6e9b6  !important;">
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
        </form>
    </div>
@endsection

@push('custom-scripts')
    <script src="{{ asset('assets/backend/js/select2/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/backend/js/datatable/datatables/plugin/datatables.min.js') }}"></script>
    <script src="https://unpkg.com/sweetalert2@7.19.1/dist/sweetalert2.all.js"></script>
    <script src="{{ asset('assets/backend/js/notify/bootstrap-notify.min.js') }}"></script>
    <!-- Developer's JS file for brand page -->
    @include('backend.excel-files.indent-index-js')
@endpush
