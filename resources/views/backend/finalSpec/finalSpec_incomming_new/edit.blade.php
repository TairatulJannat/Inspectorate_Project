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
                                <a href="{{ url('admin/import-final-spec-data-index') }}" class="btn btn-success"
                                    id="importExcelBtn">Final Spec Import Excel</a>
                            </div>
                        </div> --}}
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="sender">Sender</label>

                                <input type="hidden" value=" {{ $finalSpec->id }}" id="editId" name="editId">

                                <select class="form-control " id="sender" name="sender">

                                    <option value="">Please Select</option>

                                    @foreach ($dte_managments as $dte)
                                        <option value="{{ $dte->id }}"
                                            {{ $dte->id == $finalSpec->sender ? 'selected' : '' }}>{{ $dte->name }}

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
                                    value="{{ $finalSpec->reference_no ? $finalSpec->reference_no : '' }}">
                                <span id="error_reference_no" class="text-danger error_field"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="reference_date">Final Spec Reference Date</label>
                                <input type="text" class="form-control" id="reference_date" name="reference_date"
                                    value="{{ $finalSpec->reference_date ? $finalSpec->reference_date : '' }} ">
                                <span id="error_reference_date" class="text-danger error_field"></span>
                            </div>

                        </div>



                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="final_spec_receive_Ltr_dt">Final Spec Receive Date</label>
                                <input type="text" class="form-control" id="final_spec_receive_Ltr_dt"
                                    name="final_spec_receive_Ltr_dt"
                                    value="{{ $finalSpec->final_spec_receive_Ltr_dt ? $finalSpec->final_spec_receive_Ltr_dt : $finalSpec->final_spec_receive_Ltr_dt }} ">
                                <span id="error_final_spec_receive_Ltr_dt" class="text-danger error_field"></span>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">

                                <label for="offer_reference_no">Offer Reference No</label>
                                <select class="form-control" id="offer_reference_no" name="offer_reference_no">

                                    <option value="">Please Select</option>

                                    @foreach ($offer_reference_numbers as $offer_reference_number)
                                        <option value="{{ $offer_reference_number->reference_no }}"
                                            {{ $offer_reference_number->reference_no == $finalSpec->offer_reference_no ? 'selected' : '' }}>
                                            {{ $offer_reference_number->reference_no }}</option>
                                    @endforeach

                                </select>
                                <span id="error_tender_reference_no" class="text-danger error_field"></span>

                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="tender_reference_no">Tender Reference No</label>
                                <input type="text" id="tender_reference_no" class="form-control"
                                    name="tender_reference_no"
                                    value="{{ $finalSpec->tender_reference_no ? $finalSpec->tender_reference_no : '' }}">
                                <span id="error_tender_reference_no" class="text-danger error_field"></span>
                            </div>
                        </div>

                        <div class="col-md-4 d-none">
                            <div class="form-group">
                                <label for="indent_reference_no">Indent Reference Number</label>

                                <input type="text" id="indent_reference_no" class="form-control"
                                    name="indent_reference_no"
                                    value="{{ $finalSpec->indent_reference_no ? $finalSpec->indent_reference_no : '' }}">
                                <span id="error_indent_reference_no" class="text-danger error_field"></span>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="supplier_id">Supplier</label>
                                <select class="form-control" id="supplier_id" name="supplier_id">
                                    @foreach ($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}"
                                            {{ $supplier->id == $finalSpec->supplier_id ? 'selected' : '' }}>
                                            {{ $supplier->firm_name }}
                                        </option>
                                    @endforeach
                                </select>
                                <span id="error_supplier_id" class="text-danger error_field"></span>
                            </div>
                        </div>


                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="item_type_id">Item Type</label>
                                <select class="form-control" id="item_type_id" name="item_type_id">

                                    <option selected disabled value="">Please Select</option>
                                    @if ($item_types)
                                        <option value="{{ $item_types->id }}"
                                            {{ $item_types->id == $finalSpec->item_type_id ? 'selected' : '' }}>
                                            {{ $item_types->name }}</option>
                                    @endif
                                </select>
                                <span id="error_item_type_id" class="text-danger error_field"></span>
                            </div>
                        </div>



                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="item_id">Nomenclature</label>

                                <select class="form-control" id="item_id" name="item_id">
                                    {{-- <option value="">Please Select</option> --}}

                                    @if ($item)
                                        @foreach ($item as $nomenclature)
                                            <option value="{{ $nomenclature->id }}"
                                                {{ $nomenclature->id == $finalSpec->item_id ? 'selected' : '' }}>
                                                {{ $nomenclature->name }}
                                            </option>
                                        @endforeach

                                    @endif
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
                                        <option value={{ $fin_year->id }}
                                            {{ $fin_year->id == $finalSpec->fin_year_id ? 'selected' : '' }}>
                                            {{ $fin_year->year }}

                                        </option>
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
                                <textarea name="remark" id="remark" class="form-control">{{ $finalSpec->remark ? $finalSpec->remark : '' }}</textarea>
                                <span id="error_remark" class="text-danger error_field"></span>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="card-body">
                    <h1 class="mb-4">Upload Document</h1>

                    <div class="file-container">
                        <div class="form-row mb-3">
                            <div class="col-md-4">
                                <input type="text" class="form-control file-name" name="file_name[]"
                                    placeholder="File Name" id="file_name_0">
                            </div>
                            <div class="col-md-6 mt-2">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input file" name="file[]" id="file_0">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <a class="btn btn-primary" id="addFile">Add More File</a>

                    </div>
                </div>

                <div class="card-footer text-end">
                    <div class="col-sm-9 offset-sm-3">
                        <a href="" type="button" class="btn btn-secondary">Cancel</a>
                        <button class="btn btn-primary" type="submit" id="form_submission_button">Update</button>
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
        let fileCount = 1;
        $("#addFile").click(function() {
            var newFileInput =
                '<div class="form-row mb-3"><div class="col-md-4"><input type="text" class="form-control file-name" name="file_name[]" placeholder="File Name" id="file_name_' +
                fileCount +
                '"></div><div class="col-md-6 mt-2"><div class="custom-file"><input type="file" class="custom-file-input file" name="file[]" id="file_' +
                fileCount + '"></div></div></div>';
            $(".file-container").append(newFileInput);

            // Increment the fileCount for the next set of inputs
            fileCount++;
        });

        $(document).ready(function() {
            $('.select2').select2();

            $('#importExcelBtn').on('click', function(event) {
                event.preventDefault();

                var url = $(this).attr('href');
                var refNo = $('#reference_no').val();
                var redirectUrl = url + '?refNo=' + encodeURIComponent(refNo);

                window.location.href = redirectUrl;
            });
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

            // $('.select2').select2();


            $('#offer_reference_no').off('change').on('change', function() {
                var offerReferenceNo = $(this).val();
                if (offerReferenceNo) {
                    $.ajax({
                        url: "{{ url('admin/final_spec/get_offer_details') }}" + '/' +
                            offerReferenceNo,
                        type: 'GET',
                        success: function(response) {

                            if (response.item) {
                                var item_html = '<option value="' + response.item.id + '">' +
                                    response.item.name + '</option>';
                                $('#item_id').html(item_html);

                            } else {
                                var item_html =
                                    '<option value="">No nomenclature found</option>';
                                $('#item_id').html(item_html);
                                error_notification('No Nomenclature Found')
                            }

                            if (response.itemType) {
                                var itemType_html = '<option value="' + response.itemType.id +
                                    '">' + response.itemType.name + '</option>';
                                $('#item_type_id').html(itemType_html);
                            } else {
                                var itemType_html =
                                    '<option value="">No item type found</option>';
                                $('#item_type_id').html(itemType_html);
                                error_notification('No Item Type Found')
                            }


                            if (response.suppliernames) {
                                var suppliers_html = "";

                                $.each(response.suppliernames, function(index, supplierName) {
                                    suppliers_html += '<option value="' + supplierName
                                        .id +
                                        '">' + supplierName.firm_name + '</option>';
                                });
                                $('#supplier_id').html(suppliers_html);
                            } else {
                                var suppliers_html =
                                    '<option value="">No Supplier Found</option>';
                                $('#supplier_id').html(suppliers_html);
                                error_notification('No Supplier Found')
                            }


                            if (response.tenderReferenceNo) {
                                $('#tender_reference_no').val(response.tenderReferenceNo
                                    .reference_no);
                            } else {
                                $('#tender_reference_no').val('');
                            }
                            if (response.indentReferenceNo) {
                                $('#indent_reference_no').val(response.indentReferenceNo
                                    .reference_no);
                            } else {
                                $('#indent_reference_no').val('');
                            }

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
