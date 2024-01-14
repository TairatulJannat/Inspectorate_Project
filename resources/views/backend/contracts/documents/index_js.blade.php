<script>
    $(document).ready(function() {
        $('.select2').select2();

        toastr.options.preventDuplicates = true;

        const $receiveStatus = $('#receiveStatus');
        const $receiveDateContainer = $('#receiveDateContainer');
        const $askingDateContainer = $('#askingDateContainer');

        $askingDateContainer.hide();

        $receiveStatus.on('change', function() {
            if ($receiveStatus.is(':checked')) {
                $receiveDateContainer.show();
                $askingDateContainer.hide();
            } else {
                $receiveDateContainer.hide();
                $askingDateContainer.show();
            }
        });

        // Get All Data
        $(function() {
            var table = $('.contract-doc-datatable').DataTable({
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
                    url: "{{ url('admin/contract/get-all-data-doc') }}",
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    data: function(d) {
                        d._token = '{{ csrf_token() }}',
                            d.contractId = '{{ $contractId }}';
                    },
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: true,
                        searchable: false
                    },
                    {
                        data: 'additional_documents_name',
                        name: 'additional_documents_name',
                        orderable: false
                    },
                    {
                        data: 'duration',
                        name: 'duration',
                        orderable: false
                    },
                    {
                        data: 'receive_status',
                        name: 'receive_status',
                        orderable: false
                    },
                    {
                        data: 'receive_date',
                        name: 'receive_date',
                        orderable: false
                    },
                    {
                        data: 'asking_date',
                        name: 'asking_date',
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

        // Start:: Create Contract Doc
        $('#store-contract-doc').off().on("submit", function(e) {
            e.preventDefault();
            var form = this;
            disableButton();
            clearErrorFields();
            $.ajax({
                // dataType: "JSON",
                url: "{{ url('admin/contract/store-doc') }}",
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
                        toastr.success(response.Message);
                        $('#createContractModal').modal('hide');
                        resetForm()
                    } else if (response.isSuccess == false) {
                        toastr.error(response.Message);
                    }
                },
                error: function(response) {
                    enableButton();
                    clearErrorFields();
                    errorNotification('Please fill out the form correctly and try again!');

                    $('#errorAdditionalDocTypeId').text(response.responseJSON.errors
                        .additionalDocTypeId);
                    $('#errorDuration').text(response.responseJSON.errors.duration);
                    $('#errorMember').text(response.responseJSON.errors.member);
                }
            });
        });
        // End:: save information

        function resetForm() {
            document.getElementById("store-contract-doc").reset();
            $('.select2').val(null).trigger('change');
            $('.contract-doc-datatable').DataTable().ajax.reload(null, false);
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

        // // Edit Item Type
        $(document).on('click', '.edit_doc', function(e) {
            e.preventDefault();

            var id = $(this).data('id');

            $.ajax({
                url: "{{ url('admin/contract/edit-doc') }}/" + id,
                method: 'get',
                data: {
                    id: id,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {

                    $("#edit_item_type_id").val(id);
                    $("#editItemTypeName").val(response.name);
                    $("#editItemTypeStatus").prop('checked', response.status == 1);

                    $('#editItemTypeModal').modal('show');
                }
            });
        });

        // // Update Item Type
        // $("#update_info").on("submit", function(e) {
        //     e.preventDefault();
        //     var form = this;
        //     var editButton = $("#editButton");
        //     editButton.prop('disabled', true).text('Updating...');
        //     $.ajax({
        //         url: $(form).attr('action'),
        //         method: $(form).attr('method'),
        //         data: new FormData(form),
        //         processData: false,
        //         dataType: "JSON",
        //         contentType: false,
        //         cache: false,
        //         beforeSend: function() {
        //             $(form).find("span.error-text").text("");
        //         },
        //         success: function(response) {
        //             if (response.isSuccess === false) {
        //                 $.each(response.error, function(prefix, val) {
        //                     $(form).find("span." + prefix + "_error").text(val[0]
        //                         .replace("edit ", ""));
        //                 });
        //                 toastr.error(response.Message);
        //                 editButton.prop('disabled', false).text('Update');
        //             } else if (response.isSuccess === true) {
        //                 $(form)[0].reset();
        //                 $("#editItemTypeModal").modal("hide");
        //                 Swal.fire(
        //                     'Updated!',
        //                     'Item Type Edited Successfully!',
        //                     'success'
        //                 )
        //                 toastr.success(response.Message);
        //                 editButton.prop('disabled', false).text('Update');

        //                 // Reload the DataTable
        //                 $('.yajra-datatable').DataTable().ajax.reload();
        //             }
        //         },
        //         error: function(error) {
        //             console.log('Error:', error);
        //             toastr.error('An error occurred while processing the request.');
        //             editButton.prop('disabled', false).text('Update');
        //         },
        //     });
        // });

        // Delete Item Type ajax request


        // // Show Item Type
        // $(document).on('click', '.show_item_type', function(e) {
        //     e.preventDefault();
        //     let id = $(this).attr('id');
        //     $.ajax({
        //         url: '{{ url('admin/item_types/show') }}',
        //         method: 'post',
        //         data: {
        //             id: id,
        //             _token: '{{ csrf_token() }}'
        //         },
        //         success: function(response) {
        //             $("#showItemTypeName").text(response.name);
        //             $("#showItemTypeStatus").prop('checked', response.status == 1);

        //             $('#showItemTypeModal').modal('show');
        //         }
        //     });
        // });


    });

    function deleteData(id) {
        swal({
            title: 'Are you sure?',
            text: "You want to delete this record!",
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, cancel!',
            confirmButtonClass: 'btn btn-danger',
            cancelButtonClass: 'btn btn-success',
        }).then((result) => {
            if (result.value) {
                event.preventDefault();
                $.ajax({
                    type: 'post',
                    url: '{{ url('admin/contract/destroy-doc') }}/' + id,
                    data: {
                        id: id,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.isSuccess) {
                            toastr.success(response.Message, 'Deleted');
                            $('.contract-doc-datatable').DataTable().ajax.reload(null, false);
                        } else {
                            toastr.error('Something went wrong!', 'Error');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        toastr.error('An error occurred while processing your request', 'Error');
                    }
                });
            } else if (
                result.dismiss === swal.DismissReason.cancel
            ) {
                swal(
                    'Cancelled',
                    'Your record is safe!',
                    'error'
                )
            }
        })
    }

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
