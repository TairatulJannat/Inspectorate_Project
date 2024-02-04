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



        $(document).on('click', '#edit_supplier_btn', function(e) {
            e.preventDefault();
            let id = $(this).data('supplier-id');

            $.ajax({
                url: '{{ url('admin/supplier/edit') }}/' + id,
                method: 'get',

                success: function(response) {

                    $("#update_id").val(response.supplier.id);
                    $("#editfirm_name").val(response.supplier.firm_name);
                    $("#editprincipal_name").val(response.supplier.principal_name);
                    $("#editaddress_of_principal").val(response.supplier
                        .address_of_principal);
                    $("#editaddress_of_local_agent").val(response.supplier
                        .address_of_local_agent);
                    $("#editcontact_no").val(response.supplier.contact_no);
                    $("#editemail").val(response.supplier.email);

                    $('#edit_supplier').modal('show');
                }
            });
        });

        $('#update_form').off().on('submit', function(event) {
            event.preventDefault();
            var formData = new FormData($('#update_form')[0]);
            disableButton()
            $.ajax({
                url: "{{ url('admin/supplier/update') }}",
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
                        $('#edit_supplier').modal('hide');
                    }
                    setTimeout(window.location.href = "{{ route('admin.supplier/index') }}",
                        2000);
                },
                error: function(response) {
                    enableeButton()
                    clear_error_field();
                    error_notification('Please fill up the form correctly and try again')
                    if (response.responseJSON && response.responseJSON.errors) {
                        // Iterate over the validation errors and display them
                        $.each(response.responseJSON.errors, function(key, value) {

                            var errorSpanId =  key + '_error';
                            alert(errorSpanId);
                            $('.' + errorSpanId).text(value[
                            0]); // Assuming you want to display only the first error
                        });
                    }


                }
            });
        })
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
                                setTimeout(window.location.href =
                                    "{{ route('admin.supplier/index') }}", 10000
                                );
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
