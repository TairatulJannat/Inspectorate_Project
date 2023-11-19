<div class="modal fade" id="createItemModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Create Item</h5>
            </div>
            <form action="{{ url('admin/items/store') }}" method="POST" id="createItemForm" autocomplete="off">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="itemName" class="form-label">Item Name</label>
                        <input type="text" class="form-control" id="itemName" name="name">
                        <span class="text-danger error-text name_error"></span>
                    </div>
                    <div class="mb-3">
                        <label for="itemTypeId" class="form-label">Item Type</label><br>
                        <select class="form-control select2 itemTypeId" id="itemTypeId" name="item_type_id"
                            style="width: 100% !important;">
                            <option value="" selected disabled>Select an item</option>
                            @foreach ($item_types as $item_type)
                                <option value="{{ $item_type->id }}">{{ $item_type->name }}</option>
                            @endforeach
                        </select>
                        <span class="text-danger error-text item_type_id_error"></span>
                    </div>
                    <div class="mb-3">
                        <label for="itemAttribute" class="form-label">Attribute</label>
                        <input type="text" class="form-control" id="itemAttribute" name="attribute">
                        <span class="text-danger error-text attribute_error"></span>
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

