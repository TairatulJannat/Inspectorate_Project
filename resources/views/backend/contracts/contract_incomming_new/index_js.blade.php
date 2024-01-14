<script>
    $(document).ready(function() {
        $('.select2').select2();

        // Start:: All Data
        $(function() {
            var table = $('.contract-datatable').DataTable({
                searching: true,
                "order": [
                    [0, 'desc']
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
                    url: "{{ url('admin/contract/get-all-data') }}",
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    data: function(d) {
                        d._token = '{{ csrf_token() }}'
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: true,
                        searchable: false
                    },
                    {
                        data: 'ltr_no_of_contract',
                        name: 'ltr_no_of_contract',
                        orderable: false
                    },
                    {
                        data: 'ltr_date_contract',
                        name: 'ltr_date_contract',
                        orderable: false
                    },
                    {
                        data: 'contract_no',
                        name: 'contract_no',
                        orderable: false
                    },
                    {
                        data: 'contract_date',
                        name: 'contract_date',
                        orderable: false
                    },
                    {
                        data: 'contract_state',
                        name: 'contract_state',
                        orderable: false
                    },
                    {
                        data: 'con_fin_year',
                        name: 'con_fin_year',
                        orderable: false
                    },
                    {
                        data: 'supplier_id',
                        name: 'supplier_id',
                        orderable: false
                    },
                    {
                        data: 'contracted_value',
                        name: 'contracted_value',
                        orderable: false
                    },
                    {
                        data: 'delivery_schedule',
                        name: 'delivery_schedule',
                        orderable: false
                    },
                    {
                        data: 'currency_unit',
                        name: 'currency_unit',
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
                        orderable: false
                    },
                ],
                dom: 'lBfrtip',
                buttons: ['excel', 'csv', 'pdf', 'copy'],
            });

            $('#search_form').on('submit', function(event) {
                event.preventDefault();
                table.draw(true);
            });
        });
        // End:: All Data

        // Start:: save information
        $('#store-contract').off().on("submit", function(e) {
            e.preventDefault();
            var form = this;
            disableButton();
            clearErrorFields();
            $.ajax({
                // dataType: "JSON",
                url: "{{ url('admin/contract/store') }}",
                type: "POST",
                data: new FormData(form),
                processData: false,
                contentType: false,
                cache: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                success: function(response) {
                    enableButton();

                    if (response.isSuccess == true) {
                        $(form)[0].reset();
                        Swal.fire(
                            'Created!',
                            'Contract saved successfully!',
                            'success'
                        )
                        toastr.success(response.Message);
                        setTimeout(function() {
                            window.location.href =
                                "{{ url('admin/contract/index') }}";
                        }, 4000);
                    } else if (response.isSuccess == false) {
                        toastr.error(response.Message);
                    }
                },
                error: function(response) {
                    enableButton();
                    clearErrorFields();
                    errorNotification('Please fill out the form correctly and try again!');

                    $('#error-admin-section').text(response.responseJSON.errors[
                        'admin-section']);
                    $('#error-sender').text(response.responseJSON.errors.sender);
                    $('#error-ltr-no-contract').text(response.responseJSON.errors[
                        'ltr-no-contract']);
                    $('#error-ltr-date-contract').text(response.responseJSON.errors[
                        'ltr-date-contract']);
                    $('#error-contract-reference-no').text(response.responseJSON.errors[
                        'contract-reference-no']);
                    $('#error-contract-number').text(response.responseJSON.errors[
                        'contract-number']);
                    $('#error-contract-date').text(response.responseJSON.errors[
                        'contract-date']);
                    $('#error-received-by').text(response.responseJSON.errors[
                        'received-by']);
                }
            });
        });
        // End:: save information

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
                                    $('.yajra-datatable').DataTable().ajax.reload(null,
                                        false);
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

        function clearErrorFields() {
            $('.error-field').text("");
        }

        function disableButton() {
            var btn = document.getElementById('form_submission_button');
            btn.disabled = true;
            btn.innerText = 'Saving...';
        }

        function enableButton() {
            var btn = document.getElementById('form_submission_button');
            btn.disabled = false;
            btn.innerText = 'Save';
        }

        function errorNotification(message) {
            var notify = $.notify('<i class="fa fa-bell-o"></i><strong>' + message + '</strong> ', {
                type: 'danger',
                allow_dismiss: true,
                delay: 2000,
                showProgressbar: true,
                timer: 300
            });
        }
    });

    document.addEventListener('DOMContentLoaded', function() {
        flatpickr('.flatpickr', {
            wrap: true,
            altInput: true,
            altFormat: "d/m/Y",
            dateFormat: "Y-m-d",
            allowInput: false,
            // minDate: 'today',
            // maxDate: new Date().fp_incr(7),
        });
    });
</script>
