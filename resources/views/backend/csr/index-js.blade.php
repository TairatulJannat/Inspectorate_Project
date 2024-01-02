<script>
    var xhr;

    $(document).ready(function() {
        var itemsData = {!! $items !!};
        populateItemsDropdown(itemsData);

        $('.select2').select2();
        // toastr.options.preventDuplicates = true;

        function updatePrintButtonUrl(tenderRefNo, itemTypeId, itemId) {
            var selectedItemType = itemTypeId;
            var selectedItem = itemId;
            var tenderRefNo = tenderRefNo;
            var printButton = $("#printButton");

            if (selectedItemType && selectedItem) {
                var printButtonUrl = '{{ url('admin/csr-generate-pdf') }}?tenderRefNo=' + tenderRefNo;
                printButton.attr('href', printButtonUrl);
            } else {
                printButton.addClass('disabled');
            }
        }

        $('#searchCSRForm').submit(function(e) {
            e.preventDefault();
            var form = this;
            performSearch(form);
        });

        var printButton = $("#printButton");
        printButton.addClass('disabled');

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
                        var buttonLink = $('#printButton');
                        buttonLink.addClass('disabled');
                        var searchedDataContainer = $(".searched-data");
                        searchedDataContainer.empty();
                    } else if (response.isSuccess === true) {
                        toastr.success(response.message);
                        renderTreeView(response.combinedData, response.itemTypeName, response
                            .itemName, response.indentRefNo, response.tenderRefNo);
                        var buttonLink = $('#printButton');
                        buttonLink.removeClass('disabled');
                        updatePrintButtonUrl(response.tenderRefNo, response.itemTypeId, response
                            .itemId);
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

        function renderTreeView(combinedData, itemTypeName, itemName, indentRefNo, tenderRefNo) {
            var searchedDataContainer = $(".searched-data");
            searchedDataContainer.empty();

            if (combinedData && combinedData.length > 0) {
                var html = '<div class="p-md-3 paper-document">' +
                    '<div class="header text-center">' +
                    '<div class="item-id f-30">' + itemName + '</div>' +
                    '<div class="item-type-id f-28">' + itemTypeName + '</div>' +
                    '<div class="tender-id f-20">Tender Ref. No: <span class="fw-bold">' + tenderRefNo +
                    '</span></div>' +
                    '<div class="indent-id f-20">Indent Ref. No: <span class="fw-bold">' + indentRefNo +
                    '</span></div>' +
                    '</div>' +
                    '<div class="content">';
                var globalSerialNumber = 1;

                $.each(combinedData, function(index, group) {
                    var groupName = Object.keys(group)[0];
                    var node = group[groupName];

                    html += '<div class="row parameter-group mt-5 edit-row">' +
                        '<span><h5 class="parameter-group-name text-uppercase text-underline fw-bold">' +
                        groupName + '</h5></span>' +
                        '<div class="table-responsive" style="overflow-x: auto; max-width: 100%;">' +
                        // Add this line
                        '<table class="parameter-table table table-bordered table-hover">' +
                        '<thead>' +
                        '<tr>' +
                        '<th style="background-color: #bdf5fb">Serial No.</th>' +
                        '<th style="background-color: #bdf5fb">Parameter Name</th>' +
                        '<th style="background-color: #bdf5fb">Indent Parameter Value</th>';

                    // Determine unique SupplierIds
                    var uniqueSupplierIds = [];
                    $.each(node, function(i, parameterValue) {
                        $.each(parameterValue, function(key, value) {
                            if (key.startsWith("Supplier_") && !uniqueSupplierIds
                                .includes(key)) {
                                uniqueSupplierIds.push(key);
                            }
                        });
                    });

                    // Add Supplier columns dynamically based on unique SupplierIds
                    $.each(uniqueSupplierIds, function(i, supplierId) {
                        var supplierNumber = supplierId.split("_")[1];
                        html += '<th style="background-color: #b0e0bc">' + supplierNumber +
                            "</th>";
                    });

                    html += '</tr>' +
                        '</thead>' +
                        '<tbody>';

                    $.each(node, function(i, parameterValue) {
                        html += '<tr>' +
                            '<td class="col-md-1" style="background-color: #bdf5fb">' +
                            globalSerialNumber++ + '</td>' +
                            '<td class="col-md-2 parameter-name" style="background-color: #bdf5fb">' +
                            parameterValue.parameter_name + '</td>' +
                            '<td class="col-md-2 parameter-value" style="background-color: #bdf5fb">' +
                            parameterValue.parameter_value + '</td>';

                        // Loop through unique SupplierIds
                        $.each(uniqueSupplierIds, function(j, supplierId) {
                            html +=
                                '<td class="col-md-2 parameter-value" style="background-color: #b0e0bc">' +
                                parameterValue[supplierId] + '</td>';
                        });

                        html += '</tr>';
                    });

                    html += '</tbody></table></div></div>'; // Add this line
                });

                html += '</div></div>';
                searchedDataContainer.append(html);
            } else {
                searchedDataContainer.html('<h2>Searched Item Parameters will appear here.</h2>');
            }
        }

        var tenderRefNo = new URLSearchParams(window.location.search).get('tenderRefNo');

        if (tenderRefNo) {
            $(".infoHide").hide();
            $(".infoShow").show();

            $.ajax({
                type: 'GET',
                url: "{{ url('admin/tender/info') }}",
                data: {
                    tenderRefNo: tenderRefNo
                },
                success: function(response) {
                    var tenderId = response.Data[0].id;

                    $.ajax({
                        type: 'GET',
                        url: "{{ url('admin/tender/info-to-csr') }}",
                        data: {
                            tenderId: tenderId
                        },
                        success: function(secondResponse) {
                            if (secondResponse.isSuccess === false) {
                                $.each(secondResponse.error, function(prefix, val) {
                                    $(form).find("span." + prefix + "-error")
                                        .text(val[0]);
                                });
                                toastr.error(secondResponse.message);
                                var buttonLink = $('#printButton');
                                buttonLink.addClass('disabled');
                                var searchedDataContainer = $(".searched-data");
                                searchedDataContainer.empty();
                            } else if (secondResponse.isSuccess === true) {
                                toastr.success(secondResponse.message);
                                renderTreeView(secondResponse.combinedData,
                                    secondResponse.itemTypeName, secondResponse
                                    .itemName, secondResponse.indentRefNo,
                                    secondResponse.tenderRefNo);
                                var buttonLink = $('#printButton');
                                buttonLink.removeClass('disabled');
                                updatePrintButtonUrl(secondResponse.tenderRefNo,
                                    secondResponse.itemTypeId, secondResponse
                                    .itemId);
                            }
                        },
                        error: function(xhr, status, error) {
                            // console.error(xhr.responseText);
                            console.error("I am here");
                        }
                    });
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }
    });
</script>
