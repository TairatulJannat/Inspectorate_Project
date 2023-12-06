@extends('backend.app')
@section('title', 'Hall Pricing Managemnent')
@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend/css/datatables.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend/css/select2.css') }}">
@endpush
@section('main_menu', 'Hall Pricing')
@section('active_menu', 'Edit Hall Pricing')
@section('content')
    <div class="col-sm-12 col-xl-8">
        <div class="card">
            <form action="" id="update_form" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="row">

                        <input type="hidden" name="edit_id" value="{{ $hallPrice->id }}">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="hall_id">Hall</label>
                                <select class="form-control" id="hall_id" name="hall_id">
                                    <option value="">Please Select Hall</option>
                                    @if ($hall)
                                        @foreach ($hall as $id => $name)
                                            <option value="{{ $id }}"
                                                {{ $hallPrice->hall_id == $id ? 'selected' : '' }}>
                                                {{ $name }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                                <span id="error_hall_id" class="text-danger error_field"></span>
                            </div>
                        </div>

                        <div class="col-md-6">
                            {{-- <div class="form-group">
                                <label for="floor_id">Floor</label>
                                <select class="form-control" id="floor_id" name="floor_id">
                                    <option value="">Please Select Floor</option>
                                    @if ($floor)
                                        @foreach ($floor as $id => $name)
                                            <option value="{{ $id }}"
                                                {{ $hallPrice->floor_id == $id ? 'selected' : '' }}>
                                                {{ $name }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                                <span id="error_floor_id" class="text-danger error_field"></span>
                            </div> --}}
                            <div class="mb-2">
                                <label class="">Floor</label>
                                <select class="js-example-basic-multiple col-sm-12 select2" name="floor_id[]"
                                    multiple="multiple" id="floor_id">
                                    @if ($floor)
                                        @foreach ($floor as $id => $name)
                                            <option value="{{ $id }}"
                                                {{ in_array($id, $floor_id) ? 'selected' : '' }}>{{ $name }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                                <span id="error_floor_id" class="text-danger error_field"></span>
                            </div>
                        </div>

                        <div class="col-md-6">
                            {{-- <div class="form-group">
                                <label for="user_category_id">User Category</label>
                                <select class="form-control" id="user_category_id" name="user_category_id">
                                    <option value="">Please Select User Category</option>
                                    @if ($userCategory)
                                        @foreach ($userCategory as $id => $name)
                                            <option value="{{ $id }}"
                                                {{ $hallPrice->user_category_id == $id ? 'selected' : '' }}>
                                                {{ $name }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                                <span id="error_user_category_id" class="text-danger error_field"></span>
                            </div> --}}

                            <div class="mb-2 mt-2">
                                <label class="">User Category</label>
                                <select class="js-example-basic-multiple col-sm-12 select2" name="user_category_id[]"
                                    multiple="multiple" id="user_category_id">
                                    @if ($userCategory)
                                        @foreach ($userCategory as $id => $name)
                                            <option value="{{ $id }}"
                                                {{ in_array($id, $user_category_id) ? 'selected' : '' }}>
                                                {{ $name }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                                <span id="error_user_category_id" class="text-danger error_field"></span>
                            </div>
                        </div>

                        <div class="col-md-6 m-t-10">
                            <div class="form-group shift-container">
                                {{-- style="{{ $hallPrice->specify_shift_charge == 'on' ? '' : 'display: none' }}"> --}}
                                <label for="shift_id">Shift</label>
                                <select class="form-control" id="shift_id" name="shift_id">
                                    <option value="">Please Select Shift</option>
                                    @if ($shift)
                                        @foreach ($shift as $id => $name)
                                            <option value="{{ $id }}"
                                                {{ $hallPrice->shift_id == $id ? 'selected' : '' }}>
                                                {{ $name }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                                <span id="error_shift_id" class="text-danger error_field"></span>
                            </div>
                        </div>

                        <div class="col-md-6 m-t-20">
                            <div class="media">
                                <label class="col-form-label m-r-10">Specify Event</label>
                                <div class="media-body text-end">
                                    <label class="switch">
                                        <input type="checkbox" name="specify_event" id="specify_event"
                                            {{ $hallPrice->specify_event == 'on' ? 'checked' : '' }}>
                                        <span class="switch-state"></span>
                                    </label>
                                </div>
                                <span id="error_specify_event" class="text-danger error_field"></span>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group event-name-container"
                                style="{{ $hallPrice->specify_event == 'on' ? '' : 'display: none' }}">
                                <label class="control-label">Event Name</label>
                                <input class="form-control" type="text" name="event_name" placeholder="Enter event name"
                                    value="{{ $hallPrice->event_name ?? '' }}">
                                <span id="error_event_name" class="text-danger error_field"></span>
                            </div>
                        </div>

                        <div class="col-md-12"></div>
                        <div class="col-md-6 m-t-40">
                            <div class="media">
                                <label class="col-form-label m-r-10">Specify Month</label>
                                <div class="media-body text-end">
                                    <label class="switch">
                                        <input type="checkbox" name="specify_month" id="specify_month"
                                            {{ $hallPrice->specify_month == 'on' ? 'checked' : '' }}>
                                        <span class="switch-state"></span>
                                    </label>
                                </div>
                                <span id="error_specify_month" class="text-danger error_field"></span>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-2 months-container"
                                style="{{ $hallPrice->specify_month == 'on' ? '' : 'display: none' }}">
                                <label class="col-form-label">Month</label>
                                <select class="js-example-basic-multiple col-sm-12 select2" name="months[]"
                                    multiple="multiple">
                                    <option value="January" {{ in_array('January', $months) ? 'selected' : '' }}>
                                        January
                                    </option>
                                    <option value="February" {{ in_array('February', $months) ? 'selected' : '' }}>
                                        February
                                    </option>
                                    <option value="March" {{ in_array('March', $months) ? 'selected' : '' }}>
                                        March
                                    </option>
                                    <option value="April" {{ in_array('April', $months) ? 'selected' : '' }}>
                                        April
                                    </option>
                                    <option value="May" {{ in_array('May', $months) ? 'selected' : '' }}>
                                        May
                                    </option>
                                    <option value="June" {{ in_array('June', $months) ? 'selected' : '' }}>
                                        June
                                    </option>
                                    <option value="July" {{ in_array('July', $months) ? 'selected' : '' }}>
                                        July
                                    </option>
                                    <option value="August" {{ in_array('August', $months) ? 'selected' : '' }}>
                                        August
                                    </option>
                                    <option value="September" {{ in_array('September', $months) ? 'selected' : '' }}>
                                        September
                                    </option>
                                    <option value="October" {{ in_array('October', $months) ? 'selected' : '' }}>
                                        October
                                    </option>
                                    <option value="November" {{ in_array('November', $months) ? 'selected' : '' }}>
                                        November
                                    </option>
                                    <option value="December" {{ in_array('December', $months) ? 'selected' : '' }}>
                                        December
                                    </option>
                                </select>
                                <span id="error_months" class="text-danger error_field"></span>
                            </div>
                        </div>

                        <div class="col-md-12"></div>
                        <div class="col-md-6 m-t-40">
                            <div class="media">
                                <label class="col-form-label m-r-10">Specify Ramadan</label>
                                <div class="media-body text-end">
                                    <label class="switch">
                                        <input type="checkbox" name="specify_ramadan" id="specify_ramadan"
                                            {{ $hallPrice->specify_ramadan == 'on' ? 'checked' : '' }}>
                                        <span class="switch-state"></span>
                                    </label>
                                </div>
                                <span id="error_specify_ramadan" class="text-danger error_field"></span>
                            </div>
                        </div>

                        <div class="col-md-12"></div>
                        <div class="col-md-6 m-t-40">
                            <div class="media">
                                <label class="col-form-label m-r-10">Specify Holiday</label>
                                <div class="media-body text-end">
                                    <label class="switch">
                                        <input type="checkbox" name="specify_holiday" id="specify_holiday"
                                            {{ $hallPrice->specify_holiday == 'on' ? 'checked' : '' }}>
                                        <span class="switch-state"></span>
                                    </label>
                                </div>
                                <span id="error_specify_holiday" class="text-danger error_field"></span>
                            </div>
                        </div>

                        <div class="col-md-12"></div>
                        {{-- <div class="col-md-6 m-t-40">
                            <div class="media">
                                <label class="col-form-label m-r-10">Specify Shift Charge</label>
                                <div class="media-body text-end">
                                    <label class="switch">
                                        <input type="checkbox" name="specify_shift_charge" id="specify_shift_charge"
                                            {{ $hallPrice->specify_shift_charge == 'on' ? 'checked' : '' }}>
                                        <span class="switch-state"></span>
                                    </label>
                                </div>
                            </div>
                            <span id="error_specify_shift_charge" class="text-danger error_field"></span>
                        </div> --}}

                        <div class="col-md-6 m-t-30">
                            <div class="form-group">
                                <label class="control-label">Price</label>
                                <input class="form-control" type="number" name="price"
                                    value="{{ $hallPrice->price ?? '' }}" placeholder="Enter booking price (taka)">
                                <span id="error_price" class="text-danger error_field"></span>
                            </div>
                        </div>

                        <div class="col-md-6 m-t-30">
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select class="form-control" id="status" name="status">
                                    <option value="1" {{ $hallPrice->status == '1' ? 'selected' : '' }}>
                                        Active
                                    </option>
                                    <option value="0"{{ $hallPrice->status == '0' ? 'selected' : '' }}>
                                        Inactive
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-end">
                    <div class="col-sm-9 offset-sm-3">
                        <a href="{{ route('admin.hall_price') }}" type="button" class="btn btn-secondary">Cancel</a>
                        <button class="btn btn-primary" type="submit" id="form_submission_button">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@push('js')
    <script>
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
    </script>
    <script src="{{ asset('assets/backend/js/select2/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/backend/js/datatable/datatables/plugin/datatables.min.js') }}"></script>
    <script src="https://unpkg.com/sweetalert2@7.19.1/dist/sweetalert2.all.js"></script>
    <script src="{{ asset('assets/backend/js/select2/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/backend/js/notify/bootstrap-notify.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2();
        });

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
    </script>
@endpush
