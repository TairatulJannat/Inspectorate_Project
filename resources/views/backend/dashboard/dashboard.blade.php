@extends('backend.app')
@section('title', 'Dashboard')
@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend/css/animate.css') }}">
    <style>
        .nav-tabs .nav-link {
            width: 15% !important;
            font-size: 24px;
            font-weight: bold;
            background-color: #ffff;
            border: none;
            border-radius: none;
        }

        .nav-tabs button {
            border: none;
            border-radius: 0px;
        }

        #nav-indent-tab {
            background-color: #28A8BC;
            color: #ffff;
        }

        #nav-offer-tab {
            background-color: #FBA45A;
            color: #ffff;
        }

        #nav-finalSpec-tab {
            background-color: #28A744;
            color: #ffff;
        }

        #nav-draftContract-tab {
            background-color: #B87AEB;
            color: #ffff;
        }

        #nav-contact-tab {
            background-color: #007AFF;
            color: #ffff;
        }

        #nav-iNote-tab {
            background-color: #AB8574;
            color: #ffff;
        }
    </style>
@endpush
@section('main_menu', 'Dashboard')
@section('active_menu', 'Dashboard')
@section('content')


    <nav class="mt-1">
        <div class="nav nav-tabs justify-content-between" id="nav-tab" role="tablist">
            <button class="nav-link active" id="nav-indent-tab" data-bs-toggle="tab" data-bs-target="#nav-indent"
                type="button" role="tab" aria-controls="nav-indent" aria-selected="true">Indent</button>
            <button class="nav-link" id="nav-offer-tab" data-bs-toggle="tab" data-bs-target="#nav-offer" type="button"
                role="tab" aria-controls="nav-offer" aria-selected="false">Offer</button>
            <button class="nav-link" id="nav-finalSpec-tab" data-bs-toggle="tab" data-bs-target="#nav-finalSpec"
                type="button" role="tab" aria-controls="nav-finalSpec" aria-selected="false">Final Spec</button>
            <button class="nav-link" id="nav-draftContract-tab" data-bs-toggle="tab" data-bs-target="#nav-draftContract"
                type="button" role="tab" aria-controls="nav-draftContract" aria-selected="false">Draft
                Contract</button>
            <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact" type="button"
                role="tab" aria-controls="nav-contact" aria-selected="false">Contract</button>
            <button class="nav-link" id="nav-iNote-tab" data-bs-toggle="tab" data-bs-target="#nav-iNote" type="button"
                role="tab" aria-controls="nav-iNote" aria-selected="false">I-Note</button>

        </div>
    </nav>
    <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane fade show active" id="nav-indent" role="tabpanel" aria-labelledby="nav-indent-tab">
            @include('backend.dashboard.indent')
        </div>
        <div class="tab-pane fade" id="nav-offer" role="tabpanel" aria-labelledby="nav-offer-tab">
            @include('backend.dashboard.offer')
        </div>

        <div class="col-sm-12 col-xl-12">
            <div class="card">

                <div class="card-body">
                    <div id="dasboard_barchart"></div>
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
                    '{{ $currentMonthStart->format('M') }}',
                    '{{ $oneMonthAgoStart->format('M') }}',
                    '{{ $twoMonthAgoStart->format('M') }}',
                    '{{ $threeMonthAgoStart->format('M') }}'
                ],
            },
            colors: ['#B263C5']
        }

        var chart2 = new ApexCharts(
            document.querySelector("#basic-bar-indent"),
            options2
        );

        chart2.render();

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
                    {{ $currentMonthData }},
                    {{ $oneMonthAgoData }},
                    {{ $twoMonthAgoData }},
                    {{ $threeMonthAgoData }}
                ]
            }],
            xaxis: {
                categories: [
                    '{{ $currentMonthStart->format('M') }}',
                    '{{ $oneMonthAgoStart->format('M') }}',
                    '{{ $twoMonthAgoStart->format('M') }}',
                    '{{ $threeMonthAgoStart->format('M') }}'
                ],
            },
            colors: ['#B263C5']
        }

        var chart2 = new ApexCharts(
            document.querySelector("#basic-bar_offer"),
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
            series: [{{ $indentNewChart }}, {{ $indentOnProcessChart }}, {{ $indentCompletedChart }},
                {{ $indentDispatchChart }}
            ],
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
            series: [{{ $offerNewChart }}, {{ $offerOnProcessChart }}, {{ $offerCompletedChart }},
                {{ $offerDispatchChart }}
            ],
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

        var indentReport = {
    series: [{
        data: [21, 22, 10, 28, 16, 21]
    }],
    chart: {
        height: 350,
        type: 'bar',
        events: {
            click: function(chart, w, e) {
                // console.log(chart, w, e)
            }
        },
        toolbar: {
            show: true,
            tools: {
                download: false,
                selection: false,
                zoom: false,
                zoomin: false,
                zoomout: false,
                pan: false,
                reset: false
            },
            autoSelected: 'zoom'
        },
        zoom: {
            enabled: false
        }
    },
    title: {
        text: 'Overall Report',
        align: 'center',
        style: {
            fontSize: '20px'
        }
    },
    plotOptions: {
        bar: {
            columnWidth: '45%',
            distributed: true,
            dataLabels: {
                position: 'top' // Show data values on top of bars
            }
        }
    },
    dataLabels: {
        enabled: true,
        formatter: function(val) {
            return val;
        },
        offsetY: -20,
        style: {
            fontSize: '12px',
            colors: ["#304758"]
        }
    },
    legend: {
        show: false
    },
    xaxis: {
        categories: [
            "Indent",
            'Offer',
            'Final Spec',
            'Draft Contract',
            'Contract',
            'I-Note',
        ],
        labels: {
            style: {
                fontSize: '12px'
            }
        }
    }
};

var renderIndentReport = new ApexCharts(document.querySelector("#dasboard_barchart"), indentReport);
renderIndentReport.render();

    </script>
@endpush
