@extends('backend.app')

@section('title', 'Contracts'),

@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend/css/datatables.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend/css/select2.min.css') }}">
@endpush

@section('main_menu', 'Contracts')
@section('active_menu', 'Contracts Index')

@section('content')
    <form action="{{ url('admin/contract/store') }}" method="POST" id="createContractForm" autocomplete="off">
        @csrf
        <div class="card">
            <div class="card-header">
                <div class="flot-chart-placeholder mt-3">
                    <h3 class="fw-bold text-underline">Create Contract</h3>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="ltrNoOfContract" class="form-label">letter No. of Contract</label>
                            <input type="text" class="form-control ltr-no-of-contract" id="ltrNoOfContract"
                                name="ltr-no-of-contract">
                            <span class="text-danger error-text ltr-no-of-contract-error"></span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="ltrDateContract" class="form-label">letter Date Contract</label>
                            <input type="date" class="form-control ltr-date-contract" id="ltrDateContract"
                                name="ltr-date-contract">
                            <span class="text-danger error-text ltr-date-contract-error"></span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="contractNo" class="form-label">Contract No.</label>
                            <input type="text" class="form-control contract-no" id="contractNo" name="contract-no">
                            <span class="text-danger error-text contract-no-error"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="contractDate" class="form-label">Contract Date</label>
                            <input type="date" class="form-control contract-date" id="contractDate" name="contract-date">
                            <span class="text-danger error-text contract-date-error"></span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="contractState" class="form-label">Contract State</label>
                            <input type="text" class="form-control contract-state" id="contractState"
                                name="contract-state">
                            <span class="text-danger error-text contract-state-error"></span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="conFinYear" class="form-label">Contract Financial Year</label>
                            <input type="year" class="form-control con-fin-year" id="conFinYear" name="con-fin-year">
                            <span class="text-danger error-text con-fin-year-error"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="supplierId" class="form-label">Supplier</label>
                            <select class="form-control supplier-id" id="supplierId" name="supplier-id">
                                <option value="" selected disabled>Select a Supplier</option>
                                @foreach ($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}">{{ $supplier->firm_name }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger error-text supplier-id-error"></span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="contractedValue" class="form-label">Contracted Value</label>
                            <input type="text" class="form-control contracted-value" id="contractedValue"
                                name="contracted-value">
                            <span class="text-danger error-text contracted-value-error"></span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="deliverySchedule" class="form-label">Delivery Schedule</label>
                            <input type="text" class="form-control delivery-schedule" id="deliverySchedule"
                                name="delivery-schedule">
                            <span class="text-danger error-text delivery-schedule-error"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="currencyUnit" class="form-label">Currency Uunit</label>
                            <input type="text" class="form-control currency-unit" id="currencyUnit"
                                name="currency-unit">
                            <span class="text-danger error-text currency-unit-error"></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="float-end">
                    <button type="submit" class="btn btn-success" id="createButton">Create</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('custom-scripts')
    <script src="{{ asset('assets/backend/js/select2/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/backend/js/datatable/datatables/plugin/datatables.min.js') }}"></script>
    <script src="https://unpkg.com/sweetalert2@7.19.1/dist/sweetalert2.all.js"></script>
    <script src="{{ asset('assets/backend/js/notify/bootstrap-notify.min.js') }}"></script>
    <!-- Developer's JS file for brand page -->
    @include('backend.contracts.index_js')
@endpush
