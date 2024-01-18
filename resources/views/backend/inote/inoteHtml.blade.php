@extends('backend.app')
@section('title', 'I-Note')
@push('css')
@endpush
@section('main_menu', 'I-Note')
@section('active_menu', 'Layout')
@section('content')
    <div class="col-sm-12 col-xl-12">
        <div class="card">
sdfsdf
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
