<script>
    $(document).ready(function() {
        const $receiveStatus = $('#receive_status');
        const $receiveDateContainer = $('#receiveDateContainer');
        const $askingDateContainer = $('#askingDateContainer');

        // Initially hide the Asking Date field
        $askingDateContainer.hide();

        $receiveStatus.on('change', function() {
            if ($receiveStatus.is(':checked')) {
                // If checkbox is checked, show Receive Date field and hide Asking Date field
                $receiveDateContainer.show();
                $askingDateContainer.hide();
            } else {
                // If checkbox is unchecked, hide Receive Date field and show Asking Date field
                $receiveDateContainer.hide();
                $askingDateContainer.show();
            }
        });
    });

    $(document).ready(function() {
        $('.select2').select2();

        toastr.options.preventDuplicates = true;

        // Get All Data
        $(function() {
            var table = $('.yajra-datatable').DataTable({
                searching: true,
                "order": [
                    [1, 'desc']
                ],
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
                    url: "{{ url('admin/indent/doc_status/all_data') }}",
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    data: function(d) {
                        d._token = '{{ csrf_token() }}',
                            d.indentId = '{{ $indentId }}';
                    },
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
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
                        orderable: true
                    },

                ],
                dom: 'lfrtip',
            });

            $('#search_form').on('submit', function(event) {
                event.preventDefault();
                table.draw(true);
            });
        });

        // Create doc
        $('#save_info').off().on('submit', function(event) {
            event.preventDefault();

            var formData = new FormData($('#save_info')[0]);
            $.ajax({
                url: "{{ url('admin/indent/doc_status/store') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                success: function(response) {
                    console.log(response);
                    if (response.error) {
                        error_notification(response.error)
                        // enableeButton()
                    }
                    if (response.success) {
                        // enableeButton()
                        $('#createItemTypeModal').modal('hide');
                        $('.yajra-datatable').DataTable().ajax.reload(null, false);
                        $('#save_info')[0].reset();
                        toastr.success('Information Saved', 'Saved');

                    }
                    // setTimeout(window.location.href = "{{ route('admin.indent/view') }}", 40000);
                },
                error: function(response) {
                    console.log(response);
                    // enableeButton()
                    // clear_error_field();
                    // error_notification('Please fill up the form correctly and try again')
                    // $('#error_sender').text(response.responseJSON.errors.sender);
                    // $('#error_reference_no').text(response.responseJSON.errors.reference_no);
                    // $('#error_spec_type').text(response.responseJSON.errors.spec_type);
                    // $('#error_additional_documents').text(response.responseJSON.errors
                    //     .additional_documents);
                    // $('#error_item_type_id').text(response.responseJSON.errors.item_type_id);
                    // $('#error_spec_received_date').text(response.responseJSON.errors
                    //     .spec_received_date);

                }
            });
        })

        // // Edit Item Type
        $(document).on('click', '.edit_data', function(e) {
            e.preventDefault();
            let id = $(this).attr('id');
            $.ajax({
                url: '{{ url('admin/indent/doc_status/edit') }}',
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
        // $("#editItemTypeForm").on("submit", function(e) {
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
                        url: '{{ url('admin/indent/doc_status/delete') }}/' + id,
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
</script>
