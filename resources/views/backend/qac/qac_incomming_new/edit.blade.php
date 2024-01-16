@extends('backend.app')
@section('title', 'Qac (Edit)')
@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend/css/datatables.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend/css/select2.css') }}">
@endpush
@section('main_menu', 'Qac')
@section('active_menu', 'Edit')
@section('content')
    <div class="col-sm-12 col-xl-12">
        <div class="card">
            <form action="" id="update_form" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">

                    <div class=" header">
                        {{-- <div class="col-md-3">
                            <div class="form-group d-flex">
                                <label class="col-6 pt-2" for="">Select Section:</label>
                                <select class="form-control" id="admin_section" name="admin_section">
                                    @foreach ($sections as $section)
                                        <option value="{{ $section->id }}">{{ $section->name }}</option>
                                    @endforeach

                                </select>
                                <span id="error_admin_section" class="text-danger error_field"></span>
                            </div>
                        </div> --}}
                        {{-- <div class="col-md-2">
                            <div class="form-group">
                                <a href="{{ url('admin/import-indent-spec-data-index') }}" class="btn btn-success">Import
                                    Indent Spec</a>
                            </div>
                        </div> --}}
                    </div>

                    <div class="row mt-4">

                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="hidden" value=" {{ $qac->id }}" id="editId" name="editId">
                                <label for="sender">Sender</label>
                                <select class="form-control " id="sender" name="sender">

                                    <option value="">Please Select</option>

                                    @foreach ($dte_managments as $dte)
                                        <option value="{{ $dte->id }}"
                                            {{ $dte->id == $qac->sender_id ? 'selected' : '' }}>{{ $dte->name }}
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
                                    value="{{ $qac->reference_no ? $qac->reference_no : '' }} ">
                                <span id="error_reference_no" class="text-danger error_field"></span>
                            </div>
                        </div>



                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="qac_received_date">Qac Received Date</label>
                                <input type="date" class="form-control" id="qac_received_date" name="qac_received_date"
                                    value="{{ $qac->received_date ? $qac->received_date : '' }}">
                                <span id="error_qac_received_date" class="text-danger error_field"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="qac_reference_date">Qac Reference Date</label>
                                <input type="date" class="form-control" id="qac_reference_date" name="qac_reference_date"
                                    value="{{ $qac->reference_date ? $qac->reference_date : '' }}">
                                <span id="error_qac_reference_date" class="text-danger error_field"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="contract_reference_no">Contract Reference No.</label>

                                @foreach ($contracts as $contract)
                                    <select class="form-control select2" id="contract_reference_no"
                                        name="contract_reference_no">
                                        <option value="">Select a Contract No</option>
                                        <option value="{{ $contract->reference_no }}"
                                            {{ $contract->reference_no == $qac->contract_reference_no ? 'selected' : '' }}>
                                            {{ $contract->reference_no }}
                                        </option>
                                    </select>
                                @endforeach

                                <span id="error_contract_reference_no" class="text-danger error_field"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="indent_reference_no">Indent Reference No.</label>

                                <input type="text" class="form-control" id="indent_reference_no"
                                    name="indent_reference_no"
                                    value="{{ $qac->indent_reference_no ? $qac->contract_reference_no : '' }} ">
                                <span id="error_indent_reference_no" class="text-danger error_field"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="offer_reference_no">Offer Reference No.</label>

                                <input type="text" class="form-control" id="offer_reference_no" name="offer_reference_no"
                                    value="{{ $qac->offer_reference_no ? $qac->offer_reference_no : '' }} ">
                                <span id="error_offer_reference_no" class="text-danger error_field"></span>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="supplier_id">Supplier</label>
                                <select name="supplier_id" id="supplier_id" class="form-control">
                                    <option value="">Selete Supplier</option>
                                    @if ($supplier)
                                        <option value="{{ $supplier->id }}"
                                            {{ $supplier->id == $qac->supplier_id ? 'selected' : '' }}>
                                            {{ $supplier->firm_name }}
                                        </option>
                                    @endif
                                </select>
                                <span id="error_supplier_id" class="text-danger error_field"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="item_type_id">Item Type</label>
                                <select class="form-control" id="item_type_id" name="item_type_id" required>

                                    <option selected disabled value="">Please Select</option>

                                    @foreach ($item_types as $item_type)
                                        <option value="{{ $item_type->id }}"
                                            {{ $item_type->id == $qac->item_type_id ? 'selected' : '' }}>
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

                                <select class="form-control select2" id="item_id" name="item_id" required>
                                    <option value="">Please Select</option>
                                    @if ($qac->item_id)
                                        <option value="{{ $item->id }}" selected>{{ $item->name }}</option>
                                    @endif
                                </select>


                                <span id="error_item_id" class="text-danger error_field"></span>
                            </div>
                        </div>


                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="fin_year_id">Financial Year </label>

                                <select class="form-control" id="fin_year_id" name="fin_year_id" required>

                                    <option value="">Please Select Year </option>
                                    @foreach ($fin_years as $fin_year)
                                        <option value={{ $fin_year->id }}
                                            {{ $fin_year->id == $qac->fin_year_id ? 'selected' : '' }}>
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
                                <textarea name="remark" id="remark" class="form-control"> {{ $qac->remarks ? $qac->remarks : '' }}</textarea>
                                <span id="error_remark" class="text-danger error_field"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="doc_file">Upload Document</label>
                                <input class="form-control" type="file" id="doc_file" name='doc_file'>
                                <span id="doc_file" class="text-danger error_field"></span>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="card-footer text-end">
                    <div class="col-sm-9 offset-sm-3">
                        <a href="{{ route('admin.qac/view') }}" type="button" class="btn btn-secondary">Cancel</a>
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
        });

        //Start:: Update information
        $('#update_form').off().on('submit', function(event) {
            event.preventDefault();
            var formData = new FormData($('#update_form')[0]);
            disableButton()
            $.ajax({
                url: "{{ url('admin/qac/update') }}",
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
                    setTimeout(window.location.href = "{{ route('admin.qac/view') }}", 40000);
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
        $('#contract_reference_no').off('change').on('change', function() {
            var ContractReferenceNo = $(this).val();

            if (ContractReferenceNo) {
                $.ajax({
                    url: "{{ url('admin/qac/get_contract_details') }}" + '/' +
                        ContractReferenceNo,
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

                        if (response.contract.indent_reference_no) {
                            var indent_html = response.contract.indent_reference_no;
                            $('#error_indent_reference_no').html('')
                        } else {
                            var indent_html = ''
                            $('#error_indent_reference_no').html(
                                'Indent Reference Id Not Found')
                        }

                        if (response.contract.offer_reference_no) {

                            var offer_html = response.contract.offer_reference_no;
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

                        // $('#contract_reference_no').val(response.contract.reference_no).trigger(
                        //     'change');

                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            }
        });
    </script>
@endpush
