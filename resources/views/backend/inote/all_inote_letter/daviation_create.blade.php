<div class="inote_boc mb-2">
    <form action="" id='saveDeviation' method="POST" enctype="multipart/form-data">
        <input type="hidden" id="inote_reference_no" name="inote_reference_no" value="{{ $inote->reference_no }}">
        <div class="container">
            <div class="py-3">
                <h3 class="text-center">APPLICATION FOR DEVIATION</h3>
            </div>
            <div class="row">
                <h5>1. Details of contract</h5>
                <div class="col-md-12 p-2">
                    <label for="file_no"> File no:</label>
                    <input type="text" id="file_no" name="file_no" class="form-control">
                </div>
                <div class="col-md-6 p-2">
                    <label for="nomenclature">a. Nomenclature:</label>
                    <input type="text" class="form-control" name="nomenclature" >
                </div>

                <div class="col-md-6 p-2">
                    <label for="contract_and_date">b. Contract no & dt</label>
                    <input type="text" id="contract_and_date" name="contract_no_dt"  class="form-control">
                </div>
                <div class="col-md-6 p-2">
                    <label for="supplier">c. Supplier's name & address</label>
                    <input type="text" id="supplier" name="suppliers_name_address"  class="form-control">
                </div>
                <div class="col-md-6 p-2">
                    <label for="quantity">d. Quantity</label>
                    <input type="text" id="quantity" name="qty" class="form-control">
                    <input type="text" id="quantity" class="form-control mt-2" name="on_order"   placeholder="(1) On order">
                    <input type="text" id="quantity" class="form-control mt-2" name="deviation_required"  placeholder="(2) Deviation required">
                    <input type="text" id="quantity" class="form-control mt-2" name="accepted_to_date"   placeholder="(3) Accepted to date">

                </div>
                <div class="col-md-6 p-2">
                    <label for="particulars">e. Others particulars</label>
                    <input type="text" id="particulars" name="others_particulars"  class="form-control">
                </div>
                <div class="col-md-6 p-2">
                    <label for="classification">f. Classification of deviation</label>
                    <input type="text" id="classification" name="classification_of_deviation"  class="form-control">
                </div>
                <div class="col-md-6 p-2">

                    <label for="classification">g. Contract made on the basis on approved sample/advivance sample basis</label>
                    <input type="text" id="classification" name="contract_approved_simple_basis"  class="form-control">

                </div>

            </div>
            <div class="row mt-3">
                <h5>2. The fol veviation (s) form particulars is/are recommended </h5>
                <div class="col-md-12">
                    <textarea  class="form-control" name="deviation_recommended"  id="" cols="30" rows="10">a.</textarea>
                </div>


            </div>
            <div class="row mt-3">
                <h5>3. The stores are required fir issue to: </h5>
                <div class="col-md-12">
                    <textarea class="form-control" name="stores_issue"  id="" cols="30" rows="10">a.</textarea>
                </div>


            </div>
            <div class="row mt-3">
                <h5>4. It is considred that: </h5>
                <div class="col-md-12">
                    <textarea  class="form-control" name="considered_that"  id="" cols="30" rows="10">a.</textarea>
                </div>

            </div>
            <div class="row mt-3">
                <h5>5. Other Remarks: </h5>
                <div class="col-md-12">
                    <textarea class="form-control" name="others_remarks"  id="" cols="30" rows="10">a.</textarea>
                </div>

            </div>
            <div class="row mt-3">

                <div class="col-md-12">
                    <textarea  class="form-control" name="deviation_applied_above"  id="" cols="30" rows="10">6. The deviation (s) applied for avobe is/are recommended/sanctioned in full with .......% price reduction is in part ................above</textarea>
                </div>

            </div>
            <div class="row mt-3">
                <h5>Copy to </h5>
                <div class="col-md-12">
                    <textarea name="copy" class="form-control" id="" cols="30" rows="10">DGDP</textarea>
                </div>

            </div>

        </div>

        <div class="footer-box d-flex justify-content-center pt-2">
            <a href="#" class="btn btn-primary px-4 py-3 me-2" id="prevBtn">Previous</a>
            <button type="submit" class="btn btn-success px-4 py-3" id="nextBtn2">Save And Continue</button>
        </div>
    </form>
</div>
