@extends('backend.app')
@section('title', 'Offer (Edit)')
@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend/css/datatables.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend/css/select2.css') }}">
@endpush
@section('main_menu', 'Offer')
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
                                <a id="importExcelBtn" href="{{ url('admin/import-supplier-spec-data-index') }}"
                                    class="btn btn-success">Import Supplier Spec</a>
                            </div>
                        </div>
                    </div>
                    <div class="row">

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="sender">Sender</label>
                                <input type="hidden" value=" {{ $offer->id }}" id="editId" name="editId">
                                <select class="form-control " id="sender" name="sender">

                                    <option value="">Please Select</option>

                                    @foreach ($dte_managments as $dte)
                                        <option value="{{ $dte->id }}"
                                            {{ $dte->id == $offer->sender ? 'selected' : '' }}>{{ $dte->name }}
                                        </option>
                                    @endforeach

                                </select>
                                <span id="error_sender" class="text-danger error_field"></span>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="reference_no">Reference Number</label>
                                <input type="text" class="form-control" id="reference_no" name="reference_no"
                                    value="{{ $offer->reference_no ? $offer->reference_no : '' }}">
                                <span id="error_reference_no" class="text-danger error_field"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="offer_reference_date">Offer Reference Date</label>
                                <input type="date" class="form-control" id="offer_reference_date"
                                    name="offer_reference_date"
                                    value="{{ $offer->offer_reference_date ? $offer->offer_reference_date : '' }}">
                                <span id="error_offer_reference_date" class="text-danger error_field"></span>
                            </div>
                        </div>

                        
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="offer_rcv_ltr_dt">Offer Receive Letter Date</label>
                                <input type="date" class="form-control" id="offer_rcv_ltr_dt" name="offer_rcv_ltr_dt"
                                    value="{{ $offer->offer_rcv_ltr_dt ? $offer->offer_rcv_ltr_dt : '' }}">
                                <span id="error_offer_rcv_ltr_dt" class="text-danger error_field"></span>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="tender_reference_no">Tender Reference Number</label>
                                <select class="form-control" id="tender_reference_no" name="tender_reference_no">
                                    <option value="">Please Select</option>
                                    @if ($offer->tender_reference_no)
                                        <option value="{{ $offer->tender_reference_no }}" selected>
                                            {{ $offer->tender_reference_no }}
                                        </option>
                                    @endif
                                    @foreach ($tender_reference_numbers as $tender_reference_number)
                                        <option value="{{ $tender_reference_number->reference_no }}">

                                            {{ $tender_reference_number->reference_no }}</option>
                                    @endforeach
                                </select>
                                <span id="error_tender_reference_no" class="text-danger error_field"></span>
                            </div>
                        </div>
                     


                        <div class="col-md-4">
                            <div class="form-group">

                                <label for="additional_documents">Additional Documents</label>
                                <select class="form-control select2" id="additional_documents" name="additional_documents[]"
                                    multiple>
                                    <option value="">Please Select</option>
                                    @foreach ($additional_documnets as $additional_document)
                                        @php
                                            $documentIds = json_decode($offer->additional_documents);
                                            $isSelected = in_array($additional_document->id, $documentIds ? $documentIds : []) ? 'selected' : '';
                                        @endphp
                                        <option value="{{ $additional_document->id }}" {{ $isSelected }}>
                                            {{ $additional_document->name }}
                                        </option>
                                    @endforeach

                                </select>
                                <span id="error_additional_documents" class="text-danger error_field"></span>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">

                                <label for="supplier_id">Suppiler</label>

                                <select class="form-control select2" id="supplier_id" name="supplier_id[]" multiple>
                                    <option value="">Please Select</option>
                                    @foreach ($suppliers as $supplier)
                                        @php
                                            $supplierIds = json_decode($offer->supplier_id);
                                            $isSelected = in_array($supplier->id, $supplierIds ? $supplierIds : []) ? 'selected' : '';
                                        @endphp

                                        <option value="{{ $supplier->id }}" {{ $isSelected }}>
                                            {{ $supplier->firm_name }}</option>
                                    @endforeach

                                </select>



                                <span id="error_supplier_id" class="text-danger error_field"></span>
                            </div>
                        </div>
                        {{-- <div class="col-md-4">
                            <div class="form-group">
                                <label for="offer_rcv_ltr_no">Offer Receive Letter No</label>
                                <input type="text" class="form-control" id="offer_rcv_ltr_no" name="offer_rcv_ltr_no"
                                    value="{{ $offer->offer_rcv_ltr_no ? $offer->offer_rcv_ltr_no : '' }}">
                                <span id="error_offer_rcv_ltr_no" class="text-danger error_field"></span>

                            </div>
                        </div> --}}

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="indent_reference_no">Indent Reference Number</label>


                                <select class="form-control " id="indent_reference_no" name="indent_reference_no">

                                    <option value="">Please Select</option>
                                    @if ($offer->indent_reference_no)
                                        <option value={{ $offer->indent_reference_no }} selected>
                                            {{ $offer->indent_reference_no }}</option>
                                    @endif
                                    @foreach ($indent_reference_numbers as $indent_reference_number)
                                        <option value="{{ $indent_reference_number->reference_no }}">
                                            {{ $indent_reference_number->reference_no }}</option>
                                    @endforeach

                                </select>
                                <span id="error_indent_reference_no" class="text-danger error_field"></span>
                            </div>
                        </div>
     


                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="item_type_id">Item Type</label>
                                <select class="form-control" id="item_type_id" name="item_type_id">

                                    <option selected disabled value="">Please Select</option>

                                    {{-- @foreach ($item_types as $item_type)
                                        <option value="{{ $item_type->id }}"
                                            {{ $item_type->id == $offer->item_type_id ? 'selected' : '' }}>
                                            {{ $item_type->name }}
                                        </option>
                                    @endforeach --}}


                                </select>
                                <span id="error_item_type_id" class="text-danger error_field"></span>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="item_id">Item</label>


                                <select class="form-control" id="item_id" name="item_id">
                                    <option value="">Please Select</option>
                                    {{-- @if ($item)
                                        <option value="{{ $item->id }}" selected>{{ $item->name }}</option>
                                    @endif --}}
                                </select>



                                <span id="error_item_id" class="text-danger error_field"></span>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="qty">Item Qty</label>

                                <input type="text" class="form-control" id="qty" name="qty"
                                    value="{{ $offer->qty ? $offer->qty : '' }}">


                                <span id="error_qty" class="text-danger error_field"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="attribute">Attribute</label>

                                <select class="form-control" name="attribute" id="attribute">
                                    <option value="">Please Select</option>

                                    <option value="Controlled" {{ $offer->attribute == 'Controlled' ? 'selected' : '' }}>
                                        Controlled</option>
                                    <option value="Uncontrolled"
                                        {{ $offer->attribute == 'Uncontrolled' ? 'selected' : '' }}>Uncontrolled</option>

                                </select>


                                <span id="error_attribute" class="text-danger error_field"></span>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="fin_year_id">Financial Year </label>

                                <select class="form-control" id="fin_year_id" name="fin_year_id">
                                    <option value="">Please Select Year </option>
                                    @foreach ($fin_years as $fin_year)
                                        <option value={{ $fin_year->id }}
                                            {{ $fin_year->id == $offer->fin_year_id ? 'selected' : '' }}>
                                            {{ $fin_year->year }}
                                        </option>
                                    @endforeach
                                </select>


                                <span id="error_item_id" class="text-danger error_field"></span>
                            </div>
                        </div>

                        {{-- <div class="col-md-4">
                        <label for="receive_status">Is Offer Vetted</label>
                        <input class="form-check-input" type="checkbox" id="is_offer_vetted" name="is_offer_vetted" checked>
                        <span class="text-danger error-text receive_status_error"></span>
                    </div>
                    <div class="col-md-4" id="offer_vetting_ltr_no">
                        <label  for="receive_date">Offer Vetting Ltr No</label>
                        <input class="form-control"  type="text" id="offer_vetting_ltr_no" name="offer_vetting_ltr_no" >
                        <span class="text-danger error-text rreceive_date_error"></span>
                    </div>
                    <div class="col-md-4" id="offer_vetting_ltr_dt">
                        <label  for="asking_date">Offer vetting Ltr Date</label>
                        <input class="form-control" type="date" id="offer_vetting_ltr_dt" name="offer_vetting_ltr_dt" >
                        <span class="text-danger error-text receiveDate_error"></span>
                    </div> --}}

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

                                <textarea name="remark" id="remark" class="form-control">{{ $offer->remark ? $offer->remark : '' }}</textarea>

                                <span id="error_remark" class="text-danger error_field"></span>
                            </div>
                        </div>



                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="pdf_file"><b>Upload Document</b></label>
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

            $('#importExcelBtn').on('click', function(event) {
                event.preventDefault();

                var url = $(this).attr('href');
                var offerRefNo = $('#reference_no').val();
                var redirectUrl = url + '?offerRefNo=' + encodeURIComponent(offerRefNo);

                window.location.href = redirectUrl;
            });
        });

        //Start:: Update information
        $('#update_form').off().on('submit', function(event) {
            event.preventDefault();
            var formData = new FormData($('#update_form')[0]);
            disableButton()
            $.ajax({
                url: "{{ url('admin/offer/update') }}",
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
                    setTimeout(window.location.href = "{{ route('admin.offer/view') }}", 40000);
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

            $('#indent_reference_no').off('change').on('change', function() {
                var indentReferenceNo = $(this).val();
                if (indentReferenceNo) {
                    $.ajax({
                        url: "{{ url('admin/offer/get_indent_details') }}" + '/' +
                        indentReferenceNo,
                        type: 'GET',
                        success: function(response) {
                            var item_html = '<option value="' + response.item.id + '">' +
                                response.item.name + '</option>';
                            var itemType_html = '<option value="' + response.itemType.id +
                                '">' + response.itemType.name + '</option>';
                            



                            $('#item_id').html(item_html);
                            $('#item_type_id').html(itemType_html);



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
