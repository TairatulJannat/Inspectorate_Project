<div class="modal fade" id="editInspectorateModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Inspectorate</h5>
            </div>
            <form action="{{ url('admin/inspectorates/update') }}" method="POST" id="editInspectorateForm"
                autocomplete="off">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="edit_inspectorate_id" id="edit_inspectorate_id">

                    <div class="mb-3">
                        <label for="editInspectorateName" class="form-label">Name</label>
                        <input type="text" class="form-control" id="editInspectorateName" name="edit_name">
                        <span class="text-danger error-text edit_name_error"></span>
                    </div>
                    <div class="mb-3">
                        <label for="editInspectorateSlag" class="form-label">Slag</label>
                        <input type="text" class="form-control" id="editInspectorateSlag" name="edit_slag">
                        <span class="text-danger error-text edit_slag_error"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="editButton">Update</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
