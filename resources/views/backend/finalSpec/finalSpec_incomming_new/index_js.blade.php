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

                url: "{{ url('admin/finalspec/all_data') }}",
                type: 'GET',
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
                    data: 'item_name',
                    name: 'item_id',
                   
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
    $('#save_info').off().on('submit', function(event) {
        event.preventDefault();

        var formData = new FormData($('#save_info')[0]);


        disableButton()
        $.ajax({
            url: "{{ url('admin/finalspec/store') }}",
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
                setTimeout(window.location.href = "{{ route('admin.FinalSpec/view') }}", 40000);
            },
            error: function(response) {
                enableeButton()
                clear_error_field();
                error_notification('Please fill up the form correctly and try again')
                $('#error_sender').text(response.responseJSON.errors.sender);
                $('#error_reference_no').text(response.responseJSON.errors.reference_no);
                $('#error_spec_type').text(response.responseJSON.errors.spec_type);
                $('#error_additional_documents').text(response.responseJSON.errors
                    .additional_documents);
                $('#error_item_type_id').text(response.responseJSON.errors.item_type_id);
                $('#error_spec_received_date').text(response.responseJSON.errors
                    .spec_received_date);
                $('#error_estimated_value').text(response.responseJSON.errors
                    .estimated_value);
                $('#error_qty').text(response.responseJSON.errors
                    .qty);
                $('#error_indent_received_date').text(response.responseJSON.errors
                    .indent_received_date);

            }
        });
    })
    // End:: save information

    
    

    function form_reset() {
        document.getElementById("search_form").reset();
        $('.select2').val(null).trigger('change');
        $('.yajra-datatable').DataTable().ajax.reload(null, false);
    }

    function clear_error_field() {
        $('#error_sender').text("");
        $('#error_reference_no').text("");
        $('#error_spec_type').text("");
        $('#error_additional_documents').text("");
        $('#error_item_type_id').text("");
        $('#error_spec_received_date').text("");
        $('#error_estimated_value').text("");
        $('#error_qty').text("");
        $('#error_qty').text("");
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
