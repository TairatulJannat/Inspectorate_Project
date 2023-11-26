@extends('backend.app')
@section('title', 'Indent')
@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend/css/datatables.css') }}">
    <style>
        /* styles.css */

        /* Styling for the card elements */
        .card {
            margin-bottom: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .card-header {
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #006A4E !important;
            border-radius: 8px 8px 0 0 !important;
            color: #ffff;
        }

        .card-body {

            margin: 30px 15px 30px 0
        }

        .col-6 {
            padding: 10px 15px !important;
        }

        .col-3,
        .col-2 {
            background-color: #F5F7FB !important;
            /* Light gray */
            border-radius: 8px;
            box-shadow: rgba(50, 50, 93, 0.25) 0px 6px 12px -2px, rgba(0, 0, 0, 0.3) 0px 3px 7px -3px;
        }

        h4 {
            margin-top: 0;
            color: #333;
        }

        /* Styling for the form elements */
        form {
            margin-top: 15px;
        }

        .delivery-btn {
            width: 100%;
            /* Adjust for padding */
            padding: 12px;
            border: none;
            border-radius: 5px;
            background-color: #ffffff !important;
            color: #006a4e8c;
            cursor: pointer;
        }

        .delivery-btn:hover {
            background-color: #ff8533 !important;
            /* Lighter orange on hover */
        }

        .forward_status {
            min-height: 250px
        }

        .remarks_status {
            min-height: 250px
        }

        .documents {
            display: flex;
            justify-content: center;
            column-gap: 10px;
            margin-bottom: 25px
        }
    </style>
@endpush
@section('main_menu', 'Indent')
@section('active_menu', 'Details')
@section('content')


    <div class="col-sm-12 col-xl-12">
        <div class="card ">
            <div class="card-header">
                <h2>Details of Indent</h2>
            </div>
            <div style="display: flex">
                <div class="card-body col-6">
                    <div class="table-responsive">
                        <table class="table table-bordered ">
                            <tr>
                                <th>Referance No</td>
                                <td>{{ $details->reference_no }}</td>
                            </tr>
                            <tr>
                                <th>Indent Number</td>
                                <td>{{ $details->indent_number }}</td>
                            </tr>
                            <tr>
                                <th>User Directorate</td>
                                <td>{{ $details->dte_managment_name }}</td>
                            </tr>
                            <tr>
                                <th>Receive Date</td>
                                <td>{{ $details->indent_received_date }}</td>
                            </tr>

                            <tr>
                                <th>Name of Eqpt</td>
                                <td>{{ $details->item_type_name }}</td>
                            </tr>
                            <tr>
                                <th>Attribute</td>
                                <td>{{ $details->attribute }}</td>
                            </tr>
                            <tr>
                                <th>Additional Documents</td>
                                <td>{{ $details->additional_documents_name }}</td>
                            </tr>
                            <tr>
                                <th>Financial Year</td>
                                <td>{{ $details->fin_year_name }}</td>
                            </tr>
                            <tr>
                                <th>Nomenclature</td>
                                <td>{{ $details->nomenclature }}</td>
                            </tr>
                            <tr>
                                <th>Make</td>
                                <td>{{ $details->make }}</td>
                            </tr>
                            <tr>
                                <th>Model</td>
                                <td>{{ $details->model }}</td>
                            </tr>
                            <tr>
                                <th>Country of Origin</td>
                                <td>{{ $details->country_of_origin }}</td>
                            </tr>
                            <tr>
                                <th>Country of Assembly</td>
                                <td>{{ $details->country_of_assembly }}</td>
                            </tr>

                        </table>
                        <button class="btn btn-success mt-3 btn-parameter">Parameter</button>
                    </div>
                </div>


                {{-- @if (!$sender_designation_id ) --}}
                    <div class="card-body col-3">
                        <h4 class="text-success">Forward Status</h4>
                        <hr>
                        <ul class="forward_status">

                            <li class="d-flex justify-content-between bg-success p-2 mb-2" style="border-radius: 5px">
                                <div>Sender </div>
                                <div> Forwarded Date Time</div>
                            </li>


                            @if ($document_tracks !== null )
                                @foreach ($document_tracks as $document_track)
                                    <li class="d-flex justify-content-between px-2 ">
                                        <div><i class="fa fa-check ps-2 text-success"
                                                aria-hidden="true"></i>{{ $document_track->designations_name }}</div>
                                        <div> {{ $document_track->created_at->format('d-m-Y h:i A') }}</div>
                                    </li>
                                @endforeach
                            @else
                                <li> <i class="fa fa-times text-danger" aria-hidden="true"></i> No forward status found</li>
                            @endif


                        </ul>
                        <h4 class="text-success">Notes from immediate sender </h4>
                        <hr>
                        <ul class="remarks_status">
                            <li>
                                @if ($notes)

                                    @if ($notes->reciever_desig_id == $auth_designation_id->desig_id)
                                        <p>{{ $notes->remarks }}</p>
                                    @else
                                        <p>Notes are not provided.</p>
                                    @endif
                                @else
                                    <p>Notes are not provided.</p>
                                @endif
                            </li>

                        </ul>
                    </div>
                    <div class="card-body col-2">
                        <h4 class="text-success">Forward</h4>
                        <hr>
                        <form action="">
                            <select name="designation" id="designations" class="form-control mt-2">
                                <option value="">Select To Receiver </option>
                                @foreach ($designations as $d)
                                    <option value={{ $d->id }}>{{ $d->name }}</option>
                                @endforeach

                            </select>

                            <textarea name="remarks" id="remarks" class="form-control mt-2" placeholder="Remarks Here"></textarea>
                            <button class="btn btn-success mt-2 " id="submitBtn">Forward</button>
                        </form>
                    </div>

                {{-- @endif --}}
            </div>

        </div>
    </div>
    <div class="col-sm-12 col-xl-12">
        <div class="card">
            <div class="p-3">
                <h4>Documents</h4>
            </div>
            <div class="documents">
                <img src="{{ asset('assets/backend/images/pdf.png') }}" alt="">
                <img src="{{ asset('assets/backend/images/pdf.png') }}" alt="">
                <img src="{{ asset('assets/backend/images/pdf.png') }}" alt="">

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
    {{-- @include('backend.specification.prelimgeneral.index_js') --}}

    <script>
        $(document).ready(function() {
            var reciever_desig_text
            $('#designations').on('change', function() {

                reciever_desig_text = $(this).find('option:selected').text();

            });


            $('#submitBtn').off('click').on('click', function(event) {

                event.preventDefault();

                var reciever_desig_id = $('#designations').val()
                var remarks = $('#remarks').val()
                var doc_ref_id = {{ $details->id }}


                swal({
                    title: `Are you sure to forward to the <span style="color: red; font-weight: bold;">  ${reciever_desig_text}</span>?`,
                    text: "",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Submit!',
                    cancelButtonText: 'No, cancel!',
                    confirmButtonClass: 'btn btn-success',
                    cancelButtonClass: 'btn btn-danger',
                    buttonsStyling: false,
                    reverseButtons: true
                }).then((result) => {
                    if (result.value) {
                        event.preventDefault();
                        $.ajax({
                            type: 'post',
                            url: '{{ url('admin/indent/indent_tracking') }}',
                            data: {
                                'reciever_desig_id': reciever_desig_id,
                                'doc_ref_id': doc_ref_id,
                                'remarks': remarks,

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
                                        toastr.success('Forward Successful',
                                            response.success);
                                            setTimeout(window.location.href = "{{ route('admin.indent/view') }}", 40000);
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

                    } else if (
                        result.dismiss === swal.DismissReason.cancel
                    ) {

                        swal(
                            'Cancelled',
                            'Your data is safe :)',
                            'error'
                        )
                    }
                })

            });

            $('.btn-parameter').on('click', function(event){
                event
            })

        });
    </script>
@endpush
