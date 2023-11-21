<script>
    $(document).ready(function() {
        // Initial Setup: Begins here
        $('.select2').select2();

        $('.sectionId').select2({
            dropdownParent: $('#createParameterGroupModal')
        });

        $('.editSectionId').select2({
            dropdownParent: $('#editParameterGroupModal')
        });

        toastr.options.preventDuplicates = true;
        // Initial Setup: Ends here

        // Get All Data 
        $(function() {
            var table = $('.yajra-datatable').DataTable({
                searching: true,
                // order: [
                //     [0, 'desc']
                // ],
                columnDefs: [{
                    className: 'dt-center',
                    targets: '_all'
                }],
                bDestroy: true,
                processing: true,
                serverSide: true,
                language: {
                    processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span>'
                },
                drawCallback: function(settings) {
                    var api = this.api();
                    $('#total_data').html(api.ajax.json().recordsTotal);
                },
                ajax: {
                    url: "{{ url('admin/parameter_groups/get_all_data') }}",
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    data: function(d) {
                        d._token = '{{ csrf_token() }}';
                    },
                },
                columns: [{
                        data: null,
                        searchable: false,
                        orderable: false,
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        data: 'name',
                        name: 'name',
                        orderable: false
                    },
                    {
                        data: 'item_type_id_name',
                        name: 'item_type_id_name',
                        orderable: false
                    },
                    {
                        data: 'item_id_name',
                        name: 'item_id_name',
                        orderable: false
                    },
                    {
                        data: 'status',
                        name: 'status',
                        orderable: false,
                        render: function(data, type, row) {
                            var badgeClass = row.status == 1 ? 'badge-success' :
                                'badge-danger';
                            var statusLabel = row.status == 1 ? 'Active' : 'Inactive';

                            return '<span class="badge ' + badgeClass + '">' +
                                statusLabel + '</span>';
                        }
                    },
                    {
                        data: null,
                        searchable: false,
                        orderable: false,
                        render: function(data, type, row) {
                            return '<button class="btn btn-sm me-2 show_parameter_group" id="' +
                                row.id +
                                '" >Show</button>' +
                                '<button class="btn btn-secondary btn-sm me-2 edit_parameter_group" id="' +
                                row.id +
                                '" >Edit</button>' +
                                '<button class="btn btn-danger btn-sm me-2 delete_parameter_group" id="' +
                                row.id +
                                '" >Delete</button>' +
                                '<button class="btn btn-dark btn-sm assign-parameter-value" id="' +
                                row.id +
                                '" >Assign Parameter</button>';
                        }
                    }
                ],
                dom: 'lfrtip',
            });

            $('#search_form').on('submit', function(event) {
                event.preventDefault();
                table.draw(true);
            });
        });

        // Create Parameter Group
        $("#createParameterGroupForm").on("submit", function(e) {
            e.preventDefault();
            var form = this;
            var createButton = $("#createButton");
            createButton.prop('disabled', true).text('Saving...');
            $.ajax({
                url: $(form).attr('action'),
                method: $(form).attr('method'),
                data: new FormData(form),
                processData: false,
                dataType: "JSON",
                contentType: false,
                cache: false,
                beforeSend: function() {
                    $(form).find("span.error-text").text("");
                },
                success: function(response) {
                    console.log(response);
                    if (response.isSuccess === false) {
                        $.each(response.error, function(prefix, val) {
                            $(form).find("span." + prefix + "-error").text(val[0]);
                        });
                        toastr.error(response.Message);
                        createButton.prop('disabled', false).text('Create');
                    } else if (response.isSuccess === true) {
                        $(form)[0].reset();

                        for (let i = inputFieldCounter; i > 1; i--) {
                            let parameterGroupNameId = 'parameterGroupName_' + i;

                            $('.field_wrapper').find('#' + parameterGroupNameId)
                                .closest('.row').remove();
                        }

                        inputFieldCounter = 1;

                        $("#createParameterGroupModal").modal("hide");
                        Swal.fire(
                            'Added!',
                            'Parameter Group Added Successfully!',
                            'success'
                        );
                        toastr.success(response.Message);
                        createButton.prop('disabled', false).text('Create');

                        // Reload the DataTable
                        $('.yajra-datatable').DataTable().ajax.reload();
                    }
                },
                error: function(error) {
                    console.log('Error:', error);
                    toastr.error('An error occurred while processing the request.');
                    createButton.prop('disabled', false).text('Create');
                },
            });
        });

        // Edit Parameter Group
        $(document).on('click', '.edit_parameter_group', function(e) {
            e.preventDefault();
            let id = $(this).attr('id');
            $.ajax({
                url: '{{ url('admin/parameter_groups/edit') }}',
                method: 'post',
                data: {
                    id: id,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    $("#editParameterGroupId").val(id);
                    $("#editItemTypeId").val(response.item_type_id).change();
                    $("#editItemId").val(response.item_id).change();
                    $("#editParameterGroupName").val(response.name);
                    $("#editParameterGroupStatus").prop('checked', response.status == 1);

                    $('#editParameterGroupModal').modal('show');
                }
            });
        });

        // Update Parameter Group
        $("#editParameterGroupForm").on("submit", function(e) {
            e.preventDefault();
            var form = this;
            var editButton = $("#editButton");
            editButton.prop('disabled', true).text('Updating...');
            $.ajax({
                url: $(form).attr('action'),
                method: $(form).attr('method'),
                data: new FormData(form),
                processData: false,
                dataType: "JSON",
                contentType: false,
                cache: false,
                beforeSend: function() {
                    $(form).find("span.error-text").text("");
                },
                success: function(response) {
                    if (response.isSuccess === false) {
                        $.each(response.error, function(prefix, val) {
                            $(form).find("span." + prefix + "-error").text(val[0]
                                .replace("edit ", ""));
                        });
                        toastr.error(response.Message);
                        editButton.prop('disabled', false).text('Update');
                    } else if (response.isSuccess === true) {
                        $(form)[0].reset();
                        $("#editParameterGroupModal").modal("hide");
                        Swal.fire(
                            'Updated!',
                            'Parameter Group Edited Successfully!',
                            'success'
                        );
                        toastr.success(response.Message);
                        editButton.prop('disabled', false).text('Update');

                        // Reload the DataTable
                        $('.yajra-datatable').DataTable().ajax.reload();
                    }
                },
                error: function(error) {
                    console.log('Error:', error);
                    toastr.error('An error occurred while processing the request.');
                    editButton.prop('disabled', false).text('Update');
                },
            });
        });

        // Delete Parameter Group ajax request
        $(document).on('click', '.delete_parameter_group', function(e) {
            e.preventDefault();
            let id = $(this).attr('id');
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
                        url: '{{ url('admin/parameter_groups/destroy') }}',
                        method: 'post',
                        data: {
                            id: id,
                            _token: csrf
                        },
                        success: function(response) {
                            console.log(response);
                            if (response.isSuccess === true) {
                                Swal.fire(
                                    'Deleted!',
                                    'Parameter Group has been deleted.',
                                    'success'
                                );
                                toastr.success(response.Message);

                                // Reload the DataTable
                                $('.yajra-datatable').DataTable().ajax.reload();
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
                                'Failed to delete Parameter Group.',
                                'error'
                            );
                        }
                    });
                }
            });
        });

        // Show Parameter Group
        $(document).on('click', '.show_parameter_group', function(e) {
            e.preventDefault();
            let id = $(this).attr('id');
            $.ajax({
                url: '{{ url('admin/parameter_groups/show') }}',
                method: 'post',
                data: {
                    id: id,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    $("#showParameterGroupName").text(response.name);
                    $("#showItem").text(response.item_id);
                    $("#showItemType").text(response.item_type_id);
                    $("#showInspectorate").text(response.inspectorate_id);
                    $("#showSection").text(response.section_id);
                    $("#showStatus").prop('checked', response.status == 1);

                    $('#showParameterGroupModal').modal('show');
                }
            });
        });

        // Populate Items Dropdown: Begins here
        var itemsData = {!! $items !!};
        populateItemsDropdownCreate(itemsData);
        populateItemsDropdownEdit(itemsData);

        $('#itemTypeId').on('change', function() {
            var itemTypeId = $(this).val();
            var filteredItems = itemsData.filter(item => item.item_type_id == itemTypeId);

            populateItemsDropdownCreate(filteredItems);
        });

        function populateItemsDropdownCreate(items) {
            $('#itemId').empty();
            $('#itemId').append('<option value="" selected disabled>Select an item</option>');

            $.each(items, function(key, value) {
                $('#itemId').append('<option value="' + value.id + '">' + value.name + '</option>');
            });
        }

        $('#editItemTypeId').on('change', function() {
            var editItemTypeId = $(this).val();
            var filteredItems = itemsData.filter(item => item.item_type_id == editItemTypeId);

            populateItemsDropdownEdit(filteredItems);
        });

        function populateItemsDropdownEdit(items) {
            $('#editItemId').empty();
            $('#editItemId').append('<option value="" selected disabled>Select an item</option>');

            $.each(items, function(key, value) {
                $('#editItemId').append('<option value="' + value.id + '">' + value.name + '</option>');
            });
        }
        // Populate Items Dropdown: Ends here

        // Creating dynamic input fields: Begins here
        var addButton = $('.add_button');
        var wrapper = $('.field_wrapper');
        var inputFieldCounter = 1;

        // Once add button is clicked
        $(addButton).click(function() {
            inputFieldCounter++; // Increment the counter

            var fieldHTML =
                '<div class="row mb-2">' +
                '<div class="col-10 ps-0">' +
                '<input type="text" class="form-control parameter-group-name"' +
                'id="parameterGroupName_' + inputFieldCounter + '" name="parameter-group-name[]">' +
                '<span class="text-danger error-text parameter-group-name-error"></span>' +
                '</div>' +
                '<div class="col-2 ps-0">' +
                '<a href="javascript:void(0);" class="btn btn-danger-gradien float-end remove_button" title="Remove field">-</a>' +
                '</div>' +
                '</div>';

            $(wrapper).append(fieldHTML);
        });

        // Once remove button is clicked
        $(wrapper).on('click', '.remove_button', function(e) {
            e.preventDefault();
            $(this).closest('.row').remove();
        });
        // Creating dynamic input fields: Ends here

        // Assign Parameter Value Modal Show
        $(document).on('click', '.assign-parameter-value', function(e) {
            e.preventDefault();
            let id = $(this).attr('id');
            $.ajax({
                url: '{{ url('admin/assign-parameter-value/create') }}',
                method: 'post',
                data: {
                    id: id,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    $("#assignParameterGroupId").val(response.id);
                    $("#assignParameterGroupName").val(response.name);

                    $('#assignParameterValueGroupModal').modal('show');
                }
            });
        });

        // Creating dynamic input fields for adding parameter value: Begins here
        var addParameterButton = $('.add-parameter-button');
        var parameterFieldWrapper = $('.parameter-field-wrapper');
        var fieldCounter = 1; // Initialize the counter

        // Once add button is clicked
        $(addParameterButton).click(function() {
            fieldCounter++; // Increment the counter

            var fieldHTML =
                '<div class="row mb-2">' +
                '<div class="col-5 ps-0">' +
                '<input type="text" class="form-control parameter-name" id="parameterName_' +
                fieldCounter + '" name="parameter-name[]" placeholder="Name">' +
                '<span class="text-danger error-text parameter-name-error"></span>' +
                '</div>' +
                '<div class="col-5">' +
                '<input type="text" class="form-control parameter-value" id="parameterValue_' +
                fieldCounter + '" name="parameter-value[]" placeholder="Value">' +
                '<span class="text-danger error-text parameter-value-error"></span>' +
                '</div>' +
                '<div class="col-2">' +
                '<a href="javascript:void(0);" class="btn btn-danger-gradien float-end remove-parameter-button" title="Remove Parameter field">-</a>' +
                '</div>' +
                '</div>';

            $(parameterFieldWrapper).append(fieldHTML);
        });

        // Once remove button is clicked
        $(parameterFieldWrapper).on('click', '.remove-parameter-button', function(e) {
            e.preventDefault();
            $(this).closest('.row').remove();
        });
        // Creating dynamic input fields for adding parameter value: Ends here

        // Assign Parameter Value ajax request
        $("#assignParameterValueGroupForm").on("submit", function(e) {
            e.preventDefault();

            var form = this;
            var assignButton = $("#assignButton");
            assignButton.prop('disabled', true).html(
                '<div class="text-center"><i class="fa fa-spinner fa-spin"></i></div>');

            $(form).find("span.parameter-name-error, span.parameter-value-error").text("");

            $.ajax({
                url: $(form).attr('action'),
                method: $(form).attr('method'),
                data: new FormData(form),
                processData: false,
                dataType: "JSON",
                contentType: false,
                cache: false, // Ensure that the request is not cached
                beforeSend: function() {
                    $(form).find("span.parameter-name-error, span.parameter-value-error")
                        .text("");
                },
                success: function(response) {
                    if (response && typeof response === 'object' && 'isSuccess' in
                        response) {
                        if (response.isSuccess === false) {
                            if ('error' in response) {
                                $.each(response.error, function(prefix, val) {
                                    $(form).find("span." + prefix + "-error").text(
                                        val[0]);
                                });
                            }
                            toastr.error(response.Message);
                        } else if (response.isSuccess === true) {
                            if ('Message' in response) {
                                toastr.success(response.Message);
                            }

                            $(form)[0].reset();

                            for (let i = fieldCounter; i > 1; i--) {
                                let parameterValueId = 'parameterValue_' + i;

                                $('.parameter-field-wrapper').find('#' + parameterValueId)
                                    .closest('.row').remove();
                            }

                            fieldCounter = 1;

                            $("#createParameterGroupModal").modal("hide");
                            Swal.fire(
                                'Added!',
                                'Parameter Group Created Successfully!',
                                'success'
                            );

                            if ($.fn.DataTable.isDataTable('.yajra-datatable')) {
                                $('.yajra-datatable').DataTable().ajax.reload();
                            }
                        } else {
                            toastr.error('Unexpected response format.');
                        }
                    } else {
                        toastr.error('Unexpected response format.');
                    }
                },
                error: function(error) {
                    console.log('Error:', error);
                    if ('error' in response) {
                        $.each(response.error, function(prefix, val) {
                            $(form).find("span." + prefix + "-error").text(
                                val[0]);
                        });
                    }
                    toastr.error('An error occurred while processing the request.');
                },
                complete: function() {
                    assignButton.prop('disabled', false).text('Assign');
                }
            });
        });
    });
</script>
