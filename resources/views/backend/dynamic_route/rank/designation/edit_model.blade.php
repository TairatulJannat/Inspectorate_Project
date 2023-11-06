<div class="modal fade" id="edit_model" tabindex="-1" role="dialog" aria-labelledby="edit_model" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form action="" id="update_form">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Edit @yield('title')</h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="col-form-label">Name</label>
                        <input class="form-control" type="text" name="name" id="edit_name">
                        <span id="error_name" class="text-danger error_field"></span>
                    </div>
                    <input type="hidden" name="edit_id" id="edit_id">
                    <div class="mb-3">
                        <label class="col-form-label">Short Name</label>
                        <input class="form-control" type="text" name="short_name" id="edit_short_name">
                        <span id="error_short_name" class="text-danger error_field"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
                    <button class="btn btn-primary" type="submit" id="form_submission_button">Update changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
