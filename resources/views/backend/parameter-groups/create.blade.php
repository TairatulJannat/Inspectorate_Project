<div class="modal fade" id="createParameterGroupModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Create Parameter Group</h5>
            </div>
            <form action="{{ url('admin/parameter_groups/store') }}" method="POST" id="createParameterGroupForm"
                autocomplete="off">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="itemTypeId" class="form-label">Item Type</label><br>
                        <select class="form-control select2 item-type-id" id="itemTypeId" name="item-type-id"
                            style="width: 100% !important;">
                            <option value="" selected disabled>Select Item Type</option>
                            @foreach ($itemTypes as $itemType)
                                <option value="{{ $itemType->id }}">{{ $itemType->name }}</option>
                            @endforeach
                        </select>
                        <span class="text-danger error-text item-type-id-error"></span>
                    </div>
                    <div class="mb-3">
                        <label for="itemId" class="form-label">Item</label><br>
                        <select class="form-control select2 item-id" id="itemId" name="item-id"
                            style="width: 100% !important;">
                            <option value="" selected disabled>Select an item</option>
                            @foreach ($items as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                        <span class="text-danger error-text item-id-error"></span>
                    </div>
                    <div class="mb-3">
                        <label for="parameterGroupName" class="form-label">Parameter Group Name</label>
                        <div class="container">
                            <div class="field_wrapper">
                                <div class="row mb-2">
                                    <div class="col-10 ps-0">
                                        <input type="text" class="form-control parameter-group-name"
                                            id="parameterGroupName_1" name="parameter-group-name[]">
                                        <span class="text-danger error-text parameter-group-name-error"></span>
                                    </div>
                                    <div class="col-2">
                                        <a href="javascript:void(0);"
                                            class="btn btn-success-gradien float-end add_button" title="Add field">+</a>
                                    </div>
                                </div>
                            </div>
                        </div>
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
