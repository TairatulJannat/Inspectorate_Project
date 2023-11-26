<div class="modal fade" id="createDocTypeModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Create Doc Type</h5>
            </div>
            <form action="{{ url('admin/doc-type/store') }}" method="POST" id="createDocTypeForm" autocomplete="off">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="docTypeName" class="form-label">Doc Type Name</label>
                        <input type="text" class="form-control doc-type-name" id="docTypeName" name="doc-type-name">
                        <span class="text-danger error-text doc-type-name-error"></span>
                    </div>
                    <div class="mb-3">
                        <label for="docSerial" class="form-label">Doc Serial</label>
                        <input type="text" class="form-control doc-serial" id="docSerial" name="doc-serial">
                        <span class="text-danger error-text doc-serial-error"></span>
                    </div>
                    <div class="mb-3">
                        <label for="processingDay" class="form-label">Processing Day</label>
                        <input type="text" class="form-control processing-day" id="processingDay"
                            name="processing-day">
                        <span class="text-danger error-text processing-day-error"></span>
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
