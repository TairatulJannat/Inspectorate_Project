@extends('backend.app')
@section('title', 'Suppliers')
@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend/css/datatables.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend/css/select2.min.css') }}">
@endpush
@section('main_menu', 'Suppliers')
@section('active_menu', 'Suppliers Index')
@section('content')

    <div class="col-sm-12 col-xl-12">
        <div class="card">
            <div class="card-header">
                <div class="row justify-content-between align-items-center">
                    <div class="col-6">
                        <h6 class="card-title">Total: <span class="badge badge-secondary" id="total_data"></span></h6>
                    </div>
                    <!-- Button to trigger the modal -->
                    <div class="col-6">
                        <button type="button" class="btn btn-primary float-md-end" data-bs-toggle="modal"
                            data-bs-target="#createItemTypeModal">
                            Create Supplier
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body" style="margin-top: 10px">
                <div class="table-responsive">
                    <table class="table table-bordered yajra-datatable">
                        <thead>
                            <?php
                            $i = 1;
                            ?>
                            <tr>
                                <th>SL</th>
                                <th>Firm Name</th>
                                <th>Principal Name</th>
                                <th>Address of Principal</th>
                                <th>Address of Local Agent</th>
                                <th>Contact No</th>
                                <th>Email</th>
                                <th class="col-2">Action</th>
                            </tr>


                        </thead>
                        <tbody>

                            @foreach ($suppliers as $supplier)
                                <tr>
                                    <td>{{ $i++ }}</td>
                                    <td>{{ $supplier->firm_name }}</td>
                                    <td>{{ $supplier->principal_name }}</td>
                                    <td>{{ $supplier->address_of_principal }}</td>
                                    <td>{{ $supplier->address_of_local_agent }}</td>
                                    <td>{{ $supplier->contact_no }}</td>
                                    <td>{{ $supplier->email }}</td>
                                    <td>
                                        <button class="btn btn-danger"  data-supplier-id="{{ $supplier->id }}" id="delete_supplier">Delete</button>
                                        <button class="btn btn-info"  data-supplier-id="{{ $supplier->id }}" id="edit_supplier_btn">Edit</button>


                                        {{-- <a class="btn btn-info"
                                            href="{{ url('admin.supplier/edit', ['id' => $supplier->id]) }}">Edit</a> --}}
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Create Item Type Modal --}}
    @include('backend.supplier.create')
    {{-- Edit Item Type --}}
    @include('backend.supplier.edit')
    {{-- Show Item Type --}}
    {{-- @include('backend.supplier.show') --}}
@endsection

@push('custom-scripts')
    <script src="{{ asset('assets/backend/js/select2/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/backend/js/datatable/datatables/plugin/datatables.min.js') }}"></script>
    <script src="https://unpkg.com/sweetalert2@7.19.1/dist/sweetalert2.all.js"></script>
    <script src="{{ asset('assets/backend/js/notify/bootstrap-notify.min.js') }}"></script>
    <!-- Developer's JS file for brand page -->
    @include('backend.supplier.index_js')
@endpush
