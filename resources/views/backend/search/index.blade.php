@extends('backend.app')
@section('title', 'Search')
@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend/css/datatables.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend/css/select2.min.css') }}">
    <style>
        .search-box{
            width: 100%;
            margin: 15px;
            display: flex;
            justify-content: center
        }
        input{
        width:
        }
    </style>
@endpush
@section('main_menu', 'Search')
@section('active_menu', 'Search')
@section('content')

    <div class="container-fluid dashboard-default-sec">
        <div class="card">
            <div class="search-box">
                <select name="" id="" class="form-control">
                    <option value="">Select Document Type</option>
                    @foreach ($doc_types as $doc_type)
                    <option value="{{$doc_type->id}}">{{$doc_type->name}}</option>
                    @endforeach

                </select>
                <input type="text" placeholder="Enter Reference" class="form-control">
                <button class="form-control">Search</button>

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
@endpush
