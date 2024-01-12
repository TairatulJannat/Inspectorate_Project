@extends('backend.app')
@section('title', 'Contract Create')
@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend/css/datatables.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend/css/select2.css') }}">
    <style>
        form select {
            padding: 10px
        }

        .form-check-input {
            width: 70px !important;

            height: 35px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: aliceblue;
            padding: 20px 10px 0 20px;
            border-radius: 10px;
            margin-bottom: 20px !important:
        }

        .required-field::before {
            content: '*';
            color: red;
            margin-right: 5px;
        }
    </style>
@endpush
@section('main_menu', 'Contract')
@section('active_menu', 'Contract Create')
@section('content')
    <div class="col-sm-12 col-xl-12">
        <div class="card">
            <form action="" method="POST" id="store-contract" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class=" header">
                        <div class="col-md-3">
                            <div class="form-group d-flex">
                                <label class="col-6 pt-2" for="admin-section">Select Section:</label>
                                <select class="form-control" id="admin-section" name="admin-section">
                                    @foreach ($sections as $section)
                                        <option value="{{ $section->id }}">{{ $section->name }}</option>
                                    @endforeach
                                </select>
                                <span id="error-admin-section" class="text-danger error-field"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="sender" class="required-field">Sender</label>
                                <select class="form-control select2" id="sender" name="sender">
                                    <option value="">Please Select a Sender</option>
                                    @foreach ($dte_managments as $dte)
                                        <option value="{{ $dte->id }}">{{ $dte->name }}</option>
                                    @endforeach
                                </select>
                                <span id="error-sender" class="text-danger error-field"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="ltr-no-contract" class="required-field">Letter No. of Contract</label>
                                <input type="text" class="form-control" id="ltr-no-contract" name="ltr-no-contract">
                                <span id="error-ltr-no-contract" class="text-danger error-field"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group flatpickr" data-wrap>
                                <label for="ltr-date-contract" class="required-field">Letter Date of Contract</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="ltr-date-contract"
                                        name="ltr-date-contract" data-input>
                                    <span class="input-group-text">
                                        <a class="btn m-0 p-0" title="Toggle" data-toggle>
                                            <i class="fa fa-calendar"></i>
                                        </a>
                                        {{-- <a class="btn m-0 p-0" title="Clear" data-clear>
                                            <i class="fa fa-close"></i>
                                        </a> --}}
                                    </span>
                                </div>
                                <span id="error-ltr-date-contract" class="text-danger error-field"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="contract-reference-no" class="required-field">Contract Reference No.</label>
                                <input type="text" class="form-control" id="contract-reference-no"
                                    name="contract-reference-no">
                                <span id="error-contract-reference-no" class="text-danger error-field"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="contract-number" class="required-field">Contract Number</label>
                                <input type="text" class="form-control" id="contract-number" name="contract-number">
                                <span id="error-contract-number" class="text-danger error-field"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group flatpickr" data-wrap>
                                <label for="contract-date" class="required-field">Contract Date</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="contract-date" name="contract-date"
                                        data-input>
                                    <span class="input-group-text">
                                        <a class="btn m-0 p-0" title="Toggle" data-toggle>
                                            <i class="fa fa-calendar"></i>
                                        </a>
                                        {{-- <a class="btn m-0 p-0" title="Clear" data-clear>
                                            <i class="fa fa-close"></i>
                                        </a> --}}
                                    </span>
                                </div>
                                <span id="error-contract-date" class="text-danger error-field"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="received-by" class="required-field">Received By</label>
                                <input type="text" value="{{ Auth::user()->name }}" readonly class="form-control"
                                    id="received-by" name="received-by">
                                <span id="error-received-by" class="text-danger error-field"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-end">
                    <div class="col-sm-9 offset-sm-3">
                        <a href="index" type="button" class="btn btn-secondary">Cancel</a>
                        <button class="btn btn-primary" type="submit" id="form_submission_button">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@push('js')
    <script src="{{ asset('assets/backend/js/select2/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/backend/js/datatable/datatables/plugin/datatables.min.js') }}"></script>
    <script src="https://unpkg.com/sweetalert2@7.19.1/dist/sweetalert2.all.js"></script>
    <script src="{{ asset('assets/backend/js/select2/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/backend/js/notify/bootstrap-notify.min.js') }}"></script>
    @include('backend.contracts.contract_incomming_new.index_js')
@endpush
