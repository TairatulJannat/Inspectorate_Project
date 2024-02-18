<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myLargeModalLabel">Cover Letter</h4>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <div class="row">
                    <form action="" id="myForm">
                        @csrf
                        <div class="col-12 text-center">
                            <div class="col-12 d-flex justify-content-center">
                                <div class="col-2">
                                    <select name="page_size" class="form-control bg-success text-light" id="page_size">
                                        <option value="A4">Select Page Size</option>
                                        <option value="A4">A4</option>
                                        <option value="Legal">Legal</option>
                                        <option value="Letter">Letter</option>
                                    </select>
                                </div>
                                <div class="col-3">
                                    <input type="text" id="header_footer" class="form-control "
                                        placeholder="Header Here">
                                </div>
                            </div>
                        </div>
                        <input type="hidden" id="insp_id" value="{{ $details->inspectorate_id }}">
                        <input type="hidden" id="sec_id" value="{{ $details->section_id }}">
                        <input type="hidden" id="doc_reference_no" value="{{ $details->reference_no }}">
                        <input type="hidden" id="doc_type_id" value="8">
                        <div class="row text-center">
                            <div class="col-6 align-self-end">
                                <div class="input-group ">
                                    <div class="input-group-prepend ">
                                        <span class="input-group-text">23.01.901.051. </span>
                                    </div>
                                    <input type="text" class="form-control " id="letter_reference_no">
                                    <div class="input-group-append ">
                                        <span class="input-group-text "> .{{ \Carbon\Carbon::now()->format('d.m.y') }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-2">

                            </div>
                            <div class="col-4">
                                <div>
                                    <input type="text" class="form-control inspectorate_name" id="inspectorate_name"
                                        name="inspectorate_name" placeholder="Inspectorate Name" value="I E & I">
                                    <input type="text" class="form-control place" id="place" name="place"
                                        placeholder="Address" value="Dhaka Cantt">
                                    <input type="text" class="form-control mobile" id="mobile" name="mobile"
                                        placeholder="Telephone" value="8711111 Ext-7122">
                                    <input type="text" class="form-control fax" id="fax" name="fax"
                                        placeholder="fax" value="9837120">
                                    <input type="text" class="form-control email" id="email" name="email"
                                        placeholder="email" value="iei.dci@army.mil.bd">
                                    <input type="text" class="form-control date" id="date" name="date"
                                        placeholder="date">
                                </div>
                            </div>
                        </div>
                        <div>
                            <textarea class="form-control my-2" name="subject" id="subject" placeholder="Subject"></textarea>
                            {{-- <input type="text" id="subject" class="form-control my-2" placeholder="Subject"> --}}
                        </div>
                        <div class="my-2">
                            <label for="body_1">Refs: </label>
                            <textarea class="form-control " name="body_1" id="body_1"></textarea>
                        </div>
                        <div class="mt-2">
                            <label for="body_2">Body </label>
                            <textarea class="form-control " name="body_2" id="body_2"></textarea>
                        </div>
                        <div class="row">
                            <div class="col-4"></div>
                            <div class="col-4"></div>
                            <div class="col-4 mt-5">

                                <div class="mt-2">
                                    <label for="signature">Signature Details </label>
                                    <textarea class="form-control " name="signature" id="signature"></textarea>
                                </div>

                            </div>
                        </div>
                        <div class="row">
                            <div>
                                <label for="anxs">Anxs: </label>
                                <textarea class="form-control" name="anxs" id="anxs"></textarea>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-12 mt-2">
                                <div>
                                    <label for="distr">Distr: </label>
                                    <textarea class="form-control" name="distr" id="distr"></textarea>
                                </div>
                                <div>
                                    <label for="extl">Extl: </label>
                                    <textarea class="form-control" name="extl" id="extl"></textarea>
                                </div>
                                <div>
                                    <label for="act">Act: </label>
                                    <textarea class="form-control" name="act" id="act"></textarea>
                                </div>
                                <div>
                                    <label for="info">info: </label>
                                    <textarea class="form-control" name="info" id="info"></textarea>
                                </div>
                                {{-- <input type="text" class="form-control" id="distr" placeholder="Distr">
                                    <input type="text" class="form-control" id="extl" placeholder="Extl">
                                    <input type="text" class="form-control" id="act" placeholder="Act">
                                    <input type="text" class="form-control" id="info" placeholder="info"> --}}

                            </div>
                        </div>
                        <div class="row mt-2">
                            <div>
                                <label for="anxs">Internal: </label>
                                <textarea class="form-control" name="internal" id="internal">
                                </textarea>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-12 mt-2">
                                <div>
                                    <label for="anxs">Act: </label>
                                    <textarea class="form-control" name="internal_act" id="internal_act">
                                        </textarea>
                                </div>
                                <div>
                                    <label for="anxs">Info: </label>
                                    <textarea class="form-control" name="internal_info" id="internal_info">
                                        </textarea>
                                </div>
                                {{-- <input type="text" class="form-control" id="internal_act" placeholder="Act">
                                    <input type="text" class="form-control" id="internal_info" placeholder="Info"> --}}

                            </div>
                        </div>
                        {{-- <div class="col-12 text-center">RESTRICTED</div> --}}

                        <div>
                            <button type="submit" class="btn btn-success"> Save </button>
                        </div>

                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
