<div class="modal fade" id="createItemTypeModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Document</h5>
            </div>
            <form action="" id="save_info">
                @csrf
                <div class="modal-body">
                    <input type="hidden" id="indent_id" name="indent_id" value="{{ $indentId }}">
                    <div class="mb-3">
                        <label for="indent_doc_id" class="form-label">Document</label>
                        <select name="indent_doc_id" id="indent_doc_id" class="form-control">
                            <option value="">Select Document</option>
                            @foreach ($additional_documents as $doc)
                                <option value="{{ $doc->id }}">{{ $doc->name }}</option>
                            @endforeach

                        </select>
                        <span class="text-danger error-text name_error"></span>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="duration">Duration</label>
                        {{-- <input class="form-control" type="text" id="duration" name="duration"> --}}
                        <select class="form-control" id="duration" name="duration">
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

                        <span class="text-danger error-text duration_error"></span>
                    </div>
                    <div class="mb-3">
                        <label class="form-check-label form-label" for="receive_status">Receive Status</label> <br>
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
                    <button type="submit" class="btn btn-primary">Create</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
