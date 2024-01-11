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
            <form action="" method="POST" id="save_info" enctype="multipart/form-data">
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
                                <select class="form-control" id="sender" name="sender">
                                    <option value="">Please Select</option>
                                    @foreach ($dte_managments as $dte)
                                        <option value="{{ $dte->id }}">{{ $dte->name }}</option>
                                    @endforeach
                                </select>
                                <span id="error-sender" class="text-danger error-field"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="reference-no" class="required-field">Contract Reference No.</label>
                                <input type="text" class="form-control" id="reference-no" name="reference-no">
                                <span id="error-reference-no" class="text-danger error-field"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="contract-reference-date" class="required-field">Contract Reference Date</label>
                                <input type="date" class="form-control" id="contract-reference-date"
                                    name="contract-reference-date">
                                <span id="error-contract-reference-date" class="text-danger error-field"></span>
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
                            <div class="form-group">
                                <label for="contract-date" class="required-field">Contract Date</label>
                                <input type="date" class="form-control" id="contract-date" name="contract-date">
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
    <script>
        $(document).ready(function() {

            $('.select2').select2();


            $("#item_type_id").off('change').on('change', function() {

                //  alert('123');
                var itemtype_id = $('#item_type_id').val();

                if (itemtype_id > 0) {
                    $.ajax({
                        url: "{{ url('admin/prelimgeneral/item_name') }}" +
                            '/' + itemtype_id,
                        type: 'GET',
                        dataType: 'json',
                        success: function(res) {
                            console.log(res);

                            var _html = '<option value="">Select an item</option>';
                            $.each(res, function(index, item) {
                                _html += '<option value="' + item.id + '">' + item
                                    .name + '</option>';
                            });
                            $('#item_id').html(_html);
                        }
                    });
                }
            });
        });
    </script>
@endpush
