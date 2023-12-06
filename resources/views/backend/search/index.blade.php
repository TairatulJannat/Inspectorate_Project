@extends('backend.app')
@section('title', 'Search')
@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend/css/datatables.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend/css/select2.min.css') }}">
    <style>
        .search-box {
            width: 100%;
            margin: 15px;
            display: flex;
            justify-content: center
        }

        input {
            width:
        }

        .title {
            background-color: #1B4C43;
            padding: 7px 10px;
            color: #ffff;
            border-radius: 7px 7px 0 0;
        }

        .forward_status {
            box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;
        }

        .table-responsive {
            padding: 0 10px;
        }
        .card-body form{
        background-color: #1B4C43;
        }
    </style>
@endpush
@section('main_menu', 'Search')
@section('active_menu', 'Search')
@section('content')


    <div class="card">
        <div class="card-body">
            <div>
                <form action="" method=" " id="searchItemParametersButton" autocomplete="off">
                    @csrf
                    <div class="row p-3">
                        <div class="col-md-2 text-center mt-2">
                            <h6>Select Document Type: </h6>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-2">
                                <select class="form-control select2 item-type-id" id="docTypeId" name="doc-type-id"
                                    style="width: 100% !important;">
                                    <option value="" selected disabled>Select Document Type</option>
                                    @foreach ($doc_types as $doc_type)
                                        <option value="{{ $doc_type->doc_serial }}">{{ $doc_type->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <span class="text-danger error-text item-type-id-error"></span>
                        </div>
                        <div class="col-md-2 text-center mt-2">
                            <h6 class="card-title">Referance Number: </h6>
                        </div>
                        <div class="col-md-3">

                            <input type="text" placeholder="Enter Reference" class="form-control" id="reference_number">
                            <span class="text-danger error-text item-id-error"></span>
                        </div>
                        <!-- Search Button -->
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-success-gradien search-button"
                                id="searchButton">Search<span>
                                    <i class="fa fa-search"></i></span></button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="row details">
                <div class="col-6" id="indent_details">

                </div>
                <div class="col-6" id="track_details">



                </div>

            </div>
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

            $('#searchButton').on('click', function(e) {
                e.preventDefault()
                var docTypeId = $("#docTypeId").val();
                var docReferenceNumber = $("#reference_number").val();


                $.ajax({
                    type: 'Post',
                    url: '{{ url('admin/search/view') }}',
                    data: {
                        'docTypeId': docTypeId,
                        'docReferenceNumber': docReferenceNumber,

                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {

                        if (response) {
                            if (response.permission === false) {
                                toastr.warning(
                                    'You don\'t have that Permission',
                                    'Permission Denied');
                            } else {

                                var details = response.details;

                                var arrivel = response.data_seen;
                                var decision = response.data_approved;
                                var vetted = response.data_vetted;
                                var dispatch = response.data_dispatch;

                                var concatenatedHTML = data_seen(arrivel) +
                                    data_approved(decision) +
                                    data_vetted(vetted) +
                                    data_dispatch(dispatch);

                                $('#indent_details').html(indent_details(details))
                                $('#track_details').html(concatenatedHTML)
                                // $('#track_details').html("ok")
                            }
                        }
                    },
                    error: function(xhr, status, error) {

                        console.error(xhr.responseText);
                        toastr.error(
                            'An error occurred while processing the request',
                            'Error');
                    }
                });
            })


        });

        function indent_details(details) {
            html = '';
            html += `<table class="table table-bordered ">
                            <tr>
                                <th>Referance No</td>
                                <td>${details.reference_no }</td>
                            </tr>
                            <tr>
                                <th>Indent Number</td>
                                <td>${details.indent_number}</td>
                            </tr>
                            <tr>
                                <th>User Directorate</td>
                                <td>${details.dte_managment_name }</td>
                            </tr>
                            <tr>
                                <th>Receive Date</td>
                                <td>${details.indent_received_date }</td>
                            </tr>

                            <tr>
                                <th>Name of Eqpt</td>
                                <td>${details.item_type_name}</td>
                            </tr>
                            <tr>
                                <th>Attribute</td>
                                <td>${details.attribute}</td>
                            </tr>
                            <tr>
                                <th>Additional Documents</td>
                                <td>${details.additional_documents_name}</td>
                            </tr>
                            <tr>
                                <th>Financial Year</td>
                                <td>${details.fin_year_name }</td>
                            </tr>
                            <tr>
                                <th>Nomenclature</td>
                                <td>${details.nomenclature }</td>
                            </tr>
                            <tr>
                                <th>Make</td>
                                <td>${ details.make }</td>
                            </tr>
                            <tr>
                                <th>Model</td>
                                <td>${ details.model }</td>
                            </tr>
                            <tr>
                                <th>Country of Origin</td>
                                <td>${ details.country_of_origin }</td>
                            </tr>
                            <tr>
                                <th>Country of Assembly</td>
                                <td>${ details.country_of_assembly }</td>
                            </tr>

                        </table>`

            return html;

        }



        function data_seen(data) {
            var html = '';
            html += `<div class="forward_status col-md-12 mb-3">
                        <div>
                            <h4 class="title ">New Arrivel</h4>
                            <hr>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Sender</th>
                                            <th></th>
                                            <th>Receiver</th>
                                            <th>Forwarded Date Time</th>
                                            <th>Remark</th>
                                        </tr>
                                    </thead>
                                    <tbody>`

            if (data !== null) {


                $.each(data, function(index, value) {

                    var date_time = formatDate(value.created_at)

                    html += `<tr>
                                <td>${value.sender_designation_name}</td>
                                <td><i class="fa fa-arrow-right text-success"></i></td>
                                <td>${value.receiver_designation_name}</td>
                                <td>${date_time}</td>
                                <td>${value.remarks}</td>
                            </tr>`;
                });
            }

            html += `</tbody>
                                </table>
                            </div>
                        </div>
                    </div>`;

            return html;
        }

        function data_vetted(data) {
            var html = '';
            html += `<div class="forward_status col-md-12 mb-3">
                        <div>
                            <h4 class="title bg-info ">OutGoing</h4>
                            <hr>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Sender</th>
                                            <th></th>
                                            <th>Receiver</th>
                                            <th>Forwarded Date Time</th>
                                            <th>Remark</th>
                                        </tr>
                                    </thead>
                                    <tbody>`

            if (data !== null) {


                $.each(data, function(index, value) {

                    var date_time = formatDate(value.created_at)

                    html += `<tr>
                                <td>${value.sender_designation_name}</td>
                                <td><i class="fa fa-arrow-right text-success"></i></td>
                                <td>${value.receiver_designation_name}</td>
                                <td>${date_time}</td>
                                <td>${value.remarks}</td>
                            </tr>`;
                });
            }

            html += `</tbody>
                                </table>
                            </div>
                        </div>
                    </div>`;

            return html;
        }

        function data_approved(data) {
            var html = '';
            html += `<div class="forward_status col-md-12 mb-3">
                        <div>
                            <h4 class="title bg-secondary">Decision</h4>
                            <hr>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Sender</th>
                                            <th></th>
                                            <th>Receiver</th>
                                            <th>Forwarded Date Time</th>
                                            <th>Remark</th>
                                        </tr>
                                    </thead>
                                    <tbody>`

            if (data !== null) {


                $.each(data, function(index, value) {

                    var date_time = formatDate(value.created_at)

                    html += `<tr>
                                <td>${value.sender_designation_name}</td>
                                <td><i class="fa fa-arrow-right text-success"></i></td>
                                <td>${value.receiver_designation_name}</td>
                                <td>${date_time}</td>
                                <td>${value.remarks}</td>
                            </tr>`;
                });
            }

            html += `</tbody>
                                </table>
                            </div>
                        </div>
                    </div>`;

            return html;
        }

        function data_dispatch(data) {
            var html = '';
            html += `<div class="forward_status col-md-12 mb-3">
                        <div>
                            <h4 class="title bg-danger">Dispatch</h4>
                            <hr>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Sender</th>
                                            <th></th>
                                            <th>Receiver</th>
                                            <th>Forwarded Date Time</th>
                                            <th>Remark</th>
                                        </tr>
                                    </thead>
                                    <tbody>`

            if (data !== null) {


                $.each(data, function(index, value) {

                    var date_time = formatDate(value.created_at)

                    html += `<tr>
                                <td>${value.sender_designation_name}</td>
                                <td><i class="fa fa-arrow-right text-success"></i></td>
                                <td>${value.receiver_designation_name}</td>
                                <td>${date_time}</td>
                                <td>${value.remarks}</td>
                            </tr>`;
                });
            }

            html += `</tbody>
                                </table>
                            </div>
                        </div>
                    </div>`;

            return html;
        }

        function formatDate(date) {
            var selectedDate = date.toString();
            var selectedDate = new Date(selectedDate);

            var year = selectedDate.getFullYear();
            var month = (selectedDate.getMonth() + 1).toString().padStart(2, '0');
            var day = selectedDate.getDate().toString().padStart(2, '0');

            return `${day}-${month}-${year}`;
        }
    </script>
@endpush
