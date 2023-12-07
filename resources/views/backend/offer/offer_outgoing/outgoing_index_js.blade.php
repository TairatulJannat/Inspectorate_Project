<script>
    // alert('123')
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
                url: "{{ url('admin/outgoing_offer/all_data') }}",
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
                    orderable: false
                },
                {
                    data: 'tender_reference_no',
                    name: 'tender_reference_no',
                    orderable: false
                },
                {
                    data: 'item_type_name',
                    name: 'item_type_id',
                    orderable: false
                },
                {
                    data: 'dte_managment_name',
                    name: 'sender',
                    orderable: false
                },


                {
                    data: 'offer_rcv_ltr_dt',
                    name: 'offer_rcv_ltr_dt',
                    orderable: false
                },
                {
                    data: 'section_name',
                    name: 'section_name',
                    orderable: false
                },
                {
                    data: 'qty',
                    name: 'qty',
                    orderable: false
                },

                {
                    data: 'status',
                    name: 'status',
                    orderable: false
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
