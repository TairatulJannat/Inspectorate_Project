@extends('backend.app')
@section('title', 'Prelim/general')
@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend/css/datatables.css') }}">
@endpush
@section('main_menu', 'Prelim/general')
@section('active_menu', 'Details')
@section('content')

    <div class="panel-heading">
        <div class="invoice_date_filter" style="">

        </div>

    </div>
    <br>
    <div class="col-sm-12 col-xl-12">
        <div class="card">
            <div class="card-header">

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
                        </table>
                    </div>
                </div>
                <div class="card-body col-3" style="margin: 10px;">
                    <h4>Forward Status</h4>
                    <ul>
                        @if ($document_tracks !== null && $desig_id !== 1 )
                            @foreach ($document_tracks as $document_track )
                            <li><i class="fa fa-check ps-2 text-success" aria-hidden="true"></i>{{$document_track->designations_name}}</li>
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

            $('#submitBtn').off('click').on('click', function(event) {

                event.preventDefault();

                var reciever_desig_id = $('#designations').val()
                var doc_ref_id = {{ $details->id }}
                var doc_type_id = {{ $details->spec_type }}



                swal({
                    title: 'Are you sure?',
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
                                'doc_ref_id':doc_ref_id,
                                'doc_type_id':doc_type_id,

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
