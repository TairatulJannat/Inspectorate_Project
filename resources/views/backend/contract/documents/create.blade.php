<div class="modal fade" id="createContractModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Contract Document:</h5>
            </div>
            <form action="" id="store-contract-doc">
                @csrf
                <div class="modal-body">
                    <input type="hidden" id="contractId" name="contractId" value="{{ $contractId }}">
                    <div class="mb-3">
                        <label for="additionalDocTypeId" class="form-label required-field">Document Type</label><br>
                        <select name="additionalDocTypeId" id="additionalDocTypeId" class="form-control select2">
                            <option value="">Select Document Type</option>
                            @foreach ($additional_documents as $doc)
                                <option value="{{ $doc->id }}">{{ $doc->name }}</option>
                            @endforeach
                        </select>
                        <span id="errorAdditionalDocTypeId" class="text-danger error-text error-field"></span>
                    </div>
                    <div class="mb-3">
                        <label class="form-label required-field" for="duration">Duration</label><br>
                        <select class="form-control select2" id="duration" name="duration">
                            <option value="">Select Duration</option>
                            <option value="None">None</option>
                            <option value="1">1 days</option>
                            <option value="2">2 days</option>
                            <option value="3">3 days</option>
                            <option value="4">4 days</option>
                            <option value="5">5 days</option>
                            <option value="6">6 days</option>
                            <option value="7">7 days</option>
                            <option value="8">8 days</option>
                            <option value="9">9 days</option>
                            <option value="10">10 days</option>
                            <option value="11">11 days</option>
                            <option value="12">12 days</option>
                            <option value="13">13 days</option>
                            <option value="14">14 days</option>
                            <option value="15">15 days</option>
                        </select>
                        <span id="errorDuration" class="text-danger error-text error-field"></span>
                    </div>
                    <div class="mb-3">
                        <label class="form-check-label form-label" for="receiveStatus">Receive Status</label><br>
                        <input type="checkbox" class="custom-toggle-width" data-toggle="toggle" data-on="Received"
                            data-off="Not Received" data-onstyle="info" data-offstyle="warning" id="receiveStatus"
                            name="receiveStatus" checked data-width=150>
                        <span id="errorReceiveStatus" class="text-danger error-text error-field"></span>
                    </div>
                    <div class="mb-3" id="receiveDateContainer">
                        <div class="form-group flatpickr" data-wrap>
                            <label for="receiveDate" class="required-field">Receive Date</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="receiveDate" name="receiveDate"
                                    data-input>
                                <span class="input-group-text">
                                    <a class="btn m-0 p-0" title="Toggle" data-toggle>
                                        <i class="fa fa-calendar"></i>
                                    </a>
                                    {{-- <a class="btn m-0 p-0" title="Clear" data-clear>
                                        <i class="fa fa-close"></i>
                                    </a> --}}
                                </span>
                            </div>
                            <span id="errorReceiveDate" class="text-danger error-text error-field"></span>
                        </div>
                    </div>
                    <div class="mb-3" id="askingDateContainer">
                        <div class="form-group flatpickr" data-wrap>
                            <label for="askingDate" class="required-field">Asking Date</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="askingDate" name="askingDate" data-input>
                                <span class="input-group-text">
                                    <a class="btn m-0 p-0" title="Toggle" data-toggle>
                                        <i class="fa fa-calendar"></i>
                                    </a>
                                    {{-- <a class="btn m-0 p-0" title="Clear" data-clear>
                                        <i class="fa fa-close"></i>
                                    </a> --}}
                                </span>
                            </div>
                            <span id="errorAskingDate" class="text-danger error-text error-field"></span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label required-field" for="member">Member</label>
                        <select class="form-control select2" id="member" name="member">
                            <option value="">Select Number Of Member</option>
                            <option value="0">None</option>
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
                        <span id="errorMember" class="text-danger error-text error-field"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="form_submission_button">Save</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
