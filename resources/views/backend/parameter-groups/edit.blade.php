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
                    <input type="hidden" name="edit_parameter_group_id" id="editParameterGroupId">
                    <input type="hidden" name="edit_inspectorate_id" id="editInspectorateId">

                    <div class="mb-3">
                        <label for="editParameterGroupName" class="form-label">Parameter Group Name</label>
                        <input type="text" class="form-control" id="editParameterGroupName" name="edit_name">
                        <span class="text-danger error-text edit_name_error"></span>
                    </div>
                    <div class="mb-3">
                        <label for="editSectionId" class="form-label">Section</label><br>
                        <select class="form-control select2 editSectionId" id="editSectionId" name="edit_section_id"
                            style="width: 100% !important;">
                            <option value="" selected disabled>Select a section</option>
                            @foreach ($sections as $section)
                                <option value="{{ $section->id }}">{{ $section->name }}</option>
                            @endforeach
                        </select>
                        <span class="text-danger error-text edit_section_id_error"></span>
                    </div>
                    <div class="mb-3">
                        <label for="editParameterGroupDescription" class="form-label">Parameter Group
                            Description</label>
                        <textarea class="form-control" id="editParameterGroupDescription" name="edit_description"></textarea>
                        <span class="text-danger error-text edit_description_error"></span>
                    </div>
                    <div class="mb-3">
                        <label for="editParameterGroupStatus" class="form-label">Status (Default Active)</label>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="editParameterGroupStatus"
                                name="edit_status">
                            <label class="form-check-label" for="editParameterGroupStatus"></label>
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
