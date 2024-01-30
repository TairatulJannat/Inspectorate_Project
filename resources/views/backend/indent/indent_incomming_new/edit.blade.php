@extends('backend.app')
@section('title', 'Indent (Edit)')
@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend/css/datatables.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend/css/select2.css') }}">
@endpush
@section('main_menu', 'Indent')
@section('active_menu', 'Edit')
@section('content')
    <div class="col-sm-12 col-xl-12">
        <div class="card">
            <form action="" id="update_form" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class=" header">

                        <div class="col-md-2">
                            <div class="form-group">
                                <a id="importExcelBtn" href="{{ url('admin/import-indent-spec-data-index') }}"
                                    class="btn btn-success">Import Indent Spec</a>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4">

                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="hidden" value=" {{ $indent->id }}" id="editId" name="editId">
                                <label for="sender">Sender</label>
                                <select class="form-control " id="sender" name="sender">

                                    <option value="">Please Select</option>

                                    @foreach ($dte_managments as $dte)
                                        <option value="{{ $dte->id }}"
                                            {{ $dte->id == $indent->sender ? 'selected' : '' }}>{{ $dte->name }}
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
                                    value="{{ $indent->reference_no ? $indent->reference_no : '' }}">
                                <span id="error_reference_no" class="text-danger error_field"></span>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="indent_number">Indent Number</label>

                                <input type="text" class="form-control" id="indent_number" name="indent_number"
                                    value="{{ $indent->indent_number ? $indent->indent_number : '' }}">

                                <span id="error_indent_number" class="text-danger error_field"></span>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="indent_received_date">Indent Received Date</label>
                                <input type="date" class="form-control" id="indent_received_date"
                                    name="indent_received_date"
                                    value="{{ $indent->indent_received_date ? $indent->indent_received_date : '' }}">
                                <span id="error_indent_received_date" class="text-danger error_field"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="indent_reference_date">Indent Reference Date</label>
                                <input type="date" class="form-control" id="indent_reference_date"
                                    name="indent_reference_date"
                                    value="{{ $indent->indent_reference_date ? $indent->indent_reference_date : '' }}">
                                <span id="error_indent_reference_date" class="text-danger error_field"></span>
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
                                            $documentIds = json_decode($indent->additional_documents);
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
                                <label for="item_type_id">Item Type</label>
                                <select class="form-control" id="item_type_id" name="item_type_id">

                                    <option selected disabled value="">Please Select</option>

                                    @foreach ($item_types as $item_type)
                                        <option value="{{ $item_type->id }}"
                                            {{ $item_type->id == $indent->item_type_id ? 'selected' : '' }}>
                                            {{ $item_type->name }}
                                        </option>
                                    @endforeach

                                </select>
                                <span id="error_item_type_id" class="text-danger error_field"></span>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="item_id">Item</label>

                                <select class="form-control select2" id="item_id" name="item_id">
                                    <option value="">Please Select</option>
                                    @if ($item)
                                        <option value="{{ $item->id }}" selected>{{ $item->name }}</option>
                                    @endif
                                </select>


                                <span id="error_item_id" class="text-danger error_field"></span>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="qty">Item QTY</label>
                                <input type="text" class="form-control" id="qty" name="qty"
                                    value="{{ $indent->qty ? $indent->qty : '' }}">

                                <span id="error_qty" class="text-danger error_field"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="attribute">Attribute</label>

                                <select class="form-control" name="attribute" id="attribute">
                                    <option value="">Please Select</option>
                                    <option value="Controlled" {{ $indent->attribute == 'Controlled' ? 'selected' : '' }}>
                                        Controlled</option>
                                    <option value="Uncontrolled"
                                        {{ $indent->attribute == 'Uncontrolled' ? 'selected' : '' }}>Uncontrolled</option>
                                </select>

                                <span id="error_attribute" class="text-danger error_field"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="estimated_value">Estimated Value</label>
                                <input type="text" class="form-control" id="estimated_value" name="estimated_value"
                                    value="{{ $indent->estimated_value ? $indent->estimated_value : '' }}">

                                <span id="error_estimated_value" class="text-danger error_field"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="spare">Spare</label>
                                <input type="text" class="form-control" id="spare" name="spare"
                                    value="{{ $indent->spare ? $indent->spare : '' }}">

                                <span id="error_spare" class="text-danger error_field"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="checked_standard">Standard / Non Standard </label>
                                <select class="form-control" name="checked_standard" id="checked_standard">
                                    <option value="">Please Select</option>
                                    <option value="0" {{ $indent->checked_standard == '0' ? 'selected' : '' }}>
                                        Standard
                                    </option>
                                    <option value="1" {{ $indent->checked_standard == '1' ? 'selected' : '' }}>Non
                                        Standard</option>
                                </select>
                                {{-- <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="checked_standard"
                                        name="checked_standard">
                                </div> --}}

                                <span id="error_checked_standard" class="text-danger error_field"></span>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="fin_year_id">Financial Year </label>
                                <select class="form-control" id="fin_year_id" name="fin_year_id">
                                    <option value="">Please Select Year </option>
                                    @foreach ($fin_years as $fin_year)
                                        <option value={{ $fin_year->id }}
                                            {{ $fin_year->id == $indent->fin_year_id ? 'selected' : '' }}>
                                            {{ $fin_year->year }}
                                        </option>
                                    @endforeach
                                </select>
                                <span id="error_fin_year_id" class="text-danger error_field"></span>
                            </div>
                        </div>
                        {{-- <div class="col-md-4">
                            <div class="form-group">
                                <label for="nomenclature">Nomenclature</label>
                                <input type="text" class="form-control" id="nomenclature" name="nomenclature"
                                    value="{{ $indent->nomenclature ? $indent->nomenclature : '' }}">

                                <span id="error_nomenclature" class="text-danger error_field"></span>
                            </div>

                        </div>


                        </div> --}}
                        {{-- <div class="col-md-4">
                            <div class="form-group">
                                <label for="make">Make</label>
                                <input type="text" class="form-control" id="make" name="make">
                                <span id="error_make" class="text-danger error_field"></span>
                            </div>
                        </div> --}}

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="model">Model</label>
                                <input type="text" class="form-control" id="model" name="model"
                                    value="{{ $indent->model ? $indent->model : '' }}">
                                <span id="error_model" class="text-danger error_field"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="country_of_origin">Country of Origin</label>

                                <input type="text" class="form-control" id="country_of_origin"
                                    name="country_of_origin"
                                    value="{{ $indent->country_of_origin ? $indent->country_of_origin : '' }}">
                                <span id="error_country_of_origin" class="text-danger error_field"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="country_of_assembly">Country of Assembly</label>
                                <input type="text" class="form-control" id="country_of_assembly"
                                    name="country_of_assembly"
                                    value="{{ $indent->country_of_assembly ? $indent->country_of_assembly : '' }}">
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
                                <textarea name="remark" id="remark" class="form-control"> {{ $indent->remark ? $indent->remark : '' }}</textarea>
                                <span id="error_remark" class="text-danger error_field"></span>
                            </div>
                        </div>

                    </div>
                </div>
                <div  class="card-body">
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
                        <a href="{{ route('admin.indent/view') }}" type="button" class="btn btn-secondary">Cancel</a>
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
        $(document).ready(function() {
            $('.select2').select2();

            const urlParams = new URLSearchParams(window.location.search);
            const errorMessage = urlParams.get('error');

            if (errorMessage) {
                toastr.error(decodeURIComponent(errorMessage));

                const currentUrl = window.location.href;
                const cleanUrl = currentUrl.split('?')[0];
                history.replaceState({}, document.title, cleanUrl);
            }

            $('#importExcelBtn').on('click', function(event) {
                event.preventDefault();

                var url = $(this).attr('href');
                var indentNo = $('#indent_number').val();
                var redirectUrl = url + '?indentNo=' + encodeURIComponent(indentNo);

                window.location.href = redirectUrl;
            });
        });
        let fileCount = 1;

        $("#addFile").click(function() {
            var newFileInput = '<div class="form-row mb-3"><div class="col-md-4"><input type="text" class="form-control file-name" name="file_name[]" placeholder="File Name" id="file_name_' + fileCount + '"></div><div class="col-md-6 mt-2"><div class="custom-file"><input type="file" class="custom-file-input file" name="file[]" id="file_' + fileCount + '"></div></div></div>';
            $(".file-container").append(newFileInput);

            // Increment the fileCount for the next set of inputs
            fileCount++;
        });

        //Start:: Update information
        $('#update_form').off().on('submit', function(event) {
            event.preventDefault();
            var formData = new FormData($('#update_form')[0]);
            disableButton()
            $.ajax({
                url: "{{ url('admin/indent/update') }}",
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
