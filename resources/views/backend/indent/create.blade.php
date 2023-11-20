@extends('backend.app')
@section('title', 'Indent')
@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend/css/datatables.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend/css/select2.css') }}">
    <style>
        form select {
            padding: 10px
        }
        .form-check-input{
            width:70px !important;
            height: 35px;
        }
    </style>
@endpush
@section('main_menu', 'Indent')
@section('active_menu', 'Add Indent')
@section('content')
    <div class="col-sm-12 col-xl-12">

        <div class="card">
            <form action="" method="POST" id="save_info" enctype="multipart/form-data">
                @csrf

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="additional_documents">Select Section</label>
                                <select class="form-control bg-success text-light" id="admin_section" name="admin_section">
                                    @foreach ($sections as $section)
                                        <option value="{{ $section->id }}">{{ $section->name }}</option>
                                    @endforeach

                                </select>
                                <span id="error_admin_section" class="text-danger error_field"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="sender">Sender</label>
                                <select class="form-control " id="sender" name="sender">

                                    <option value="">Please Select</option>

                                    @foreach ($dte_managments as $dte)
                                        <option value="{{ $dte->id }}">{{ $dte->name }}</option>
                                    @endforeach

                                </select>
                                <span id="error_sender" class="text-danger error_field"></span>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="reference_no">Reference No.</label>
                                <input type="text" class="form-control" id="reference_no" name="reference_no">
                                <span id="error_reference_no" class="text-danger error_field"></span>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="additional_documents">Aditional Document</label>
                                <select class="form-control " id="additional_documents" name="additional_documents">

                                    <option value="">Please Select</option>

                                    @foreach ($additional_documnets as $additional_documnet)
                                        <option value="{{ $additional_documnet->id }}">{{ $additional_documnet->name }}
                                        </option>
                                    @endforeach

                                </select>
                                <span id="error_additional_documents" class="text-danger error_field"></span>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="indent_number">Indent Number</label>
                                <input type="text" class="form-control" id="indent_number"
                                    name="indent_number">
                                <span id="error_indent_number" class="text-danger error_field"></span>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="indent_received_date">Indent Received Date</label>
                                <input type="date" class="form-control" id="indent_received_date"
                                    name="indent_received_date">
                                <span id="error_indent_received_date" class="text-danger error_field"></span>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="item_type_id">Item Type</label>
                                <select class="form-control " id="item_type_id" name="item_type_id">

                                    <option selected disabled value="">Please Select</option>

                                    @foreach ($item_types as $item_type)
                                        <option value="{{ $item_type->id }}">{{ $item_type->name }}</option>
                                    @endforeach

                                </select>
                                <span id="error_item_type_id" class="text-danger error_field"></span>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="item_id">Item</label>

                                <select class="form-control" id="item_id" name="item_id">

                                    <option value="">Please Select </option>
                                </select>

                                <span id="error_item_id" class="text-danger error_field"></span>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="qty">Item QTY</label>
                                <input type="text" class="form-control" id="qty" name="qty">

                                <span id="error_qty" class="text-danger error_field"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="attribute">Attribute</label>
                               <select class="form-control" name="attribute" id="attribute">
                                <option value="">Please Select</option>
                                <option value="Controlled">Controlled</option>
                                <option value="Uncontrolled">Uncontrolled</option>
                               </select>

                                <span id="error_attribute" class="text-danger error_field"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="estimated_value">Estimated Value</label>
                                <input type="text" class="form-control" id="estimated_value" name="estimated_value">

                                <span id="error_estimated_value" class="text-danger error_field"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="spare">Spare</label>
                                <input type="text" class="form-control" id="spare" name="spare">

                                <span id="error_spare" class="text-danger error_field"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="checked_standard">Standard Checked</label>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="checked_standard"  name="checked_standard">
                                </div>

                                <span id="error_checked_standard" class="text-danger error_field"></span>
                            </div>

                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="fin_year_id">Financial Year </label>

                                <select class="form-control" id="fin_year_id" name="fin_year_id ">

                                    <option value="">Please Select Year </option>
                                    @foreach ($fin_years as $fin_year)
                                        <option value={{ $fin_year->id }}>{{ $fin_year->name }} </option>
                                    @endforeach

                                </select>

                                <span id="error_item_id" class="text-danger error_field"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="nomenclature">Nomenclature</label>
                                <input type="text" class="form-control" id="nomenclature" name="nomenclature">

                                <span id="error_nomenclature" class="text-danger error_field"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="make">Make</label>
                                <input type="text" class="form-control" id="make" name="make">

                                <span id="error_make" class="text-danger error_field"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="model">Model</label>
                                <input type="text" class="form-control" id="model" name="model">

                                <span id="error_model" class="text-danger error_field"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="country_of_origin">Country of Origin</label>
                                <input type="text" class="form-control" id="country_of_origin" name="country_of_origin">

                                <span id="error_country_of_origin" class="text-danger error_field"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="country_of_assembly">Country of Assembly</label>
                                <input type="text" class="form-control" id="country_of_assembly" name="country_of_assembly">

                                <span id="error_country_of_assembly" class="text-danger error_field"></span>
                            </div>
                        </div>


                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="received_by">Received By</label>
                                <input type="text" value="{{ \Illuminate\Support\Facades\Auth::user()->name }}"
                                    readonly class="form-control" id="received_by" name="received_by">
                                <span id="error_received_by" class="text-danger error_field"></span>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="remark">Remark</label>
                                <textarea name="remark" id="remark" class="form-control"></textarea>
                                <span id="error_remark" class="text-danger error_field"></span>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="card-footer text-end">
                    <div class="col-sm-9 offset-sm-3">
                        <a href="" type="button" class="btn btn-secondary">Cancel</a>
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
    @include('backend.tender.index_js')
    <script>
        $(document).ready(function() {

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
