@extends('backend.app')
@section('title','Prelim/General')
@push('css')
    <link rel="stylesheet" type="text/css" href="{{asset('assets/backend/css/select2.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/backend/css/datatables.css')}}">

@endpush
@section('main_menu','Rank / Designation')
@section('active_menu','Rank / Designation')
@section('link','')
@section('content')
    
    <div class="card">
        <div class="card-header">
            <div class="row justify-content-between align-items-center">
                <div class="col-6">
                    <h6 class="card-title">Total: <span class="badge badge-secondary" id="total_data"></span></h6>
                </div>
                <div class="col-6">
                    <a  href="{{route('admin.prelimgeneral/create')}}"  class="btn-sm btn-success" style="margin-left: 80%">Add @yield('title')</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered yajra-datatable">
                <thead>
                <tr>
                    <th>SL No</th>
                    <th>Name of Eqpt</th>
                    <th>User Directorate</th>
                    <th>Receive Dt</th>
                    <th>Present State of Spec</th>
                    <th>Remarks</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
    
    {{-- @include('backend.specification.add_model') --}}
    {{-- @include('backend.rank.designation.edit_model') --}}

@endsection
@push('js')
    <script src="{{asset('assets/backend/js/select2/select2.full.min.js')}}"></script>
    <script src="{{asset('assets/backend/js/datatable/datatables/plugin/datatables.min.js')}}"></script>
    <script src="{{asset('assets/backend/js/select2/select2.full.min.js')}}"></script>
    <script src="{{asset('assets/backend/js/sweetalert2.all.js')}}"></script>
    <script src="{{asset('assets/backend/js/notify/bootstrap-notify.min.js')}}"></script>
    <script src="https://unpkg.com/sweetalert2@7.19.1/dist/sweetalert2.all.js"></script>
    {{-- @include('backend.rank.designation.designation _js') --}}
@endpush
