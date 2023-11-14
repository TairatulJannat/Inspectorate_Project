<div class="modal fade" id="editItemTypeModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Item Type</h5>
            </div>
            <form action="{{ url('admin/item_types/update') }}" method="POST" id="editItemTypeForm" autocomplete="off">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="edit_item_type_id" id="edit_item_type_id">

                    <div class="mb-3">
                        <label for="editItemTypeName" class="form-label">Item Type Name</label>
                        <input type="text" class="form-control" id="editItemTypeName" name="edit_name">
                        <span class="text-danger error-text edit_name_error"></span>
                    </div>
                    <div class="mb-3">
                        <label for="editItemTypeStatus" class="form-label">Status</label>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="editItemTypeStatus" name="status">
                            <label class="form-check-label" for="editItemTypeStatus"></label>
                        </div>
                        <span class="text-danger error-text edit_status_error"></span>
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
