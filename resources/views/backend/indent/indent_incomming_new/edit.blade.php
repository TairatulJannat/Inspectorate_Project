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
                                <label for="sender">*Sender</label>
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
                                <label for="reference_no">*Reference No.</label>
                                <input type="text" class="form-control" id="reference_no" name="reference_no"
                                    value="{{ $indent->reference_no ? $indent->reference_no : '' }}">
                                <span id="error_reference_no" class="text-danger error_field"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="indent_reference_date">*Reference Date</label>
                                <input type="date" class="form-control" id="indent_reference_date"
                                    name="indent_reference_date"
                                    value="{{ $indent->indent_reference_date ? $indent->indent_reference_date : '' }}">
                                <span id="error_indent_reference_date" class="text-danger error_field"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="indent_number">*Indent Number</label>

                                <input type="text" class="form-control" id="indent_number" name="indent_number"
                                    value="{{ $indent->indent_number ? $indent->indent_number : '' }}">

                                <span id="error_indent_number" class="text-danger error_field"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="indent_date">*Indent Date</label>
                                <input type="date" class="form-control" id="indent_date" name="indent_date"
                                    value="{{ $indent->indent_date ? $indent->indent_date : '' }}">
                                <span id="error_indent_date" class="text-danger error_field"></span>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="indent_received_date">*Indent Received Date</label>
                                <input type="date" class="form-control" id="indent_received_date"
                                    name="indent_received_date"
                                    value="{{ $indent->indent_received_date ? $indent->indent_received_date : '' }}">
                                <span id="error_indent_received_date" class="text-danger error_field"></span>
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
                                            $isSelected = in_array(
                                                $additional_document->id,
                                                $documentIds ? $documentIds : [],
                                            )
                                                ? 'selected'
                                                : '';
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
                                <label for="item_type_id">*Item Type</label>
                                <select class="form-control" id="item_type_id" name="item_type_id">

                                    <option value="">Please Select</option>

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
                                <label for="item_id">*Nomenclature</label>

                                <select class="form-control select2" id="item_id" name="item_id">
                                    <option value="">Please Select</option>
                                    @if ($item)
                                        <option value="{{ $item->id }}" selected>{{ $item->name }}</option>
                                    @endif
                                </select>

                                <span id="loading-message" class="text-danger error_field"></span>
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
                                <label for="fin_year_id">*Financial Year </label>
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
    @include('backend.indent.indent_incomming_new.index_js')
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
            var newFileInput =
                '<div class="form-row mb-3"><div class="col-md-4"><input type="text" class="form-control file-name" name="file_name[]" placeholder="File Name" id="file_name_' +
                fileCount +
                '"></div><div class="col-md-6 mt-2"><div class="custom-file"><input type="file" class="custom-file-input file" name="file[]" id="file_' +
                fileCount + '"></div></div></div>';
            $(".file-container").append(newFileInput);

            // Increment the fileCount for the next set of inputs
            fileCount++;
        });
    </script>
    <script>
        $(document).ready(function() {

            $('.select2').select2();


            $("#item_type_id").off('change').on('change', function() {


                $('#loading-message').text('Please wait nomenclature loading...');

                var itemtype_id = $('#item_type_id').val();

                if (itemtype_id > 0) {
                    $.ajax({
                        url: "{{ url('admin/prelimgeneral/item_name') }}" +
                            '/' + itemtype_id,
                        type: 'GET',
                        dataType: 'json',
                        success: function(res) {

                            $('#loading-message').text('Nomenclature loaded successfully');

                            var _html = '<option value="">Select an item</option>';
                            $.each(res, function(index, item) {
                                _html += '<option value="' + item.id + '">' + item
                                    .name + '</option>';
                            });
                            $('#item_id').html(_html);

                            setTimeout(function() {
                                $('#loading-message').text('');
                            }, 3000);
                        }
                    });
                }
            });
        });
    </script>
@endpush
