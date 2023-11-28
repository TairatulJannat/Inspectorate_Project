<script>
    $(document).ready(function() {
        $('.select2').select2();
        toastr.options.preventDuplicates = true;

        $('#searchItemParametersButton').submit(function(e) {
            e.preventDefault();
            var form = this;
            var searchButton = $(".search-button");
            var originalSearchButtonHtml = searchButton.html();

            searchButton.html(
                '<span class="fw-bold">Loading <i class="fa fa-spinner fa-spin"></i></span>');

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
                            $(form).find("span." + prefix + "-error").text(val[0]);
                        });
                        toastr.error(response.Message);
                    } else if (response.isSuccess === true) {
                        toastr.success(response.Message);
                        renderTreeView(response.treeViewData, response.itemTypeName,
                            response.itemName);
                    }

                    searchButton.html(originalSearchButtonHtml);
                },
                error: function(error) {
                    console.log('Error:', error);
                    toastr.error('An error occurred while processing the request.');
                },
            });
        });

        function renderTreeView(treeViewData, itemTypeName, itemName) {
            var searchedDataContainer = $(".searched-data");
            searchedDataContainer.empty();

            if (treeViewData && treeViewData.length > 0) {
                var html = '<div class="p-md-3 paper-document">' +
                    '<div class="header text-center">' +
                    '<div class="item-id f-30">' + itemName + '</div>' +
                    '<div class="item-type-id f-20">' + itemTypeName + '</div>' +
                    '</div>' +
                    '<div class="content">';

                $.each(treeViewData, function(index, node) {
                    html += '<div class="row parameter-group mt-5 edit-row">' +
                        '<span><h5 class="parameter-group-name text-uppercase text-underline fw-bold">' +
                        node.parameterGroupName + '</h5>' +
                        '<button class="btn btn-outline-warning btn-sm fa fa-edit edit-group float-end" data-group-id="' +
                        node.parameterGroupId +
                        '" data-group-name="' + node.parameterGroupName +
                        '" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"></button></span>' +
                        '<table class="parameter-table table table-border-vertical table-hover">';

                    $.each(node.parameterValues, function(i, parameterValue) {
                        html += '<tr>' +
                            '<td class="col-md-4 parameter-name">' + parameterValue
                            .parameter_name + '</td>' +
                            '<td class="col-md-6 parameter-value">' + parameterValue
                            .parameter_value + '</td>' +
                            '</tr>';
                    });

                    html += '</table></div>';
                });

                html += '</div></div>';
                searchedDataContainer.append(html);
            } else {
                searchedDataContainer.html('<h2>Searched Item Parameters will appear here.</h2>');
            }

            $('.edit-group').click(function() {
                var groupId = $(this).data('group-id');
                var groupName = $(this).data('group-name');
                $.ajax({
                    url: '{{ url('admin/assign-parameter-value/edit') }}',
                    method: 'post',
                    data: {
                        id: groupId,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.length > 0) {
                            var groupData = response;

                            $('#editGroupName').text(groupName);
                            $('.modal-body .dynamic-fields').empty();

                            var labelPrinted = false;
                            groupData.forEach(function(parameter) {
                                if (!labelPrinted) {
                                    $('.modal-body .dynamic-fields').append(
                                        '<div class="row mb-3" data-row-id="' +
                                        parameter.id + '">' +
                                        '<div class="col-md-5">' +
                                        '<label class="form-label">' +
                                        'Parameter Name</label></div>' +
                                        '<div class="col-md-5">' +
                                        '<label class="form-label">' +
                                        'Parameter Value</label></div>' +
                                        '</div>'
                                    );
                                    labelPrinted = true;
                                }

                                var inputFields = $(
                                    '<div class="row mb-3" data-row-id="' +
                                    parameter.id + '">' +
                                    '<div class="col-md-5">' +
                                    '<input type="text" class="form-control" name="parameter_name[]" value="' +
                                    parameter.parameter_name +
                                    '">' +
                                    '</div>' +
                                    '<div class="col-md-5">' +
                                    '<input type="text" class="form-control" name="parameter_value[]" value="' +
                                    parameter.parameter_value +
                                    '">' +
                                    '</div>' +
                                    '<div class="col-md-2">' +
                                    '<button class="btn btn-danger-gradien btn-sm delete-row fa fa-trash-o" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete">' +
                                    '</button>' +
                                    '</div>' +
                                    '</div>');

                                $('.modal-body .dynamic-fields').append(
                                    inputFields);

                                $('.modal-body .dynamic-fields').on('click',
                                    '.delete-row',
                                    function() {
                                        var rowToRemove = $(this).closest(
                                            '.row');
                                        var rowIdToRemove = rowToRemove.data(
                                            'row-id');
                                        rowToRemove.remove();
                                    });
                            });

                            $('#addNewInputFields').off('click').on('click', function() {
                                var newInputFields = $(
                                    '<div class="row mb-3" data-new-row="true">' +
                                    '<div class="col-md-5">' +
                                    '<input type="text" class="form-control" name="parameter_name[]" placeholder="Parameter Name">' +
                                    '</div>' +
                                    '<div class="col-md-5">' +
                                    '<input type="text" class="form-control" name="parameter_value[]" placeholder="Parameter Value">' +
                                    '</div>' +
                                    '<div class="col-md-2">' +
                                    '<button class="btn btn-danger-gradien btn-sm delete-row fa fa-trash-o" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete">' +
                                    '</button>' +
                                    '</div>' +
                                    '</div>');

                                $('.modal-body .dynamic-fields').append(
                                    newInputFields);

                                $('.modal-body .dynamic-fields').on('click',
                                    '.delete-row',
                                    function() {
                                        $(this).closest('.row').remove();
                                    });
                            });
                        }

                        $('#editModal').modal('show');
                    },
                    error: function(error) {
                        console.log('Error:', error);
                    }
                });
            });

            $('#saveChanges').click(function() {
                $('.modal-body .dynamic-fields .row').each(function() {
                    var rowId = $(this).data('row-id');
                    var editedData = {
                        parameter_name: $(this).find('[name="parameter_name[]"]').val(),
                        parameter_value: $(this).find('[name="parameter_value[]"]').val()
                    };

                    if (
                        initialData[rowId] &&
                        (editedData.parameter_name !== initialData[rowId].parameter_name ||
                            editedData.parameter_value !== initialData[rowId].parameter_value)
                    ) {
                        updateRowInDatabase(rowId, editedData.parameter_name, editedData
                            .parameter_value);
                    }
                });

                for (var id in initialData) {
                    if (initialData.hasOwnProperty(id) && initialData[id].deleted) {
                        deleteRowFromDatabase(id);
                    }
                }
            });

            function deleteRowFromDatabase(rowId) {
                $.ajax({
                    url: '{{ url('admin/assign-parameter-value/delete') }}',
                    method: 'post',
                    data: {
                        id: rowId,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        console.log('Row deleted successfully:', response);
                    },
                    error: function(error) {
                        console.log('Error deleting row:', error);
                    }
                });
            }

            function saveNewRowToDatabase(parameterName, parameterValue) {
                $.ajax({
                    url: '{{ url('admin/assign-parameter-value/add') }}',
                    method: 'post',
                    data: {
                        parameter_name: parameterName,
                        parameter_value: parameterValue,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        console.log('New row saved successfully:', response);
                    },
                    error: function(error) {
                        console.log('Error saving new row:', error);
                    }
                });
            }

            function updateRowInDatabase(rowId, parameterName, parameterValue) {
                $.ajax({
                    url: '{{ url('admin/assign-parameter-value/update') }}',
                    method: 'post',
                    data: {
                        id: rowId,
                        parameter_name: parameterName,
                        parameter_value: parameterValue,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        console.log('Row updated successfully:', response);
                    },
                    error: function(error) {
                        console.log('Error updating row:', error);
                    }
                });
            }
        }

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
    });
</script>
