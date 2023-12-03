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
            <div class="details">
                <div class="col-12 col-lg-6" id="indent_details">

                </div>
                <div class="col-12 col-lg-6" id="track_details">

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
                                var doc_track_data = response.data;
                                $('#indent_details').html(indent_details(details))
                                $('#track_details').html(track_data(doc_track_data))
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

        function track_data(data) {
            var html = ''
            html += `<table class="table ">
                            <thead>
                                <tr>
                                    <th>Sender</th>
                                    <th></th>
                                    <th>Receiver</th>
                                    <th>Forwarded Date Time</th>
                                </tr>
                            </thead>`


            if (data !== null)
                $.each(data, function(index, value) {
                    `<tr>
                        <td> ${ value.sender_designation_name } </td>
                         <td> < i class = "fa fa-arrow-right text-success" > </i></td >
                        <td> ${value.receiver_designation_name } </td>
                        <td>  </td>
                    </tr>`
                });

                `</table>`

        }
    </script>
@endpush
