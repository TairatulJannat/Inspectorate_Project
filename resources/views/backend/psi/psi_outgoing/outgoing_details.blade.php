@extends('backend.app')
@section('title', 'PSI (Completed)')
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
        .forward,
        .delay_cause {
            background-color: #F5F7FB !important;
            /* Light gray */
            border-radius: 6px;
            padding: 20px;
            box-shadow: rgba(0, 0, 0, 0.18) 0px 2px 4px;
            n
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
            min-height: 200px
        }

        .delay_cause {
            min-height: 100px
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
@section('main_menu', 'PSI')
@section('active_menu', 'Details')
@section('content')
    <div class="col-sm-12 col-xl-12">
        <div class="card ">
            <div class="card-header">
                <h2><strong>Details of PSI</strong></h2>
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
                                <th>Contract Referance No</td>
                                <td>{{ $details->contract_reference_no }}</td>
                            </tr>

                            <tr>
                                <th>User Directorate</td>
                                <td>{{ $details->dte_managment_name }}</td>
                            </tr>
                            <tr>
                                <th>Receive Date</td>
                                <td>{{ $details->received_date }}</td>
                            </tr>
                            <tr>
                                <th>Referance Date</td>
                                <td>{{ $details->reference_date }}</td>
                            </tr>

                            <tr>
                                <th>Nomenclature</td>
                                <td>{{ $details->item_name }}</td>
                            </tr>

                            <tr>
                                <th>Financial Year</td>
                                <td>{{ $details->fin_year_name }}</td>
                            </tr>


                        </table>
                        {{-- <a class="btn btn-success mt-3 btn-parameter"
                            href="{{ route('admin.indent/parameter', ['indent_id' => $details->id]) }}">Parameter</a> --}}
                        {{-- <a class="btn btn-success mt-3 btn-parameter"
                            href="{{ route('admin.indent/parameterPdf', ['indent_id' => $details->id]) }}">Genarate Parameter Pdf</a> --}}
                        {{-- <a class="btn btn-info mt-3 btn-parameter text-light"
                            href="{{ asset('storage/' . $details->attached_file) }}" target="_blank">Pdf Document</a> --}}
                        {{-- additional file design start here --}}
                        @include('backend.files.file')
                        {{-- additional file design end here --}}

                        @if ($cover_letter)
                            <a href="{{ url('admin/cover_letter/pdf') }}/{{ $details->reference_no }}"
                                class="btn btn-warning mt-3" target="blank"> <i class="fas fa-file-alt"></i> Genarate Cover
                                Letter</a>
                            <button class="btn btn-warning text-light ml-2 mt-2" type="button" data-bs-toggle="modal"
                                data-bs-target=".edit-modal-lg">Edit Cover
                                Letter</button>
                            {{-- <a href="{{ url('admin/cover_letter/edit') }}" class="btn btn-warning mt-3">  Edit Cover
                                Letter</a> --}}
                        @endif
                    </div>
                </div>


                <div class="card-body col-8">
                    <div class="row">
                        @if ($DocumentTrack_hidden)

                            @if ($desig_id == $DocumentTrack_hidden->reciever_desig_id)
                                <div class="forward col-md-12 mb-3">
                                    <div>
                                        <h4 class="text-success">Forward</h4>
                                        <hr>
                                        <form action="">
                                            <div class="row">
                                                <div class="col-md-12 d-flex">

                                                    <select name="designation" id="designations" class="form-control "
                                                        style="height: 40px; margin-right">
                                                        <option value="">Select To Receiver </option>
                                                        @foreach ($designations as $d)
                                                            <option value={{ $d->id }}>{{ $d->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    <span id="error_designation" class="text-danger"></span>
                                                    <textarea name="remarks" id="remarks" class="form-control ml-2 " placeholder="Remarks Here"
                                                        style="height: 40px; margin-left: 10px;"></textarea>
                                                </div>
                                                <div class="d-flex">
                                                    @if ($desig_position->position == 3)
                                                        <div class=" col-md-6 mt-2">
                                                            <label for="delivery_date">Delivery Date </label>
                                                            <input type="date" id="delivery_date" name="delivery_date"
                                                                class="form-control"
                                                                value={{ \Carbon\Carbon::now()->format('Y-m-d') }}>
                                                        </div>
                                                        <div class="col-md-6 mt-2 " style="margin-left: 10px;">
                                                            <label for="delay_cause">Delay Cause </label>
                                                            <textarea name="delay_cause" id="delay_cause" class="form-control" placeholder="Enter delay cause"
                                                                style="height: 40px; "></textarea>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="d-flex">



                                                    @if (!$cover_letter)
                                                        <div
                                                            class="col-md-12 m-2 d-flex justify-content-center align-items-center">
                                                            <button class="btn btn-warning text-light ml-2"
                                                                style='height: 60px' type="button" data-bs-toggle="modal"
                                                                data-bs-target=".bd-example-modal-lg">Create Cover
                                                                Letter</button>
                                                        </div>
                                                    @endif

                                                </div>


                                                <div class="col-md-2">
                                                    @if ($cover_letter)
                                                        <button class="delivery-btn btn btn-success mt-2" id="submitBtn"
                                                            style="height: 40px;">Deliver</button>
                                                    @else
                                                        <button class="delivery-btn btn btn-info text-white mt-2"
                                                            id="disabledSubmitBtn"
                                                            title="To Enable Button Create Cover Letter"
                                                            style="height: 40px;" disabled>Deliver</button>
                                                    @endif


                                                </div>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            @else
                                {{-- blank --}}
                            @endif

                            @if ($desig_id == $DocumentTrack_hidden->sender_designation_id)
                                {{-- blank --}}
                            @endif
                        @else
                            <div class="forward col-md-12 mb-3">
                                <div>
                                    <h4 class="text-success">Forward</h4>
                                    <hr>
                                    <form action="">
                                        <div class="row">
                                            <div class="col-md-12 d-flex">

                                                <select name="designation" id="designations" class="form-control "
                                                    style="height: 40px; margin-right">
                                                    <option value="">Select To Receiver </option>
                                                    @foreach ($designations as $d)
                                                        <option value={{ $d->id }}>{{ $d->name }}</option>
                                                    @endforeach
                                                </select>

                                                <textarea name="remarks" id="remarks" class="form-control ml-2 " placeholder="Remarks Here"
                                                    style="height: 40px; margin-left: 10px;"></textarea>
                                            </div>
                                            <div class="d-flex">
                                                @if ($desig_position->position == 3)
                                                    <div class=" col-md-6 mt-2">
                                                        <label for="delivery_date">Delivery Date </label>
                                                        <input type="date" id="delivery_date" name="delivery_date"
                                                            class="form-control"
                                                            value={{ \Carbon\Carbon::now()->format('Y-m-d') }}>
                                                    </div>
                                                    <div class="col-md-6 mt-2 " style="margin-left: 10px;">
                                                        <label for="delay_cause">Delay Cause </label>
                                                        <textarea name="delay_cause" id="delay_cause" class="form-control" placeholder="Enter delay cause"
                                                            style="height: 40px; "></textarea>
                                                    </div>
                                                @endif
                                            </div>

                                            <div class="col-md-2">


                                                <button class="delivery-btn btn btn-success mt-2" id="submitBtn"
                                                    style="height: 40px;">Deliver</button>
                                            </div>
                                        </div>
                                    </form>

                                </div>
                            </div>

                        @endif


                        <div class="forward_status col-md-12 mb-3">
                            <div>
                                <h4 class="text-success">Vetting Status</h4>
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
                                                        <td>{{ $document_track->created_at->format('d-m-Y') }}
                                                        </td>
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
                        @if ($details->delay_cause !== null)
                            <div class="delay_cause col-md-12  mb-3">
                                <div>
                                    <h4 class="text-success">Delay Cause</h4>
                                    <hr>
                                    <div class="table-responsive">
                                        {{ $details->delay_cause }}

                                    </div>
                                </div>
                            </div>
                        @endif

                    </div>

                </div>
            </div>

        </div>
    </div>
    {{-- start Modal for cover letter --}}

    @include('backend.psi.cover_letter.cover_letter_create')

    {{-- start Modal for cover letter --}}

    {{-- start edit cover letter --}}
    @if ($cover_letter)
    @include('backend.psi.cover_letter.cover_letter_edit')
        
    @endif


    {{-- start edit cover letter --}}
@endsection
@push('js')
    <script src="{{ asset('assets/backend/js/select2/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/backend/js/datatable/datatables/plugin/datatables.min.js') }}"></script>
    <script src="https://unpkg.com/sweetalert2@7.19.1/dist/sweetalert2.all.js"></script>
    <script src="{{ asset('assets/backend/js/select2/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/backend/js/notify/bootstrap-notify.min.js') }}"></script>
    @include('backend.psi.psi_outgoing.outgoing_index_js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ckeditor5/40.2.0/ckeditor.min.js"
        integrity="sha512-8gumiqgUuskL3/m+CdsrNnS9yMdMTCdo5jj5490wWG5QaxStAxJSYNJ0PRmuMNYYtChxYVFQuJD0vVQwK2Y1bQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        @include('backend.psi.cover_letter.cover_letter_js')

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
                            url: '{{ url('admin/outgoing_psi/tracking') }}',
                            data: {
                                'reciever_desig_id': reciever_desig_id,
                                'doc_ref_id': doc_ref_id,
                                'delay_cause': delay_cause,
                                'delivery_date': delivery_date,
                                'doc_reference_number': doc_reference_number,
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

                                        setTimeout(window.location.href =
                                            "{{ route('admin.psi/outgoing') }}",
                                            40000);
                                    }
                                }
                            },
                            error: function(response) {
                                enableeButton()
                                clear_error_field();
                                error_notification(
                                    'Please fill up the form correctly and try again'
                                )
                                $('#error_designation').text(response.responseJSON.error
                                    .reciever_desig_id);


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
        // $('#myForm').submit(function(e) {

        //     var formData = {}; // Object to store form data

        //     $(this).find('input, textarea').each(function() {
        //         var fieldId = $(this).attr('id');
        //         var fieldValue = $(this).val();
        //         formData[fieldId] = fieldValue;
        //     });

        //     console.log(formData);

        //     $.ajax({
        //         url: '{{ url('admin/cover_letter/create') }}',
        //         method: 'POST',
        //         data: formData,
        //         headers: {
        //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //         },
        //         success: function(response) {
        //             toastr.success('Information Saved', 'Saved');
        //         },
        //         error: function(error) {
        //             console.error('Error sending data:', error);
        //         }
        //     });
        // });
        // $('#editForm').submit(function(e) {
        //     var formData = {}; // Object to store form data

        //     $(this).find('input, textarea').each(function() {
        //         var fieldId = $(this).attr('id');
        //         var fieldValue = $(this).val();
        //         formData[fieldId] = fieldValue;
        //     });

        //     $.ajax({
        //         url: '{{ url('admin/cover_letter/edit') }}',
        //         method: 'POST',
        //         data: formData,
        //         headers: {
        //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //         },
        //         success: function(response) {
        //             toastr.success('Information Updated', 'Saved');
        //         },
        //         error: function(error) {
        //             console.error('Error sending data:', error);
        //         }
        //     });
        // });
    </script>
@endpush
