@extends('backend.app')
@section('title', 'Dashboard')
@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend/css/animate.css') }}">
    <style>

    </style>
@endpush
@section('main_menu', 'Dashboard')
@section('active_menu', 'Dashboard')
@section('content')


    <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <button class="nav-link active" id="nav-indent-tab" data-bs-toggle="tab" data-bs-target="#nav-indent" type="button"
                role="tab" aria-controls="nav-indent" aria-selected="true">Indent</button>
            <button class="nav-link" id="nav-offer-tab" data-bs-toggle="tab" data-bs-target="#nav-offer" type="button"
                role="tab" aria-controls="nav-offer" aria-selected="false">Offer</button>

        </div>
    </nav>
    <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane fade show active" id="nav-indent" role="tabpanel" aria-labelledby="nav-indent-tab">
            @include('backend.dashboard.indent')
        </div>
        <div class="tab-pane fade" id="nav-offer" role="tabpanel" aria-labelledby="nav-offer-tab">...</div>

    </div>



@endsection

@push('js')
    <script src="{{ asset('assets/backend/js/chart/chartjs/chart.min.js') }}"></script>
    <script>
        var doughnutCtx = document.getElementById("myDoughnutGraph").getContext("2d");
        var myDoughnutChart = new Chart(doughnutCtx).Doughnut(doughnutData, doughnutOptions);
        var myLineChart = {
            labels: ["", "10", "20", "30", "40", "50", "60", "70", "80"],
            datasets: [{
                fillColor: "rgba(113, 113, 113, 0.2)",
                strokeColor: "#717171",
                pointColor: "#717171",
                data: [10, 20, 40, 30, 0, 20, 10, 30, 10]
            }, {
                fillColor: "rgba(186, 137, 93, 0.2)",
                strokeColor: vihoAdminConfig.secondary,
                pointColor: vihoAdminConfig.secondary,
                data: [20, 40, 10, 20, 40, 30, 40, 10, 20]
            }, {
                fillColor: "rgb(36, 105, 92, 0.2)",
                strokeColor: vihoAdminConfig.primary,
                pointColor: vihoAdminConfig.primary,
                data: [60, 10, 40, 30, 80, 30, 20, 90, 0]
            }]
        }
    </script>
@endpush
