<div class="modal fade" id="editParameterGroupModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Parameter Group</h5>
            </div>
            <form action="{{ url('admin/parameter_groups/update') }}" method="POST" id="editParameterGroupForm"
                autocomplete="off">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="edit-parameter-group-id" id="editParameterGroupId">

                    <div class="mb-3">
                        <label for="editItemTypeId" class="form-label">Item Type</label><br>
                        <select class="form-control select2 edit-item-type-id" id="editItemTypeId"
                            name="edit-item-type-id" style="width: 100% !important;">
                            <option value="" selected disabled>Select Item Type</option>
                            @foreach ($itemTypes as $itemType)
                                <option value="{{ $itemType->id }}">{{ $itemType->name }}</option>
                            @endforeach
                        </select>
                        <span class="text-danger error-text edit-item-type-id-error"></span>
                    </div>
                    <div class="mb-3">
                        <label for="editItemId" class="form-label">Item</label><br>
                        <select class="form-control select2 edit-item-id" id="editItemId" name="edit-item-id"
                            style="width: 100% !important;">
                            <option value="" selected disabled>Select an item</option>
                            @foreach ($items as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                        <span class="text-danger error-text edit-item-id-error"></span>
                    </div>
                    <div class="mb-3">
                        <label for="editParameterGroupName" class="form-label">Parameter Group Name</label>
                        <input type="text" class="form-control edit-parameter-group-name" id="editParameterGroupName"
                            name="edit-parameter-group-name">
                        <span class="text-danger error-text edit-parameter-group-name-error"></span>
                    </div>
                    <div class="mb-3">
                        <label for="editParameterGroupStatus" class="form-label">Status (Default Active)</label>
                        <div class="form-check form-switch">
                            <input class="form-check-input edit-parameter-group-status" type="checkbox"
                                id="editParameterGroupStatus" name="edit-parameter-group-status">
                            <label class="form-check-label" for="editParameterGroupStatus"></label>
                        </div>
                        <span class="text-danger error-text edit-parameter-group-status-error"></span>
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
