<script>
    ClassicEditor
        .create(document.querySelector('#body_1'))
        .catch(error => {
            console.error(error);
        });
    ClassicEditor
        .create(document.querySelector('#body_2'))
        .catch(error => {
            console.error(error);
        });
    ClassicEditor
        .create(document.querySelector('#anxs'))
        .catch(error => {
            console.error(error);
        });
    ClassicEditor
        .create(document.querySelector('#distr'))
        .catch(error => {
            console.error(error);
        });
    ClassicEditor
        .create(document.querySelector('#extl'))
        .catch(error => {
            console.error(error);
        });
    ClassicEditor
        .create(document.querySelector('#act'))
        .catch(error => {
            console.error(error);
        });
    ClassicEditor
        .create(document.querySelector('#info'))
        .catch(error => {
            console.error(error);
        });

    ClassicEditor
        .create(document.querySelector('#internal'))
        .catch(error => {
            console.error(error);
        });
    ClassicEditor
        .create(document.querySelector('#internal_info'))
        .catch(error => {
            console.error(error);
        });
    ClassicEditor
        .create(document.querySelector('#internal_act'))
        .catch(error => {
            console.error(error);
        });

    // edit
    ClassicEditor
        .create(document.querySelector('#bodyEdit_1'))
        .catch(error => {
            console.error(error);
        });
    ClassicEditor
        .create(document.querySelector('#bodyEdit_2'))
        .catch(error => {
            console.error(error);
        });

    ClassicEditor
        .create(document.querySelector('#signatureEdit'))
        .catch(error => {
            console.error(error);
        });
    ClassicEditor
        .create(document.querySelector('#anxsEdit'))
        .catch(error => {
            console.error(error);
        });
    ClassicEditor
        .create(document.querySelector('#distrEdit'))
        .catch(error => {
            console.error(error);
        });
    ClassicEditor
        .create(document.querySelector('#extlEdit'))
        .catch(error => {
            console.error(error);
        });
    ClassicEditor
        .create(document.querySelector('#actEdit'))
        .catch(error => {
            console.error(error);
        });
    ClassicEditor
        .create(document.querySelector('#infoEdit'))
        .catch(error => {
            console.error(error);
        });
    ClassicEditor
        .create(document.querySelector('#signature'))
        .catch(error => {
            console.error(error);
        });

    ClassicEditor
        .create(document.querySelector('#internalEdit'))
        .catch(error => {
            console.error(error);
        });
    ClassicEditor
        .create(document.querySelector('#internal_infoEdit'))
        .catch(error => {
            console.error(error);
        });
    ClassicEditor
        .create(document.querySelector('#internal_actEdit'))
        .catch(error => {
            console.error(error);
        });

    // save cover letter
    $('#myForm').submit(function(e) {

        var formData = {}; // Object to store form data

        $(this).find('input, textarea, select').each(function() {
            var fieldId = $(this).attr('id');
            var fieldValue = $(this).val();
            formData[fieldId] = fieldValue;
        });

        console.log(formData);

        $.ajax({
            url: '{{ url('admin/cover_letter/create') }}',
            method: 'POST',
            data: formData,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                toastr.success('Information Saved', 'Saved');
            },
            error: function(error) {
                console.error('Error sending data:', error);
            }
        });
    });
    // edit cover letter
    $('#editForm').submit(function(e) {
        var formData = {}; // Object to store form data

        $(this).find('input, textarea, select').each(function() {
            var fieldId = $(this).attr('id');
            var fieldValue = $(this).val();
            formData[fieldId] = fieldValue;
        });

        $.ajax({
            url: '{{ url('admin/cover_letter/edit') }}',
            method: 'POST',
            data: formData,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                toastr.success('Information Updated', 'Saved');
            },
            error: function(error) {
                console.error('Error sending data:', error);
            }
        });
    });
</script>
