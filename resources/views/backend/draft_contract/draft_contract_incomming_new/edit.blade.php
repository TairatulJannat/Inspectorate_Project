@extends('backend.app')
@section('title', 'Draft Contract (Edit)')
@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend/css/datatables.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend/css/select2.css') }}">
@endpush
@section('main_menu', 'Draft Contract')
@section('active_menu', 'Edit')
@section('content')
    <div class="col-sm-12 col-xl-12">
        <div class="card">
            <div class=" header">

                <div class="col-md-2">
                    <div class="form-group">
                        <form action="{{ url('admin/import-draft-contract-spec-data-index') }}" method="POST">
                            @csrf
                            <input type="hidden" value="{{ $draft_contract->reference_no }}" id="dcRefNo" name="dcRefNo">
                            <input type="hidden" value="{{ $draft_contract->final_spec_reference_no }}" id="fsRefNo"
                                name="fsRefNo">
                            <input type="hidden" value="{{ $draft_contract->offer_reference_no }}" id="DcRefNo"
                                name="offerRefNo">
                            <input type="hidden" value="{{ $draft_contract->indent_reference_no }}" id="DcRefNo"
                                name="indentRefNo">
                            <input type="hidden" value="{{ $draft_contract->item_id }}" id="itemId" name="itemId">
                            <input type="hidden" value="{{ $draft_contract->item_type_id }}" id="itemTypeId"
                                name="itemTypeId">
                            <input type="hidden" value="{{ $draft_contract->supplier_id }}" id="supplierId"
                                name="supplierId">
                            <button class="btn btn-success ms-4 mt-3" type="submit">Import Excel</button>
                        </form>
                    </div>
                </div>
            </div>
            <form action="" id="update_form" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">

                    <div class="row mt-4">

                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="hidden" value=" {{ $draft_contract->id }}" id="editId" name="editId">
                                <label for="sender">Sender</label>
                                <select class="form-control " id="sender" name="sender">

                                    <option value="">Please Select</option>

                                    @foreach ($dte_managments as $dte)
                                        <option value="{{ $dte->id }}"
                                            {{ $dte->id == $draft_contract->sender_id ? 'selected' : '' }}>
                                            {{ $dte->name }}
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
                                    value="{{ $draft_contract->reference_no ? $draft_contract->reference_no : '' }}">
                                <span id="error_reference_no" class="text-danger error_field"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="reference_date">Draft Contract Reference Date</label>
                                <input type="date" class="form-control" id="reference_date" name="reference_date"
                                    value="{{ $draft_contract->reference_date ? $draft_contract->reference_date : '' }}">
                                <span id="error_reference_date" class="text-danger error_field"></span>
                            </div>
                        </div>





                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="draft_contract_no">Draft Contract Number</label>
                                <input type="text" class="form-control" id="draft_contract_no" name="draft_contract_no"
                                    value="{{ $draft_contract->draft_contract_no ? $draft_contract->draft_contract_no : '' }}">
                                <span id="error_draft_contract_no" class="text-danger error_field"></span>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="draft_contract_date">Draft Contract Date</label>
                                <input type="date" class="form-control" id="draft_contract_date"
                                    name="draft_contract_date"
                                    value="{{ $draft_contract->draft_contract_date ? $draft_contract->draft_contract_date : '' }}">
                                <span id="error_draft_contract_date" class="text-danger error_field"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="draft_contract_received_date">Draft Contract Received Date</label>
                                <input type="date" class="form-control" id="draft_contract_received_date"
                                    name="draft_contract_received_date"
                                    value="{{ $draft_contract->received_date ? $draft_contract->received_date : '' }}">
                                <span id="error_draft_contract_received_date" class="text-danger error_field"></span>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="final_spec_reference_no">Final Spec Reference No.</label>
                                <select name="final_spec_reference_no" id="final_spec_reference_no"
                                    class="form-control select2">
                                    <option value="">Please Select</option>
                                    @foreach ($finalSpecs as $finalSpec)
                                        <option value="{{ $finalSpec->reference_no }}"
                                            {{ $finalSpec->reference_no == $draft_contract->final_spec_reference_no ? 'selected' : '' }}>
                                            {{ $finalSpec->reference_no }}
                                        </option>
                                    @endforeach
                                </select>
                                <span id="error_contract_reference_no" class="text-danger error_field"></span>
                            </div>
                        </div>


                        <div class="col-md-4 d-none">
                            <div class="form-group">
                                <label for="indent_reference_no">Indent Reference No</label>

                                <input type="text" id="indent_reference_no" class="form-control"
                                    name="indent_reference_no"
                                    value="{{ $draft_contract->indent_reference_no ? $draft_contract->indent_reference_no : '' }}">

                                <span id="error_indent_reference_no" class="text-danger error_field"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="offer_reference_no">Offer Reference No</label>
                                <input type="text" id="offer_reference_no" class="form-control"
                                    name="offer_reference_no"
                                    value="{{ $draft_contract->offer_reference_no ? $draft_contract->offer_reference_no : '' }}">

                                <span id="error_offer_reference_no" class="text-danger error_field"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="item_type_id">Item Type</label>
                                <select class="form-control" id="item_type_id" name="item_type_id">

                                    <option selected disabled value="">Please Select</option>
                                    @if ($item)
                                        @foreach ($item_types as $i_type)
                                            <option value="{{ $i_type->id }}"
                                                {{ $i_type->id == $draft_contract->item_type_id ? 'selected' : '' }}>
                                                {{ $i_type->name }}</option>
                                        @endforeach

                                    @endif
                                </select>
                                <span id="error_item_type_id" class="text-danger error_field"></span>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="item_id">Nomenclature</label>

                                <select class="form-control select2" id="item_id" name="item_id">
                                    <option value="">Please Select</option>
                                    @if ($item)
                                        @foreach ($item as $i)
                                            <option value="{{ $i->id }}"
                                                {{ $i->id == $draft_contract->item_id ? 'selected' : '' }}>
                                                {{ $i->name }}</option>
                                        @endforeach

                                    @endif
                                </select>

                                <span id="error_item_id" class="text-danger error_field"></span>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="supplier_id">Supplier</label>

                                <select class="form-control " id="supplier_id" name="supplier_id">
                                    <option value="">Please Select</option>
                                    @if ($supplier)
                                        @foreach ($supplier as $s)
                                            <option value="{{ $s->id }}"
                                                {{ $s->id == $draft_contract->supplier_id ? 'selected' : '' }}>
                                                {{ $s->firm_name }}</option>
                                        @endforeach

                                    @endif

                                </select>
                                <span id="error_supplier_id" class="text-danger error_field"></span>
                            </div>
                        </div>


                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="fin_year_id">Financial Year </label>

                                <select class="form-control" id="fin_year_id" name="fin_year_id">

                                    <option value="">Please Select Year </option>
                                    @foreach ($fin_years as $fin_year)
                                        <option value={{ $fin_year->id }}
                                            {{ $fin_year->id == $draft_contract->fin_year_id ? 'selected' : '' }}>
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
                                <textarea name="remark" id="remark" class="form-control"> {{ $draft_contract->remarks ? $draft_contract->remarks : '' }}</textarea>
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
                        <a href="{{ route('admin.draft_contract/view') }}" type="button"
                            class="btn btn-secondary">Cancel</a>
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
                url: "{{ url('admin/draft_contract/update') }}",
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
                    setTimeout(window.location.href = "{{ route('admin.draft_contract/view') }}",
                        40000);
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
        $('#final_spec_reference_no').off('change').on('change', function() {
            var FinalSpecReferenceNo = $(this).val();
            if (FinalSpecReferenceNo) {
                $.ajax({
                    url: "{{ url('admin/draft_contract/get_final_spec_details') }}" + '/' +
                        FinalSpecReferenceNo,
                    type: 'GET',
                    success: function(response) {

                        if (response.item) {
                            var item_html = '<option value="' + response.item.id + '">' +
                                response.item.name + '</option>';
                            $('#error_item_id').html('')
                        } else {
                            var item_html = ''
                            $('#error_item_id').html('Item Not Found')
                        }

                        if (response.itemType) {
                            var itemType_html = '<option value="' + response.itemType.id +
                                '">' + response.itemType.name + '</option>';
                            $('#error_item_type_id').html('')
                        } else {
                            var itemType_html = ''
                            $('#error_item_type_id').html('Item Type Not Found')
                        }

                        if (response.supplier) {
                            var supplier_html = '<option value="' + response.supplier.id +
                                '">' + response.supplier.firm_name + '</option>';
                            $('#error_supplier_id').html('')
                        } else {
                            var supplier_html = ''
                            $('#error_supplier_id').html('Supplier Not Found')
                        }

                        if (response.finalSpec.indent_reference_no) {
                            var indent_html = response.finalSpec.indent_reference_no;
                            $('#error_indent_reference_no').html('')
                        } else {
                            var indent_html = ''
                            $('#error_indent_reference_no').html(
                                'Indent Reference Id Not Found')
                        }

                        if (response.finalSpec.offer_reference_no) {

                            var offer_html = response.finalSpec.offer_reference_no;
                            $('#error_offer_reference_no').html('')
                        } else {
                            var offer_html = ''
                            $('#error_offer_reference_no').html(
                                'Offer Reference no Not Found')
                        }

                        $('#item_id').html(item_html);
                        $('#item_type_id').html(itemType_html);
                        $('#supplier_id').html(supplier_html);
                        $('#indent_reference_no').val(indent_html);
                        $('#offer_reference_no').val(offer_html);

                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            }
        });
    </script>
@endpush
