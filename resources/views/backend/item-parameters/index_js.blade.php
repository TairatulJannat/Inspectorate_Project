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
                        Swal.fire(
                            'Successful!',
                            'Parameter Groups and related values were successfully retrieved!',
                            'success'
                        );
                        toastr.success(response.Message);

                        renderTreeView(response.treeViewData);
                    }

                    searchButton.html(originalSearchButtonHtml);
                },
                error: function(error) {
                    console.log('Error:', error);
                    toastr.error('An error occurred while processing the request.');
                },
            });
        });

        function renderTreeView(treeViewData) {
            var searchedDataContainer = $(".searched-data");

            searchedDataContainer.empty();

            if (treeViewData && treeViewData.length > 0) {
                var html = '<div class="row">';

                $.each(treeViewData, function(index, node) {
                    html +=
                        '<div class="col-md-6 mb-4">' +
                        '<div class="card parameter-group">' +
                        '<div class="card-body shadow">' +
                        '<h5 class="card-title parameter-group-name">Parameter Group Name: ' + node
                        .parameterGroupName + '</h5>' +
                        '<ul class="list-group parameter-values">';

                    $.each(node.parameterValues, function(i, parameterValue) {
                        html += '<li class="list-group-item">' +
                            '<span class="parameter-name">' + parameterValue.parameter_name +
                            ': </span>' +
                            '<span class="parameter-value">' + parameterValue.parameter_value +
                            '</span>' +
                            '</li>';
                    });

                    html += '</ul></div></div></div>';
                });

                html += '</div>';
                searchedDataContainer.append(html);
            } else {
                searchedDataContainer.html('<h2>Searched Item Parameters will appear here.</h2>');
            }
        }
    });
</script>
