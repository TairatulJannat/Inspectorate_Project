@extends('backend.app')
@section('title', 'Offer')
@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend/css/datatables.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend/css/select2.css') }}">
    <style>
        form select {
            padding: 10px
        }


        .form-check-input {
            margin-left: 10px;
            width: 30px !important;

            height: 20px;
        }
        .header{
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: aliceblue;
            padding: 20px 10px 0 20px;
            border-radius: 10px;
            margin-bottom: 20px !important:
        }
    </style>
@endpush
@section('main_menu', 'Offer')
@section('active_menu', 'Add Offer')
@section('content')
    <div class="col-sm-12 col-xl-12">

        <div class="card">
            <form action="" method="POST" id="save_info" enctype="multipart/form-data">
                @csrf

                <div class="card-body">
                    <div  class=" header">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="additional_documents">*Select Section</label>
                                <select class="form-control bg-success text-light" id="admin_section" name="admin_section">
                                    <Option value="">Select Section</Option>
                                    @foreach ($sections as $section)
                                        <option value="{{ $section->id }}">{{ $section->name }}</option>
                                    @endforeach

                                </select>
                                <span id="error_admin_section" class="text-danger error_field"></span>
                            </div>
                        </div>
                        {{-- <div class="col-md-2">
                            <div class="form-group">
                                <a href="{{url('admin/import-supplier-spec-data-index')}}" class="btn btn-success">Import Supplier Spec</a>
                            </div>
                        </div> --}}
                    </div>
                    <div class="row">

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="sender">*Sender</label>
                                <select class="form-control " id="sender" name="sender">

                                    <option value="">Please Select</option>

                                    @foreach ($dte_managments as $dte)
                                        <option value="{{ $dte->id }}">{{ $dte->name }}</option>
                                    @endforeach

                                </select>
                                <span id="error_sender" class="text-danger error_field"></span>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="reference_no">*Reference Number</label>
                                <input type="text" class="form-control" id="reference_no" name="reference_no">
                                <span id="error_reference_no" class="text-danger error_field"></span>
                            </div>
                        </div>

                 
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="offer_reference_date">*Offer Reference Date</label>
                                <input type="date" class="form-control" id="offer_reference_date" name="offer_reference_date">
                                <span id="error_offer_reference_date" class="text-danger error_field"></span>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">

                                <label for="offer_rcv_ltr_dt">Offer Receive Letter Date</label>
                                <input type="date" class="form-control" id="offer_rcv_ltr_dt" name="offer_rcv_ltr_dt" value={{ \Carbon\Carbon::now()->format('Y-m-d') }}>

                                <span id="error_offer_rcv_ltr_dt" class="text-danger error_field"></span>
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

                        {{-- <div class="col-md-4">
                            <div class="form-group">
                                <label for="remark">Remark</label>
                                <textarea name="remark" id="remark" class="form-control"></textarea>
                                <span id="error_remark" class="text-danger error_field"></span>
                            </div>
                        </div> --}}



                        {{-- <div class="col-md-4">
                            <div class="form-group">
                                <label for="pdf_file" style="color: yellow"><button type="button" class="btn btn-warning">Upload PDF</b></button></label><br>
                                <input type="file" class="form-control-file" id="pdf_file" name="pdf_file">
                                <span id="error_pdf_file" class="text-danger error_field"></span>
                            </div>
                        </div> --}}

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
    @include('backend.offer.offer_incomming_new.index_js')
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
