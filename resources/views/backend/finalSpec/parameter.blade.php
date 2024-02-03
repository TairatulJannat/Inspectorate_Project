@extends('backend.app')

@section('title', 'Final Spec Parameter')

@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend/css/datatables.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend/css/select2.min.css') }}">
@endpush

@section('main_menu', 'Final Spec')
@section('active_menu', 'Parameter')

@section('content')

    <div class="row bg-body mx-1" style="background-color: rgb(255, 255, 255) !important;">
        <div class="text-success ">

            @foreach ($groupedData as $parameterGroupId => $groupedCollection)
                <div class="container mt-4">
                    <h2>Parameter Group ID: {{ $parameterGroupId }}</h2>
                    <table class="table table-bordered">
                        {{-- Uncomment the thead section if you want to include table headers --}}
                        {{-- <thead>
                        <tr>
                            <th>Parameter Name</th>
                            <th>Parameter Value</th>
                            <!-- Add other columns as needed -->
                        </tr>
                    </thead> --}}
                        <tbody>
                            @foreach ($groupedCollection as $item)
                                <tr>
                                    {{-- Include the 'id' column if needed --}}
                                    {{-- <td>{{ $item->id }}</td> --}}
                                    <td class="col-4">{{ $item->parameter_name }}</td>
                                    <td class="col-8">{{ $item->parameter_value }}</td>
                                    <!-- Add other columns as needed -->
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endforeach


        </div>
    </div>
@endsection

@push('custom-scripts')
    <script src="{{ asset('assets/backend/js/select2/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/backend/js/datatable/datatables/plugin/datatables.min.js') }}"></script>
    <script src="https://unpkg.com/sweetalert2@7.19.1/dist/sweetalert2.all.js"></script>
    <script src="{{ asset('assets/backend/js/notify/bootstrap-notify.min.js') }}"></script>
    <!-- Developer's JS file for brand page -->
    {{-- @include('backend.csr.index-js') --}}
@endpush
