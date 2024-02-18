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


        <div class="col-12">
            <div class="card">

                <div class="card-body">
                    <div id="dasboard_barchart" class="col-10"></div>
                </div>
            </div>
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
            data: [
                {{ $indentcurrentMonthData }},
                {{ $indentoneMonthAgoData }},
                {{ $indenttwoMonthAgoData }},
                {{ $indentthreeMonthAgoData }}
            ]
        }],
        xaxis: {
            categories: [
                '{{ $currentMonthStart->format("M") }}',
                '{{ $oneMonthAgoStart->format("M") }}',
                '{{ $twoMonthAgoStart->format("M") }}',
                '{{ $threeMonthAgoStart->format("M") }}'
            ],
        },
        colors: ['#B263C5']
    }

    var chart2 = new ApexCharts(
        document.querySelector("#basic-bar-indent"),
        options2
    );

    chart2.render();

        var docPieChart = {
          series: [44, 55, 13, 43],
          chart: {
          width: 380,
          type: 'pie',
        },
        labels: ['New Arrivel', 'Approved', 'Completed', 'Dispatch'],
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
        }]
        };

        var paichart = new ApexCharts(document.querySelector("#pichart"), docPieChart);
        paichart.render();

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
