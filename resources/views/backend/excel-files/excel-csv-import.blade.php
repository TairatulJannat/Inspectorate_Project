@extends('backend.app')

@section('title', 'Excel Files')

@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend/css/datatables.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend/css/select2.min.css') }}">
@endpush

@section('main_menu', 'Excel Files')
@section('active_menu', 'Excel Files Index')

@section('content')
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    <div class="card">
        <div class="card-header bg-primary">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="m-0">Import Export Excel, CSV File</h2>
                {{-- <div>
                    <a href="{{ url('admin/export-excel-csv-file/xlsx') }}" class="btn btn-secondary mr-2">Export
                        Excel</a>
                    <a href="{{ url('admin/export-excel-csv-file/csv') }}" class="btn btn-secondary">Export CSV</a>
                </div> --}}
            </div>
        </div>
        <div class="card-body">
            <form id="excel-csv-import-form" method="POST" action="{{ url('admin/import-excel-csv-file') }}"
                accept-charset="utf-8" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="file" class="form-label">Choose Excel/CSV File:</label>
                            <input class="form-control" type="file" id="file">
                            @error('file')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary btn-block mt-3 float-end">Import Data</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('custom-scripts')
    <script src="{{ asset('assets/backend/js/select2/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/backend/js/datatable/datatables/plugin/datatables.min.js') }}"></script>
    <script src="https://unpkg.com/sweetalert2@7.19.1/dist/sweetalert2.all.js"></script>
    <script src="{{ asset('assets/backend/js/notify/bootstrap-notify.min.js') }}"></script>
    <!-- Developer's JS file for brand page -->
@endpush
