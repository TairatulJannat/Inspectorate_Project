@extends('backend.app')
@section('title', 'Assign Section')
@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend/css/datatables.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend/css/select2.css') }}">
    <style>
        form select {
            padding: 10px
        }
    </style>
@endpush
@section('main_menu', 'Assign Section')
@section('active_menu', 'Add Assign Section')
@section('content')
    <div class="col-sm-12 col-xl-12">

        <div class="card">
            <form action="" method="POST" id="save_info" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="form-group">
                            <input type="hidden" id="admin_id" name="admin_id" value={{ $admin_id }}>
                        </div>
                        <div class="col-md-6">

                            <div class="form-group">
                                <label for="section_multiple">Select Section</label>
                                @if ($section)
                                    @foreach ($section as $s)
                                        <br> <input type="checkbox" value="{{ $s->id }}" id="sec_id"
                                            name="sec_id[]">
                                        {{ $s->name }}
                                    @endforeach
                                @endif
                                <br><span id="error_sec_id" class="text-danger error_field"></span>
                            </div>
                        </div>
                        <div class="col-md-4">

                            <div class="form-group">
                                <label for="designation">Designation</label>
                                <select class="form-control " id="desig_id" name="desig_id">

                                    <option value="">Please Select</option>
                                    @if ($designation)
                                        @foreach ($designation as $d)
                                            <option value="{{ $d->id }}">{{ $d->name }}</option>
                                        @endforeach
                                    @endif

                                </select>
                                <span id="error_desig_id" class="text-danger error_field"></span>
                            </div>
                        </div>



                    </div>
                </div>
                <div class="card-footer text-end">
                    <div class="col-sm-9 offset-sm-3">
                        <a href="{{ url('admin/all_user') }}" type="button" class="btn btn-secondary">Cancel</a>
                        <button class="btn btn-primary" type="submit" id="form_submission">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@push('js')
    <script src="{{ asset('assets/backend/js/select2/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/backend/js/datatable/datatables/plugin/datatables.min.js') }}"></script>
    <script src="https://unpkg.com/sweetalert2@7.19.1/dist/sweetalert2.all.js"></script>
    <script src="{{ asset('assets/backend/js/select2/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/backend/js/notify/bootstrap-notify.min.js') }}"></script>
    <script>
        $(document).ready(function() {

            $('#save_info').off().on('submit', function(event) {

                event.preventDefault();

                var formData = new FormData($('#save_info')[0]);

                // disableButton()
                $.ajax({
                    url: "{{ url('admin/store_assign_section') }}",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },
                    success: function(response) {
                        if (response.error) {
                            // error_notification(response.error)
                            // enableeButton()
                        }
                        if (response.success) {
                            // enableeButton()
                            // $('#add_model').modal('hide');
                            // $('.modal-backdrop').remove();
                            // $('.yajra-datatable').DataTable().ajax.reload(null, false);
                            toastr.success('Information Saved', 'Saved');
                        }
                        setTimeout(window.location.href = "{{ route('admin.all_user') }}",
                            40000);
                    },
                    error: function(response) {
                        // enableeButton()
                        // clear_error_field();
                        error_notification('Please fill up the form correctly and try again')
                        $('#error_desig_id').text(response.responseJSON.errors.desig_id);
                        $('#error_sec_id').text(response.responseJSON.errors.sec_id);

                    }
                });
            })

        });

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
