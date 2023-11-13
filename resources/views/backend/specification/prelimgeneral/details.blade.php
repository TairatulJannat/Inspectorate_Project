@extends('backend.app')
@section('title', 'Prelim/general')
@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend/css/datatables.css') }}">
@endpush
@section('main_menu', 'Prelim/general')
@section('active_menu', 'Details')
@section('content')

    <div class="panel-heading">
        <div class="invoice_date_filter" style="">

        </div>

    </div>
    <br>
    <div class="col-sm-12 col-xl-12">
        <div class="card">
            <div class="card-header">
                <div class="row justify-content-end ">
                    <div class="">
                        <a href="{{ route('admin.prelimgeneral/view') }}" type="button" class="btn-sm btn-success"
                            style="margin-left: 70%">Back</a>
                    </div>
                </div>
            </div>
            <div style="display: flex">
                <div class="card-body col-6" style="margin: 10px">
                    <div class="table-responsive">
                        <table class="table table-bordered yajra-datatable">
                            <tr>
                                <th>Referance No</td>
                                <td>{{$details->reference_no}}</td>
                            </tr>
                            <tr>
                                <th>User Directorate</td>
                                <td>{{$details->dte_managment_name}}</td>
                            </tr>

                            <tr>
                                <th>Name of Eqpt</td>
                                <td>{{$details->item_type_name}}</td>
                            </tr>
                            <tr>
                                <th>Receive Date</td>
                                <td>{{$details->spec_received_date}}</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="card-body col-3" style="margin: 10px;">
                    <h4>Forword Status</h4>
                    <ul>
                        <li><i class="fa fa-check ps-2 text-success" aria-hidden="true"></i>CR</li>
                        <li><i class="fa fa-check ps-2 text-success" aria-hidden="true"></i>Head Clark</li>
                        <li><i class="fa fa-check ps-2 text-success" aria-hidden="true"></i>AO</li>
                    </ul>
                </div>
                <div class="card-body col-2" style="margin: 10px;">
                    <h4>Forword</h4>
                    <form action="">
                        <select name="" id="" class="form-control ">

                            @foreach ($designations as $d)
                                <option value={{ $d->id }}>{{ $d->name }}</option>
                            @endforeach

                        </select>
                        <button class="btn btn-success mt-2">Forword</button>
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
    {{-- @include('backend.specification.prelimgeneral.index_js') --}}
@endpush
