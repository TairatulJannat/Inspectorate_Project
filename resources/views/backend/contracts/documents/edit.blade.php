<div class="modal fade" id="editContractModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Document</h5>
            </div>
            <form action="" id="update_info">
                @csrf
                <input type="hidden" id="doc_id">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="contract_doc_id" class="form-label">Document</label>
                        <select name="contract_doc_id" id="contract_doc_id" class="form-control">
                            <option value="">Select Document</option>
                            @foreach ($additional_documents as $doc)
                                <option value="{{ $doc->id }}">{{ $doc->name }}</option>
                            @endforeach
                        </select>
                        <span class="text-danger error-text name_error"></span>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="duration">Duration</label>
                        <input class="form-control" type="text" id="duration" name="duration">
                        <span class="text-danger error-text duration_error"></span>
                    </div>
                    <div class="mb-3">
                        <label class="form-check-label form-label" for="receive_status">Receive Status</label>
                        <input class="form-check-input" type="checkbox" id="receive_status" name="receive_status"
                            checked>
                        <span class="text-danger error-text receive_status_error"></span>
                    </div>
                    <div class="mb-3" id="receiveDateContainer">
                        <label class=" form-label" for="receive_date">Receive Date</label>
                        <input class="form-control" type="date" id="receive_date" name="receive_date">
                        <span class="text-danger error-text rreceive_date_error"></span>
                    </div>
                    <div class="mb-3" id="askingDateContainer">
                        <label class=" form-label" for="asking_date">Asking Date</label>
                        <input class="form-control" type="date" id="asking_date" name="asking_date">
                        <span class="text-danger error-text receiveDate_error"></span>
                    </div>
                    <div class="mb-3">
                        <label class=" form-label" for="member">Member</label>
                        <select class="form-control" id="member" name="member">
                            <option value="">Select Number Of Member</option>
                            <option value="None">None</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                        </select>
                        <span class="text-danger error-text member_error"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
