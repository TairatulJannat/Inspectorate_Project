<div class="modal fade" id="editItemModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Item</h5>
            </div>
            <form action="{{ url('admin/items/update') }}" method="POST" id="editItemForm" autocomplete="off">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="edit_item_id" id="edit_item_id">

                    <div class="mb-3">
                        <label for="editItemName" class="form-label">Name</label>
                        <input type="text" class="form-control" id="editItemName" name="edit_name">
                        <span class="text-danger error-text edit_name_error"></span>
                    </div>
                    <div class="mb-3">
                        <label for="editItemAttribute" class="form-label">Attribute</label>
                        <input type="text" class="form-control" id="editItemAttribute" name="edit_attribute">
                        <span class="text-danger error-text edit_attribute_error"></span>
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
