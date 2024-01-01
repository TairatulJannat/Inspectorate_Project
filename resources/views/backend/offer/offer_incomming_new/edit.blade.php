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
                <div  class=" header">
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
                            <a href="{{url('admin/import-supplier-spec-data-index')}}" class="btn btn-success">Supplier Import Excel</a>
                        </div>
                    </div>
                </div>
                <div class="row">

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="sender">Sender</label>
                            <input type="hidden" value=" {{$offer->id}}" id="editId" name="editId">
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
                                    value="{{ $offer->reference_no ? $offer->reference_no : '' }} ">
                            <span id="error_reference_no" class="text-danger error_field"></span>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="tender_reference_no">Tender Reference Number</label>
                            <select class="form-control " id="tender_reference_no" name="tender_reference_no">

                                <option value="">Please Select</option>

                                @foreach ($tender_reference_numbers as $tender_reference_no)
                                    <option value="{{ $tender_reference_no->id }}" 
                                        {{ $tender_reference_no->id == $offer->tender_reference_no ? 'selected' : '' }}>{{ $tender_reference_no->reference_no }}</option>

                                @endforeach
 
                            </select>
                            <span id="error_tender_reference_no" class="text-danger error_field"></span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="indent_reference_no">Indent Reference Number</label>
                            <select class="form-control " id="indent_reference_no" name="indent_reference_no">

                                <option value="">Please Select</option>

                                @foreach ($indent_reference_numbers as $indent_reference_no)
                                    <option value="{{ $indent_reference_no->id }}"
                                    {{ $indent_reference_no->id == $offer->indent_reference_no ? 'selected' : '' }}>{{ $indent_reference_no->reference_no }}</option>

                                @endforeach

                            </select>
                            <span id="error_indent_reference_no" class="text-danger error_field"></span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="offer_reference_date">Offer Reference Date</label>
                            <input type="date" class="form-control" id="offer_reference_date" name="offer_reference_date" value="{{ $offer->offer_reference_date ?$offer->offer_reference_date : '' }}">
                            <span id="offer_reference_date" class="text-danger error_field"></span>
                        </div>
                    </div>

                     <div class="col-md-4">
                        <div class="form-group">

                            <label for="additional_documents">Additional Documents</label>
                            <select class="form-control select2" id="additional_documents" name="additional_documents[]"
                                multiple>
                                <option value="">Please Select</option>
                                @foreach ($additional_documnets as $additional_document)
                                    <option value="{{ $additional_document->id }}">{{ $additional_document->name }}
                                    </option>
                                @endforeach

                            </select>
                            <span id="error_additional_documents" class="text-danger error_field"></span>
                        </div>
                    </div> 

                    <div class="col-md-4">
                        <div class="form-group">

                            <label for="supplier_id">Suppiler</label>
                           
                            <select class="form-control select2" id="supplier_id" name="supplier_id[]"
                                multiple>
                                <option value="">Please Select</option>
                                @foreach ($suppliers as $supplier)
                                <option value="{{ $supplier->id }}">{{ $supplier->firm_name }}</option>
                                @endforeach

                            </select>
                            <span id="error_supplier_id" class="text-danger error_field"></span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="offer_rcv_ltr_no">Offer Receive Letter No</label>
                            <input type="text" class="form-control" id="offer_rcv_ltr_no"
                                name="offer_rcv_ltr_no">
                            <span id="error_offer_rcv_ltr_no" class="text-danger error_field"></span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="offer_rcv_ltr_dt">Offer Receive Letter Date</label>
                            <input type="date" class="form-control" id="offer_rcv_ltr_dt"
                                name="offer_rcv_ltr_dt">
                            <span id="error_offer_rcv_ltr_dt" class="text-danger error_field"></span>
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
                            <label for="qty">Item Qty</label>
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
                            <textarea name="remark" id="remark" class="form-control"></textarea>
                            <span id="error_remark" class="text-danger error_field"></span>
                        </div>
                    </div>



                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="pdf_file" style="color: yellow"><button type="button" class="btn btn-warning">Upload PDF</b></button></label><br>
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
    <script>
        $(document).ready(function() {
            $('.select2').select2();
        });
        // Start:: Get Floor & User category & shift
        $('#hall_id').off('change').on('change', function() {
            var hall_id = $('#hall_id').val();
            $('#floor_id').html('');
            $('#user_category_id').html('');
            $('#shift_id').html(`
            <option value="">Please Select Shift</option>
        `);
            $.ajax({
                url: "{{ url('admin/hall/get_floor') }}",
                type: "POST",
                data: {
                    hall_id: hall_id,
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                success: function(response) {
                    response.data.forEach(function(item) {
                        $('#floor_id').append(`
                        <option value="${item.id ? item.id : ''}">
                            ${item.name ? item.name : ''}
                        </option>
                    `);
                    });
                }
            });

            $.ajax({
                url: "{{ url('admin/hall/get_user_category') }}",
                type: "POST",
                data: {
                    hall_id: hall_id,
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                success: function(response) {
                    response.data.forEach(function(item) {
                        $('#user_category_id').append(`
                    <option value="${item.id ? item.id : ''}">
                        ${item.name ? item.name : ''}
                    </option>
                `);
                    });
                }
            });

            $.ajax({
                url: "{{ url('admin/hall/get_shift') }}",
                type: "POST",
                data: {
                    hall_id: hall_id,
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                success: function(response) {
                    response.data.forEach(function(item) {
                        $('#shift_id').append(`
                    <option value="${item.id ? item.id : ''}">
                        ${item.name ? item.name : ''}
                    </option>
                `);
                    });
                }
            });
        })
        // End:: Get Floor & User category & shift

        $('#specify_event').off('change').on('change', function() {
            if ($(this).prop('checked')) {
                $('.event-name-container').show();
            } else {
                $('.event-name-container').hide();
            }
        })

        $('#specify_month').off('change').on('change', function() {
            if ($(this).prop('checked')) {
                $('.months-container').show();
            } else {
                $('.months-container').hide();
            }
        })

        // $('#specify_shift_charge').off('change').on('change', function() {
        //     if ($(this).prop('checked')) {
        //         $('.shift-container').show();
        //     } else {
        //         $('.shift-container').hide();
        //     }
        // })
    </script>
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
                    setTimeout(window.location.href = "{{ route('admin.indent/view') }}", 40000);
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
        //End:: Update information

        // Start:: delete user
        // function delete_data(id) {
        //     swal({
        //         title: 'Are you sure?',
        //         text: "You won't be able to revert this!",
        //         type: 'warning',
        //         showCancelButton: true,
        //         confirmButtonColor: '#3085d6',
        //         cancelButtonColor: '#d33',
        //         confirmButtonText: 'Yes, delete it!',
        //         cancelButtonText: 'No, cancel!',
        //         confirmButtonClass: 'btn btn-success',
        //         cancelButtonClass: 'btn btn-danger',
        //         buttonsStyling: false,
        //         reverseButtons: true
        //     }).then((result) => {
        //         if (result.value) {
        //             event.preventDefault();
        //             $.ajax({
        //                 type: 'get',
        //                 url: '{{ url('admin/hall_price/delete') }}/' + id,
        //                 success: function(response) {
        //                     if (response) {
        //                         if (response.permission == false) {
        //                             toastr.warning('you dont have that Permission',
        //                                 'Permission Denied');
        //                         } else {
        //                             toastr.success('Deleted Successful', 'Deleted');
        //                             $('.yajra-datatable').DataTable().ajax.reload(null, false);
        //                         }
        //                     }
        //                 }
        //             });
        //         } else if (
        //             result.dismiss === swal.DismissReason.cancel
        //         ) {
        //             swal(
        //                 'Cancelled',
        //                 'Your data is safe :)',
        //                 'error'
        //             )
        //         }
        //     })
        // }
        // End:: delete user

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
