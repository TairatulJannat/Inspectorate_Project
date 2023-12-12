<script>
    var xhr;

    $(document).ready(function() {
        var itemsData = {!! $items !!};
        populateItemsDropdown(itemsData);

        $('.select2').select2();
        // toastr.options.preventDuplicates = true;

        $('#searchCSRForm').submit(function(e) {
            e.preventDefault();
            var form = this;
            performSearch(form);
        });

        $('#itemTypeId').on('change', function() {
            var itemTypeId = $(this).val();
            var filteredItems = itemsData.filter(item => item.item_type_id == itemTypeId);

            populateItemsDropdown(filteredItems);
        });

        function populateItemsDropdown(items) {
            $('#itemId').empty();
            $('#itemId').append('<option value="" selected disabled>Select an Item</option>');

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
                    if (response.isSuccess === false) {
                        $.each(response.error, function(prefix, val) {
                            $(form).find("span." + prefix + "-error").text(val[0]);
                        });
                        toastr.error(response.message);
                    } else if (response.isSuccess === true) {
                        toastr.success(response.message);
                        renderTreeView(response.combinedData, response.itemTypeName, response
                            .itemName);
                    }

                    searchButton.html(originalSearchButtonHtml);
                },
                error: function(error) {
                    console.log('Error:', error);
                    toastr.error('An error occurred while processing the request.');
                    searchButton.html(originalSearchButtonHtml);
                    var searchedDataContainer = $(".searched-data");
                    searchedDataContainer.empty();
                },
            });
        }

        function renderTreeView(combinedData, itemTypeName, itemName) {
            var searchedDataContainer = $(".searched-data");
            searchedDataContainer.empty();

            if (combinedData && combinedData.length > 0) {
                var html = '<div class="p-md-3 paper-document">' +
                    '<div class="header text-center">' +
                    '<div class="item-id f-30">' + itemName + '</div>' +
                    '<div class="item-type-id f-20">' + itemTypeName + '</div>' +
                    '</div>' +
                    '<div class="content">';

                $.each(combinedData, function(index, group) {
                    var groupName = Object.keys(group)[0];
                    var node = group[groupName];

                    html += '<div class="row parameter-group mt-5 edit-row">' +
                        '<span><h5 class="parameter-group-name text-uppercase text-underline fw-bold">' +
                        groupName + '</h5></span>' +
                        '<table class="parameter-table table table-border-vertical table-hover">' +
                        '<thead>' +
                        '<tr>' +
                        '<th>Parameter Name</th>' +
                        '<th>Parameter Value</th>';

                    // Determine unique SupplierIds
                    var uniqueSupplierIds = [];
                    $.each(node, function(i, parameterValue) {
                        $.each(parameterValue, function(key, value) {
                            log.warn(value);
                            if (key.startsWith("SupplierId_") && !uniqueSupplierIds
                                .includes(key)) {
                                uniqueSupplierIds.push(key);
                            }
                        });
                    });

                    // Add Supplier columns dynamically based on unique SupplierIds
                    $.each(uniqueSupplierIds, function(i, supplierId) {
                        var supplierNumber = supplierId.split("_")[1];
                        html += '<th>Supplier ' + supplierNumber + "'s Value</th>";
                    });

                    html += '</tr>' +
                        '</thead>' +
                        '<tbody>';

                    $.each(node, function(i, parameterValue) {
                        html += '<tr>' +
                            '<td class="col-md-2 parameter-name">' + parameterValue
                            .parameter_name + '</td>' +
                            '<td class="col-md-2 parameter-value">' + parameterValue
                            .parameter_value + '</td>';

                        // Loop through unique SupplierIds
                        $.each(uniqueSupplierIds, function(j, supplierId) {
                            html += '<td class="col-md-2 parameter-value">' +
                                parameterValue[supplierId] + '</td>';
                        });

                        html += '</tr>';
                    });

                    html += '</tbody></table></div>';
                });

                html += '</div></div>';
                searchedDataContainer.append(html);
            } else {
                searchedDataContainer.html('<h2>Searched Item Parameters will appear here.</h2>');
            }
        }


    });
</script>
