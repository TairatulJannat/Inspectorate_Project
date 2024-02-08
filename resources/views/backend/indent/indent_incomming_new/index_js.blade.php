<script>
    $(document).ready(function() {
        $('.select2').select2();
    });


    // Start:: All Data
    $(function() {
        var table = $('.yajra-datatable').DataTable({
            searching: true,
            
            "bFilter": false,
            "columnDefs": [{
                "className": "dt-center",
                "targets": "_all"
            }],
            "bDestroy": true,
            processing: true,
            serverSide: true,
            "language": {
                processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span>'
            },
            drawCallback: function(settings) {
                var api = this.api();
                $('#total_data').html(api.ajax.json().recordsTotal);
            },
            ajax: {

                url: "{{ url('admin/indent/all_data') }}",
                type: 'GET',
                data: function(d) {
                    d._token = '{{ csrf_token() }}'
                }
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    searchable: false
                },
                {
                    data: 'reference_no',
                    name: 'reference_no',

                },
                {
                    data: 'indent_number',
                    name: 'indent_number',

                },
                {
                    data: 'item_name',
                    name: 'item_name',

                },
                {
                    data: 'dte_managment_name',
                    name: 'sender',

                },


                {
                    data: 'indent_received_date',
                    name: 'indent_received_date',

                },
                {
                    data: 'section_name',
                    name: 'section_name',

                },
                {
                    data: 'qty',
                    name: 'qty',

                },

                {
                    data: 'status',
                    name: 'status',

                },

                {
                    data: 'action',
                    name: 'action',
                    orderable: true
                },

            ],
            dom: 'lBfrtip',
            buttons: [
                'excel', 'csv', 'pdf', 'copy'
            ],
        });
        $('#search_form').on('submit', function(event) {
            event.preventDefault();
            table.draw(true);
        });
    });
    // End:: All Data

    // Start:: save information
    $('#save_info').off().on('submit', function(event) {
        event.preventDefault();

        var formData = new FormData($('#save_info')[0]);

        disableButton()
        $.ajax({
            url: "{{ url('admin/indent/store') }}",
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
                    $('.modal-backdrop').remove();
                    $('.yajra-datatable').DataTable().ajax.reload(null, false);
                    toastr.success('Information Saved', 'Saved');
                }
                setTimeout(window.location.href = "{{ route('admin.indent/view') }}", 40000);
            },
            error: function(response) {
                enableeButton()
                clear_error_field();
                error_notification('Please fill up the form correctly and try again')
                // $('#error_sender').text(response.responseJSON.errors.sender);
                // $('#error_reference_no').text(response.responseJSON.errors.reference_no);
                // $('#admin_section').text(response.responseJSON.errors.admin_section);
                // $('#error_reference_no').text(response.responseJSON.errors.reference_no);

            }
        });
    })
    // End:: save information

    //Start:: Update information
    // $('#update_form').off().on('submit', function(event) {
    //     event.preventDefault();
    //     var formData = new FormData($('#update_form')[0]);

    //     disableButton()
    //     $.ajax({
    //         url: "{{ url('admin/hall_price/update') }}",
    //         type: "POST",
    //         data: formData,
    //         processData: false,
    //         contentType: false,
    //         headers: {
    //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
    //         },
    //         success: function(response) {
    //             if (response.error) {
    //                 error_notification(response.error)
    //                 enableeButton()
    //             }
    //             if (response.success) {
    //                 enableeButton()
    //                 $('.yajra-datatable').DataTable().ajax.reload(null, false);
    //                 toastr.success('Information Updated', 'Saved');
    //                 $('#edit_model').modal('hide');
    //             }
    //             setTimeout(window.location.href = "{{ route('admin.prelimgeneral/view') }}", 40000);
    //         },
    //         error: function(response) {
    //             enableeButton()
    //             clear_error_field();
    //             error_notification('Please fill up the form correctly and try again')
    //             // $('#error_hall_id').text(response.responseJSON.errors.hall_id);
    //             // $('#error_floor_id').text(response.responseJSON.errors.floor_id);
    //             // $('#error_user_category_id').text(response.responseJSON.errors.user_category_id);
    //             // $('#error_specify_event').text(response.responseJSON.errors.specify_event);
    //             // $('#error_event_name').text(response.responseJSON.errors.event_name);
    //             // $('#error_specify_month').text(response.responseJSON.errors.specify_month);
    //             // $('#error_months').text(response.responseJSON.errors.months);
    //             // $('#error_specify_ramadan').text(response.responseJSON.errors.specify_ramadan);
    //             // $('#error_specify_shift_charge').text(response.responseJSON.errors
    //             //     .specify_shift_charge);
    //             // $('#error_shift_id').text(response.responseJSON.errors.shift_id);
    //             // $('#error_price').text(response.responseJSON.errors.price);
    //             // $('#error_status').text(response.responseJSON.errors.status);
    //         }
    //     });
    // })
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
        $('#error_sender').text("");
        $('#error_reference_no').text("");

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
