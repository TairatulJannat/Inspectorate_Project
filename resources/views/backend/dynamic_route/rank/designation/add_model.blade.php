<div class="modal fade" id="add_model" tabindex="-1" role="dialog" aria-labelledby="add_model" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form action="" id="save_info">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Create @yield('title')</h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="col-form-label">Name</label>
                        <input class="form-control" type="text" name="name" id="name">
                        <span id="error_name" class="text-danger error_field"></span>
                    </div>
                    <div class="mb-3">
                        <label class="col-form-label">Short Name</label>
                        <input class="form-control" type="text" name="short_name" id="short_name">
                        <span id="error_short_name" class="text-danger error_field"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
                    <button class="btn btn-primary" type="submit" id="form_submission_button">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
