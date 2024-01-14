@extends('backend.app')
@section('title', 'Indent (Completed)')
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

        .cover_letter {
            margin-top: 20px;
            height: 90px;
            font-size: 20px;
        }
    </style>
@endpush
@section('main_menu', 'Indent (Completed)')
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
                        {{-- <a class="btn btn-success mt-3 btn-parameter"
                            href="{{ route('admin.indent/parameterPdf', ['indent_id' => $details->id]) }}">Genarate Parameter Pdf</a> --}}
                        <a class="btn btn-info mt-3 btn-parameter text-light"
                            href="{{ asset('storage/' . $details->doc_file) }}" target="_blank">Pdf Document</a>

                        @if ($cover_letter)
                            <a href="{{ url('admin/cover_letter/pdf') }}/{{ $details->reference_no }}"
                                class="btn btn-warning mt-3" target="blank"> <i class="fas fa-file-alt"></i> Genarate Cover
                                Letter</a>
                            <button class="btn btn-warning text-light ml-2 mt-3" type="button" data-bs-toggle="modal"
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
                                                    @if (!$details->terms_conditions)
                                                        <div class="col-md-6 mt-2 ">
                                                            <label for=""></label>
                                                            <textarea name="terms" class="form-control terms_conditions_text" cols="20" rows="5"
                                                                id="terms_conditions_text" placeholder="Please write terms and conditions"></textarea>
                                                        </div>
                                                    @endif


                                                    @if (!$cover_letter)
                                                        <div
                                                            class="col-md-6 m-2 d-flex justify-content-center align-items-center">
                                                            <button class="btn btn-warning text-light ml-2 cover_letter"
                                                                type="button" data-bs-toggle="modal"
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
                        @if ($details->terms_conditions)
                            <div class="forward_status col-md-12 mb-3">
                                <div>
                                    <h4 class="text-success">Terms Conditions</h4>
                                    <hr>
                                    <div class="table-responsive">
                                        {{ $details->terms_conditions }}
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


    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myLargeModalLabel">Cover Letter</h4>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <form action="" id="myForm">
                            @csrf
                            <div class="col-12 text-center">RESTRICTED</div>
                            <input type="hidden" id="insp_id" value="{{ $details->insp_id }}">
                            <input type="hidden" id="sec_id" value="{{ $details->sec_id }}">
                            <input type="hidden" id="doc_reference_no" value="{{ $details->reference_no }}">
                            <div class="row text-center">
                                <div class="col-6 align-self-end">
                                    <div class="input-group ">
                                        <div class="input-group-prepend ">
                                            <span class="input-group-text">23.01.901.051. </span>
                                        </div>
                                        <input type="text" class="form-control " id="letter_reference_no">
                                        <div class="input-group-append ">
                                            <span class="input-group-text "> .{{ \Carbon\Carbon::now()->format('d.m.y') }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-2">

                                </div>
                                <div class="col-4">
                                    <div>
                                        <input type="text" class="form-control inspectorate_name"
                                            id="inspectorate_name" name="inspectorate_name"
                                            placeholder="Inspectorate Name" value="I E & I">
                                        <input type="text" class="form-control place" id="place" name="place"
                                            placeholder="Address" value="Dhaka Cantt">
                                        <input type="text" class="form-control mobile" id="mobile" name="mobile"
                                            placeholder="Telephone" value="8711111 Ext-7122">
                                        <input type="text" class="form-control fax" id="fax" name="fax"
                                            placeholder="fax" value="9837120">
                                        <input type="text" class="form-control email" id="email" name="email"
                                            placeholder="email" value="iei.dci@army.mil.bd">
                                        <input type="text" class="form-control date" id="date" name="date"
                                            placeholder="date">
                                    </div>
                                </div>
                            </div>
                            <div>
                                <textarea class="form-control my-2" name="subject" id="subject" placeholder="Subject"></textarea>
                                {{-- <input type="text" id="subject" class="form-control my-2" placeholder="Subject"> --}}
                            </div>
                            <div class="my-2">
                                <label for="body_1">Refs: </label>
                                <textarea class="form-control " name="body_1" id="body_1"></textarea>
                            </div>
                            <div class="mt-2">
                                <label for="body_2">Body </label>
                                <textarea class="form-control " name="body_2" id="body_2"></textarea>
                            </div>
                            <div class="row">
                                <div class="col-4"></div>
                                <div class="col-4"></div>
                                <div class="col-4 mt-5">

                                    <div class="mt-2">
                                        <label for="signature">Signature Details </label>
                                        <textarea class="form-control " name="signature" id="signature"></textarea>
                                    </div>

                                </div>
                            </div>
                            <div class="row">
                                <div>
                                    <label for="anxs">Anxs: </label>
                                    <textarea class="form-control" name="anxs" id="anxs"></textarea>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-4 mt-2">

                                    <input type="text" class="form-control" id="distr" placeholder="Distr">
                                    <input type="text" class="form-control" id="extl" placeholder="Extl">
                                    <input type="text" class="form-control" id="act" placeholder="Act">
                                    <input type="text" class="form-control" id="info" placeholder="info">

                                </div>
                            </div>
                            <div class="row mt-2">
                                <div>
                                    <label for="anxs">Internal: </label>
                                    <textarea class="form-control" name="internal" id="internal">
                                </textarea>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-4 mt-2">

                                    <input type="text" class="form-control" id="internal_act" placeholder="Act">
                                    <input type="text" class="form-control" id="internal_info" placeholder="Info">

                                </div>
                            </div>
                            <div class="col-12 text-center">RESTRICTED</div>

                            <div>
                                <button type="submit" class="btn btn-success"> Save </button>
                            </div>

                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>

    {{-- start Modal for cover letter --}}

    {{-- start edit cover letter --}}
    @if ($cover_letter)
        <div class="modal fade edit-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myLargeModalLabel">Edit Cover Letter</h4>
                        <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <div class="row">
                            <form action="" id="editForm">
                                @csrf
                                <div class="col-12 text-center">RESTRICTED</div>
                                <input type="hidden" id="editId" value="{{ $cover_letter->id }}">
                                <input type="hidden" id="insp_id" value="{{ $details->insp_id }}">
                                <input type="hidden" id="sec_id" value="{{ $details->sec_id }}">
                                <input type="hidden" id="doc_reference_no" value="{{ $details->reference_no }}">
                                <div class="row text-center">
                                    <div class="col-6 align-self-end">
                                        <div class="input-group ">

                                            <input type="text" class="form-control " id="letter_reference_no"
                                                value="{{ $cover_letter->letter_reference_no }}">

                                        </div>
                                    </div>
                                    <div class="col-2">

                                    </div>
                                    <div class="col-4">
                                        <div>
                                            <input type="text" class="form-control inspectorate_name"
                                                id="inspectorate_name" name="inspectorate_name"
                                                placeholder="Inspectorate Name"
                                                value="{{ $cover_letter->inspectorate_name }}">
                                            <input type="text" class="form-control place" id="place"
                                                name="place" placeholder="Address"
                                                value="{{ $cover_letter->inspectorate_place }}">
                                            <input type="text" class="form-control mobile" id="mobile"
                                                name="mobile" placeholder="Telephone"
                                                value="{{ $cover_letter->mobile }}">
                                            <input type="text" class="form-control fax" id="fax" name="fax"
                                                placeholder="fax" value="{{ $cover_letter->fax }}">
                                            <input type="text" class="form-control email" id="email"
                                                name="email" placeholder="email" value="{{ $cover_letter->email }}">
                                            <input type="text" class="form-control date" id="date"
                                                name="date" placeholder="date"
                                                value="{{ $cover_letter->letter_date }}">
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <input type="text" id="subject" class="form-control my-2" placeholder="Subject"
                                        value="{{ $cover_letter->subject }}">
                                </div>
                                <div class="my-2">
                                    <label for="body_1">Refs: </label>
                                    <textarea class="form-control body_1" name="bodyEdit_1" id="bodyEdit_1">
                                {!! $cover_letter->body_1 !!}
                    </textarea>
                                </div>
                                <div class="mt-2">
                                    <label for="body_2">Body </label>
                                    <textarea class="form-control body_2" name="bodyEdit_2" id="bodyEdit_2">
                                {!! $cover_letter->body_2 !!}
                    </textarea>
                                </div>
                                <div class="row">
                                    <div class="col-4"></div>
                                    <div class="col-4"></div>
                                    <div class="col-4 mt-5">

                                        <div class="mt-2">
                                            <label for="signatureEdit">Signature Details </label>
                                            <textarea class="form-control " name="signatureEdit" id="signatureEdit"> {!! $cover_letter->signature !!}</textarea>
                                        </div>

                                    </div>
                                </div>
                                <div class="row">
                                    <div>
                                        <label for="anxs">Anxs: </label>
                                        <textarea class="form-control" name="anxs" id="anxsEdit">
                                    {!! $cover_letter->anxs !!}</textarea>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-4 mt-2">

                                        <input type="text" class="form-control" id="distr" placeholder="Distr"
                                            value="{{ $cover_letter->distr }}">
                                        <input type="text" class="form-control" id="extl" placeholder="Extl"
                                            value="{{ $cover_letter->extl }}">
                                        <input type="text" class="form-control" id="act" placeholder="Act"
                                            value="{{ $cover_letter->act }}">
                                        <input type="text" class="form-control" id="info" placeholder="info"
                                            {{ $cover_letter->info }}>

                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div>
                                        <label for="anxs">Internal: </label>
                                        <textarea class="form-control" name="internal" id="internal">
                                    {!! $cover_letter->internal !!}</textarea>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-4 mt-2">

                                        <input type="text" class="form-control" id="internal_act" placeholder="Act"
                                            value="{{ $cover_letter->internal_act }}">
                                        <input type="text" class="form-control" id="internal_info" placeholder="Info"
                                            value="{{ $cover_letter->internal_info }}">

                                    </div>
                                </div>

                                <div class="col-12 text-center">RESTRICTED</div>

                                <div>
                                    <button type="submit" class="btn btn-primary"> Update </button>
                                </div>

                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    @endif


    {{-- start edit cover letter --}}
@endsection
@push('js')
    <script src="{{ asset('assets/backend/js/select2/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/backend/js/datatable/datatables/plugin/datatables.min.js') }}"></script>
    <script src="https://unpkg.com/sweetalert2@7.19.1/dist/sweetalert2.all.js"></script>
    <script src="{{ asset('assets/backend/js/select2/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/backend/js/notify/bootstrap-notify.min.js') }}"></script>
    {{-- @include('backend.indent.indent_outgoing.outgoing_index_js') --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ckeditor5/40.2.0/ckeditor.min.js"
        integrity="sha512-8gumiqgUuskL3/m+CdsrNnS9yMdMTCdo5jj5490wWG5QaxStAxJSYNJ0PRmuMNYYtChxYVFQuJD0vVQwK2Y1bQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        // ClassicEditor
        //     .create(document.querySelector(''))
        //     .catch(error => {
        //         console.error(error);
        //     });
        ClassicEditor
            .create(document.querySelector('#body_1'))
            .catch(error => {
                console.error(error);
            });
        ClassicEditor
            .create(document.querySelector('#body_2'))
            .catch(error => {
                console.error(error);
            });
        ClassicEditor
            .create(document.querySelector('#anxs'))
            .catch(error => {
                console.error(error);
            });
        ClassicEditor
            .create(document.querySelector('#signature'))
            .catch(error => {
                console.error(error);
            });
        ClassicEditor
            .create(document.querySelector('#bodyEdit_1'))
            .catch(error => {
                console.error(error);
            });
        ClassicEditor
            .create(document.querySelector('#bodyEdit_2'))
            .catch(error => {
                console.error(error);
            });
        ClassicEditor
            .create(document.querySelector('#anxsEdit'))
            .catch(error => {
                console.error(error);
            });
        ClassicEditor
            .create(document.querySelector('#signatureEdit'))
            .catch(error => {
                console.error(error);
            });
    </script>

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
                var terms_conditions = $('#terms_conditions_text').val();

                swal({
                    title: `Are you sure to delivered ${reciever_desig_text}?`,
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
                            url: '{{ url('admin/outgoing_indent/tracking') }}',
                            data: {
                                'reciever_desig_id': reciever_desig_id,
                                'doc_ref_id': doc_ref_id,
                                'delay_cause': delay_cause,
                                'delivery_date': delivery_date,
                                'doc_reference_number': doc_reference_number,
                                'remarks': remarks,
                                'terms_conditions': terms_conditions
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
        $('#myForm').submit(function(e) {

            var formData = {}; // Object to store form data

            $(this).find('input, textarea').each(function() {
                var fieldId = $(this).attr('id');
                var fieldValue = $(this).val();
                formData[fieldId] = fieldValue;
            });

            console.log(formData);

            $.ajax({
                url: '{{ url('admin/cover_letter/create') }}',
                method: 'POST',
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    toastr.success('Information Saved', 'Saved');
                },
                error: function(error) {
                    console.error('Error sending data:', error);
                }
            });
        });
        $('#editForm').submit(function(e) {
            var formData = {}; // Object to store form data

            $(this).find('input, textarea').each(function() {
                var fieldId = $(this).attr('id');
                var fieldValue = $(this).val();
                formData[fieldId] = fieldValue;
            });

            $.ajax({
                url: '{{ url('admin/cover_letter/edit') }}',
                method: 'POST',
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    toastr.success('Information Updated', 'Saved');
                },
                error: function(error) {
                    console.error('Error sending data:', error);
                }
            });
        });
    </script>
@endpush
