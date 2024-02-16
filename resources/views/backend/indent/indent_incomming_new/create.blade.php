@extends('backend.app')
@section('title', 'Indent')
@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend/css/datatables.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend/css/select2.css') }}">
    <style>
        form select {
            padding: 10px
        }

        .form-check-input {
            width: 70px !important;

            height: 35px;
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
@section('main_menu', 'Indent')
@section('active_menu', 'Add Indent')
@section('content')

    <div class="col-sm-12 col-xl-12">

        <div class="card">
            <form action="" method="POST" id="save_info" enctype="multipart/form-data">
                @csrf

                <div class="card-body">
                    <div class=" header">
                        <div class="col-md-3">
                            <div class="form-group d-flex">
                                <label class="col-6 pt-2" for="">*Select Section:</label>
                                <select class="form-control bg-success text-light" id="admin_section" name="admin_section">
                                    <option value="">Select Section</option>
                                    @foreach ($sections as $section)
                                        <option value="{{ $section->id }}">{{ $section->name }}</option>
                                    @endforeach

                                </select>
                               
                               
                            </div>
                            <span id="error_admin_section" class="text-danger error_field"></span>
                        </div>

                    </div>
                    <div class="row mt-4">

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
                                <label for="reference_no">*Reference No.</label>
                                <input type="text" class="form-control" id="reference_no" name="reference_no">
                                <span id="error_reference_no" class="text-danger error_field"></span>
                            </div>
                        </div>



                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="indent_number">*Indent Number</label>

                                <input type="text" class="form-control" id="indent_number" name="indent_number">

                                <span id="error_indent_number" class="text-danger error_field"></span>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="indent_reference_date">*Indent Reference Date</label>
                                <input type="date" class="form-control" id="indent_reference_date"
                                    name="indent_reference_date">
                                <span id="error_indent_reference_date" class="text-danger error_field"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="indent_received_date">Indent Received Date</label>
                                <input type="date" class="form-control" id="indent_received_date"
                                    name="indent_received_date" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
                                <span id="error_indent_received_date" class="text-danger error_field"></span>
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
    @include('backend.indent.indent_incomming_new.index_js')
    <script>
        $(document).ready(function() {

            $('.select2').select2();


        });
    </script>
@endpush
