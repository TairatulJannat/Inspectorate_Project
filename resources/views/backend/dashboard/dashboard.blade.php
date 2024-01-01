@extends('backend.app')
@section('title', 'Dashboard')
@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend/css/animate.css') }}">
    <style>
.nav-tabs .nav-link{
    width: 15% !important;
    font-size: 24px;
    font-weight: bold;
    background-color: #ffff;
}
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
        <div class="tab-pane fade" id="nav-offer" role="tabpanel" aria-labelledby="nav-offer-tab">
            @include('backend.dashboard.offer')
        </div>

    </div>



@endsection

@push('js')
<script>
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            toastr.error('{{ $error }}', 'Error', {
                closeButton: true,
                progressBar: true,
            });
        @endforeach
    @endif
    console.log = function() {};




    var offeroptions2 = {
        chart: {
            height: 230,
            width: 450,
            type: 'bar',
            toolbar: {
                show: false
            }
        },
        plotOptions: {
            bar: {
                horizontal: true,
            }
        },
        dataLabels: {
            enabled: false
        },
        series: [{
            data: [100, 200, 300, 400]
        }],
        xaxis: {
            categories: ['Sep', 'Oct', 'Nov', 'Dec'],
        },
        colors: ['#B263C5']
    }

    var offer2 = new ApexCharts(
        document.querySelector("#basic-bar-offer"),
        offeroptions2
    );

    offer2.render();

    var options2 = {
        chart: {
            height: 210,
            width: 450,
            type: 'bar',
            toolbar: {
                show: false
            }
        },
        plotOptions: {
            bar: {
                horizontal: true,
            }
        },
        dataLabels: {
            enabled: false
        },
        series: [{
            data: [100, 200, 300, 400]
        }],
        xaxis: {
            categories: ['Sep', 'Oct', 'Nov', 'Dec'],
        },
        colors: ['#B263C5']
    }

    var chart2 = new ApexCharts(
        document.querySelector("#basic-bar"),
        options2
    );

    chart2.render();

    var options8 = {
        chart: {
            width: 380,
            type: 'pie',
        },
        labels: ['Team A', 'Team B', 'Team C', 'Team D', 'Team E'],
        series: [44, 55, 13, 43],
        responsive: [{
            breakpoint: 480,
            options: {
                chart: {
                    width: 200
                },
                legend: {
                    position: 'bottom'
                }
            }
        }],
        colors: [vihoAdminConfig.primary, vihoAdminConfig.secondary, '#222222', '#717171', '#e2c636']
    }

    var options9 = {
        chart: {
            width: 380,
            type: 'donut',
        },
        series: [{{$indentNewChart}}, {{$indentOnProcessChart}}, {{$indentCompletedChart}}, {{$indentDispatchChart}}],
        labels: ['New Arrival', 'On Process', 'Completed', 'Dispatch'],
        responsive: [{
            breakpoint: 480,
            options: {
                chart: {
                    width: 200
                },
                legend: {
                    position: 'bottom'
                }
            }
        }],
        colors: [vihoAdminConfig.primary, vihoAdminConfig.secondary, '#31D2F2', '#D22D3D']
    }

    var chart9 = new ApexCharts(
        document.querySelector("#donutchart"),
        options9
    );

    chart9.render();

    var offer = {
        chart: {
            width: 380,
            type: 'donut',
        },
        series: [{{$offerNewChart}}, {{$offerOnProcessChart}}, {{$offerCompletedChart}}, {{$offerDispatchChart}}],
        labels: ['New Arrival', 'On Process', 'Completed', 'Dispatch'],
        responsive: [{
            breakpoint: 480,
            options: {
                chart: {
                    width: 200
                },
                legend: {
                    position: 'bottom'
                }
            }
        }],
        colors: [vihoAdminConfig.primary, vihoAdminConfig.secondary, '#31D2F2', '#D22D3D']
    }

    var offer = new ApexCharts(
        document.querySelector("#donutchart-offer"),
        offer
    );

    offer.render();
</script>
@endpush
