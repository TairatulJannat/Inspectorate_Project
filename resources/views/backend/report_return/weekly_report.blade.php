@extends('backend.app')
@section('title', 'Report Return')
@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend/css/datatables.css') }}">
@endpush
@section('main_menu', 'Report Return ')
@section('active_menu', 'Weekly')
@section('content')

    <div class="col-sm-12 col-xl-12">
        <div class="card mt-2">
            <div class="row mt-2">


                <div class="modal-body">
                    <form action="" id="myForm">
                        <div class="d-flex justify-content-center align-item-center">

                            <div class="col-3">
                                Type:<select name="report_type" id="report_type" class="form-control">
                                    <option value="">Select Type</option>
                                    <option value="0">Weekly</option>
                                    <option value="1">Monthly</option>
                                </select>
                            </div>
                            <div class="col-3">
                                From: <input type="date" class="form-control" name="from_date" id="from_date">
                            </div>
                            <div class="col-3">
                                To: <input type="date" class="form-control" name="to_date" id="to_date">
                            </div>
                            <div class="col-3 d-flex justify-content-center align-item-center">
                                <button class='btn btn-success' id="rr_filter_btn">Filter</button>
                            </div>

                        </div>
                        <div class="row">

                            @csrf
                            <div id="report">


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
    <script></script>
@endpush
