<script>
    $(document).ready(function() {
        $('.select2').select2();

        $('.sectionId').select2({
            dropdownParent: $('#createParameterGroupModal')
        });

        $('.editSectionId').select2({
            dropdownParent: $('#editParameterGroupModal')
        });

        toastr.options.preventDuplicates = true;

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
                                '<button class="btn btn-danger btn-sm delete_parameter_group"id="' +
                                row.id +
                                '" >Delete</button>';
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
                        $("#createParameterGroupModal").modal("hide");
                        Swal.fire(
                            'Added!',
                            'Parameter Group Added Successfully!',
                            'success'
                        )
                        toastr.success(response.Message);
                        createButton.prop('disabled', false).text('Create');
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
                    $("#editInspectorateId").val(response.inspectorate_id);
                    $("#editParameterGroupName").val(response.name);
                    $("#editSectionId").val(response.section_id).change();
                    $("#editParameterGroupDescription").val(response.description);
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
                            $(form).find("span." + prefix + "_error").text(val[0]
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
                        )
                        toastr.success(response.Message);
                        editButton.prop('disabled', false).text('Update');
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
                    $("#showInspectorateId").text(response.inspectorate_id);
                    $("#showSectionId").text(response.section_id);
                    $("#showDescription").text(response.description);
                    $("#showStatus").prop('checked', response.status == 1);

                    $('#showParameterGroupModal').modal('show');
                }
            });
        });

        // Populate Items Dropdown
        var itemsData = {!! $items !!};
        populateItemsDropdown(itemsData);

        $('#itemTypeId').on('change', function() {
            var itemTypeId = $(this).val();

            var filteredItems = itemsData.filter(item => item.item_type_id == itemTypeId);

            populateItemsDropdown(filteredItems);
        });

        function populateItemsDropdown(items) {
            $('#itemId').empty();
            $('#itemId').append('<option value="" selected disabled>Select an item</option>');

            $.each(items, function(key, value) {
                $('#itemId').append('<option value="' + value.id + '">' + value.name + '</option>');
            });
        }

        var addButton = $('.add_button');
        var wrapper = $('.field_wrapper');
        var fieldHTML =
            '<div class="row mb-2"><div class="col-10 ps-0"><input type="text" class="form-control parameter-group-name" id="parameterGroupName" name="parameter-group-name[]"><span class="text-danger error-text parameter-group-name-error"></span></div><div class="col-2 ps-0"><a href="javascript:void(0);" class="btn btn-danger-gradien float-end remove_button" title="Remove field">-</a></div></div>';

        // Once add button is clicked
        $(addButton).click(function() {
            $(wrapper).append(fieldHTML);
        });

        // Once remove button is clicked
        $(wrapper).on('click', '.remove_button', function(e) {
            e.preventDefault();
            $(this).closest('.row').remove();
        });
    });
</script>
