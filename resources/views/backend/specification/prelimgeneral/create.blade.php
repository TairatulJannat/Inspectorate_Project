@extends('backend.app')
@section('title', 'Prelim/General Specification')
@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend/css/datatables.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend/css/select2.css') }}">
    <style>
        form select {
            padding: 10px
        }
    </style>
@endpush
@section('main_menu', 'Prelim/General')
@section('active_menu', 'Add Specification')
@section('content')
    <div class="col-sm-12 col-xl-12">

        <div class="card">
            <form action="" method="POST" id="save_info" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="row">

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="sender_id">Sender</label>
                                <select class="form-control " id="sender_id" name="sender_id">

                                    <option value="">Please Select</option>

                                    @foreach ($dte_managments as $dte)
                                        <option value="{{ $dte->id }}">{{ $dte->name }}</option>
                                    @endforeach

                                </select>
                                <span id="error_hall_id" class="text-danger error_field"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="hall_id">Spec. Type</label>
                                <select class="form-control" id="hall_id" name="hall_id">

                                    <option value="">Please Select </option>
                                    <option value="0"> General Spe</option>
                                    <option value="1">Please Select </option>

                                </select>
                                <span id="error_hall_id" class="text-danger error_field"></span>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="hall_id">Spec. Received Date</label>
                                <input type="date" class="form-control">
                                <span id="error_hall_id" class="text-danger error_field"></span>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="hall_id">Reference No.</label>
                                <input type="text" class="form-control">
                                <span id="error_hall_id" class="text-danger error_field"></span>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="hall_id">Aditional Document</label>
                                <select class="form-control " id="document_id" name="document_id">

                                    <option value="">Please Select</option>

                                    @foreach ($additional_documnets as $additional_documnet)
                                        <option value="{{ $additional_documnet->id }}">{{ $additional_documnet->name }}
                                        </option>
                                    @endforeach

                                </select>
                                <span id="error_hall_id" class="text-danger error_field"></span>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="hall_id">Item Type</label>
                                <select class="form-control " id="itemtype_id" name="itemtype_id">

                                    <option selected disabled value="">Please Select</option>

                                    @foreach ($item_types as $item_type)
                                        <option value="{{ $item_type->id }}">{{ $item_type->name }}</option>
                                    @endforeach

                                </select>


                                <span id="error_hall_id" class="text-danger error_field"></span>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="hall_id">Item</label>

                                <select class="form-control" id="item_id" name="item_id">

                                    <option value="">Please Select </option>


                                </select>

                                <span id="error_hall_id" class="text-danger error_field"></span>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="hall_id">Received By</label>
                                <input type="text" value="Abir(CR)" readonly class="form-control">
                                <span id="error_hall_id" class="text-danger error_field"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="hall_id">Remarks</label>
                                <textarea name="" id="" class="form-control"></textarea>
                                <span id="error_hall_id" class="text-danger error_field"></span>
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

            $("#itemtype_id").off('change').on('change', function() {

                // alert('123');
                var itemtype_id = $('#itemtype_id').val();

                if (itemtype_id > 0) {
                    $.ajax({
                        url: "http://localhost/ie&i/Inspectorate_Project/super_admin/prelimgeneral/item_name" +
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
