@extends('backend.app')
@section('title', 'Final Spec (Edit)')
@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend/css/datatables.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend/css/select2.css') }}">
@endpush
@section('main_menu', 'Final Spec')
@section('active_menu', 'Edit')
@section('content')
    <div class="col-sm-12 col-xl-12">

        <div class="card">
            <form action="" id="update_form" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="card-body">
                    <div class=" header">
                        {{-- <div class="col-md-2">
                        <div class="form-group">
                            <label for="additional_documents">Select Section</label>
                            <select class="form-control bg-success text-light" id="admin_section" name="admin_section">
                                @foreach ($sections as $section)
                                    <option value="{{ $section->id }}">{{ $section->name }}</option>
                                @endforeach

                            </select>
                            <span id="error_admin_section" class="text-danger error_field"></span>
                        </div>
                    </div> --}}
                        <div class="col-md-2">
                            <div class="form-group">
                                <a href="{{ url('admin/import-supplier-spec-data-index') }}" class="btn btn-success">Final
                                    Spec Import Excel</a>
                            </div>
                        </div>
                    </div>
                    <div class="row">

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="sender">Sender</label>
                                <input type="hidden" value=" {{ $finalspec->id }}" id="editId" name="editId">
                                <select class="form-control " id="sender" name="sender">

                                    <option value="">Please Select</option>

                                    @foreach ($dte_managments as $dte)
                                        <option value="{{ $dte->id }}"
                                            {{ $dte->id == $finalspec->sender ? 'selected' : '' }}>{{ $dte->name }}
                                        </option>
                                    @endforeach

                                </select>
                                <span id="error_sender" class="text-danger error_field"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="reference_no">Reference No.</label>
                                <input type="text" class="form-control" id="reference_no" name="reference_no"
                                    value="{{ $finalspec->reference_no ? $finalspec->reference_no : '' }} ">
                                <span id="error_reference_no" class="text-danger error_field"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="reference_date">Final Spec Reference Date</label>
                                <input type="text" class="form-control" id="reference_date" name="reference_date"
                                    value="{{ $finalspec->reference_date ? $finalspec->reference_date : '' }} ">
                                <span id="error_reference_date" class="text-danger error_field"></span>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="offer_reference_no">Offer Reference Number</label>
                                <select class="form-control " id="offer_reference_no" name="offer_reference_no">

                                    <option value="">Please Select</option>

                                    @foreach ($offer_reference_numbers as $offer_reference_number)
                                        <option value="{{ $offer_reference_number->reference_no }}"
                                            {{ $offer_reference_number->reference_no == $finalspec->offer_reference_no ? 'selected' : '' }}>
                                            {{ $offer_reference_number->reference_no }}</option>
                                    @endforeach

                                </select>
                                <span id="error_tender_reference_no" class="text-danger error_field"></span>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="tender_reference_no">Tender Reference Number</label>
                                <select class="form-control " id="tender_reference_no" name="tender_reference_no">

                                    <option value="">Please Select</option>

                                    {{-- @foreach ($tender_reference_numbers as $tender_reference_no)
                                    <option value="{{ $tender_reference_no->id }}" 
                                        {{ $tender_reference_no->id == $offer->tender_reference_no ? 'selected' : '' }}>{{ $tender_reference_no->reference_no }}</option>

                                @endforeach --}}

                                </select>
                                <span id="error_tender_reference_no" class="text-danger error_field"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="indent_reference_no">Indent Reference Number</label>
                                <select class="form-control " id="indent_reference_no" name="indent_reference_no">

                                    <option value="">Please Select</option>
                                    {{-- 
                                @foreach ($indent_reference_numbers as $indent_reference_no)
                                    <option value="{{ $indent_reference_no->id }}"
                                    {{ $indent_reference_no->id == $offer->indent_reference_no ? 'selected' : '' }}>{{ $indent_reference_no->reference_no }}</option>

                                @endforeach --}}

                                </select>
                                <span id="error_indent_reference_no" class="text-danger error_field"></span>
                            </div>
                        </div>



                        <div class="col-md-4">
                            <div class="form-group">

                                <label for="supplier_id">Suppiler</label>

                                <select class="form-control select2" id="supplier_id" name="supplier_id[]" multiple>
                                    <option value="">Please Select</option>
                                    {{-- @foreach ($suppliers as $supplier)
                                <option value="{{ $supplier->id }}">{{ $supplier->firm_name }}</option>
                                @endforeach --}}

                                </select>
                                <span id="error_supplier_id" class="text-danger error_field"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="final_spec_receive_Ltr_dt">Final Spec Receive Letter Date</label>
                                <input type="date" class="form-control" id="final_spec_receive_Ltr_dt"
                                    name="final_spec_receive_Ltr_dt">
                                <span id="error_final_spec_receive_Ltr_dt" class="text-danger error_field"></span>
                            </div>
                        </div>



                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="item_type_id">Item Type</label>
                                <select class="form-control " id="item_type_id" name="item_type_id">

                                    <option selected disabled value="">Please Select</option>
                                    {{-- 
                                @foreach ($item_types as $item_type)
                                    <option value="{{ $item_type->id }}">{{ $item_type->name }}</option>
                                @endforeach --}}

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
                                <label for="fin_year_id">Financial Year </label>

                                <select class="form-control" id="fin_year_id" name="fin_year_id">

                                    <option value="">Please Select Year </option>
                                    @foreach ($fin_years as $fin_year)
                                        <option value={{ $fin_year->id }}>{{ $fin_year->year }} </option>
                                    @endforeach

                                </select>

                                <span id="error_item_id" class="text-danger error_field"></span>
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



                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="pdf_file" style="color: yellow"><button type="button"
                                        class="btn btn-warning">Upload PDF</b></button></label><br>
                                <input type="file" class="form-control-file" id="pdf_file" name="pdf_file">
                                <span id="error_pdf_file" class="text-danger error_field"></span>
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
    <script>
        $(document).ready(function() {
            $('.select2').select2();
        });

        //Start:: Update information
        $('#update_form').off().on('submit', function(event) {
            event.preventDefault();
            var formData = new FormData($('#update_form')[0]);
            disableButton()
            $.ajax({
                url: "{{ url('admin/finalspec/update') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                success: function(response) {
                    if (response.error) {
                        error_notification(response.error)
                        enableeButton()
                    }
                    if (response.success) {
                        // enableeButton()
                        $('.yajra-datatable').DataTable().ajax.reload(null, false);
                        toastr.success('Information Updated', 'Saved');
                        $('#edit_model').modal('hide');
                    }
                    setTimeout(window.location.href = "{{ route('admin.FinalSpec/view') }}", 40000);
                },
                error: function(response) {
                    enableeButton()
                    clear_error_field();
                    error_notification('Please fill up the form correctly and try again')
                    // $('#error_hall_id').text(response.responseJSON.errors.hall_id);
                    // $('#error_floor_id').text(response.responseJSON.errors.floor_id);
                    // $('#error_user_category_id').text(response.responseJSON.errors.user_category_id);
                    // $('#error_specify_event').text(response.responseJSON.errors.specify_event);
                    // $('#error_event_name').text(response.responseJSON.errors.event_name);
                    // $('#error_specify_month').text(response.responseJSON.errors.specify_month);
                    // $('#error_months').text(response.responseJSON.errors.months);
                    // $('#error_specify_ramadan').text(response.responseJSON.errors.specify_ramadan);
                    // $('#error_specify_shift_charge').text(response.responseJSON.errors
                    //     .specify_shift_charge);
                    // $('#error_shift_id').text(response.responseJSON.errors.shift_id);
                    // $('#error_price').text(response.responseJSON.errors.price);
                    // $('#error_status').text(response.responseJSON.errors.status);
                }
            });
        })


        function form_reset() {
            document.getElementById("search_form").reset();
            $('.select2').val(null).trigger('change');
            $('.yajra-datatable').DataTable().ajax.reload(null, false);
        }

        function clear_error_field() {
            $('#error_name').text('');
            $('#error_holiday_date').text('');
        }

        function disableButton() {
            var btn = document.getElementById('form_submission_button');
            btn.disabled = true;
            btn.innerText = 'Saving....';
        }

        function enableeButton() {
            var btn = document.getElementById('form_submission_button');
            btn.disabled = false;
            btn.innerText = 'Save'
        }

        function error_notification(message) {
            var notify = $.notify('<i class="fa fa-bell-o"></i><strong>' + message + '</strong> ', {
                type: 'theme',
                allow_dismiss: true,
                delay: 2000,
                showProgressbar: true,
                timer: 300
            });
        }
    </script>
    <script>
        $(document).ready(function() {

            $('.select2').select2();


            // $("#item_type_id").off('change').on('change', function() {

            //     //  alert('123');
            //     var itemtype_id = $('#item_type_id').val();

            //     if (itemtype_id > 0) {
            //         $.ajax({
            //             url: "{{ url('admin/prelimgeneral/item_name') }}" +
            //                 '/' + itemtype_id,
            //             type: 'GET',
            //             dataType: 'json',
            //             success: function(res) {
            //                 console.log(res);

            //                 var _html = '<option value="">Select an item</option>';
            //                 $.each(res, function(index, item) {
            //                     _html += '<option value="' + item.id + '">' + item
            //                         .name + '</option>';
            //                 });
            //                 $('#item_id').html(_html);
            //             }
            //         });
            //     }
            // });

            $('#offer_reference_no').off('change').on('change', function() {
                var offerReferenceNo = $(this).val();
                if (offerReferenceNo) {
                    $.ajax({
                        url: "{{ url('admin/final_spec/get_offer_details') }}" + '/' +
                            offerReferenceNo,
                        type: 'GET',
                        success: function(response) {
                            var item_html = '<option value="' + response.item.id + '">' +
                                response.item.name + '</option>';
                            var itemType_html = '<option value="' + response.itemType.id +
                                '">' + response.itemType.name + '</option>';
                            var tenderReferenceNo_html = '<option value="' + response
                                .tenderReferenceNo.reference_no + '">' + response.tenderReferenceNo
                                .reference_no + '</option>';
                            var indentReferenceNo_html = '<option value="' + response
                                .indentReferenceNo.reference_no + '">' + response.indentReferenceNo
                                .reference_no + '</option>';
                            // var suppliers_html = '<option value="'+response.suppliers.id+'">'+response.suppliers.firm_name+'</option>';

                            $('#item_id').html(item_html);
                            $('#item_type_id').html(itemType_html);
                            $('#tender_reference_no').html(tenderReferenceNo_html);
                            $('#indent_reference_no').html(indentReferenceNo_html);
                            // $('#supplier_id').html(suppliers_html);


                        },
                        error: function(error) {
                            console.log(error);
                        }
                    });
                }
            });
        });
    </script>
@endpush
