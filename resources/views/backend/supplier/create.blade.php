<div class="modal fade" id="createItemTypeModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Create Supplier</h5>
            </div>
            <form action="" method="POST" id="createItemTypeForm">
                @csrf
                <div class="modal-body">
                   
                    <div class="mb-3">
                        <label for="firm_name" class="form-label">Firm Name</label>
                        <input type="text" class="form-control" id="firm_name" name="firm_name">
                        <span class="text-danger error-text firm_name_error"></span>
                    </div>
                    <div class="mb-3">
                        <label for="principal_name" class="form-label">Principal Name</label>
                        <input type="text" class="form-control" id="principal_name" name="principal_name">
                        <span class="text-danger error-text principal_name_error"></span>
                    </div>
                    <div class="mb-3">
                        <label for="address_of_principal" class="form-label">Address of Principal</label>
                        <input type="text" class="form-control" id="address_of_principal" name="address_of_principal">
                        <span class="text-danger error-text address_of_principal_error"></span>
                    </div>
                    <div class="mb-3">
                        <label for="address_of_local_agent" class="form-label">Address of Local Agent</label>
                        <input type="text" class="form-control" id="address_of_local_agent" name="address_of_local_agent">
                        <span class="text-danger error-text address_of_local_agenterror"></span>
                    </div>
                    <div class="mb-3">
                        <label for="contact_no" class="form-label">Contact No</label>
                        <input type="text" class="form-control" id="contact_no" name="contact_no">
                        <span class="text-danger error-text contact_no_error"></span>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="text" class="form-control" id="email" name="email">
                        <span class="text-danger error-text email_error"></span>
                    </div>
                 
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="form_submission_button">Create</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
