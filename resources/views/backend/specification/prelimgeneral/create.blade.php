@extends('backend.app')
@section('title', 'Prelim/General Specification')
@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend/css/datatables.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend/css/select2.css') }}">
    <style>
        form select {
            padding: 10px
        }
    </style>
@endpush
@section('main_menu', 'Prelim/General')
@section('active_menu', 'Add Specification')
@section('content')
    <div class="col-sm-12 col-xl-12">

        <div class="card">
            <form action="" method="POST" id="save_info" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="row">

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="sender_id">Sender</label>
                                <select class="form-control " id="sender_id" name="sender_id">

                                    <option value="">Please Select</option>
                                    
                                    @foreach ($dte_managments as $dte)

                                        <option value="{{ $dte->id }}">{{ $dte->name }}</option>

                                    @endforeach

                                </select>
                                <span id="error_hall_id" class="text-danger error_field"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="hall_id">Spec. Type</label>
                                <select class="form-control" id="hall_id" name="hall_id">

                                    <option value="">Please Select </option>
                                    <option value="0"> General Spe</option>
                                    <option value="1">Please Select </option>

                                </select>
                                <span id="error_hall_id" class="text-danger error_field"></span>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="hall_id">Spec. Received Date</label>
                                <input type="date" class="form-control">
                                <span id="error_hall_id" class="text-danger error_field"></span>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="hall_id">Reference No.</label>
                                <input type="text" class="form-control">
                                <span id="error_hall_id" class="text-danger error_field"></span>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="hall_id">Aditional Document</label>
                                <select class="form-control " id="document_id" name="document_id">

                                    <option value="">Please Select</option>
                                    
                                    @foreach ($additional_documnets as $additional_documnet)

                                        <option value="{{ $additional_documnet->id }}">{{ $additional_documnet->name }}</option>

                                    @endforeach

                                </select>
                                <span id="error_hall_id" class="text-danger error_field"></span>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="hall_id">Item</label>
                                <select class="form-control " id="item_id" name="item_id">

                                    <option value="">Please Select</option>
                                    
                                    @foreach ($items as $item)

                                        <option value="{{ $item->id }}">{{ $item->name }}</option>

                                    @endforeach

                                </select>
                                <span id="error_hall_id" class="text-danger error_field"></span>
                            </div>
                        </div>


                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="hall_id">Item Type</label>
                                <select class="form-control" id="item_type_id" name="item_type_id">

                                    <option value="">Please Select </option>
                                    <option value="0"> Light vehicle</option>
                                    <option value="1">Heavy vehicle </option>

                                </select>
                                <span id="error_hall_id" class="text-danger error_field"></span>
                            </div>
                        </div>

                       

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="hall_id">Received By</label>
                                <input type="text" value="Abir(CR)" readonly class="form-control">
                                <span id="error_hall_id" class="text-danger error_field"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="hall_id">Remarks</label>
                                <textarea name="" id="" class="form-control"></textarea>
                                <span id="error_hall_id" class="text-danger error_field"></span>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="card-footer text-end">
                    <div class="col-sm-9 offset-sm-3">
                        <a href="" type="button" class="btn btn-secondary">Cancel</a>
                        <button class="btn btn-primary" type="submit" id="form_submission_button">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@push('js')
    {{-- <script>
        $(document).ready(function() {
            $('.select2').select2();
        });
        // Start:: Get Floor & User category & shift
        $('#hall_id').off('change').on('change', function() {
            var hall_id = $('#hall_id').val();
            $('#floor_id').html('');
            $('#user_category_id').html('');
            $('#shift_id').html(`
                <option value="">Please Select Shift</option>
            `);
            $.ajax({
                url: "{{ url('admin/hall/get_floor') }}",
                type: "POST",
                data: {
                    hall_id: hall_id,
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                success: function(response) {
                    response.data.forEach(function(item) {
                        $('#floor_id').append(`
                        <option value="${item.id ? item.id : ''}">
                            ${item.name ? item.name : ''}
                        </option>
                    `);
                    });
                }
            });

            $.ajax({
                url: "{{ url('admin/hall/get_user_category') }}",
                type: "POST",
                data: {
                    hall_id: hall_id,
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                success: function(response) {
                    response.data.forEach(function(item) {
                        $('#user_category_id').append(`
                        <option value="${item.id ? item.id : ''}">
                            ${item.name ? item.name : ''}
                        </option>
                    `);
                    });
                }
            });

            $.ajax({
                url: "{{ url('admin/hall/get_shift') }}",
                type: "POST",
                data: {
                    hall_id: hall_id,
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                success: function(response) {
                    response.data.forEach(function(item) {
                        $('#shift_id').append(`
                        <option value="${item.id ? item.id : ''}">
                            ${item.name ? item.name : ''}
                        </option>
                    `);
                    });
                }
            });
        })
        // End:: Get Floor & User category & shift

        $('#specify_event').off('change').on('change', function() {
            if ($(this).prop('checked')) {
                $('.event-name-container').show();
            } else {
                $('.event-name-container').hide();
            }
        })

        $('#specify_month').off('change').on('change', function() {
            if ($(this).prop('checked')) {
                $('.months-container').show();
            } else {
                $('.months-container').hide();
            }
        })

        // $('#specify_shift_charge').off('change').on('change', function() {
        //     if ($(this).prop('checked')) {
        //         $('.shift-container').show();
        //     } else {
        //         $('.shift-container').hide();
        //     }
        // })
    </script> --}}
    <script src="{{ asset('assets/backend/js/select2/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/backend/js/datatable/datatables/plugin/datatables.min.js') }}"></script>
    <script src="https://unpkg.com/sweetalert2@7.19.1/dist/sweetalert2.all.js"></script>
    <script src="{{ asset('assets/backend/js/select2/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/backend/js/notify/bootstrap-notify.min.js') }}"></script>
    {{-- <script>
        $(document).ready(function() {
            $('.select2').select2();
        });

        // Start:: save information
        $('#save_info').off().on('submit', function(event) {
            event.preventDefault();

            var formData = new FormData($('#save_info')[0]);

            disableButton()
            $.ajax({
                url: "{{ url('admin/hall_price/store') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                success: function(response) {
                    if (response.error) {
                        error_notification(response.error)
                        enableeButton()
                    }
                    if (response.success) {
                        enableeButton()
                        $('#add_model').modal('hide');
                        $('.modal-backdrop').remove();
                        $('.yajra-datatable').DataTable().ajax.reload(null, false);
                        toastr.success('Information Saved', 'Saved');
                    }
                    setTimeout(window.location.href = "{{ route('admin.hall_price') }}", 40000);
                },
                error: function(response) {
                    enableeButton()
                    clear_error_field();
                    error_notification('Please fill up the form correctly and try again')
                    $('#error_hall_id').text(response.responseJSON.errors.hall_id);
                    $('#error_floor_id').text(response.responseJSON.errors.floor_id);
                    $('#error_user_category_id').text(response.responseJSON.errors.user_category_id);
                    $('#error_specify_event').text(response.responseJSON.errors.specify_event);
                    $('#error_event_name').text(response.responseJSON.errors.event_name);
                    $('#error_specify_month').text(response.responseJSON.errors.specify_month);
                    $('#error_months').text(response.responseJSON.errors.months);
                    $('#error_specify_ramadan').text(response.responseJSON.errors.specify_ramadan);
                    $('#error_specify_shift_charge').text(response.responseJSON.errors
                        .specify_shift_charge);
                    $('#error_shift_id').text(response.responseJSON.errors.shift_id);
                    $('#error_price').text(response.responseJSON.errors.price);
                    $('#error_status').text(response.responseJSON.errors.status);
                }
            });
        })
        // End:: save information

        //Start:: Update information
        $('#update_form').off().on('submit', function(event) {
            event.preventDefault();
            var formData = new FormData($('#update_form')[0]);
            disableButton()
            $.ajax({
                url: "{{ url('admin/hall_price/update') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                success: function(response) {
                    if (response.error) {
                        error_notification(response.error)
                        enableeButton()
                    }
                    if (response.success) {
                        enableeButton()
                        $('.yajra-datatable').DataTable().ajax.reload(null, false);
                        toastr.success('Information Updated', 'Saved');
                        $('#edit_model').modal('hide');
                    }
                    setTimeout(window.location.href = "{{ route('admin.hall_price') }}", 40000);
                },
                error: function(response) {
                    enableeButton()
                    clear_error_field();
                    error_notification('Please fill up the form correctly and try again')
                    $('#error_hall_id').text(response.responseJSON.errors.hall_id);
                    $('#error_floor_id').text(response.responseJSON.errors.floor_id);
                    $('#error_user_category_id').text(response.responseJSON.errors.user_category_id);
                    $('#error_specify_event').text(response.responseJSON.errors.specify_event);
                    $('#error_event_name').text(response.responseJSON.errors.event_name);
                    $('#error_specify_month').text(response.responseJSON.errors.specify_month);
                    $('#error_months').text(response.responseJSON.errors.months);
                    $('#error_specify_ramadan').text(response.responseJSON.errors.specify_ramadan);
                    $('#error_specify_shift_charge').text(response.responseJSON.errors
                        .specify_shift_charge);
                    $('#error_shift_id').text(response.responseJSON.errors.shift_id);
                    $('#error_price').text(response.responseJSON.errors.price);
                    $('#error_status').text(response.responseJSON.errors.status);
                }
            });
        })
        //End:: Update information

        // Start:: delete user
        function delete_data(id) {
            swal({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    event.preventDefault();
                    $.ajax({
                        type: 'get',
                        url: '{{ url('admin/hall_price/delete') }}/' + id,
                        success: function(response) {
                            if (response) {
                                if (response.permission == false) {
                                    toastr.warning('you dont have that Permission',
                                        'Permission Denied');
                                } else {
                                    toastr.success('Deleted Successful', 'Deleted');
                                    $('.yajra-datatable').DataTable().ajax.reload(null, false);
                                }
                            }
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
        }
        // End:: delete user

        function form_reset() {
            document.getElementById("search_form").reset();
            $('.select2').val(null).trigger('change');
            $('.yajra-datatable').DataTable().ajax.reload(null, false);
        }

        function clear_error_field() {
            $('#error_name').text('');
            $('#error_holiday_date').text('');
        }

        function disableButton() {
            var btn = document.getElementById('form_submission_button');
            btn.disabled = true;
            btn.innerText = 'Saving....';
        }

        function enableeButton() {
            var btn = document.getElementById('form_submission_button');
            btn.disabled = false;
            btn.innerText = 'Save'
        }

        function error_notification(message) {
            var notify = $.notify('<i class="fa fa-bell-o"></i><strong>' + message + '</strong> ', {
                type: 'theme',
                allow_dismiss: true,
                delay: 2000,
                showProgressbar: true,
                timer: 300
            });
        }
    </script> --}}
@endpush
