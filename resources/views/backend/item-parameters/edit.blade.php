<div class="modal fade" id="editModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
    aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Parameter Group: <span id="editGroupName"></span></h5>
                <input type="hidden" id="editParameterGroupId">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Container for dynamically generated input fields -->
                <div class="dynamic-fields"></div>
            </div>
            <div class="add-new-input p-2 text-center">
                <button class="btn btn-air-light fa fa-plus-circle" id="addNewInputFields"> Add New Parameters</button>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveChanges">Save changes</button>
            </div>
        </div>
    </div>
</div>
