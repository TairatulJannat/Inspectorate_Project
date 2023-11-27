<div class="modal fade" id="createItemTypeModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Document</h5>
            </div>
            <form action="{{ url('admin/item_types/store') }}" method="POST" id="createItemTypeForm"
                autocomplete="off">
                @csrf
                <div class="modal-body">
                    <input type="hidden" id="indentId" name="indentId" value="{{ $indentId }}">
                    <div class="mb-3">
                        <label for="indent_doc_id" class="form-label">Document</label>
                        <select name="indent_doc_id" id="indent_doc_id" class="form-control">
                            <option value="">Select Document</option>
                            <option value="">Doc Name</option>
                        </select>
                        <span class="text-danger error-text name_error"></span>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="duration">Duration</label>
                        <input class="form-control" type="text" id="duration" name="duration">
                        <span class="text-danger error-text status_error"></span>
                    </div>
                    <div class="mb-3">
                        <label class="form-check-label form-label" for="receiveStatus">Receive Status</label>
                        <input class="form-check-input" type="checkbox" id="receiveStatus" name="status" checked>
                        <span class="text-danger error-text status_error"></span>
                    </div>
                    <div class="mb-3">
                        <label class=" form-label" for="receiveStatus">Receive Date</label>
                        <input class="form-control"  type="date" id="receiveStatus" name="status" >
                        <span class="text-danger error-text status_error"></span>
                    </div>
                    <div class="mb-3">
                        <label class=" form-label" for="receiveStatus">Asking Date</label>
                        <input class="form-control" type="date" id="receiveStatus" name="status" >
                        <span class="text-danger error-text status_error"></span>
                    </div>
                    <div class="mb-3">
                        <label class=" form-label" for="receiveStatus">Member</label>
                        <input class="form-control" type="text" id="receiveStatus" name="status" >
                        <span class="text-danger error-text status_error"></span>
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
