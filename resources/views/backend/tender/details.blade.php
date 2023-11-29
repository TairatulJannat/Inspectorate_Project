@extends('backend.app')
@section('title', 'Tender Management')
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
            background-color:  #006A4E!important;
            border-radius: 8px 8px 0 0 !important;
            color:  #ffff;
        }
        .remarks_status {
            min-height: 250px
        }
        .forward_status {
            min-height: 250px
        }

        .card-body {
            padding: 20px !important;
        }

        .col-3,
        .col-2 {
            background-color: #F5F7FB !important;
            /* Light gray */
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
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
    </style>
@endpush
@section('main_menu', 'Tender Management')
@section('active_menu', 'Details')
@section('content')


    <div class="col-sm-12 col-xl-12">
        <div class="card">
            <div class="card-header">
                <h2>Details of Specification</h2>
            </div>
            <div style="display: flex">
                <div class="card-body col-6" style="margin: 10px">
                    <div class="table-responsive">
                        <table class="table table-bordered yajra-datatable">
                            <tr>
                                <th>Referance No</td>
                                <td>{{ $details->reference_no }}</td>
                            </tr>
                            <tr>
                                <th>User Directorate</td>
                                <td>{{ $details->dte_managment_name }}</td>
                            </tr>

                            <tr>
                                <th>Name of Eqpt</td>
                                <td>{{ $details->item_type_name }}</td>
                            </tr>
                            <tr>
                                <th>Item</td>
                                <td>{{ $details->item_name }}</td>
                            </tr>
                            <tr>
                                <th>Item Quantity</td>
                                <td>{{ $details->qty }}</td>
                            </tr>
                            <tr>
                                <th>Receive Date</td>
                                <td>{{ $details->receive_date}}</td>
                            </tr>
                            <tr>
                                <th>Opening Date</td>
                                <td> {{ $details->opening_date }}</td>
                            </tr>
                            <tr>
                                <th>Tender Date</td>
                                <td> {{ $details->tender_date }}</td>
                            </tr>
                            <tr>
                                <th>Additional Documents</th>
                                <td>
                                    @if (!empty($additional_documents_names))
                                        <ul>
                                            @foreach ($additional_documents_names as $documents_name)
                                                <li>{{ $documents_name}} </li>
                                                <!-- Adjust the key according to your array structure -->
                                            @endforeach
                                        </ul>
                                    @else
                                        No additional documents available.
                                    @endif
                                </td>
                            </tr>
                          
                        </table>
                    </div>
                </div>

                
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
                                @foreach ( $notes as $note )
                                    @if ($note->reciever_desig_id == $auth_designation_id->desig_id)
                                        <p><i class="fa fa-circle ps-2 text-success" aria-hidden="true"></i> 
                                            
                                            {{ $note->remarks }}</p>
                                    @else
                                        <p>Notes are not provided.</p>
                                    @endif
                                @endforeach
                            @else
                                <p>Notes are not provided.</p>
                            @endif
                        </li>

                    </ul>
                </div>
                <div class="card-body col-2" style="margin: 10px;">
                    <h4>Forward</h4>
                    <form action="">
                        <select name="designation" id="designations" class="form-control">
                            <option value="">Select To Receiver </option>
                            @foreach ($designations as $d)
                                <option value={{ $d->id }}>{{ $d->name }}</option>
                            @endforeach

                        </select>
                        <textarea name="remarks" id="remarks" class="form-control mt-2" placeholder="Remarks Here"></textarea>
                        <button class="btn btn-success mt-2 " id="submitBtn">Forward</button>
                    </form>
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
                var doc_type_id = {{ $details->spec_type }}
            


                swal({
                    title: `Are you sure to forward <span style="color: red; font-weight: bold;">  ${reciever_desig_text}</span>?`,
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
                            url: '{{ url('admin/tender/tenderTracking') }}',
                            data: {
                                'reciever_desig_id': reciever_desig_id,
                                'doc_ref_id': doc_ref_id,
                                'doc_type_id': doc_type_id,
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
                                        setTimeout(window.location.href = "{{ route('admin.tender/view') }}", 40000);
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

        });
    </script>
@endpush
