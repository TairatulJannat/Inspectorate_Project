<script>
    $(document).ready(function() {
        // Initial Setup: Begins here
        $('.supplier-id').select2({
                placeholder: 'Select a Supplier',
                // theme: 'bootstrap',
            });

        toastr.options.preventDuplicates = true;

        $('.con-fin-year').on('input', function() {
            var inputValue = $(this).val();
            var isValidYear = /^\d{4}$/.test(inputValue);

            if (!isValidYear) {
                $('.con-fin-year-error').text('Please enter a valid year (e.g., 2023)');
            } else {
                $('.con-fin-year-error').text('');
            }
        });
        // Initial Setup: Ends here

        // Create Contract
        $("#createContractForm").on("submit", function(e) {
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
                            $(form).find("span." + prefix + "-error").text(val[0]);
                        });
                        toastr.error(response.Message);
                    } else if (response.isSuccess === true) {
                        $(form)[0].reset();

                        Swal.fire(
                            'Added!',
                            'Contract Added Successfully!',
                            'success'
                        );
                        toastr.success(response.Message);
                    }
                    createButton.prop('disabled', false).text('Create');
                },
                error: function(error) {
                    console.log('Error:', error);
                    toastr.error('An error occurred while processing the request.');
                    createButton.prop('disabled', false).text('Create');
                },
            });
        });
    });
</script>
