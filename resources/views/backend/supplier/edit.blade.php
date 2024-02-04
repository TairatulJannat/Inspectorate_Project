<div class="modal fade" id="edit_supplier" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Supplier</h5>
            </div>
            <form action=" " method="POST" id="update_form" autocomplete="off">
                @csrf

                <div class="modal-body">
                    <input type="hidden" name="update_id" id="update_id">
                    <div class="mb-3">
                        <label for="editfirm_name" class="form-label">Firm Name</label>
                        <input type="text" class="form-control" id="editfirm_name" name="editfirm_name">
                        <span class="text-danger error-text editfirm_name_error"></span>
                    </div>
                    <div class="mb-3">
                        <label for="editprincipal_name" class="form-label">Principal Name</label>
                        <input type="text" class="form-control" id="editprincipal_name" name="editprincipal_name">
                        <span class="text-danger error-text editprincipal_name_error"></span>
                    </div>
                    <div class="mb-3">
                        <label for="editaddress_of_principal" class="form-label">Address of Principal</label>
                        <input type="text" class="form-control" id="editaddress_of_principal" name="editaddress_of_principal">
                        <span class="text-danger error-text editaddress_of_principal_error"></span>
                    </div>
                    <div class="mb-3">
                        <label for="editaddress_of_local_agent" class="form-label">Address of Local Agent</label>
                        <input type="text" class="form-control" id="editaddress_of_local_agent" name="editaddress_of_local_agent">
                        <span class="text-danger error-text editaddress_of_local_agenterror"></span>
                    </div>
                    <div class="mb-3">
                        <label for="editcontact_no" class="form-label">Contact No</label>
                        <input type="text" class="form-control" id="editcontact_no" name="editcontact_no">
                        <span class="text-danger error-text editcontact_no_error"></span>
                    </div>
                    <div class="mb-3">
                        <label for="editemail" class="form-label">Email</label>
                        <input type="text" class="form-control" id="editemail" name="editemail">
                        <span class="text-danger error-text editemail_error"></span>
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
