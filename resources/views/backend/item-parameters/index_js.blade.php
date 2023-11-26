<script>
    $(document).ready(function() {
        // Initial Setup: Begins here
        $('.select2').select2();

        toastr.options.preventDuplicates = true;
        // Initial Setup: Ends here

        // Search Item Parameters
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
                            response
                            .itemName);
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
                var html =
                    '<div class="p-md-3 paper-document" style="background-color: honeydew;">' +
                    '<div class="header text-center">' +
                    '<div class="item-id f-30">' + itemName + '</div>' +
                    '<div class="item-type-id f-20">' + itemTypeName + '</div>' +
                    '</div>' +
                    '<div class="content">';

                $.each(treeViewData, function(index, node) {
                    html +=
                        '<div class="row parameter-group mt-5">' +
                        '<h5 class="parameter-group-name text-uppercase text-underline fw-bold">' + node
                        .parameterGroupName + '</h5>' +
                        '<table class="parameter-table table table-border-vertical table-hover">';

                    $.each(node.parameterValues, function(i, parameterValue) {
                        html +=
                            '<tr>' +
                            '<td class="col-md-4 parameter-name">' + parameterValue
                            .parameter_name +
                            '</td>' +
                            '<td class="col-md-8 parameter-value">' + parameterValue
                            .parameter_value +
                            '</td>' +
                            '</tr>';
                    });

                    html += '</table></div>';
                });

                html += '</div></div>';
                searchedDataContainer.append(html);
            } else {
                searchedDataContainer.html('<h2>Searched Item Parameters will appear here.</h2>');
            }
        }

        // Populate Items Dropdown: Begins here
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
        // Populate Items Dropdown: Ends here
    });
</script>
