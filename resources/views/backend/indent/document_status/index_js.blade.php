<script>
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
                        d.indentId='{{$indentId}}';
                    },
                },
                columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    searchable: false
                },
                {
                    data: 'indent_item_id',
                    name: 'indent_item_id',
                    orderable: false
                },
                {
                    data: 'duration',
                    name: 'duration',
                    orderable: false
                },
                {
                    data: 'receive_date',
                    name: 'receive_date',
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

        // // Create Item Type
        // $("#createItemTypeForm").on("submit", function(e) {
        //     e.preventDefault();
        //     var form = this;
        //     var createButton = $("#createButton");
        //     createButton.prop('disabled', true).text('Saving...');
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
        //             console.log(response);
        //             if (response.isSuccess === false) {
        //                 $.each(response.error, function(prefix, val) {
        //                     $(form).find("span." + prefix + "_error").text(val[0]);
        //                 });
        //                 toastr.error(response.Message);
        //                 createButton.prop('disabled', false).text('Create');
        //             } else if (response.isSuccess === true) {
        //                 $(form)[0].reset();
        //                 $("#createItemTypeModal").modal("hide");
        //                 Swal.fire(
        //                     'Added!',
        //                     'Item Type Added Successfully!',
        //                     'success'
        //                 )
        //                 toastr.success(response.Message);
        //                 createButton.prop('disabled', false).text('Create');

        //                 // Reload the DataTable
        //                 $('.yajra-datatable').DataTable().ajax.reload();
        //             }
        //         },
        //         error: function(error) {
        //             console.log('Error:', error);
        //             toastr.error('An error occurred while processing the request.');
        //             createButton.prop('disabled', false).text('Create');
        //         },
        //     });
        // });

        // // Edit Item Type
        // $(document).on('click', '.edit_item_type', function(e) {
        //     e.preventDefault();
        //     let id = $(this).attr('id');
        //     $.ajax({
        //         url: '{{ url('admin/item_types/edit') }}',
        //         method: 'post',
        //         data: {
        //             id: id,
        //             _token: '{{ csrf_token() }}'
        //         },
        //         success: function(response) {
        //             $("#edit_item_type_id").val(id);
        //             $("#editItemTypeName").val(response.name);
        //             $("#editItemTypeStatus").prop('checked', response.status == 1);

        //             $('#editItemTypeModal').modal('show');
        //         }
        //     });
        // });

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

        // // Delete Item Type ajax request
        // $(document).on('click', '.delete_item_type', function(e) {
        //     e.preventDefault();
        //     let id = $(this).attr('id');
        //     let csrf = '{{ csrf_token() }}';
        //     Swal.fire({
        //         title: "Are you sure?",
        //         text: "You won't be able to revert this!",
        //         type: "warning",
        //         showCancelButton: true,
        //         confirmButtonColor: "#d33",
        //         cancelButtonColor: "#34C38F",
        //         confirmButtonText: "Yes, delete it!"
        //     }).then((result) => {
        //         if (result.value) {
        //             $.ajax({
        //                 url: '{{ url('admin/item_types/destroy') }}',
        //                 method: 'post',
        //                 data: {
        //                     id: id,
        //                     _token: csrf
        //                 },
        //                 success: function(response) {
        //                     if (response.isSuccess === true) {
        //                         Swal.fire(
        //                             'Deleted!',
        //                             'Item Type has been deleted.',
        //                             'success'
        //                         );
        //                         toastr.success(response.Message);

        //                         // Reload the DataTable
        //                         $('.yajra-datatable').DataTable().ajax.reload();
        //                     } else if (response.isSuccess === false) {
        //                         Swal.fire(
        //                             'Caution!',
        //                             'Something went wrong!',
        //                             'error'
        //                         );
        //                         toastr.error(response.Message);
        //                     }
        //                 },
        //                 error: function(error) {
        //                     // Handle AJAX request error
        //                     console.error(error);
        //                     Swal.fire(
        //                         'Error!',
        //                         'Failed to delete Item Type.',
        //                         'error'
        //                     );
        //                 }
        //             });
        //         }
        //     });
        // });

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
</script>
