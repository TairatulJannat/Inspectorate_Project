@extends('backend.app')
@section('title', 'I-Note edit')
@push('css')
    <style>
        .inote_boc {
            width: 100%;
            min-height: 600px;
            background-color: white
        }

        .header-box .title,
        .body-box .title {
            display: flex;
            justify-content: center;
            padding: 5px;
            margin: 5px;
        }

        .header-box .content {
            display: flex;
            justify-content: end;
        }

        .body-box .content {
            display: flex;
            justify-content: space-between;
        }
    </style>
@endpush
@section('main_menu', 'I-Note edit')
@section('active_menu', 'Layout')
@section('content')
    <div class="col-sm-12 col-xl-12">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="inote-tab" data-bs-toggle="tab" data-bs-target="#inote" type="button"
                    role="tab" aria-controls="inote" aria-selected="true">I-Note</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link " id="daviation-tab" data-bs-toggle="tab" data-bs-target="#daviation" type="button"
                    role="tab" aria-controls="daviation" aria-selected="false">Daviation</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="dpl5-tab" data-bs-toggle="tab" data-bs-target="#dpl5" type="button"
                    role="tab" aria-controls="dpl5" aria-selected="false">DPL-15</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="anx-tab" data-bs-toggle="tab" data-bs-target="#anx" type="button"
                    role="tab" aria-controls="anx" aria-selected="false">ANX </button>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            {{-- inote start here --}}
            <div class="tab-pane fade show active" id="inote" role="tabpanel" aria-labelledby="inote-tab">
                @include('backend.inote.all_inote_letter.inote_edit')
            </div>
            {{-- inote end here --}}
            {{--  daviation start here --}}
            <div class="tab-pane fade" id="daviation" role="tabpanel" aria-labelledby="daviation-tab">
                @include('backend.inote.all_inote_letter.deviation_edit')
            </div>
            {{--  daviation end here --}}

            {{-- dpl5 start here --}}
            <div class="tab-pane fade" id="dpl5" role="tabpanel" aria-labelledby="dpl5-tab">
                @include('backend.inote.all_inote_letter.dpl_15_edit')
            </div>
            {{-- dpl5 end here --}}
            {{-- ANX start here --}}
            <div class="tab-pane fade" id="anx" role="tabpanel" aria-labelledby="anx-tab">
                @include('backend.inote.all_inote_letter.anx_edit')
            </div>
            {{-- dANXpl5 end here --}}
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
        $('#saveInote').off().on('submit', function(event) {
            event.preventDefault();
            disableButton()
            var formData = new FormData($('#saveInote')[0]);

            $.ajax({
                url: "{{ url('admin/inote_letter/store') }}",
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
                        toastr.success('Information Saved', 'Saved');
                    }
                    var $active = $('.nav-tabs .nav-link.active');
                    var $next = $active.parent().next().find('.nav-link');

                    if ($next.length > 0) {
                        $next.tab('show');
                    }

                },
                error: function(response) {
                    enableeButton()
                    clear_error_field();
                    error_notification('Please fill up the form correctly and try again')
                    $('#error_sender').text(response.responseJSON.errors.sender);
                    $('#error_reference_no').text(response.responseJSON.errors.reference_no);
                    $('#error_inote_received_date').text(response.responseJSON.errors
                        .inote_received_date);
                    $('#error_inote_reference_date').text(response.responseJSON.errors
                        .inote_reference_date);

                }
            });
        })


        $('#saveDeviation').off().on('submit', function(event) {
            event.preventDefault();
            disableButton()
            var formData = new FormData($('#saveDeviation')[0]);

            $.ajax({
                url: "{{ url('admin/inote_deviation_letter/store') }}",
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
                        toastr.success('Information Saved', 'Saved');
                    }

                    var $active = $('.nav-tabs .nav-link.active');
                    var $next = $active.parent().next().find('.nav-link');

                    if ($next.length > 0) {
                        $next.tab('show');
                    }

                },
                error: function(response) {
                    enableeButton()
                    clear_error_field();
                    error_notification('Please fill up the form correctly and try again')
                    // $('#error_sender').text(response.responseJSON.errors.sender);
                    // $('#error_reference_no').text(response.responseJSON.errors.reference_no);
                    // $('#error_inote_received_date').text(response.responseJSON.errors
                    //     .inote_received_date);
                    // $('#error_inote_reference_date').text(response.responseJSON.errors
                    //     .inote_reference_date);

                }
            });
        })

        $('#saveDPL').off().on('submit', function(event) {
            event.preventDefault();
            disableButton()
            var formData = new FormData($('#saveDPL')[0]);

            $.ajax({
                url: "{{ url('admin/inote_dpl_letter/store') }}",
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
                        toastr.success('Information Saved', 'Saved');
                    }
                    var $active = $('.nav-tabs .nav-link.active');
                    var $next = $active.parent().next().find('.nav-link');

                    if ($next.length > 0) {
                        $next.tab('show');
                    }

                },
                error: function(response) {
                    enableeButton()
                    clear_error_field();
                    error_notification('Please fill up the form correctly and try again')
                    // $('#error_sender').text(response.responseJSON.errors.sender);
                    // $('#error_reference_no').text(response.responseJSON.errors.reference_no);
                    // $('#error_inote_received_date').text(response.responseJSON.errors
                    //     .inote_received_date);
                    // $('#error_inote_reference_date').text(response.responseJSON.errors
                    //     .inote_reference_date);

                }
            });
        })

        
        //start update inote file
        $('#updateInote').off().on('submit', function(event) {
            event.preventDefault();
            var formData = new FormData($('#updateInote')[0]);
            disableButton()
            $.ajax({
                url: "{{ url('admin/inote_letter/update') }}",
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
                        // enableeButton()
                        toastr.success('Information Updated', 'Saved');
                    }
                    setTimeout(window.location.href = "",
                        2000);
                },
                error: function(response) {
                    enableeButton()
                    clear_error_field();
                    error_notification('Please fill up the form correctly and try again')
                    if (response.responseJSON && response.responseJSON.errors) {
                        // Iterate over the validation errors and display them
                        $.each(response.responseJSON.errors, function(key, value) {

                            var errorSpanId = key + '_error';

                            $('.' + errorSpanId).text(value[
                                0]); // Assuming you want to display only the first error
                        });
                    }


                }
            });
        })



        $('#updateDeviation').off().on('submit', function(event) {
            event.preventDefault();
            var formData = new FormData($('#updateDeviation')[0]);
            disableButton()
            $.ajax({
                url: "{{ url('admin/inote_letter_deviation/update') }}",
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
                        // enableeButton()
                        toastr.success('Information Updated', 'Saved');
                    }
                    setTimeout(window.location.href = "",
                        2000);
                },
                error: function(response) {
                    enableeButton()
                    clear_error_field();
                    error_notification('Please fill up the form correctly and try again')
                    if (response.responseJSON && response.responseJSON.errors) {
                        // Iterate over the validation errors and display them
                        $.each(response.responseJSON.errors, function(key, value) {

                            var errorSpanId = key + '_error';

                            $('.' + errorSpanId).text(value[
                                0]); // Assuming you want to display only the first error
                        });
                    }


                }
            });
        })

        $('#updateDPL').off().on('submit', function(event) {
            event.preventDefault();
            var formData = new FormData($('#updateDPL')[0]);
            disableButton()
            $.ajax({
                url: "{{ url('admin/inote_letter_dpl15/update') }}",
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
                        // enableeButton()
                        toastr.success('Information Updated', 'Saved');
                    }
                    setTimeout(window.location.href = "",
                        2000);
                },
                error: function(response) {
                    enableeButton()
                    clear_error_field();
                    error_notification('Please fill up the form correctly and try again')
                    if (response.responseJSON && response.responseJSON.errors) {
                        // Iterate over the validation errors and display them
                        $.each(response.responseJSON.errors, function(key, value) {

                            var errorSpanId = key + '_error';

                            $('.' + errorSpanId).text(value[
                                0]); // Assuming you want to display only the first error
                        });
                    }


                }
            });
        })

        //end update inote file
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
        $('.detailsUpload').click(function(e) {
            e.preventDefault();

            var inoteLetterDetailsID = $(this).data('detailsid');
            var noteLetterID = $(this).data('letterid');

            // Initialize an empty object to store the values

            // Iterate over each input element in the form
            var serial_1_value = $(' #serial_1_' + inoteLetterDetailsID).val();
            var serial_2to4_value = $('#serial_2to4_' + inoteLetterDetailsID).val();
            var serial_5_value = $(' #serial_5_' + inoteLetterDetailsID).val();
            var serial_6_value = $(' #serial_6_' + inoteLetterDetailsID).val();
            var serial_7_value = $(' #serial_7_' + inoteLetterDetailsID).val();
            var serial_8_value = $(' #serial_8_' + inoteLetterDetailsID).val();
            var serial_9_value = $(' #serial_9_' + inoteLetterDetailsID).val();
            var serial_10_value = $(' #serial_10_' + inoteLetterDetailsID).val();
            var serial_11_value = $(' #serial_11_' + inoteLetterDetailsID).val();
            var serial_12_value = $(' #serial_12_' + inoteLetterDetailsID).val();
            var serial_13_value = $(' #serial_13_' + inoteLetterDetailsID).val();
            var body_info_value = $(' #body_info_' + inoteLetterDetailsID).val();

            var formData = {
                inoteLetterDetailsID: inoteLetterDetailsID,
                noteLetterID: noteLetterID,
                serial_1: serial_1_value,
                serial_2to4: serial_2to4_value,
                serial_5: serial_5_value,
                serial_6: serial_6_value,
                serial_7: serial_7_value,
                serial_8: serial_8_value,
                serial_9: serial_9_value,
                serial_10: serial_10_value,
                serial_11: serial_11_value,
                serial_12: serial_12_value,
                serial_13: serial_13_value,
                body_info: body_info_value
            };

            // Now formData object contains all the input values
            console.log(formData);

            // Make your AJAX call with the formData object
            $.ajax({
                url: '{{ url('admin/inote_letter_details/update') }}',
                method: 'POST',
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                success: function(response) {
                    if (response.error) {
                        error_notification(response.error)
                        enableeButton()
                    }
                    if (response.success) {
                        // enableeButton()
                        toastr.success('Information Updated', 'Updated');
                    }
                    setTimeout(function() {
                        window.location.reload();
                    }, 2000);
                },
                error: function(response) {
                    enableeButton()
                    clear_error_field();
                    error_notification('Please fill up the form correctly and try again')
                    if (response.responseJSON && response.responseJSON.errors) {
                        // Iterate over the validation errors and display them
                        $.each(response.responseJSON.errors, function(key, value) {

                            var errorSpanId = key + '_error';

                            $('.' + errorSpanId).text(value[
                                0]); // Assuming you want to display only the first error
                        });
                    }


                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            // Next button click event
            $("#nextBtn").click(function(e) {
                e.preventDefault()
                var $active = $('.nav-tabs .nav-link.active');
                var $next = $active.parent().next().find('.nav-link');

                if ($next.length > 0) {
                    $next.tab('show');
                }
            });

            // Previous button click event
            $("#prevBtn").click(function(e) {
                e.preventDefault()
                var $active = $('.nav-tabs .nav-link.active');
                var $prev = $active.parent().prev().find('.nav-link');

                if ($prev.length > 0) {
                    $prev.tab('show');
                }
            });
        });
    </script>
@endpush
