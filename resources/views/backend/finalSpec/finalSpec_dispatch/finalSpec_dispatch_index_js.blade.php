<script>
    $(document).ready(function() {
        $('.select2').select2();
    });


    // Start:: All Data
    $(function() {
        var table = $('.yajra-datatable').DataTable({
            searching: true,
            "order": [
                [1, 'desc']
            ],
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

                url: "{{ url('admin/FinalSpec_dispatch/all_data') }}",
                type: 'Post',
                data: function(d) {
                    d._token = '{{ csrf_token() }}'
                }
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                   
                },
                {
                    data: 'reference_no',
                    name: 'reference_no',
                   
                },
                {
                    data: 'offer_reference_no',
                    name: 'offer_reference_no',
                   
                },
                {
                    data: 'item_type_name',
                    name: 'item_type_id',
                   
                },
                {
                    data: 'dte_managment_name',
                    name: 'sender',
                    
                },


                {
                    data: 'final_spec_receive_Ltr_dt',
                    name: 'final_spec_receive_Ltr_dt',
                    
                },
                {
                    data: 'section_name',
                    name: 'section_name',
                    
                },

                {
                    data: 'status',
                    name: 'status',
                   
                },

                {
                    data: 'action',
                    name: 'action',
                   
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
