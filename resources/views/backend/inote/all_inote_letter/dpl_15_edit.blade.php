@if ($dpl_15)
    <div class="inote_boc mb-2">
        <div class="container">
            <form action="" id='updateDPL' method="POST" enctype="multipart/form-data">
                <input type="hidden" id="dpl_15_id" name="dpl_15_id" value="{{ $dpl_15->id }}">
                <div class="row mt-3">

                    <div class="col-md-8 p-2">
                        <label for="">Firm's Name:</label>
                        <input type="text" class="form-control" name="firms_name" id="firms_name"
                            value="{{ $dpl_15->firms_name ?? '' }}">
                    </div>
                    <div class="col-md-8 p-2">
                        <label for="">nomenclature od store:</label>
                        <input type="text" class="form-control" name="nomenclature" id="nomenclature"
                            value="{{ $dpl_15->nomenclature ?? '' }}">
                    </div>
                    <div class="col-md-8 p-2">
                        <label for="">Contract no:</label>
                        <input type="text" class="form-control" name="contract_no" id="contract_no"
                            value="{{ $dpl_15->contract_no ?? '' }}">
                    </div>
                    <div class="col-md-8 p-2">
                        <label for="">Qty</label>
                        <input type="text" class="form-control" name="qty" id="qty"
                            value="{{ $dpl_15->qty ?? '' }}">
                    </div>


                </div>
                <div class="row mt-3">
                    <textarea name="warranty" class="form-control" id="warranty" cols="30" rows="10">
                        {{ $dpl_15->warranty ?? '' }}
                </textarea>
                </div>
                <div class="row mt-3">
                    <div class="col-md-6">

                    </div>
                    <label for="action">Action:</label>
                    <textarea name="action" class="form-control" id="action" cols="30" rows="10"> {{ $dpl_15->action ?? '' }}</textarea>
                </div>
                <div class="footer-box d-flex justify-content-center pt-2">

                    <button type="submit" class="btn btn-success px-4 py-3">Update</button>
                </div>
            </form>
        </div>

    </div>
@else
    <div class="inote_boc mb-2">
        <div class="p-5">
            <h4>DPL 15 form is not created yet</h4>
        </div>
    </div>
@endif
