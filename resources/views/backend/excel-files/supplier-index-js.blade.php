<script>
    var initialData = {};
    var xhr;

    $(document).ready(function() {

        $('#import-supplier-spec-data-form').submit(function() {
            $('#itemTypeId, #indentId, #itemId').prop('disabled', false);
        });

        var itemsData = {!! $items !!};
        var itemTypesData = {!! $itemTypes !!};
        var tendersData = {!! $tenders !!};
        var $indentsData = {!! $indents !!};
        var $suppliersData = {!! $suppliers !!};

        populateItemsDropdown(itemsData);

        $('.select2').select2();
        // toastr.options.preventDuplicates = true;

        $('#searchItemParametersButton').submit(function(e) {
            e.preventDefault();
            var form = this;
            performSearch(form);
        });

        $('#tenderId').on('change', function() {
            var tenderId = $(this).val();

            $.ajax({
                url: '{{ url('admin/fetch-supplier-data') }}',
                method: 'GET',
                data: {
                    tenderId: tenderId
                },
                dataType: 'JSON',
                success: function(response) {
                    if (response.isSuccess === true) {
                        $("#indentId").val(response.indentId).prop('selected', true)
                            .change();
                        $("#itemTypeId").val(response.itemTypeId).prop('selected', true)
                            .change();
                        $("#itemId").val(response.itemId).prop('selected', true).change();
                        populateSupplierDropdown(response.suppliersData);
                        toastr.success("Data found for this Tender!");
                    } else if (response.isSuccess === false) {
                        toastr.error(response.message);
                        if (response.indentId) {
                            $("#indentId").val(response.indentId).prop('selected', true)
                                .change();
                        }
                        if (response.itemTypeId) {
                            $("#itemTypeId").val(response.itemTypeId).prop('selected', true)
                                .change();
                        }
                        if (response.itemId) {
                            $("#itemId").val(response.itemId).prop('selected', true)
                                .change();
                            populateSupplierDropdown(response.suppliersData);
                        }
                        var supplierDataContainer = $(".supplier-data");
                        supplierDataContainer.hide();
                    }
                },
                error: function(error) {
                    console.error('Error:', error);
                }
            });
        });

        var supplierDataContainer = $(".supplier-data");
        supplierDataContainer.hide();

        function populateSupplierDropdown(suppliersData) {
            var container = document.getElementById('supplierTableContainer');
            var tbody = container.querySelector('tbody');

            tbody.innerHTML = '';

            var row = document.createElement('tr');
            var firmNameCell = document.createElement('td');

            var firmNames = suppliersData.map(function(supplier, index) {
                return (index + 1) + ') ' + supplier.firm_name;
            }).join(', ');

            firmNameCell.textContent = firmNames;
            row.appendChild(firmNameCell);

            tbody.appendChild(row);

            supplierDataContainer.show();
        }

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

        function performSearch(form) {
            var searchButton = $(".search-button");
            var originalSearchButtonHtml = searchButton.html();

            searchButton.html('<span class="fw-bold">Loading <i class="fa fa-spinner fa-spin"></i></span>');

            if (xhr) {
                xhr.abort();
            }

            xhr = $.ajax({
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
                    initialData = {};

                    if (response.isSuccess === false) {
                        $.each(response.error, function(prefix, val) {
                            $(form).find("span." + prefix + "-error").text(val[0]);
                        });
                        toastr.error(response.message);
                    } else if (response.isSuccess === true) {
                        toastr.success(response.message);
                        renderTreeView(response.treeViewData, response.itemTypeName, response
                            .itemName);
                    }

                    searchButton.html(originalSearchButtonHtml);
                },
                error: function(error) {
                    console.log('Error:', error);
                    toastr.error('An error occurred while processing the request.');
                },
            });
        }

        function performSearchWithParams(itemTypeId, itemId) {
            var searchButton = $(".search-button");
            var originalSearchButtonHtml = searchButton.html();

            searchButton.html(
                '<span class="fw-bold">Loading <i class="fa fa-spinner fa-spin"></i></span>');

            $.ajax({
                url: '{{ url('admin/assign-parameter-value/show') }}',
                method: 'POST',
                data: {
                    'item-type-id': itemTypeId,
                    'item-id': itemId,
                    '_token': '{{ csrf_token() }}'
                },
                dataType: "JSON",
                cache: false,
                beforeSend: function() {
                    // Clear any previous error messages here
                },
                success: function(response) {
                    if (response.isSuccess === false) {
                        toastr.error(response.message);
                    } else if (response.isSuccess === true) {
                        toastr.success(response.message);
                        renderTreeView(response.treeViewData, response.itemTypeName, response
                            .itemName);
                    }

                    searchButton.html(originalSearchButtonHtml);
                },
                error: function(error) {
                    console.log('Error:', error);
                    toastr.error('An error occurred while processing the request.');
                },
            });
        }

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
                $('.modal-body .dynamic-fields').empty();
                var groupId = $(this).data('group-id');
                var groupName = $(this).data('group-name');
                $.ajax({
                    url: '{{ url('admin/assign-parameter-value/edit') }}',
                    method: 'post',
                    data: {
                        id: groupId,
                        _token: '{{ csrf_token() }}'
                    },
                    cache: false,
                    success: function(response) {
                        $('#editGroupName').text(groupName);
                        $('#editParameterGroupId').val(groupId);

                        if (response.length > 0) {
                            response.forEach(function(parameter) {
                                initialData[parameter.id] = {
                                    parameter_name: parameter.parameter_name,
                                    parameter_value: parameter.parameter_value,
                                    deleted: false
                                };

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

                                $('.modal-body .dynamic-fields').off('click').on(
                                    'click', '.delete-row',
                                    function() {
                                        var rowToRemove = $(this).closest(
                                            '.row');
                                        var rowIdToRemove = rowToRemove.data(
                                            'row-id');
                                        if (initialData && initialData
                                            .hasOwnProperty(rowIdToRemove)) {
                                            initialData[rowIdToRemove].deleted =
                                                true;
                                        } else {
                                            console.error(
                                                'initialData is undefined or row with ID ' +
                                                rowIdToRemove +
                                                ' not found.');
                                        }
                                        rowToRemove.remove();
                                    });
                            });
                        } else {
                            console.log('No parameter assigned.');
                        }

                        $('#addNewInputFields').off('click').on('click', function() {
                            var newInputFields = $(
                                '<div class="row mb-3" data-new-row="true">' +
                                '<div class="col-md-5">' +
                                '<input type="text" class="form-control" name="parameter_name[]">' +
                                '</div>' +
                                '<div class="col-md-5">' +
                                '<input type="text" class="form-control" name="parameter_value[]">' +
                                '</div>' +
                                '<div class="col-md-2">' +
                                '<button class="btn btn-danger-gradien btn-sm delete-new-row fa fa-trash-o" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete">' +
                                '</button>' +
                                '</div>' +
                                '</div>');

                            $('.modal-body .dynamic-fields').append(newInputFields);

                            $('.modal-body .dynamic-fields').on('click',
                                '.delete-new-row',
                                function() {
                                    $(this).closest('.row').remove();
                                });
                        });

                        $('#editModal').modal('show');
                    },
                    error: function(error) {
                        console.log('Error:', error);
                    }
                });
            });

            $('#saveChanges').off('click').click(function() {
                var saveChangesButton = $("#saveChanges");
                var originalsaveChangesButtonHtml = saveChangesButton.html();
                var itemTypeId = $('.item-type-id').val();
                var itemId = $('.item-id').val();
                var groupId = $('#editParameterGroupId').val();
                var hasEmptyFields = false;
                var rowsToUpdate = [];

                saveChangesButton.html(
                    '<span class="fw-bold">Saving <i class="fa fa-spinner fa-spin"></i></span>');

                $('.modal-body .dynamic-fields .row').each(function() {
                    var editedData = {
                        parameter_name: $(this).find('[name="parameter_name[]"]').val(),
                        parameter_value: $(this).find('[name="parameter_value[]"]').val()
                    };
                    if (!editedData.parameter_name.trim() || !editedData.parameter_value
                        .trim()) {
                        hasEmptyFields = true;
                        return false;
                    }
                });

                if (hasEmptyFields) {
                    toastr.error('Please fill in all the fields!');
                    saveChangesButton.html(originalsaveChangesButtonHtml);

                    return;
                } else {
                    $('.modal-body .dynamic-fields .row').each(function() {
                        var rowId = $(this).data('row-id');

                        var editedData = {
                            parameter_name: $(this).find('[name="parameter_name[]"]').val(),
                            parameter_value: $(this).find('[name="parameter_value[]"]')
                                .val()
                        };

                        if ($(this).data('new-row') !== true && initialData[rowId] &&
                            (editedData.parameter_name !== initialData[rowId].parameter_name ||
                                editedData.parameter_value !== initialData[rowId]
                                .parameter_value)) {
                            rowsToUpdate.push({
                                rowId: rowId,
                                parameter_name: editedData.parameter_name,
                                parameter_value: editedData.parameter_value
                            });
                        }
                    });

                    // Update Previous Row Into Database
                    if (rowsToUpdate.length > 0) {
                        for (var i = 0; i < rowsToUpdate.length; i++) {
                            var rowToUpdate = rowsToUpdate[i];
                            updateRowInDatabase(itemTypeId, itemId, groupId, rowToUpdate.rowId,
                                rowToUpdate
                                .parameter_name,
                                rowToUpdate.parameter_value);
                        }
                    } else {
                        toastr.error('No changes have been done!');
                    }

                    // Delete Row From Database
                    for (var id in initialData) {
                        if (initialData.hasOwnProperty(id) && initialData[id].deleted) {
                            if (initialData[id]) {
                                deleteRowFromDatabase(itemTypeId, itemId, groupId, id, initialData[id]
                                    .parameter_name);
                            } else {
                                console.error('Row with ID ' + id + ' not found in initialData.');
                            }
                        }
                    }

                    // Add Newly Added Row Into Database
                    var newDataRows = $('.modal-body .dynamic-fields .row[data-new-row="true"]');
                    newDataRows.each(function() {
                        var parameterName = $(this).find('[name="parameter_name[]"]').val();
                        var parameterValue = $(this).find('[name="parameter_value[]"]').val();
                        saveNewRowToDatabase(groupId, parameterName, parameterValue);
                    });
                }
                saveChangesButton.html(originalsaveChangesButtonHtml);
                performSearchWithParams(itemTypeId, itemId);
            });

            function updateRowInDatabase(itemTypeId, itemId, groupId, rowId, parameterName, parameterValue) {
                $.ajax({
                    url: '{{ url('admin/assign-parameter-value/update') }}',
                    method: 'post',
                    data: {
                        id: rowId,
                        item_type_id: itemTypeId,
                        item_id: itemId,
                        group_id: groupId,
                        parameter_name: parameterName,
                        parameter_value: parameterValue,
                        _token: '{{ csrf_token() }}'
                    },
                    cache: false,
                    success: function(response) {
                        if (response.isSuccess === false) {
                            toastr.error(response.message);
                        } else if (response.isSuccess === true) {
                            toastr.success(response.message);
                        }

                        $('#editModal').modal('hide');
                    },
                    error: function(error) {
                        toastr.error(error.responseText, error.statusText);
                    }
                });
            }

            function deleteRowFromDatabase(itemTypeId, itemId, groupId, id, parameterName) {
                if (initialData[id]) {
                    initialData[id].deleted = true;

                    delete initialData[id];
                }

                // Perform the AJAX request to delete the row from the database
                $.ajax({
                    url: '{{ url('admin/assign-parameter-value/destroy') }}',
                    method: 'post',
                    data: {
                        id: id,
                        item_type_id: itemTypeId,
                        item_id: itemId,
                        group_id: groupId,
                        parameter_name: parameterName,
                        _token: '{{ csrf_token() }}'
                    },
                    cache: false,
                    success: function(response) {
                        if (response.isSuccess === false) {
                            toastr.error(response.message);
                        } else if (response.isSuccess === true) {
                            toastr.success(response.message);
                        }

                        $('#editModal').modal('hide');
                    },
                    error: function(error) {
                        toastr.error(error.responseText, error.statusText);
                    }
                });
            }


            function saveNewRowToDatabase(groupId, parameterName, parameterValue) {
                $.ajax({
                    url: '{{ url('admin/assign-parameter-value/store') }}',
                    method: 'post',
                    data: {
                        assign_parameter_group_id: groupId,
                        parameter_name: parameterName,
                        parameter_value: parameterValue,
                        _token: '{{ csrf_token() }}'
                    },
                    cache: false,
                    success: function(response) {
                        if (response.isSuccess === false) {
                            toastr.error(response.message);
                        } else if (response.isSuccess === true) {
                            toastr.success(response.message);
                        }
                        $('#editModal').modal('hide');
                    },
                    error: function(error) {
                        toastr.error(error.responseText, error.statusText);
                    }
                });
            }
        }
    });
</script>
