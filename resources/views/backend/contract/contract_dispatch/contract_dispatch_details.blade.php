@extends('backend.app')
@section('title', 'Contract (Dispatch)')
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
            border-radius: 8px 8px 0 0 !important;
            color: #1B4C43;
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
        .forward,
        .delay_cause {
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
@section('main_menu', 'Contract (Dispatch) ')
@section('active_menu', 'Details')
@section('content')

    <div class="col-sm-12 col-xl-12">
        <div class="card ">
            <div class="card-header">
                <h2><b>Details of Contract</b></h2>
            </div>
            <div style="display: flex">
                <div class="card-body col-5">
                    <div class="table-responsive">
                        <table class="table table-bordered ">
                            <tr>
                                <th>Referance No</td>
                                <td>{{ $details->reference_no }}</td>
                            </tr>

                            <tr>
                                <th>Indent Reference No</td>
                                <td>{{ $details->indent_reference_no }}</td>
                            </tr>
                            <tr>
                                <th>Offer Reference No</td>
                                <td>{{ $details->offer_reference_no }}</td>
                            </tr>
                            <tr>
                                <th>Final Spec Reference No</td>
                                <td>{{ $details->final_spec_reference_no }}</td>
                            </tr>
                            <tr>
                                <th>Contract Reference No</td>
                                <td>{{ $details->draft_contract_reference_no }}</td>
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
                                <th>Reference Date</td>
                                <td>{{ $details->reference_date }}</td>
                            </tr>

                            <tr>
                                <th>Nomenclature</td>
                                <td>{{ $details->item_name }}</td>
                            </tr>
                            <tr>
                                <th>Contracted Value</td>
                                <td>{{ $details->contracted_value }}</td>
                            </tr>

                            <tr>
                                <th>Financial Year</td>
                                <td>{{ $details->fin_year_name }}</td>
                            </tr>

                        </table>
                        {{-- Attached File start --}}
                        @include('backend.files.file')
                        {{-- Attached File end --}}
                        {{-- <a class="btn btn-info mt-3 btn-parameter text-light"
                            href="{{ asset('storage/' . $details->doc_file) }}" target="_blank">Pdf Document</a> --}}
                        <a href="{{ url('admin/cover_letter/pdf') }}/{{ $details->reference_no }}"
                            class="btn btn-warning mt-3" target="blank"> <i class="fas fa-file-alt"></i> Genarate Cover
                            Letter</a>
                    </div>
                </div>

                <div class="card-body col-7">
                    <div class="row">
                        @if ($DocumentTrack_hidden)

                            @if ($desig_id == $DocumentTrack_hidden->reciever_desig_id)
                                <div class="forward col-md-12 mb-3">
                                    <div>
                                        <h4 class="text-success">Forward</h4>
                                        <hr>
                                        <form action="">
                                            <div class="row">
                                                @if ($desig_position->position != 1)
                                                    <div class="col-md-6 mb-2">
                                                        <select name="designation" id="designations" class="form-control"
                                                            style="height: 40px;">
                                                            <option value="">Select To Receiver</option>
                                                            @foreach ($designations as $d)
                                                                <option value="{{ $d->id }}">{{ $d->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        <span id="error_designation" class="text-danger"></span>
                                                    </div>
                                                @endif
                                                <div class="col-md-6 mb-2">
                                                    <textarea name="remarks" id="remarks" class="form-control" placeholder="Remarks Here" style="height: 40px;"></textarea>
                                                </div>
                                                <div class="col-md-4">
                                                    <button class="btn btn-success" id="form_submission_button"
                                                        style="height: 40px;">Deliver</button>
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
                                            @if ($desig_position->position != 1)
                                                <div class="col-md-6 mb-2">
                                                    <select name="designation" id="designations" class="form-control"
                                                        style="height: 40px;">
                                                        <option value="">Select To Receiver</option>
                                                        @foreach ($designations as $d)
                                                            <option value="{{ $d->id }}">{{ $d->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <span id="error_designation" class="text-danger"></span>
                                                </div>
                                            @endif
                                            <div class="col-md-6 mb-2">
                                                <textarea name="remarks" id="remarks" class="form-control" placeholder="Remarks Here" style="height: 40px;"></textarea>
                                            </div>
                                            <div class="col-md-4">
                                                <button class="btn btn-success" id="form_submission_button"
                                                    style="height: 40px;">Deliver</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                        @endif


                        <div class="forward_status col-md-12 ">
                            <div>
                                <h4 class="text-success">Dispatch Status</h4>
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
                                                    @if ($document_track->track_status == 2)
                                                        <tr style="background-color: #c8fff528">
                                                            <td>{{ $document_track->sender_designation_name }}</td>
                                                            <td><i class="fa fa-arrow-right text-success"></i></td>
                                                            <td>{{ $document_track->receiver_designation_name }}</td>
                                                            <td>{{ $document_track->created_at->format('d-m-Y H:i') }}</td>
                                                            <td>{{ $document_track->remarks }}</td>
                                                        </tr>
                                                    @else
                                                        <tr style="background-color: #ff715e32">
                                                            <td>{{ $document_track->sender_designation_name }}</td>
                                                            <td><i class="fa fa-arrow-right text-success"></i></td>
                                                            <td>{{ $document_track->receiver_designation_name }}</td>
                                                            <td>{{ $document_track->created_at->format('d-m-Y H:i') }}</td>
                                                            <td>{{ $document_track->remarks }}</td>
                                                        </tr>
                                                    @endif
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
                            <div class="delay_cause col-md-12 mt-3">
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

@endsection
@push('js')
    <script src="{{ asset('assets/backend/js/select2/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/backend/js/datatable/datatables/plugin/datatables.min.js') }}"></script>
    <script src="https://unpkg.com/sweetalert2@7.19.1/dist/sweetalert2.all.js"></script>
    <script src="{{ asset('assets/backend/js/select2/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/backend/js/notify/bootstrap-notify.min.js') }}"></script>
    @include('backend.contract.contract_dispatch.contract_dispatch_index_js')

    <script>
        $(document).ready(function() {
            var reciever_desig_text = '';
            $('#designations').on('change', function() {

                reciever_desig_text = $(this).find('option:selected').text();
                reciever_desig_text =
                    `to the <span style="color: red; font-weight: bold;">  ${reciever_desig_text}</span>`


            });

            $('#form_submission_button').off('click').on('click', function(event) {

                event.preventDefault();
                disableButton()
                var reciever_desig_id = $('#designations').val()
                var remarks = $('#remarks').val()
                var doc_ref_id = {{ $details->id }}
                var doc_reference_number = '{{ $details->reference_no }}'
                swal({
                    title: `Are you sure to delivered
                        ${reciever_desig_text}?`,
                    text: "",
                    type: 'success',
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
                            url: '{{ url('admin/contract_dispatch/tracking') }}',
                            data: {
                                'reciever_desig_id': reciever_desig_id,
                                'doc_ref_id': doc_ref_id,
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
                                            "{{ route('admin.contract_dispatch/view') }}",
                                            40000);
                                    }
                                }
                            },
                            error: function(response) {
                                enableeButton()
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
    </script>
@endpush
