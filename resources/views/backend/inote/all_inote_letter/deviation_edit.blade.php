@if ($deviation)
    <div class="inote_boc mb-2">
        <form action="" id="saveDeviation" method="POST" enctype="multipart/form-data">
            <input type="hidden" id="deviation_id" name="deviation_id" value="{{ $deviation->id }}">
            <div class="container">
                <div class="py-3">
                    <h3 class="text-center">APPLICATION FOR DEVIATION</h3>
                </div>
                <div class="row">
                    <h5>1. Details of contract</h5>
                    <div class="col-md-12 p-2">
                        <label for="file_no">File no:</label>
                        <input type="text" id="file_no" name="file_no" class="form-control"
                            value="{{ $deviation->file_no ?? '' }}">
                    </div>
                    <div class="col-md-6 p-2">
                        <label for="nomenclature">a. Nomenclature:</label>
                        <input type="text" class="form-control" name="nomenclature"
                            value="{{ $deviation->nomenclature ?? '' }}">
                    </div>
                    <div class="col-md-6 p-2">
                        <label for="contract_and_date">b. Contract no & dt</label>
                        <input type="text" id="contract_and_date" name="contract_no_dt" class="form-control"
                            value="{{ $deviation->contract_no_dt ?? '' }}">
                    </div>
                    <div class="col-md-6 p-2">
                        <label for="supplier">c. Supplier's name & address</label>
                        <input type="text" id="supplier" name="suppliers_name_address" class="form-control"
                            value="{{ $deviation->suppliers_name_address ?? '' }}">
                    </div>
                    <div class="col-md-6 p-2">
                        <label for="quantity">d. Quantity</label>
                        <input type="text" id="quantity" name="qty" class="form-control"
                            value="{{ $deviation->qty ?? '' }}">
                        <input type="text" class="form-control mt-2" name="on_order" placeholder="(1) On order"
                            value="{{ $deviation->on_order ?? '' }}">
                        <input type="text" class="form-control mt-2" name="deviation_required"
                            placeholder="(2) Deviation required" value="{{ $deviation->deviation_required ?? '' }}">
                        <input type="text" class="form-control mt-2" name="accepted_to_date"
                            placeholder="(3) Accepted to date" value="{{ $deviation->accepted_to_date ?? '' }}">
                    </div>
                    <div class="col-md-6 p-2">
                        <label for="particulars">e. Others particulars</label>
                        <input type="text" id="particulars" name="others_particulars" class="form-control"
                            value="{{ $deviation->others_particulars ?? '' }}">
                    </div>
                    <div class="col-md-6 p-2">
                        <label for="classification">f. Classification of deviation</label>
                        <input type="text" id="classification" name="classification_of_deviation"
                            class="form-control" value="{{ $deviation->classification_of_deviation ?? '' }}">
                    </div>
                    <div class="col-md-6 p-2">
                        <label for="contract_approved_simple_basis">g. Contract made on the basis on approved sample/advivance sample
                            basis</label>
                        <input type="text" id="contract_approved_simple_basis" name="contract_approved_simple_basis"
                            class="form-control" value="{{ $deviation->contract_approved_simple_basis ? $deviation->contract_approved_simple_basis:'' }}">
                    </div>
                </div>
                <div class="row mt-3">
                    <h5>2. The fol veviation (s) form particulars is/are recommended </h5>
                    <div class="col-md-12">
                        <textarea class="form-control" name="deviation_recommended" id="" cols="30" rows="10">{{ $deviation->deviation_recommended?$deviation->deviation_recommended: "" }}</textarea>
                        
                    </div>


                </div>
                <div class="row mt-3">
                    <h5>3. The stores are required fir issue to: </h5>
                    <div class="col-md-12">
                        <textarea class="form-control" name="stores_issue" id="stores_issue" cols="30" rows="10">{{ $deviation->stores_issue?$deviation->stores_issue: "" }}</textarea>
                    </div>


                </div>
                <div class="row mt-3">
                    <h5>4. It is considred that: </h5>
                    <div class="col-md-12">
                        <textarea class="form-control" name="considered_that" id="considered_that" cols="30" rows="10">{{ $deviation->considered_that?$deviation->considered_that: "" }}</textarea>
                    </div>

                </div>
                <div class="row mt-3">
                    <h5>5. Other Remarks: </h5>
                    <div class="col-md-12">
                        <textarea class="form-control" name="others_remarks" id="others_remarks" cols="30" rows="10">{{ $deviation->others_remarks?$deviation->others_remarks: "" }}</textarea>
                    </div>

                </div>
                <div class="row mt-3">

                    <div class="col-md-12">
                        <textarea class="form-control" name="deviation_applied_above" id="deviation_applied_above" cols="30"
                            rows="10">{{ $deviation->deviation_applied_above?$deviation->deviation_applied_above: "" }}</textarea>
                    </div>

                </div>
                <div class="row mt-3">
                    <h5>Copy to </h5>
                    <div class="col-md-12">
                        <textarea name="copy" class="form-control" id="copy" cols="30" rows="10">{{ $deviation->copy?$deviation->copy: "" }}</textarea>
                    </div>

                </div>

            </div>

            <div class="footer-box d-flex justify-content-center pt-2">

                <button type="submit" class="btn btn-success px-4 py-3" id="nextBtn2">Update</button>
            </div>
        </form>
    </div>
@else
    <div class="inote_boc mb-2">
        <div class="p-5"><h4 >Devation Form is not created yet</h4></div>
    </div>
@endif
