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
                            <div id="report">

                            </div>

                        </form>
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
    {{-- @include('backend.indent.indent_dispatch.indent_dispatch_index_js') --}}
    <script>
        $('#rr_filter_btn').click(function(event) {
            event.preventDefault();
            var fromDate = $('input[name="from_date"]').val();
            var toDate = $('input[name="to_date"]').val();

            console.log(fromDate);
            console.log(toDate);

            $.ajax({
                url: "{{ url('admin/rr/report_data') }}",
                type: "POST",
                data: {
                    'fromDate': fromDate,
                    'toDate': toDate
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                success: function(response) {
                    if (response.error) {
                        error_notification(response.error)

                    }
                    if (response.success) {

                        toastr.success('Information Status', 'Found');
                        $('#report').html(report(response.reports))

                    }
                    // setTimeout(window.location.href = "{{ route('admin.prelimgeneral/view') }}", 40000);
                },
                error: function(response) {

                    error_notification('Please fill up the form correctly and try again')

                }
            });
        });

        function report(reports) {
            var html = `      <div class="row mt-2">
                                <div class="col-12">
                                    <table class="table table-bordered">
                                        <tr>
                                            <th>Documents</th>

                                            <th>Received</th>
                                            <th>Vetted</th>
                                            <th>Under Vetted</th>
                                            <th>Cancelled/ Rejected</th>
                                        </tr>`;

            // Loop through the reports data and populate table rows
            for (const [category, values] of Object.entries(reports)) {
                html += `
                <tr>
                    <td><b> ${category} vetting report<b></td>

                    <td>Ctrl:${values.receive.controll} <br> Unctrl:${values.receive.uncontroll}</td>
                    <td>Ctrl:${values.vetted.controll} <br> Unctrl:${values.vetted.uncontroll}</td>
                    <td>Ctrl:${values.undervetted.controll} <br> Unctrl:${values.undervetted.uncontroll}</td>
                    <td>Ctrl:Nil <br> Unctrl:Nil</td>
                </tr>
                <tr>
                    <td class='text-end'><b> Total: <b></td>

                    <td>${values.receive.total}</td>
                    <td>${values.vetted.total}</td>
                    <td>${values.undervetted.total}</td>
                    <td>-</td>
                </tr>`

            }

            // Add total row
            html += `  </table>
                                </div>
                            </div>`;

            return html;
        }
    </script>
@endpush
