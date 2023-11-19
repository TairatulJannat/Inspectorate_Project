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
            background-color:  #006A4E!important;
            border-radius: 8px 8px 0 0 !important;
            color:  #ffff;
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
@section('main_menu', 'Indent')
@section('active_menu', 'Details')
@section('content')


    <div class="col-sm-12 col-xl-12">
        <div class="card">
            <div class="card-header">
                <h2>Details of Indent</h2>
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
                                <th>Receive Date</td>
                                <td>{{ $details->spec_received_date }}</td>
                            </tr>
                            <tr>
                                <th>Specification Type</td>
                                <td> {{ $details->spec_type == 1 ? 'Prelim Specification' : 'Genarel Specification' }}</td>
                            </tr>
                            <tr>
                                <th>Delivary</td>
                                <td> {{ $details->delivery_date }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="card-body col-3" style="margin: 10px;">
                    <h4>Forward Status</h4>
                    <ul>
                        @if ($document_tracks !== null && $desig_id !== 1)
                            @foreach ($document_tracks as $document_track)
                                <li><i class="fa fa-check ps-2 text-success"
                                        aria-hidden="true"></i>{{ $document_track->designations_name }}</li>
                            @endforeach
                        @endif



                    </ul>
                </div>
                <div class="card-body col-2" style="margin: 10px;">
                    <h4>Forward</h4>
                    <form action="">
                        <select name="designation" id="designations" class="form-control">

                            @foreach ($designations as $d)
                                <option value={{ $d->id }}>{{ $d->name }}</option>
                            @endforeach

                        </select>
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
                            url: '{{ url('admin/prelimgeneral/prelim_gen_tracking') }}',
                            data: {
                                'reciever_desig_id': reciever_desig_id,
                                'doc_ref_id': doc_ref_id,
                                'doc_type_id': doc_type_id,

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
