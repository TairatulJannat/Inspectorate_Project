<div class="modal fade edit-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myLargeModalLabel">Edit Cover Letter</h4>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <div class="row">
                    <form action="" id="editForm">
                        @csrf

                        <div class="col-12 d-flex justify-content-center">
                            <div class="col-2">
                                <select name="page_sizeEdit" class="form-control bg-success text-light"
                                    id="page_sizeEdit">
                                    <option value="">Select Page Size</option>
                                    <option value="A4" {{ $cover_letter->page_size == 'A4' ? 'selected' : '' }}>
                                        A4
                                    </option>
                                    <option value="Legal" {{ $cover_letter->page_size == 'Legal' ? 'selected' : '' }}>
                                        Legal</option>
                                    <option value="Letter" {{ $cover_letter->page_size == 'Letter' ? 'selected' : '' }}>
                                        Letter</option>
                                </select>
                            </div>
                            <div class="col-3">
                                <input type="text" id="header_footerEdit" class="form-control "
                                    value="{{ $cover_letter->header_footer }}" placeholder="Header Here">
                            </div>
                        </div>
                        <input type="hidden" id="editId" value="{{ $cover_letter->id }}">
                        <input type="hidden" id="insp_id" value="{{ $details->insp_id }}">
                        <input type="hidden" id="sec_id" value="{{ $details->sec_id }}">
                        <input type="hidden" id="doc_reference_no" value="{{ $details->reference_no }}">
                        <input type="hidden" id="doc_type_id" value="5">
                        <div class="row text-center">
                            <div class="col-6 align-self-end">
                                <div class="input-group ">

                                    <input type="text" class="form-control " id="letter_reference_no"
                                        value="{{ $cover_letter->letter_reference_no }}">

                                </div>
                            </div>
                            <div class="col-2">

                            </div>
                            <div class="col-4">
                                <div>
                                    <input type="text" class="form-control inspectorate_name" id="inspectorate_name"
                                        name="inspectorate_name" placeholder="Inspectorate Name"
                                        value="{{ $cover_letter->inspectorate_name }}">
                                    <input type="text" class="form-control place" id="place" name="place"
                                        placeholder="Address" value="{{ $cover_letter->inspectorate_place }}">
                                    <input type="text" class="form-control mobile" id="mobile" name="mobile"
                                        placeholder="Telephone" value="{{ $cover_letter->mobile }}">
                                    <input type="text" class="form-control fax" id="fax" name="fax"
                                        placeholder="fax" value="{{ $cover_letter->fax }}">
                                    <input type="text" class="form-control email" id="email" name="email"
                                        placeholder="email" value="{{ $cover_letter->email }}">
                                    <input type="text" class="form-control date" id="date" name="date"
                                        placeholder="date" value="{{ $cover_letter->letter_date }}">
                                </div>
                            </div>
                        </div>
                        <div>
                            <input type="text" id="subject" class="form-control my-2" placeholder="Subject"
                                value="{{ $cover_letter->subject }}">
                        </div>
                        <div class="my-2">
                            <label for="body_1">Refs: </label>
                            <textarea class="form-control body_1" name="bodyEdit_1" id="bodyEdit_1">
                                {!! $cover_letter->body_1 !!}
                    </textarea>
                        </div>
                        <div class="mt-2">
                            <label for="body_2">Body </label>
                            <textarea class="form-control body_2" name="bodyEdit_2" id="bodyEdit_2">
                                {!! $cover_letter->body_2 !!}
                    </textarea>
                        </div>
                        <div class="row">
                            <div class="col-4"></div>
                            <div class="col-4"></div>
                            <div class="col-4 mt-5">

                                <div class="mt-2">
                                    <label for="signatureEdit">Signature Details </label>
                                    <textarea class="form-control " name="signatureEdit" id="signatureEdit"> {!! $cover_letter->signature !!}</textarea>
                                </div>

                            </div>
                        </div>
                        <div class="row">
                            <div>
                                <label for="anxs">Anxs: </label>
                                <textarea class="form-control" name="anxs" id="anxsEdit">
                                    {!! $cover_letter->anxs !!}</textarea>
                            </div>

                        </div>
                        <div class="row">

                            <div class="col-12 mt-2">
                                <div>
                                    <label for="distrEdit">Distr: </label>
                                    <textarea class="form-control" name="distrEdit" id="distrEdit">{!! $cover_letter->distr !!}</textarea>
                                </div>
                                <div>
                                    <label for="extl">Extl: </label>
                                    <textarea class="form-control" name="extlEdit" id="extlEdit">{!! $cover_letter->extl !!}</textarea>
                                </div>
                                <div>
                                    <label for="actEdit">Act: </label>
                                    <textarea class="form-control" name="actEdit" id="actEdit">{!! $cover_letter->act !!}</textarea>
                                </div>
                                <div>
                                    <label for="info">info: </label>
                                    <textarea class="form-control" name="infoEdit" id="infoEdit">{!! $cover_letter->info !!}</textarea>
                                </div>


                            </div>
                        </div>
                        <div class="row mt-2">
                            <div>
                                <label for="internalEdit">Internal: </label>
                                <textarea class="form-control" name="internal" id="internalEdit">
                                    {!! $cover_letter->internal !!}
                                </textarea>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-12 mt-2">
                                <div>
                                    <label for="internal_actEdit">Act: </label>
                                    <textarea class="form-control" name="internal_actEdit" id="internal_actEdit">
                                        {!! $cover_letter->internal_act !!}
                                        </textarea>
                                </div>
                                <div>
                                    <label for="internal_infoEdit">Info: </label>
                                    <textarea class="form-control" name="internal_infoEdit" id="internal_infoEdit">
                                        {!! $cover_letter->internal_info !!}
                                        </textarea>
                                </div>
                                {{-- <input type="text" class="form-control" id="internal_act" placeholder="Act">
                                    <input type="text" class="form-control" id="internal_info" placeholder="Info"> --}}

                            </div>
                        </div>

                        {{-- <div class="col-12 text-center">RESTRICTED</div> --}}

                        <div>
                            <button type="submit" class="btn btn-primary"> Update </button>
                        </div>

                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
