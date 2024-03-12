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
                                <label for="sender">*Sender</label>
                                <input type="hidden" value=" {{ $offer->id }}" id="editId" name="editId">
                                <select class="form-control " id="sender" name="sender">

                                    <option value="">*Please Select</option>

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
                                <label for="reference_no">*Reference Number</label>
                                <input type="text" class="form-control" id="reference_no" name="reference_no"
                                    value="{{ $offer->reference_no ? $offer->reference_no : '' }}">
                                <span id="error_reference_no" class="text-danger error_field"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="offer_reference_date">*Offer Reference Date</label>
                                <input type="date" class="form-control" id="offer_reference_date"
                                    name="offer_reference_date"
                                    value="{{ $offer->offer_reference_date ? $offer->offer_reference_date : '' }}">
                                <span id="error_offer_reference_date" class="text-danger error_field"></span>
                            </div>
                        </div>


                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="offer_rcv_ltr_dt">*Offer Receive Date</label>
                                <input type="date" class="form-control" id="offer_rcv_ltr_dt" name="offer_rcv_ltr_dt"
                                    value="{{ $offer->offer_rcv_ltr_dt ? $offer->offer_rcv_ltr_dt : '' }}">
                                <span id="error_offer_rcv_ltr_dt" class="text-danger error_field"></span>
                            </div>
                        </div>


                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="tender_reference_no">*Tender Reference Number</label>
                                <select class="form-control select2" id="tender_reference_no" name="tender_reference_no">
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
                                <label for="indent_reference_no">*Indent Reference Number</label>


                                <select class="form-control select2" id="indent_reference_no" name="indent_reference_no">

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
                                <label for="item_type_id">*Item Type</label>
                                <select class="form-control" id="item_type_id" name="item_type_id">

                                    <option value="">Please Select</option>

                                    @if ($item_types)
                                        <option
                                            value="{{ $item_types->id == $offer->item_type_id ? $item_types->id : '' }}">
                                            {{ $item_types->name }} </option>
                                    @endif

                                </select>
                                <span id="error_item_type_id" class="text-danger error_field"></span>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="item_id">*Nomenclature</label>
                                <select class="form-control" id="item_id" name="item_id">
                                    @if ($items)
                                        <option value="{{ $items->id == $offer->item_id ? $items->id : '' }}">
                                            {{ $items->name }} </option>
                                    @endif
                                </select>

                                <span id="error_item_id" class="text-danger error_field"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">

                                <label for="additional_documents">Additional Documents</label>
                                <select class="form-control select2" id="additional_documents"
                                    name="additional_documents[]" multiple>
                                    <option value="">Please Select</option>
                                    @foreach ($additional_documnets as $additional_document)
                                        @php
                                            $documentIds = json_decode($offer->additional_documents);
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

                                <label for="supplier_id">*Suppiler</label>

                                <select class="form-control select2" id="supplier_id" name="supplier_id[]" multiple>
                                    <option value="">Please Select</option>
                                    @foreach ($suppliers as $supplier)
                                        @php
                                            $supplierIds = json_decode($offer->supplier_id);
                                            $isSelected = in_array($supplier->id, $supplierIds ? $supplierIds : [])
                                                ? 'selected'
                                                : '';
                                        @endphp

                                        <option value="{{ $supplier->id }}" {{ $isSelected }}>
                                            {{ $supplier->firm_name }}</option>
                                    @endforeach

                                </select>

                                <span id="error_supplier_id" class="text-danger error_field"></span>
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
                                <label for="fin_year_id">*Financial Year </label>

                                <select class="form-control" id="fin_year_id" name="fin_year_id">
                                    <option value="">Please Select Year </option>
                                    @foreach ($fin_years as $fin_year)
                                        <option value={{ $fin_year->id }}
                                            {{ $fin_year->id == $offer->fin_year_id ? 'selected' : '' }}>
                                            {{ $fin_year->year }}
                                        </option>
                                    @endforeach
                                </select>


                                <span id="error_fin_year_id" class="text-danger error_field"></span>
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

                                <textarea name="remark" id="remark" class="form-control">{{ $offer->remark ? $offer->remark : '' }}</textarea>

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
    @include('backend.offer.offer_incomming_new.index_js')
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
                var offerRefNo = $('#reference_no').val();
                var redirectUrl = url + '?offerRefNo=' + encodeURIComponent(offerRefNo);

                window.location.href = redirectUrl;
            });
        });
    </script>
    <script>
        $(document).ready(function() {

            $('.select2').select2();

            $('#indent_reference_no').off('change').on('change', function() {
                var indentReferenceNo = $(this).val();
                if (indentReferenceNo) {
                    $.ajax({
                        url: "{{ url('admin/offer/get_indent_details') }}" + '/' +
                            indentReferenceNo,
                        type: 'GET',
                        success: function(response) {
                            if (response.item) {
                                var item_html = '<option value="' + response.item.id + '">' +
                                    response.item.name + '</option>';
                                $('#item_id').html(item_html);
                            }

                            if (response.itemType) {
                                var itemType_html = '<option value="' + response.itemType.id +
                                    '">' + response.itemType.name + '</option>';


                                $('#item_type_id').html(itemType_html);
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
