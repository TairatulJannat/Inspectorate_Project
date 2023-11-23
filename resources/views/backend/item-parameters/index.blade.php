@extends('backend.app')

@section('title', 'Item Parameters')

@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend/css/datatables.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend/css/select2.min.css') }}">
@endpush

@section('main_menu', 'Item Parameters')
@section('active_menu', 'Item Parameters Index')

@section('content')
    <form action="{{ url('admin/assign-parameter-value/show') }}" method="POST" id="searchItemParametersButton"
        autocomplete="off">
        @csrf
        <div class="row bg-body p-3">
            <div class="col-md-2 text-center mt-2">
                <h6>Item Type: </h6>
            </div>
            <div class="col-md-3">
                <div class="mb-2">
                    <select class="form-control select2 item-type-id" id="itemTypeId" name="item-type-id"
                        style="width: 100% !important;">
                        <option value="" selected disabled>Select Item Type</option>
                        @foreach ($itemTypes as $itemType)
                            <option value="{{ $itemType->id }}">{{ $itemType->name }}</option>
                        @endforeach
                    </select>
                </div>
                <span class="text-danger error-text item-type-id-error"></span>
            </div>
            <div class="col-md-2 text-center mt-2">
                <h6 class="card-title">Item: </h6>
            </div>
            <div class="col-md-3">
                <div class="mb-2">
                    <select class="form-control select2 item-id" id="itemId" name="item-id"
                        style="width: 100% !important;">
                        <option value="" selected disabled>Select an item</option>
                        @foreach ($items as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                </div>
                <span class="text-danger error-text item-id-error"></span>
            </div>
            <!-- Search Button -->
            <div class="col-md-2">
                <button type="submit" class="btn btn-success-gradien search-button" id="searchButton">Search<span> <i
                            class="fa fa-search"></i></span></button>
            </div>
        </div>
    </form>
    <div class="row bg-body p-3">
        <div class="text-success searched-data">
            <div class="text-center">
                <h2>Searched Item Parameters will appear here.</h2>
            </div>
        </div>
    </div>
@endsection

@push('custom-scripts')
    <script src="{{ asset('assets/backend/js/select2/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/backend/js/datatable/datatables/plugin/datatables.min.js') }}"></script>
    <script src="https://unpkg.com/sweetalert2@7.19.1/dist/sweetalert2.all.js"></script>
    <script src="{{ asset('assets/backend/js/notify/bootstrap-notify.min.js') }}"></script>
    <!-- Developer's JS file for brand page -->
    @include('backend.item-parameters.index_js')
@endpush
