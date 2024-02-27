<div class="inote_boc mb-2">
    <div class="container">
        <form action="" id='saveDPL' method="POST" enctype="multipart/form-data">
            <input type="hidden" id="inote_reference_no" name="inote_reference_no" value="{{ $inote->reference_no }}">
            <div class="row mt-3">

                <div class="col-md-8 p-2">
                    <label for="">Firm's Name:</label>
                    <input type="text" class="form-control" name="firms_name">
                </div>
                <div class="col-md-8 p-2">
                    <label for="">nomenclature od store:</label>
                    <input type="text" class="form-control" name="nomenclature">
                </div>
                <div class="col-md-8 p-2">
                    <label for="">Contract no:</label>
                    <input type="text" class="form-control" name="contract_no">
                </div>
                <div class="col-md-8 p-2">
                    <label for="">Qty</label>
                    <input type="text" class="form-control" name="qty">
                </div>


            </div>
            <div class="row mt-3">
                <textarea name="warranty" class="form-control" id="" cols="30" rows="10">
                    1. We hereby guarantee that the articles supplied under term of this contract are produced new in accordance with approved drawing and in all respects in accordance with terms of the contract, and that the materials used, whether or not on our manufacture, are in accordance with the latest appropriate standard specification, as also in accordance with the term of the contract, complete of good workmanship throughout and that we will replace free of cost (to the consignee at Dhaka as the case may be) every article or part there of which before use or in use shall be found defective or within the limits and tolerance with the terms or the contract.
                        In case of our failure to replace the defective stores free of cost within a reasonable period, we will refund the relevant cost in the currency in which received
                        2.
                        The warranty/guarantee will remain valid for.....................................................................................................................
                        after receipt of stores by the consignee or user unit.
                </textarea>
            </div>
            <div class="row mt-3">
                <div class="col-md-6">

                </div>
                <label for="action">Action:</label>
               <textarea name="action" class="form-control" id="" cols="30" rows="10"></textarea>
            </div>
            <div class="footer-box d-flex justify-content-between pt-2">
                <button type="submit" class="btn btn-primary px-4 py-3 me-2" id="form_submission_button">Previous</button>
                <button type="submit" class="btn btn-success px-4 py-3" id="form_submission_button">Save And Next</button>
            </div>
        </form>
    </div>

</div>
