<div class="modal fade" id="createItemTypeModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Create Item Type</h5>
            </div>
            <form action="{{ url('admin/item_types/store') }}" method="POST" id="createItemTypeForm"
                autocomplete="off">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="itemTypeSection" class="form-label">Section</label>
                        <select id="itemTypeSection" name="itemTypeSection" class="form-control">
                            @foreach ($sections as $section)
                            <option value="{{$section->id}}">{{$section->name}}</option>
                            @endforeach
                        </select>
                        <span class="text-danger error-text itemTypeSection_error"></span>
                    </div>
                    <div class="mb-3">
                        <label for="itemTypeName" class="form-label">Item Type Name</label>
                        <input type="text" class="form-control" id="itemTypeName" name="name">
                        <span class="text-danger error-text name_error"></span>
                    </div>
                    <div class="mb-3">
                        <label for="itemTypeStatus" class="form-label">Status (Default Active)</label>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="itemTypeStatus" name="status" checked>
                            <label class="form-check-label" for="itemTypeStatus"></label>
                        </div>
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
