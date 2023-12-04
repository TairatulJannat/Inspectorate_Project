@extends('backend.app')
@section('title', 'Indent (Outgoing)')
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

        .table thead {
            background-color: #1B4C43 !important;
            border-radius: 10px !important;
        }

        .table thead tr th {
            color: #ffff !important;
        }

        .col-5 {
            padding: 10px 15px !important;
        }

        .forward_status,
        .forward {
            background-color: #F5F7FB !important;
            /* Light gray */
            border-radius: 6px;
            padding: 20px;
            box-shadow: rgba(0, 0, 0, 0.18) 0px 2px 4px;
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
            cursor: pointer;
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
@section('main_menu', 'Indent (Outgoing)')
@section('active_menu', 'Outgoing Details')
@section('content')
    <div class="col-sm-12 col-xl-12">
        <div class="card ">
            <div class="card-header">
                <h2>Details of Indent</h2>
            </div>
            <div style="display: flex">
                <div class="card-body col-4">
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
                                <th>Additional Documents</th>
                                <td>
                                    @if (!empty($additional_documents_names))
                                        <ul>
                                            @foreach ($additional_documents_names as $documents_name)
                                                <li>{{ $documents_name }} </li>
                                                <!-- Adjust the key according to your array structure -->
                                            @endforeach
                                        </ul>
                                    @else
                                        No additional documents available.
                                    @endif
                                </td>
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
                        <a class="btn btn-success mt-3 btn-parameter"
                            href="{{ route('admin.indent/parameter', ['indent_id' => $details->id]) }}">Parameter</a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="forward col-md-12 mb-3">
                            <div>
                                <h4 class="text-success">Forward</h4>
                                <hr>
                                <form action="">
                                    <div class="row">
                                        <div class="col-md-12 d-flex">
                                            @if ($desig_position->position != 7)
                                                <select name="designation" id="designations" class="form-control" style="height: 40px;">
                                                    <option value="">Select To Receiver </option>
                                                    @foreach ($designations as $d)
                                                        <option value={{ $d->id }}>{{ $d->name }}</option>
                                                    @endforeach
                                                </select>
                                                <textarea name="remarks" id="remarks" class="form-control mt-2" placeholder="Remarks Here" style="height: 40px;"></textarea>

                                            @endif
                                        </div>
                                        <div>
                                            @if ($desig_position->position == 3)
                                                <div class="mt-2">
                                                    <label for="delivery_date">Delivery Date </label>
                                                    <input type="date" id="delivery_date" name="delivery_date"
                                                        class="form-control">
                                                </div>
                                                <textarea name="delay_cause" id="delay_cause" class="form-control mt-2" placeholder="Enter delay cause" style="height: 40px;"></textarea>
                                            @endif
                                        </div>
                                        <div class="col-md-6">

                                            <button class="delivery-btn btn btn-success mt-2"
                                                id="submitBtn">Deliver</button>
                                        </div>
                                    </div>
                                </form>

                            </div>
                        </div>

                        <div class="forward_status col-md-12">
                            <div>
                                <h4 class="text-success">Vetted Status</h4>
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
                                        <tbody>
                                            @if ($document_tracks !== null)
                                                @foreach ($document_tracks as $document_track)
                                                    <tr>
                                                        <td>{{ $document_track->sender_designation_name }}</td>
                                                        <td><i class="fa fa-arrow-right text-success"></i></td>
                                                        <td>{{ $document_track->receiver_designation_name }}</td>
                                                        <td>{{ $document_track->created_at->format('d-m-Y h:i A') }}</td>
                                                        <td>{{ $document_track->remarks }}</td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="5"> <i class="fa fa-times text-danger"
                                                            aria-hidden="true"></i> No forward status found </td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                {{-- @if (!$sender_designation_id) --}}
                {{-- <div class="card-body col-4">
                    <h4 class="text-success">Vetted Status</h4>
                    <hr>
                    <ul class="forward_status">

                        <table class="table ">
                            <thead>
                                <tr>
                                    <th>Sender</th>
                                    <th></th>
                                    <th>Receiver</th>
                                    <th>Forwarded Date Time</th>
                                </tr>
                            </thead>


                            @if ($document_tracks !== null)
                                @foreach ($document_tracks as $document_track)
                                    <tr>
                                        <td>{{ $document_track->sender_designation_name }}</td>
                                        <td><i class="fa fa-arrow-right text-success"></i></td>
                                        <td>{{ $document_track->receiver_designation_name }}</td>
                                        <td>{{ $document_track->created_at->format('d-m-Y h:i A') }}</td>
                                    </tr>
                                @endforeach
                            @else
                                <li> <i class="fa fa-times text-danger" aria-hidden="true"></i> No forward status found</li>
                            @endif

                        </table>

                    </ul>
                    @if ($notes == !null)
                        <h4 class="text-success">Notes </h4>
                        <hr>
                        <ul class="remarks_status">
                            <li>
                                @if ($notes)
                                    @foreach ($notes as $note)
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

                    @endif

                </div>
                <div class="card-body col-2">
                    <h4 class="text-success">Forward</h4>
                    <hr>
                    <form action="">

                        @if ($desig_position->position != 7)
                            <select name="designation" id="designations" class="form-control">
                                <option value="">Select To Receiver </option>
                                @foreach ($designations as $d)
                                    <option value={{ $d->id }}>{{ $d->name }}</option>
                                @endforeach

                            </select>
                            @if ($desig_position->position == 3)
                                <div class='mt-2'>
                                    <label for='delivery_date'>Delivery Date </label>
                                    <input type="date" id='delivery_date' name="delivery_date" class="form-control">
                                </div>

                                <textarea name="delay_cause" id="delay_cause" class="form-control mt-2" placeholder="Enter delay cause"></textarea>
                            @endif

                        @endif
                        <textarea name="remarks" id="remarks" class="form-control mt-2" placeholder="Remarks Here"></textarea>


                        <button class="delivery-btn btn btn-success mt-2 " id="submitBtn">Deliver</button>
                    </form>

                </div> --}}

                {{-- @endif --}}
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
    {{-- @include('backend.indent.indent_outgoing.outgoing_index_js') --}}

    <script>
        $(document).ready(function() {
            var reciever_desig_text = '';
            $('#designations').on('change', function() {

                reciever_desig_text = $(this).find('option:selected').text();
                reciever_desig_text =
                    `to the <span style="color: red; font-weight: bold;">  ${reciever_desig_text}</span>`

            });


            $('#submitBtn').off('click').on('click', function(event) {

                event.preventDefault();


                var reciever_desig_id = $('#designations').val()
                var delivery_date = $('#delivery_date').val()
                var delay_cause = $('#delay_cause').val()
                var remarks = $('#remarks').val()
                var doc_ref_id = {{ $details->id }}
                var doc_reference_number = '{{ $details->reference_no }}'


                swal({
                    title: `Are you sure to delivered ${reciever_desig_text}?`,
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
                            url: '{{ url('admin/outgoing_indent/tracking') }}',
                            data: {
                                'reciever_desig_id': reciever_desig_id,
                                'doc_ref_id': doc_ref_id,
                                'delay_cause': delay_cause,
                                'delivery_date': delivery_date,
                                'doc_reference_number': doc_reference_number,
                                'remarks': remarks
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

                                        setTimeout(window.location.href =
                                            "{{ route('admin.indent/outgoing') }}",
                                            40000);
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