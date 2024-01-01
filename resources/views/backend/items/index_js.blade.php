<script>
    $(document).ready(function() {
        $('.select2').select2();

        $('.itemTypeId').select2({
            dropdownParent: $('#createItemModal')
        });

        $('.attributeType').select2({
            dropdownParent: $('#createItemModal')
        });

        $('.editAttributeType').select2({
            dropdownParent: $('#editItemModal')
        });

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
                    url: "{{ url('admin/items/get_all_data') }}",
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
                            // Use meta.row + meta.settings._iDisplayStart + 1 for the row index
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        data: 'name',
                        name: 'name',
                        orderable: false
                    },
                    {
                        data: 'item_type_name',
                        name: 'item_type_name',
                        orderable: false
                    },
                    {
                        data: 'attribute',
                        name: 'attribute',
                        orderable: false
                    },
                    {
                        data: null,
                        searchable: false,
                        orderable: false,
                        render: function(data, type, row) {
                            // Add your action buttons here, e.g., edit and delete
                            return '<button class="btn btn-sm me-2 show_item" id="' +
                                row.id +
                                '" >Show</button>' +
                                '<button class="btn btn-secondary btn-sm me-2 edit_item" id="' +
                                row.id +
                                '" >Edit</button>' +
                                '<button class="btn btn-danger btn-sm delete_item"id="' +
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

        // Create Item
        $("#createItemForm").on("submit", function(e) {
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
                    if (response.isSuccess === false) {
                        $.each(response.error, function(prefix, val) {
                            $(form).find("span." + prefix + "_error").text(val[0]);
                        });
                        toastr.error(response.Message);
                        createButton.prop('disabled', false).text('Create');
                    } else if (response.isSuccess === true) {
                        $(form)[0].reset();
                        $("#createItemModal").modal("hide");
                        Swal.fire(
                            'Added!',
                            'Item Added Successfully!',
                            'success'
                        )
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

        // Edit Item
        $(document).on('click', '.edit_item', function(e) {
            e.preventDefault();
            let id = $(this).attr('id');
            $.ajax({
                url: '{{ url('admin/items/edit') }}',
                method: 'post',
                data: {
                    id: id,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    $("#editItemId").val(id);
                    $("#editItemName").val(response.name);
                    $("#editItemInspectorateId").val(response.inspectorate_id);
                    $("#editItemTypeId").val(response.item_type_id).trigger('change');
                    $("#editItemAttribute").val(response.attribute).trigger('change');
                    $("#editItemSection option[value='" + response.section_id + "']")
                        .prop('selected', true);

                    $('#editItemModal').modal('show');
                }
            });
        });

        // Update Item
        $("#editItemForm").on("submit", function(e) {
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
                        $("#editItemModal").modal("hide");
                        Swal.fire(
                            'Updated!',
                            'Item Edited Successfully!',
                            'success'
                        )
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

        // Delete Item ajax request
        $(document).on('click', '.delete_item', function(e) {
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
                        url: '{{ url('admin/items/destroy') }}',
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
                                    'Item has been deleted.',
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
                                'Failed to delete Item.',
                                'error'
                            );
                        }
                    });
                }
            });
        });

        // Show Item
        $(document).on('click', '.show_item', function(e) {
            e.preventDefault();
            let id = $(this).attr('id');
            $.ajax({
                url: '{{ url('admin/items/show') }}',
                method: 'post',
                data: {
                    id: id,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    $("#showItemName").text(response.name);
                    $("#showItemTypeName").text(response.item_type_id);
                    $("#showAttribute").text(response.attribute);

                    $('#showItemModal').modal('show');
                }
            });
        });
    });
</script>
