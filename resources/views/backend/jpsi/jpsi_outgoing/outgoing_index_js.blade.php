<script>
    // alert('123')
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
                url: "{{ url('admin/outgoing_jpsi/all_data') }}",
                type: 'post',
                data: function(d) {
                    d._token = '{{ csrf_token() }}'
                }
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    searchable: true
                },
                {
                    data: 'reference_no',
                    name: 'reference_no',

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
                    data: 'received_date',
                    name: 'received_date',
                },
                {
                    data: 'section_name',
                    name: 'section_name',
                },
                {
                    data: 'provationally_status',
                    name: 'provationally_status',
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
