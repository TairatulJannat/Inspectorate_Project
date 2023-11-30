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
    {{-- <form action="" method="POST" id="" autocomplete="off">
        @csrf
        <div class="container-fluid dashboard-default-sec">
            <div class="card">
                <div class="search-box">
                    <select name="" id="" class="form-control">
                        <option value="">Select Document Type</option>
                        @foreach ($doc_types as $doc_type)
                            <option value="{{ $doc_type->id }}">{{ $doc_type->name }}</option>
                        @endforeach

                    </select>
                    <input type="text" placeholder="Enter Reference" class="form-control">
                    <button type="button" class="btn btn-primary">Search</button>
                </div>
            </div>
        </div>
    </form> --}}

    <div class="card">
        <div class="card-body">
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
                        {{-- <div class="mb-2">
                            <select class="form-control select2 item-id" id="itemId" name="item-id"
                                style="width: 100% !important;">
                                <option value="" selected disabled>Select an item</option>
                               
                            </select>
                        </div> --}}
                        <input type="text" placeholder="Enter Reference" class="form-control" id="reference_number">
                        <span class="text-danger error-text item-id-error"></span>
                    </div>
                    <!-- Search Button -->
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-success-gradien search-button" id="searchButton">Search<span>
                                <i class="fa fa-search"></i></span></button>
                    </div>
                </div>
            </form>
            {{-- <div class="row border p-3" style="background-color: honeydew;">
                <div class="text-success searched-data">
                    <div class="text-center">
                        <h2>Searched Item Parameters will appear here.</h2>
                    </div>
                </div>
            </div> --}}
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
                    url: '{{url('admin/search/view') }}',
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
                                   console.log(response)
                                 var  details = response.details;
                                 var  doc_track_data = response.data;
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
    </script>
@endpush
