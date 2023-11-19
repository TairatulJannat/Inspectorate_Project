<div class="modal fade" id="createInspectorateModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Create Inspectorate</h5>
            </div>
            <form action="{{ url('admin/inspectorates/store') }}" method="POST" id="createInspectorateForm"
                autocomplete="off">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="inspectorateName" class="form-label">Name</label>
                        <input type="text" class="form-control" id="inspectorateName" name="name">
                        <span class="text-danger error-text name_error"></span>
                    </div>
                    <div class="mb-3">
                        <label for="inspectorateSlag" class="form-label">Slag</label>
                        <input type="text" class="form-control" id="inspectorateSlag" name="slag">
                        <span class="text-danger error-text slag_error"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="createButton">Create</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
