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
                        <label for="parameterGroupName" class="form-label">Parameter Group Name</label>
                        <input type="text" class="form-control" id="parameterGroupName" name="name">
                        <span class="text-danger error-text name_error"></span>
                    </div>
                    <div class="mb-3">
                        <label for="sectionId" class="form-label">Section</label><br>
                        <select class="form-control select2 sectionId" id="sectionId" name="section_id"
                            style="width: 100% !important;">
                            <option value="" selected disabled>Select an section</option>
                            @foreach ($sections as $section)
                                <option value="{{ $section->id }}">{{ $section->name }}</option>
                            @endforeach
                        </select>
                        <span class="text-danger error-text section_id_error"></span>
                    </div>
                    <div class="mb-3">
                        <label for="parameterGroupDescription" class="form-label">Parameter Group Description</label>
                        <textarea class="form-control" id="parameterGroupDescription" name="description"></textarea>
                        <span class="text-danger error-text description_error"></span>
                    </div>
                    <div class="mb-3">
                        <label for="parameterGroupStatus" class="form-label">Status (Default Active)</label>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="parameterGroupStatus" name="status"
                                checked>
                            <label class="form-check-label" for="parameterGroupStatus"></label>
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
