@extends('backend.app')
@section('title', 'Report Return')
@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend/css/datatables.css') }}">
@endpush
@section('main_menu', 'Report Return ')
@section('active_menu', 'Weekly')
@section('content')

    <div class="col-sm-12 col-xl-12">
        <div class="card mt-2">
            <div class="row mt-2">

                <div class="d-flex justify-content-center align-item-center">

                    <div class="col-4">
                        From: <input type="date" class="form-control " name="from_date" id="from_date">
                    </div>
                    <div class="col-4">
                        To: <input type="date" class="form-control" name="to_date" id="to_date">
                    </div>
                    <div class="col-2 m-2">
                        <button class='btn btn-success' id="rr_filter_btn">Filter</button>
                    </div>

                </div>
                <div class="modal-body">

                    <div class="row">
                        <form action="" id="myForm">
                            @csrf
                            {{-- <div class="col-12 text-center">
                            <div class="col-12 d-flex justify-content-center">
                                <div class="col-2">
                                    <select name="page_size" class="form-control bg-success text-light" id="page_size">
                                        <option value="A4">Select Page Size</option>
                                        <option value="A4">A4</option>
                                        <option value="Legal">Legal</option>
                                        <option value="Letter">Letter</option>
                                    </select>
                                </div>
                                <div class="col-3">
                                    <input type="text" id="header_footer" class="form-control "
                                        placeholder="Header Here">
                                </div>
                            </div>
                        </div> --}}

                            {{-- <input type="hidden" id="doc_type_id" value="5">
                        <div class="row text-center">
                            <div class="col-6 align-self-end">
                                <div class="input-group ">
                                    <div class="input-group-prepend ">
                                        <span class="input-group-text">23.01.901.051. </span>
                                    </div>
                                    <input type="text" class="form-control " id="letter_reference_no">
                                    <div class="input-group-append ">
                                        <span class="input-group-text ">
                                            .{{ \Carbon\Carbon::now()->format('d.m.y') }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-2">

                            </div>
                            <div class="col-4">
                                <div>
                                    <input type="text" class="form-control inspectorate_name" id="inspectorate_name"
                                        name="inspectorate_name" placeholder="Inspectorate Name" value="I E & I">
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
                        </div> --}}
                            {{-- <div>
                            <textarea class="form-control my-2" name="subject" id="subject" placeholder="Subject">Weekly Report/Returns</textarea>

                        </div>
                        <div class="my-2">
                            <label for="body_1">Refs: </label>
                            <textarea class="form-control " name="body_1" id="body_1"></textarea>
                        </div>
                        <div class="mt-2">
                            <label for="body_2">Body </label>
                            <textarea class="form-control " name="body_2" id="body_2"></textarea>
                        </div> --}}
                            <div class="row mt-2">
                                <div class="col-12">
                                    <p>a. Prelim Tech Spec Vetting </p>

                                </div>
                                <div class="col-12">

                                    <table class="table table-bordered">
                                        <tr>
                                            <th>Ser</th>
                                            <th>Inspectorate</th>
                                            <th>Received</th>
                                            <th>Vetted</th>
                                            <th>Under Vetted</th>
                                            <th>Cancelled/ Rejected</th>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>Total</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-12">
                                    <p>b. Gen Tech Spec Vetting </p>

                                </div>
                                <div class="col-12">

                                    <table class="table table-bordered">
                                        <tr>
                                            <th>Ser</th>
                                            <th>Inspectorate</th>
                                            <th>Received</th>
                                            <th>Vetted</th>
                                            <th>Under Vetted</th>
                                            <th>Cancelled/ Rejected</th>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>Total</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-12">
                                    <p>c. Offer Model Vetting </p>

                                </div>
                                <div class="col-12">

                                    <table class="table table-bordered">
                                        <tr>
                                            <th>Ser</th>
                                            <th>Inspectorate</th>
                                            <th>Received</th>
                                            <th>Vetted</th>
                                            <th>Under Vetted</th>
                                            <th>Cancelled/ Rejected</th>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>Total</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-12">
                                    <p>d. Indent Vetting </p>

                                </div>
                                <div class="col-12">

                                    <table class="table table-bordered">
                                        <tr>
                                            <th>Ser</th>
                                            <th>Inspectorate</th>
                                            <th>Received</th>
                                            <th>Vetted</th>
                                            <th>Under Vetted</th>
                                            <th>Cancelled/ Rejected</th>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>Total</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            {{-- <div class="col-12 text-center">RESTRICTED</div> --}}

                            {{-- <div>
                            <button type="submit" class="btn btn-success"> Save </button>
                        </div> --}}

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
        {{-- @include('backend.indent.indent_dispatch.indent_dispatch_index_js') --}}
        <script>
            $('#rr_filter_btn').click(function(event) {
                event.preventDefault();
                var fromDate = $('input[name="from_date"]').val();
                var toDate = $('input[name="to_date"]').val();

                $.ajax({
                    url: "{{ url('admin/rr/report_data') }}",
                    type: "POST",
                    data: {
                        'fromDate':fromDate,
                        'toDate':toDate
                    },
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },
                    success: function(response) {
                        if (response.error) {
                            error_notification(response.error)

                        }
                        if (response.success) {

                            toastr.success('Information Updated', 'Saved');

                        }
                        // setTimeout(window.location.href = "{{ route('admin.prelimgeneral/view') }}", 40000);
                    },
                    error: function(response) {

                        error_notification('Please fill up the form correctly and try again')

                    }
                });
            });
        </script>
    @endpush
