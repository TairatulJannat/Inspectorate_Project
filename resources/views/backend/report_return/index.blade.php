@extends('backend.app')
@section('title', 'Report Returns')
@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend/css/datatables.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend/css/doc_design/doc.css') }}">
    <style>
        .card .card-header {
            padding: 0px;
            border-bottom: 1px solid rgba(182, 182, 182, .6);

        }

        .table {
            border-radius: 10px !important;
            box-shadow: rgba(0, 0, 0, 0.1) 0px 4px 12px;
        }

        .table thead {
            background: #1B4C43;
            color: #ffff
        }

        .table thead tr th {

            color: #ffff
        }


        .dt-buttons {
            margin-left: 8px;
        }
    </style>
@endpush
@section('main_menu', 'Index')
@section('active_menu', 'All Report')
@section('content')

    <div class="col-sm-12 col-xl-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered yajra-datatable">
                        <thead>
                            <tr>
                                <th>Sl No</th>
                                <th>From Date</th>
                                <th>End Date</th>
                                <th>Report</th>
                                <th>Act</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            ?>
                            @foreach ($rr_lists as $rr_list)
                                <tr>
                                    <td>{{ $i++ }}</td>
                                    <td>{{ $rr_list->from_date }}</td>
                                    <td>{{ $rr_list->to_date }}</td>
                                    <td>{{ $rr_list->report_type == 1 ? 'Weekly' : 'Monthly' }}</td>
                                    <td>
                                        <div class="d-flex">
                                            <form action="{{ route('admin.report_return/view', ['id' => $rr_list->id]) }}"
                                                method="get" class="m-1">
                                                @csrf
                                                <button class="btn-sm btn-info text-light" type="submit">View</button>
                                            </form>
                                            <form action="{{ route('admin.report_return/details', ['id' => $rr_list->id]) }}"
                                                method="get" class="m-1">
                                                @csrf
                                                <button class="btn-sm btn-success" type="submit">Details</button>
                                            </form>
                                            <form action="{{ route('admin.reportreturn/edit', ['id' => $rr_list->id]) }}"
                                                method="get" class="m-1">
                                                @csrf
                                                <button class="btn-sm btn-secondary text-light" type="submit">Edit</button>
                                            </form>
                                            <form action="{{ route('admin.report_return/detete', ['id' => $rr_list->id]) }}"
                                                method="post" class="m-1">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn-sm btn-danger" type="submit">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
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
@endpush
