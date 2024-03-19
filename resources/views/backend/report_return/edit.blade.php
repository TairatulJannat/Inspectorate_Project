@extends('backend.app')
@section('title', 'Report Return ')
@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend/css/datatables.css') }}">
@endpush
@section('main_menu', 'Report Return ')
@section('active_menu', 'edit')
@section('content')

    <div class="col-sm-12 col-xl-12">
        <div class="card mt-2">
            <div class="row mt-2">


                <div class="modal-body">
                    <form action="" id="myForm">
                        <div class="d-flex justify-content-center align-item-center">

                            <div class="col-3">
                                Type:<select name="report_type" id="report_type" class="form-control">
                                    <option>Select Type</option>
                                    <option value="0" {{$rr_list->report_type="0"?'selected':'' }}>Weekly</option>
                                    <option value="1" {{$rr_list->report_type="1"?'selected':'' }}>Monthly</option>

                                </select>

                            </div>
                            <div class="col-3">
                                From: <input type="date" class="form-control" name="from_date" id="from_date" value="{{ $rr_list->from_date ? $rr_list->from_date : '' }}">
                            </div>
                            <div class="col-3">
                                To: <input type="date" class="form-control" name="to_date" id="to_date"
                                value="{{ $rr_list->to_date ? $rr_list->to_date : '' }}">
                            </div>
                            <div class="col-3 d-flex justify-content-center align-item-center">
                                <button class='btn btn-success' id="rr_filter_btn">Filter</button>
                            </div>

                        </div>
                        <div class="row">

                            @csrf
                            <div id="report">
                                <input type="hidden" name="edit_reportReturn_id" id="edit_reportReturn_id">
                                <div class="">
                                    <div class="">
                                        <div class="">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="myLargeModalLabel">Weekly Report</h4>

                                            </div>
                                            <div class="modal-body">

                                                <div class="row">

                                                    <div class="col-12 text-center m-2">
                                                        <div class="col-12 d-flex justify-content-center">
                                                            <div class="col-1 m-2">
                                                                <select name="page_size"
                                                                    class="form-control bg-success text-light"
                                                                    id="page_size">
                                                                    <option value="A4" {{ $rr_list->page_size == 'A4' ? 'selected' : '' }}>A4</option>
                                                                    <option value="Legal" {{ $rr_list->page_size == 'Legal' ? 'selected' : '' }}>Legal</option>

                                                                    <option value="Letter" {{ $rr_list->page_size == 'Letter' ? 'selected' : '' }}>Letter</option>

                                                                </select>
                                                            </div>
                                                            <div class="col-2 m-2">
                                                                <input type="text" id="header_footer"
                                                                    class="form-control" value="{{ $rr_list->header_footer ? $rr_list->header_footer : '' }}" placeholder="Header Here">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row text-center">
                                                        <div class="col-6 align-self-end">
                                                            <div class="input-group ">
                                                                <div class="input-group-prepend ">
                                                                    <span class="input-group-text">23.01.901.051. </span>
                                                                </div>
                                                                <input type="text" class="form-control" 
                                                                value="{{$rr_list->letter_reference_no ? $rr_list->letter_reference_no : '' }}id="letter_reference_no" >
                                                                <div class="input-group-append ">
                                                                    <span class="input-group-text ">
                                                                        .{{ \Carbon\Carbon::now()->format('d.m.y') }}
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-2">

                                                        </div>
                                                        <div class="col-4">
                                                            <div>
                                                                <input type="text" class="form-control inspectorate_name"
                                                                    id="inspectorate_name" value="{{ $rr_list->inspectorate_name ? $rr_list->inspectorate_name : '' }}" name="inspectorate_name"
                                                                    placeholder="Inspectorate Name"  >
                                                                <input type="text" class="form-control place"
                                                                    id="place" name="place" placeholder="Address"
                                                                    value="{{ $rr_list->inspectorate_place ? $rr_list->inspectorate_place : '' }}">
                                                                <input type="text" class="form-control mobile"
                                                                    id="mobile" name="mobile"placeholder="Telephone"
                                                                    value="{{ $rr_list->mobile ? $rr_list->mobile : '' }}">
                                                                <input type="text" class="form-control fax"
                                                                    id="fax" name="fax" placeholder="fax"
                                                                    value="{{ $rr_list->fax ? $rr_list->fax : '' }}">
                                                                <input type="text" class="form-control email"
                                                                    id="email" name="email" placeholder="email"
                                                                    value="{{ $rr_list->email ? $rr_list->email : '' }}">
                                                                <input type="text" class="form-control date"
                                                                    id="date"  value="{{ $rr_list->letter_date ? $rr_list->letter_date : '' }}" name="date" placeholder="date">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <textarea class="form-control my-2" name="subject" value="{{ $rr_list->subject ? $rr_list->subject : '' }}"  id="subject" placeholder="Subject"></textarea>
                                                        {{-- <input type="text" id="subject" class="form-control my-2" placeholder="Subject"> --}}
                                                    </div>
                                                    <div class="my-2">
                                                        <label for="body_1">Refs: </label>
                                                        <textarea class="form-control " name="body_1" id="body_2">{{ strip_tags($rr_list->body_1) }}</textarea>
                                                    </div>

                                                    <div class="row mt-2" id='report_html'>
                                                        {{ strip_tags($rr_list->body_2) }}
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-4"></div>
                                                        <div class="col-4"></div>
                                                        <div class="col-4 mt-5">

                                                            <div class="mt-2">
                                                                <label for="signature">Signature Details</label>
                                                                <textarea class="form-control" name="signature" id="signature">{{ strip_tags($rr_list->signature) }}</textarea>
                                                            </div>
                                                            

                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div>
                                                            <label for="anxs">Anxs: </label>
                                                            <textarea class="form-control" value="" name="anxs" id="anxsEdit">{{ strip_tags($rr_list->anxs) }}</textarea>
                                                        </div>

                                                    </div>
                                                    <div class="row">
                                                        <div class="col-12 mt-2">
                                                            <div>
                                                                <label for="distr">Distr: </label>
                                                                <textarea class="form-control" name="distr" id="distr">{{ strip_tags($rr_list->distr) }} </textarea>
                                                            </div>
                                                            <div>
                                                                <label for="extl">Extl: </label>
                                                                <textarea class="form-control" name="extl" id="extl">{{ strip_tags($rr_list->extl) }}</textarea>
                                                            </div>
                                                            <div>
                                                                <label for="act">Act: </label>
                                                                <textarea class="form-control" name="act" id="act"> {{ strip_tags($rr_list->act) }}</textarea>
                                                            </div>
                                                            <div>
                                                                <label for="info">info:</label>
                                                                <textarea class="form-control" name="info" id="info">{{ strip_tags($rr_list->info) }}</textarea>
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
                                                            <textarea class="form-control" name="internal" value="{{ $rr_list->internal ? $rr_list->internal : '' }}" id="internal">
                                                                </textarea>
                                                        </div>

                                                    </div>
                                                    <div class="row">
                                                        <div class="col-12 mt-2">
                                                            <div>
                                                                <label for="anxs">Act: </label>
                                                                <textarea class="form-control" name="internal_act" value="{{ $rr_list->internal_act ? $rr_list->internal_act : '' }}" id="internal_act"></textarea>
                                                            </div>
                                                            <div>
                                                                <label for="anxs">Info: </label>
                                                                <textarea class="form-control" value="{{ $rr_list->internal_info ? $rr_list->internal_info : '' }}" name="internal_info" id="internal_info"> </textarea>
                                                            </div>
                                                            {{-- <input type="text" class="form-control" id="internal_act" placeholder="Act">
                                                                    <input type="text" class="form-control" id="internal_info" placeholder="Info"> --}}

                                                        </div>
                                                    </div>
                                                    {{-- <div class="col-12 text-center">RESTRICTED</div> --}}

                                                    <div class="mt-2">
                                                        <button type="submit" class="btn btn-success"> Update </button>
                                                    </div>


                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>


                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
@endsection
@push('js')
    <script src="{{ asset('assets/backend/js/select2/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/backend/js/datatable/datatables/plugin/datatables.min.js') }}"></script>
    <script src="https://unpkg.com/sweetalert2@7.19.1/dist/sweetalert2.all.js"></script>
    <script src="{{ asset('assets/backend/js/select2/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/backend/js/notify/bootstrap-notify.min.js') }}"></script>
    @include('backend.report_return.report_js')
    <script>
        function ckEditor() {
        ClassicEditor
            .create(document.querySelector('#body_1'))
            .catch(error => {

            });
        ClassicEditor
            .create(document.querySelector('#body_2'))
            .catch(error => {

            });
        ClassicEditor
            .create(document.querySelector('#anxsEdit'))
            .catch(error => {

            });
        ClassicEditor
            .create(document.querySelector('#distr'))
            .catch(error => {

            });
        ClassicEditor
            .create(document.querySelector('#extl'))
            .catch(error => {

            });
        ClassicEditor
            .create(document.querySelector('#act'))
            .catch(error => {

            });
        ClassicEditor
            .create(document.querySelector('#info'))
            .catch(error => {

            });

        ClassicEditor
            .create(document.querySelector('#internal'))
            .catch(error => {

            });
        ClassicEditor
            .create(document.querySelector('#internal_info'))
            .catch(error => {

            });
        ClassicEditor
            .create(document.querySelector('#internal_act'))
            .catch(error => {

            });

        ClassicEditor
            .create(document.querySelector('#signature'))
            .catch(error => {

            });



    }
    </script>
@endpush
