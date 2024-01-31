<script>
    $(document).ready(function() {
        $('.select2').select2();


        $('#createItemTypeForm').off().on('submit', function(event) {
            event.preventDefault();
            var formData = new FormData($(this)[0]);

            disableButton(); // Assuming you have functions to disable and enable the submit button

            $.ajax({
                url: "{{ route('admin.supplier/store') }}", // Use route() helper function to generate URL
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    // enableButton();
                    $("#createItemTypeModal").modal("hide");
                    // $('.yajra-datatable').DataTable().ajax.reload(null, false);
                    toastr.success('Information Saved', 'Saved');
                    setTimeout(function() {
                        window.location.href =
                            "{{ route('admin.supplier/index') }}";
                    }, 1000);
                    // if (response.error) {
                    //     error_notification(response.error);
                    // } else if (response.success) {

                    // }
                },
                error: function(response) {
                    // enableButton();
                    clear_error_field();
                    error_notification('Please fill up the form correctly and try again');
                    // Assuming these are the correct field IDs for error messages
                    $('#firm_name_error').text(response.responseJSON.errors.firm_name);
                    $('#principal_name_error').text(response.responseJSON.errors
                        .principal_name);
                    $('#address_of_principal_error').text(response.responseJSON.errors
                        .address_of_principal);
                    $('#address_of_local_agent_error').text(response.responseJSON.errors
                        .address_of_local_agent);
                    $('#contact_no_error').text(response.responseJSON.errors.contact_no);
                    $('#email_error').text(response.responseJSON.errors.email);
                }
            });
        });



        $(document).on('click', '.edit_supplier', function(e) {
            e.preventDefault();
            let id = $(this).attr('id');
            $.ajax({
                url: '{{ url('admin/supplier/edit') }}',
                method: 'post',
                data: {
                    id: id,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    $("#edit_item_type_id").val(id);
                    $("#editItemTypeName").val(response.name);
                    $("#editItemTypeSection option[value='" + response.section_id + "']")
                        .prop('selected', true);
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
        $(document).on('click', '#delete_supplier', function(e) {
            e.preventDefault();

            var supplierId = $(this).data('supplier-id');

            alert(supplierId);
            let csrf = '{{ csrf_token() }}';
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#34C38F",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: '{{ url('admin/supplier/destroy') }}/' + supplierId,
                        method: 'get',

                        success: function(response) {
                            if (response.isSuccess === true) {
                                Swal.fire(
                                    'Deleted!',
                                    'Supplier has been deleted.',
                                    'success'
                                );
                                toastr.success(response.Message);

                                // Reload the DataTable
                                setTimeout(window.location.href = "{{ route('admin.supplier/index') }}", 10000);
                            } else if (response.isSuccess === false) {
                                Swal.fire(
                                    'Caution!',
                                    'Something went wrong!',
                                    'error'
                                );
                                toastr.error(response.Message);
                            }
                        },
                        error: function(error) {
                            // Handle AJAX request error
                            console.error(error);
                            Swal.fire(
                                'Error!',
                                'Failed to delete Item Type.',
                                'error'
                            );
                        }
                    });
                }
            });
        });

        // Show Item Type
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

        function clear_error_field() {
            $('#error_sender').text("");
            $('#error_reference_no').text("");
            $('#error_psi_received_date').text("");
            $('#error_psi_reference_date').text("");

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
    });
</script>
