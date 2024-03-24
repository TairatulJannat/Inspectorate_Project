@extends('backend.app')

@section('title', 'Indent Parameters')

@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend/css/datatables.css') }}">

    <style>
        /* styles.css */

        /* Styling for the card elements */
        .card {
            margin-bottom: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .card-header {
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #006A4E !important;
            border-radius: 8px 8px 0 0 !important;
            color: #ffff;
        }

        .card-body {}

        .table thead tr th {
            color: #ffff !important;
        }

        .col-5 {
            padding: 10px 15px !important;
        }

        .col-4,
        .col-2 {
            background-color: #F5F7FB !important;
            /* Light gray */
            border-radius: 8px;
            box-shadow: rgba(50, 50, 93, 0.25) 0px 6px 12px -2px, rgba(0, 0, 0, 0.3) 0px 3px 7px -3px;
        }

        h4 {
            margin-top: 0;
            color: #333;
        }

        /* Styling for the form elements */
        form {
            margin-top: 15px;
        }

        .delivery-btn {
            width: 100%;
            /* Adjust for padding */
            padding: 12px;
            border: none;
            border-radius: 5px;
            background-color: #ffffff !important;
            color: #006a4e8c;
            cursor: pointer;
        }

        .delivery-btn:hover {
            background-color: rgb(7, 66, 20), 59, 5) !important;
            /* Lighter orange on hover */
        }

        .forward_status {
            min-height: 250px
        }

        .remarks_status {
            min-height: 250px
        }

        .documents {
            display: flex;
            justify-content: center;
            column-gap: 10px;
            margin-bottom: 25px
        }
    </style>
@endpush

@section('main_menu', 'Indent Parameters')

@section('active_menu', 'Indent Spec')

@section('content')
    <div class="row bg-body p-3 m-3" style="border-radius:8px">
        <div class="d-flex flex-row-reverse"><button class="btn btn-success" onclick="rediract()"><i
                    class="fa fa-arrow-left"></i></button></div>
        <div class="text-success searched-data">
            <div class="text-center">
                <h2>Searched Item Parameters will appear here.</h2>
            </div>
        </div>
    </div>

    @include('backend.item-parameters.edit')

@endsection

@push('js')
    <script src="{{ asset('assets/backend/js/select2/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/backend/js/datatable/datatables/plugin/datatables.min.js') }}"></script>
    <script src="https://unpkg.com/sweetalert2@7.19.1/dist/sweetalert2.all.js"></script>
    <script src="{{ asset('assets/backend/js/select2/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/backend/js/notify/bootstrap-notify.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            var item_id = {{ $item_id }}
            var item_type_id = {{ $item_type_id }}
            var indentRefNo = {!! json_encode($indentRefNo) !!};

            var flag = false;

            performSearchWithParams(item_id, item_type_id, indentRefNo)

            function performSearchWithParams(item_id, item_type_id, indentRefNo) {
                $.ajax({
                    url: "{{ url('admin/assign-parameter-value/show') }}",
                    method: "POST",
                    data: {
                        'item-id': item_id,
                        'item-type-id': item_type_id,
                        'indentRefNo': indentRefNo,
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },
                    success: function(response) {
                        if (response.isSuccess === false) {
                            console.log(response)
                        } else if (response.isSuccess === true) {
                            renderTreeView(response.treeViewData, response.itemTypeName, response
                                .itemName);
                        }
                    },
                    error: function(error) {
                        console.log('Error:', error);
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

                var initialData = {};

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
                                    '<input type="text" class="form-control" name="parameter_name[]" value="">' +
                                    '</div>' +
                                    '<div class="col-md-5">' +
                                    '<input type="text" class="form-control" name="parameter_value[]" value="">' +
                                    '</div>' +
                                    '<div class="col-md-2">' +
                                    '<button class="btn btn-danger-gradien btn-sm delete-new-row fa fa-trash-o" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete">' +
                                    '</button>' +
                                    '</div>' +
                                    '</div>');

                                $('.modal-body .dynamic-fields').append(
                                    newInputFields);

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

                $('#saveChanges').click(function() {
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
                            flag = false;
                        }

                        // Delete Row From Database
                        for (var id in initialData) {
                            if (initialData.hasOwnProperty(id) && initialData[id].deleted) {
                                deleteRowFromDatabase(itemTypeId, itemId, groupId, id, initialData[id]
                                    .parameter_name);
                                flag = true;
                            }
                        }

                        // Add Newly Added Row Into Database
                        var newDataRows = $('.modal-body .dynamic-fields .row[data-new-row="true"]');
                        newDataRows.each(function() {
                            var parameterName = $(this).find('[name="parameter_name[]"]').val();
                            var parameterValue = $(this).find('[name="parameter_value[]"]').val();
                            saveNewRowToDatabase(groupId, parameterName, parameterValue,
                                indentRefNo);
                            flag = true;
                        });
                    }
                    saveChangesButton.html(originalsaveChangesButtonHtml);
                    if (flag == true) {
                        location.reload();
                    }
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

                function saveNewRowToDatabase(groupId, parameterName, parameterValue, indentRefNo) {
                    $.ajax({
                        url: '{{ url('admin/assign-parameter-value/store') }}',
                        method: 'post',
                        data: {
                            assign_parameter_group_id: groupId,
                            parameter_name: parameterName,
                            parameter_value: parameterValue,
                            indentRefNo: indentRefNo,
                            _token: '{{ csrf_token() }}'
                        },
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

        function rediract() {
            window.history.back();
        }
    </script>
@endpush
