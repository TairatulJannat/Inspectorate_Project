@extends('backend.app')
@section('title', 'si (Edit)')
@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend/css/datatables.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend/css/select2.css') }}">
@endpush
@section('main_menu', 'si')
@section('active_menu', 'Edit')
@section('content')
    <div class="col-sm-12 col-xl-12">
        <div class="card">
            <form action="" id="update_form" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    {{-- <div class=" header">

                        <div class="col-md-2">
                            <div class="form-group">
                                <a href="{{ url('admin/import-indent-spec-data-index') }}" class="btn btn-success">Import
                                    Excel</a>
                            </div>
                        </div>
                    </div> --}}
                    <div class="row mt-4">

                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="hidden" value=" {{ $si->id }}" id="editId" name="editId">
                                <label for="sender">Sender</label>
                                <select class="form-control " id="sender" name="sender">

                                    <option value="">Please Select</option>

                                    @foreach ($dte_managments as $dte)
                                        <option value="{{ $dte->id }}"
                                            {{ $dte->id == $si->sender_id ? 'selected' : '' }}>{{ $dte->name }}
                                        </option>
                                    @endforeach

                                </select>
                                <span id="error_sender" class="text-danger error_field"></span>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="reference_no">Si Reference No.</label>
                                <input type="text" class="form-control" id="reference_no" name="reference_no"
                                    value="{{ $si->reference_no ? $si->reference_no : '' }} ">
                                <span id="error_reference_no" class="text-danger error_field"></span>
                            </div>
                        </div>



                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="received_date">Si Received Date</label>
                                <input type="date" class="form-control" id="received_date" name="received_date"
                                    value="{{ $si->received_date ? $si->received_date : '' }}">
                                <span id="error_received_date" class="text-danger error_field"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="reference_date">Si Reference Date</label>
                                <input type="date" class="form-control" id="reference_date" name="reference_date"
                                    value="{{ $si->reference_date ? $si->reference_date : '' }}">
                                <span id="error_reference_date" class="text-danger error_field"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">

                                <label for="contract_reference_no">Contract Reference No.</label>
                                <select class="form-control " id="contract_reference_no" name="contract_reference_no">

                                    <option value="">Please Select</option>

                                    @foreach ($contracts as $contract)
                                        <option value="{{ $contract->reference_no }}"
                                            {{ $contract->reference_no == $si->contract_reference_no ? 'selected' : '' }}>
                                            {{ $contract->reference_no }}</option>
                                    @endforeach

                                </select>
                                <span id="error_contract_reference_no" class="text-danger error_field"></span>

                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="item_type_id">Item Type</label>
                                <select class="form-control" id="item_type_id" name="item_type_id" required>

                                    <option selected disabled value="{{ $itemTypeName ? $itemTypeName : '' }}">Please
                                        Select</option>


                                </select>
                                <span id="error_item_type_id" class="text-danger error_field"></span>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="item_id">Item</label>

                                <select class="form-control" id="item_id" name="item_id" required>
                                    <option value="{{ $itemName ? $itemName : '' }}">Please Select</option>

                                </select>


                                <span id="error_item_id" class="text-danger error_field"></span>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="offer_reference_no">Offer Reference Number</label>
                                {{-- <select class="form-control " id="offer_reference_no" name="offer_reference_no">

                                    <option value="">Please Select</option>

                                </select> --}}

                                <input type="text" id="offer_reference_no" class="form-control" name="offer_reference_no"
                                    value="{{ $si->offer_reference_no ? $si->offer_reference_no : '' }}">

                                <span id="error_tender_reference_no" class="text-danger error_field"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="indent_reference_no">Indent Reference Number</label>
                                {{-- <select class="form-control " id="indent_reference_no" name="indent_reference_no">
                                    <option value="">Please Select</option>
                                </select> --}}

                                <input type="text" id="indent_reference_no" class="form-control"
                                    name="indent_reference_no"
                                    value="{{ $si->indent_reference_no ? $si->indent_reference_no : '' }}">
                                <span id="error_indent_reference_no" class="text-danger error_field"></span>
                            </div>

                        </div>

                        <div class="col-md-4">
                            <div class="form-group">

                                <label for="supplier_id">Suppiler</label>

                                <select class="form-control" id="supplier_id" name="supplier_id">
                                    @if ($supplier)
                                    <option value="{{ $supplier->id == $si->supplier_id ? $supplier->id : '' }}">{{$supplier->firm_name}} </option>
                                    @endif


                                </select>
                                {{-- <input type="text" id="supplier_id" class="form-control" name="supplier_id"
                                    value="{{ $si->supplier_id ? $si->supplier_id : '' }}"> --}}

                                <span id="error_supplier_id" class="text-danger error_field"></span>
                            </div>
                        </div>


                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="fin_year_id">Financial Year </label>

                                <select class="form-control" id="fin_year_id" name="fin_year_id" required>

                                    <option value="">Please Select Year </option>
                                    @foreach ($fin_years as $fin_year)
                                        <option value={{ $fin_year->id }}
                                            {{ $fin_year->id == $si->fin_year_id ? 'selected' : '' }}>
                                            {{ $fin_year->year }}
                                        </option>
                                    @endforeach

                                </select>

                                <span id="error_item_id" class="text-danger error_field"></span>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="checked_standard">Provationally status </label>
                                <select class="form-control" name="provationally_status" id="provationally_status">
                                    <option value="">Please Select</option>
                                    <option value="0">
                                        Provationally Accepted
                                    </option>
                                    <option value="1">Provationally Rejected</option>
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
                                <label for="received_by">Received By</label>
                                <input type="text" value="{{ \Illuminate\Support\Facades\Auth::user()->name }}"
                                    readonly class="form-control" id="received_by" name="received_by">
                                <span id="error_received_by" class="text-danger error_field"></span>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="remark">Remark</label>
                                <textarea name="remark" id="remark" class="form-control"> {{ $si->remarks ? $si->remarks : '' }}</textarea>
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
                        <a href="{{ route('admin.si/view') }}" type="button" class="btn btn-secondary">Cancel</a>
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
        });

        //Start:: Update information
        $('#update_form').off().on('submit', function(event) {
            event.preventDefault();
            var formData = new FormData($('#update_form')[0]);
            disableButton()
            $.ajax({
                url: "{{ url('admin/si/update') }}",
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
                    setTimeout(window.location.href = "{{ route('admin.si/view') }}", 40000);
                },
                error: function(response) {
                    enableeButton()
                    clear_error_field();
                    error_notification('Please fill up the form correctly and try again')
                    $('#error_contract_reference_no').text(response.responseJSON.error);
                }
            });
        })
        //End:: Update information



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


            $('#contract_reference_no').off('change').on('change', function() {
                var contractReferenceNo = $(this).val();
                if (contractReferenceNo) {
                    $.ajax({
                        url: "{{ url('admin/si/get_contract_details') }}" + '/' +
                            contractReferenceNo,
                        type: 'GET',
                        success: function(response) {
                            var item_html = '<option value="' + response.item.id + '">' +
                                response.item.name + '</option>';
                            var itemType_html = '<option value="' + response.itemType.id +
                                '">' + response.itemType.name + '</option>';
                            // var offerReferenceNo_html = '<option value="' + response
                            //     .offerReferenceNo + '">' + response
                            //     .offerReferenceNo +
                            //     '</option>';
                            // var indentReferenceNo_html = '<option value="' + response
                            //     .indentReferenceNo + '">' + response.indentReferenceNo +
                            //     '</option>';
                            var supplier_html = '<option value="' + response.supplier.id +
                                '">' + response.supplier.firm_name + '</option>';


                            $('#item_id').html(item_html);
                            $('#item_type_id').html(itemType_html);
                            $('#offer_reference_no').val(response
                                .offerReferenceNo);
                            $('#indent_reference_no').val(response
                                .indentReferenceNo);
                            $('#supplier_id').html(supplier_html);


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
