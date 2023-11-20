<div class="modal fade" id="assignParameterValueGroupModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Assign Parameter Value Group</h5>
            </div>
            <form action="{{ url('admin/assign-parameter-value/store') }}" method="POST"
                id="assignParameterValueGroupForm" autocomplete="off">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="assign-parameter-group-id" id="assignParameterGroupId">

                    <div class="mb-3">
                        <label for="assignParameterGroupName" class="form-label">Parameter Group</label>
                        <input type="text" class="form-control assign-parameter-group-name"
                            id="assignParameterGroupName" name="assign-parameter-group-name" value="" disabled>
                        <span class="text-danger error-text assign-parameter-group-name-error"></span>
                    </div>
                    <div class="mb-3">
                        <label for="parameterName" class="form-label">Parameter Details</label>
                        <div class="container">
                            <div class="parameter-field-wrapper">
                                <div class="row mb-2">
                                    <div class="col-5 ps-0">
                                        <input type="text" class="form-control parameter-name" id="parameterName_1"
                                            name="parameter-name[]" placeholder="Name">
                                        <span class="text-danger error-text parameter-name-error"></span>
                                    </div>
                                    <div class="col-5">
                                        <input type="text" class="form-control parameter-value" id="parameterValue_1"
                                            name="parameter-value[]" placeholder="Value">
                                        <span class="text-danger error-text parameter-value-error"></span>
                                    </div>
                                    <div class="col-2">
                                        <a href="javascript:void(0);"
                                            class="btn btn-success-gradien float-end add-parameter-button"
                                            title="Add Parameter field">+</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="assignButton">Assign</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
