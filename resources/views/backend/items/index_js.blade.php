<script>
    $(document).ready(function() {
        $('.select2').select2();
        toastr.options.preventDuplicates = true;
    });

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
            success: function(data) {
                if (data.code == 0) {
                    $.each(data.error, function(prefix, val) {
                        $(form).find("span." + prefix + "_error").text(val[0]);
                    });
                    toastr.error(data.Message);
                    createButton.prop('disabled', false).text('Create');
                } else if (data.code == 1) {
                    $(form)[0].reset();
                    $("#createItemModal").modal("hide");
                    Swal.fire(
                        'Added!',
                        'Item Added Successfully!',
                        'success'
                    )
                    toastr.success(data.Message);
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
                $("#edit_item_id").val(id);
                $("#editItemName").val(response.name);
                $("#editItemAttribute").val(response.attribute);

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
            success: function(data) {
                if (data.code == 0) {
                    $.each(data.error, function(prefix, val) {
                        $(form).find("span." + prefix + "_error").text(val[0]
                            .replace("edit ", ""));
                    });
                    toastr.error(data.Message);
                    editButton.prop('disabled', false).text('Update');
                } else if (data.code == 1) {
                    $(form)[0].reset();
                    $("#editItemModal").modal("hide");
                    Swal.fire(
                        'Updated!',
                        'Item Edited Successfully!',
                        'success'
                    )
                    toastr.success(data.Message);
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

    function error_notification(message) {
        var notify = $.notify('<i class="fa fa-bell-o"></i><strong>' + message + '</strong> ', {
            type: 'theme',
            allow_dismiss: true,
            delay: 2000,
            showProgressbar: true,
            timer: 300
        });
    }
</script>
