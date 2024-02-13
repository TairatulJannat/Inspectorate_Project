@extends('backend.app')
@section('title', 'Search')
@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend/css/datatables.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend/css/select2.min.css') }}">
    <style>
        .searchButton {
            color: #F7454A
        }

        .search-box {
            width: 100%;
            margin: 15px;
            display: flex;
            justify-content: center
        }

        input {
            width:
        }

        .bg-info {
            background-color: #0DCAF0 !important;
        }

        .bg-danger {
            background-color: #F7454A !important;
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

        .card-body form {
            background-color: hsla(170, 37%, 66%, 0.384);
            margin-bottom: 20px;
            border-radius: 7px;
        }

        .search_title h3 {
            padding: 0;
            margin: 0;
        }

        .search_title {
            border-radius: 7px;
            background-color: #ededed;
            color: rgb(75, 75, 75);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .search_body {
            border: 1px solid #ededed;
            border-radius: 7px;
        }

        .details {
            padding: 0 10px;
            margin-top: 15px;
        }

        .current_status {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #ededed;
            padding: 10px 20px;
            margin-bottom: 10px;
            border-radius: 5px;
            color:
        }

        .current_status div h4 {
            padding: 5px 8px;
            border-radius: 7px;
            color: white
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

                        <div class="col-md-2 text-center mt-1">
                            <h6>Doc Type: </h6>
                        </div>
                        <div class="col-md-2">
                            <div class="mb-2">
                                <select class="form-control select2 item-type-id" id="docTypeId" name="doc-type-id"
                                    style="width: 100% !important;">
                                    <option value="">Select Document Type</option>
                                    @foreach ($doc_types as $doc_type)
                                        <option value="{{ $doc_type->doc_serial }}">{{ $doc_type->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <span class="text-danger error-text item-type-id-error"></span>
                        </div>
                        <div class="col-md-1 text-center mt-2">
                            <h6 class="card-title">Referance Number: </h6>
                        </div>
                        <div class="col-md-2">
                            <input type="text" placeholder="Enter Reference" class="form-control" id="reference_number">
                            <span class="text-danger error-text item-id-error"></span>
                        </div>

                        <div class="col-md-1 text-center mt-2">
                            <h6 class="card-title">FY </h6>
                        </div>
                        <div class="col-md-2">
                            <select class="form-control select2 fy_id" id="fy_id" name="fy_id"
                                style="width: 100% !important;">
                                <option value="" selected disabled>Select FY</option>
                                @foreach ($financial_year as $fy)
                                    <option value="{{ $fy->id }}">{{ $fy->year }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger error-text fy-id-error"></span>
                        </div>
                        <!-- Search Button -->
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-success-gradien search-button"
                                id="getDataBtn">Search<span>
                                    <i class="fa fa-search"></i></span></button>
                        </div>
                        {{-- <div class="col-md-2">
                            <button type="submit" class="btn btn-success-gradien search-button"
                                id="searchButton">Search<span>
                                    <i class="fa fa-search"></i></span></button>
                        </div> --}}
                    </div>
                </form>
            </div>
            <div id='tableData' class="m-4">

            </div>
            <div class="search_body">
                {{-- <div class="search_title col-12 text-center  p-3 ">
                    <h3>Search details will be appeared here.</h3>
                </div> --}}
                <div class="row details">
                    <div class="col-5" id="indent_details">


                    </div>
                    <div class="col-7" id="track_details">

                    </div>

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
            $('.search_body').hide();

            $('#getDataBtn').on('click', function(e) {
                e.preventDefault()
                cleardata()
                $('.search_body').show();

                var doc_type_id = $("#docTypeId").val();
                var reference_no = $("#reference_number").val();
                var fy_id = $("#fy_id").val();

                $.ajax({
                    type: 'Post',
                    url: '{{ url('admin/search/all_data') }}',
                    data: {
                        'doc_type_id': doc_type_id,
                        'reference_no': reference_no,
                        'fy_id': fy_id,
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

                                let data = response.data;
                                let docTypeId = response.docTypeId;
                                toastr.success(
                                    ' Request Document is found',
                                    'Success');

                                $('#tableData').html(tableData(data, docTypeId))
                            }
                        }
                    },
                    error: function(xhr, status, error) {

                        toastr.error(error);
                    }
                });
            })
        });

        function tableData(data, doc_type_id) {

            html = `<table class="table table-bordered">
                        <thead>
                            <tr>
                            <th scope="col">#</th>
                            <th scope="col">Reference No</th>
                            <th scope="col">Nomenclature</th>
                            <th scope="col">Financial Year</th>
                            <th scope="col">Status</th>

                            <th scope="col">Action</th>

                            </tr>
                        </thead>
                        <tbody>`
            let i = 1;
            $.each(data, function(index, item) {
                html += ` <tr>
                                <th scope="row">${i++}</th>
                                <td>${item.reference_no}</td>

                                <td>${item.item_name}</td>
                                <td>${item.fin_year_name}</td>
                                <td>`
                                    if (item.status == 0) {
                                        html += `<div><h4 class="m-0 btn btn-success">New Arrival</h4></div>`;
                                    } else if (item.status == 1) {
                                        html += `<div><h4 class="m-0 btn btn-info">Vetting On Process</h4></div>`;
                                    } else if (item.status == 2) {
                                        html += `<div><h4 class="m-0 btn btn-primary">Completed</h4></div>`;
                                    } else if (item.status == 4) {
                                        html += `<div><h4 class="m-0btn btn-danger">Dispatched</h4></div>`;
                                    } else {
                                        html += `<div><h4 class="m-0 bg-danger">None</h4></div>`;
                                    }
                html += `</td>

                                <td>
                                    <button type="button" data-reference=${item.reference_no} data-type=${doc_type_id}  class="btn btn-success-gradien search-button detailsOfsearch">
                                        Details
                                    </button>
                                </td>
                            </tr>`
            })
            html += `</tbody>
                        </table>`
            return html;
        }

        $(document).on('click', '.detailsOfsearch', function(e) {
            e.preventDefault()
            // return false;
            $('.search_body').show();

            var referenceNo = $(this).data('reference');
            var docTypeId = $(this).data('type');

            $.ajax({
                type: 'Post',
                url: '{{ url('admin/search/view') }}',
                data: {
                    'docTypeId': docTypeId,
                    'docReferenceNumber': referenceNo,
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
                            var docTypeId = response.docTypeId;

                            var docTrackHTML = data_seen(arrivel) +
                                data_approved(decision) +
                                data_vetted(vetted) +
                                data_dispatch(dispatch);

                            var docDetailsHtml = '';
                            if (docTypeId == 3) {
                                docDetailsHtml = indent_details(details)
                            } else if (docTypeId == 5) {
                                docDetailsHtml = offer_details(details)
                            } else {
                                docDetailsHtml = doc_details(details)
                            }

                            $('#indent_details').html(docDetailsHtml)
                            $('#track_details').html(docTrackHTML)
                            // $('#track_details').html("ok")
                            toastr.success(
                                ' Request Document is found',
                                'Success');
                        }
                    }
                },
                error: function(xhr, status, error) {

                    toastr.error(error);
                }
            });
        })



        function indent_details(details) {
            html = '';
            html += `<div class="current_status">
                        <div><h5 class="m-0">Current Status :</h5></div>`;

            if (details.status == 0) {
                html += `<div><h4 class="m-0 bg-success">New Arrival</h4></div>`;
            } else if (details.status == 1) {
                html += `<div><h4 class="m-0 bg-info">Vetting On Process</h4></div>`;
            } else if (details.status == 2) {
                html += `<div><h4 class="m-0 bg-primary">Completed</h4></div>`;
            } else if (details.status == 3) {
                html += `<div><h4 class="m-0 bg-secondary">New Arrival</h4></div>`;
            } else if (details.status == 4) {
                html += `<div><h4 class="m-0 bg-danger">Dispatched</h4></div>`;
            } else {
                html += `<div><h4 class="m-0 bg-danger">None</h4></div>`;
            }

            html += `</div>`;


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
                                <th>Financial Year</td>
                                <td>${details.fin_year_name }</td>
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

            html += `<a class="btn btn-success mt-3 btn-parameter"
                        href="javascript:void(0)"
                        onclick="redirectToParameter(${details.id})">Parameter</a>

                    `;


            return html;

        }

        function offer_details(details) {
            html = '';
            html += `<div class="current_status">
                        <div><h5 class="m-0">Current Status :</h5></div>`;

            if (details.status == 0) {
                html += `<div><h4 class="m-0 bg-success">New Arrival</h4></div>`;
            } else if (details.status == 1) {
                html += `<div><h4 class="m-0 bg-info">Vetting On Process</h4></div>`;
            } else if (details.status == 2) {
                html += `<div><h4 class="m-0 bg-primary">Completed</h4></div>`;
            } else if (details.status == 3) {
                html += `<div><h4 class="m-0 bg-secondary">New Arrival</h4></div>`;
            } else if (details.status == 4) {
                html += `<div><h4 class="m-0 bg-danger">Dispatched</h4></div>`;
            } else {
                html += `<div><h4 class="m-0 bg-danger">None</h4></div>`;
            }

            html += `</div>`;


            html += `<table class="table table-bordered ">
                            <tr>
                                <th>Referance No</td>
                                <td>${details.reference_no }</td>
                            </tr>
                            <tr>
                                <th>Tender Reference No </td>
                                <td>${details.tender_reference_no}</td>
                            </tr>
                            <tr>
                                <th>User Directorate</td>
                                <td>${details.dte_managment_name }</td>
                            </tr>
                            <tr>
                                <th>Receive Date</td>
                                <td>${details.offer_rcv_ltr_dt }</td>
                            </tr>

                            <tr>
                                <th>Name of Eqpt</td>
                                <td>${details.item_name}</td>
                            </tr>
                            <tr>
                                <th>Type of Eqpt</td>
                                <td>${details.item_type_name}</td>
                            </tr>
                            <tr>
                                <th>Type of Eqpt</td>
                                <td>${details.qty}</td>
                            </tr>
                            <tr>
                                <th>Attribute</td>
                                <td>${details.attribute}</td>
                            </tr>

                            <tr>
                                <th>Financial Year</td>
                                <td>${details.fin_year_name }</td>
                            </tr>
                            <tr>
                                <th>Offer Receiver Letter No</td>
                                <td>${details.offer_rcv_ltr_no }</td>
                            </tr>


                        </table>`

            html += `<a class="btn btn-success mt-3 btn-parameter"
                            href="{{ url('admin/csr/index') }}">CSR</a>`;


            return html;

        }

        function doc_details(details) {
            html = '';
            html += `<div class="current_status">
                        <div><h5 class="m-0">Current Status :</h5></div>`;

            if (details.status == 0) {
                html += `<div><h4 class="m-0 bg-success">New Arrival</h4></div>`;
            } else if (details.status == 1) {
                html += `<div><h4 class="m-0 bg-info">Vetting On Process</h4></div>`;
            } else if (details.status == 2) {
                html += `<div><h4 class="m-0 bg-primary">Completed</h4></div>`;
            } else if (details.status == 3) {
                html += `<div><h4 class="m-0 bg-secondary">New Arrival</h4></div>`;
            } else if (details.status == 4) {
                html += `<div><h4 class="m-0 bg-danger">Dispatched</h4></div>`;
            } else {
                html += `<div><h4 class="m-0 bg-danger">None</h4></div>`;
            }

            html += `</div>`;


            html += `<table class="table table-bordered ">
                            <tr>
                                <th>Referance No</td>
                                <td>${details.reference_no }</td>
                            </tr>`

            if (details.offer_reference_no) {
                html += ` <tr>
                                <th>offer Referance No</td>
                                <td>${details.offer_reference_no }</td>
                            </tr>`
            }

            html += `<tr>
                                <th>User Directorate</td>
                                <td>${details.dte_management_name }</td>
                            </tr>
                            <tr>
                                <th>Receive Date</td>
                                <td>${details.received_date }</td>
                            </tr>

                            <tr>
                                <th>Item Type</td>
                                <td>${details.item_type_name}</td>
                            </tr>


                            <tr>
                                <th>Nomenclature</td>
                                <td>${details.item_name}</td>
                            </tr>

                            <tr>
                                <th>Financial Year</td>
                                <td>${details.fin_year_name }</td>
                            </tr>



                        </table>`

            // html += `<a class="btn btn-success mt-3 btn-parameter"
        //             href="javascript:void(0)"
        //             onclick="redirectToParameter(${details.id})">Parameter</a>

        //         `;


            return html;

        }

        function redirectToParameter(indentId) {
            var url = "{{ route('admin.indent/parameter', ['indent_id' => '']) }}" + indentId;
            // You can perform actions with the constructed URL here, for example:
            window.location.href = url; // Redirect to the constructed URL
        }

        function data_seen(data) {
            var html = '';
            if (data.length !== 0) {
                html += `<div class="forward_status col-md-12 mb-3">
                        <div>
                            <h4 class="title text-center ">New Arrival</h4>

                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Sender</th>
                                            <th></th>
                                            <th>Receiver</th>
                                            <th>Forwarded Date</th>
                                            <th>Remark</th>
                                        </tr>
                                    </thead>
                                    <tbody>`


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


                html += `</tbody>
                                </table>
                            </div>
                        </div>
                    </div>`;
            } else {
                html += `<div class="forward_status col-md-12 mb-3">
                    <div>
                        <p class='p-3'>No Forward Status Found </p>
                    </div>
                </div>`
            }

            return html;
        }

        function data_vetted(data) {
            var html = '';
            if (data.length !== 0) {
                html += `<div class="forward_status col-md-12 mb-3">
                        <div>
                            <h4 class="title text-center bg-info ">Completed</h4>

                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Sender</th>
                                            <th></th>
                                            <th>Receiver</th>
                                            <th>Forwarded Date</th>
                                            <th>Remark</th>
                                        </tr>
                                    </thead>
                                    <tbody>`




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
                html += `</tbody>
                                </table>
                            </div>
                        </div>
                    </div>`;
            }

            return html;
        }

        function data_approved(data) {
            var html = '';
            if (data.length !== 0) {
                html += `<div class="forward_status col-md-12 mb-3">
                        <div>
                            <h4 class="title text-center bg-secondary">On Process</h4>

                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Sender</th>
                                            <th></th>
                                            <th>Receiver</th>
                                            <th>Forwarded Date</th>
                                            <th>Remark</th>
                                        </tr>
                                    </thead>
                                    <tbody>`


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


                html += `</tbody>
                                </table>
                            </div>
                        </div>
                    </div>`;

            }
            return html;
        }

        function data_dispatch(data) {
            var html = '';
            if (data.length !== 0) {
                html += `<div class="forward_status col-md-12 mb-3">
                        <div>
                            <h4 class="title text-center bg-danger">Dispatch</h4>

                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Sender</th>
                                            <th></th>
                                            <th>Receiver</th>
                                            <th>Forwarded Date</th>
                                            <th>Remark</th>
                                        </tr>
                                    </thead>
                                    <tbody>`


                $.each(data, function(index, value) {

                    var date_time = formatDate(value.created_at)
                    html += `<tr>
                                <td>${value.sender_designation_name}</td>
                                <td><i class="fa fa-arrow-right text-success"></i></td>
                                <td>${value.receiver_designation_name!==null? value.receiver_designation_name :'Delivered'}</td>
                                <td>${date_time}</td>
                                <td>${value.remarks}</td>
                            </tr>`;
                });


                html += `</tbody>
                                </table>
                            </div>
                        </div>
                    </div>`;
            }
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

        function cleardata() {
            $('.search_body').hide();
            $('#indent_details').html('');
            $('#track_details').html('');
        }
    </script>
@endpush
