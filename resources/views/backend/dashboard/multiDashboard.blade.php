@extends('backend.app')
@section('title', 'Dashboard')
@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend/css/animate.css') }}">
    <style>
        .new-arrival-header {
            background-color: #1B4C43 !important;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 5px !important;
        }

        .new-arrival-header h3 {
            font-size: 32px !important;
            font-weight: bold;
            color: #ffffff;
            margin: 0 !important;
            padding: 0 !important;
        }

        .new-arrival-body {
            display: flex;
            justify-content: center;
            align-items: center;

            min-height: 120px;
        }

        .new-arrival-body h1 {
            font-size: 72px !important;
            font-weight: bold;
            color: #1B4C43;
            margin: 0 !important;
            padding: 0 !important;
        }

        .new-arrival-body h1 sub {
            font-size: 32px !important;
            font-weight: bold;
            color: #1B4C43;
            margin: 0 !important;
            padding: 0 !important;
        }

        .new-arrival-footer {
            display: flex;
            justify-content: end;
            align-items: center;
            padding: 0 20px 20px 0;
        }

        .new-arrival-footer a {
            color: #1B4C43;
            font-weight: bold;
        }

        .card {
            border-radius: 5px 5px 15px 15px;
        }

        .approved-header {
            background-color: #BA895D !important;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 5px !important;
        }

        .approved-header h3 {
            font-size: 32px !important;
            font-weight: bold;
            color: #ffffff;
            margin: 0 !important;
            padding: 0 !important;
        }

        .approved-body {
            display: flex;
            justify-content: center;
            align-items: center;

            min-height: 120px;
        }

        .approved-body h1 {
            font-size: 72px !important;
            font-weight: bold;
            color: #BA895D;
            margin: 0 !important;
            padding: 0 !important;
        }

        .approved-body h1 sub {
            font-size: 32px !important;
            font-weight: bold;
            color: #BA895D;
            margin: 0 !important;
            padding: 0 !important;
        }

        .approved-footer {
            display: flex;
            justify-content: end;
            align-items: center;
            padding: 0 20px 20px 0;
        }

        .approved-footer a {
            color: #BA895D;
            font-weight: bold;
        }

        .outgoing-header {
            background-color: #31D2F2 !important;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 5px !important;
        }

        .outgoing-header h3 {
            font-size: 32px !important;
            font-weight: bold;
            color: #ffffff;
            margin: 0 !important;
            padding: 0 !important;
        }

        .outgoing-body {
            display: flex;
            justify-content: center;
            align-items: center;

            min-height: 120px;
        }

        .outgoing-body h1 {
            font-size: 72px !important;
            font-weight: bold;
            color: #31D2F2;
            margin: 0 !important;
            padding: 0 !important;
        }

        .outgoing-body h1 sub {
            font-size: 32px !important;
            font-weight: bold;
            color: #31D2F2;
            margin: 0 !important;
            padding: 0 !important;
        }

        .outgoing-footer {
            display: flex;
            justify-content: end;
            align-items: center;
            padding: 0 20px 20px 0;
        }

        .outgoing-footer a {
            color: #31D2F2;
            font-weight: bold;
        }

        .dispatch-header {
            background-color: #D22D3D !important;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 5px !important;
        }

        .dispatch-header h3 {
            font-size: 32px !important;
            font-weight: bold;
            color: #ffffff;
            margin: 0 !important;
            padding: 0 !important;
        }

        .dispatch-body {
            display: flex;
            justify-content: center;
            align-items: center;

            min-height: 120px;
        }

        .dispatch-body h1 {
            font-size: 72px !important;
            font-weight: bold;
            color: #D22D3D;
            margin: 0 !important;
            padding: 0 !important;
        }

        .dispatch-body h1 sub {
            font-size: 32px !important;
            font-weight: bold;
            color: #D22D3D;
            margin: 0 !important;
            padding: 0 !important;
        }

        .dispatch-footer {
            display: flex;
            justify-content: end;
            align-items: center;
            padding: 0 20px 20px 0;
        }

        .dispatch-footer a {
            color: #D22D3D;
            font-weight: bold;
        }

        .nav-tabs .nav-link {
            width: 15% !important;
            font-size: 24px;
            padding: 0px;
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
        #nav-offer-tab:hover {
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
        .chart-container {
            position: relative;
            margin: auto;
            height: 80vh;
            width: 80vw;
        }

        .nav-link a {
            display: flex;
            justify-content: center;
            align-items: center;
            color: #ffffff;
            width: 100%;
            height: 100%;
            font-size: 24px;
            font-weight: bold;
        }
        .pichart, .myBarGraph {
        height: 95%
        }
    </style>
@endpush
@section('main_menu', 'Dashboard')
@section('active_menu', 'Dashboard')
@section('content')


    <nav class="mt-1">
        <div class="nav nav-tabs justify-content-between" id="nav-tab" role="tablist">
            <button class="nav-link active" id="nav-indent-tab" type="button"><a class="btn "
                href="{{ url('admin/adminDashboard') }}">Indent </a></button>
            <button class="nav-link" id="nav-offer-tab" type="button"><a class="btn "
                    href="{{ url('admin/multiDashboard/5') }}">Offer </a></button>
            <button class="nav-link" id="nav-finalSpec-tab"
                    type="button"><a href="{{ url('admin/multiDashboard/6') }}">Final Spec</a></button>
            <button class="nav-link" id="nav-draftContract-tab"
                    type="button"><a href="{{ url('admin/multiDashboard/9') }}">Draft Contract</a></button>
           <button class="nav-link" id="nav-contact-tab"
                    type="button"> <a href="{{ url('admin/multiDashboard/10') }}">Contract</a></button>
           <button class="nav-link" id="nav-iNote-tab"
                    type="button"> <a href="{{ url('admin/multiDashboard/13') }}">I-Note</a></button>

        </div>
    </nav>
    <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane fade show active" id="nav-indent" role="tabpanel" aria-labelledby="nav-indent-tab">
            <div class="col-xl-12 box-col-12 des-xl-100 mt-4">
                <div class="row">
                    <div class="col-xl-3 col-50 box-col-6 des-xl-50">
                        <div class="card">
                            <div class="card-header new-arrival-header">
                                <div class="header-top d-sm-flex align-items-center">
                                    <h3>New Arrival</h3>

                                </div>
                            </div>
                            <div class="card-body new-arrival-body p-0">
                                <div id="chart-dashbord"></div>
                                <div class="code-box-copy">
                                    <h1>{{ $mulipleModelNew }} <sub>{{ $doc_type->doc_name }}</sub></h1>

                                </div>
                            </div>
                            <div class="footer new-arrival-footer">
                                <div class="code-box-copy">
                                    <a href="{{ route('admin.indent/view') }}">View Details</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-50 box-col-6 des-xl-50">
                        <div class="card">
                            <div class="card-header approved-header">
                                <div class="header-top d-sm-flex align-items-center">
                                    <h3>On Process</h3>

                                </div>
                            </div>
                            <div class="card-body approved-body p-0">
                                <div id="chart-dashbord"></div>
                                <div class="code-box-copy">
                                    <h1>{{ $mulipleModelOnProcess }} <sub>{{ $doc_type->doc_name }}</sub></h1>

                                </div>
                            </div>
                            <div class="footer approved-footer">
                                <div class="code-box-copy">
                                    <a href="{{ route('admin.indent_approved/view') }}">View Details</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-50 box-col-6 des-xl-50">
                        <div class="card">
                            <div class="card-header outgoing-header">
                                <div class="header-top d-sm-flex align-items-center">
                                    <h3>Completed</h3>

                                </div>
                            </div>
                            <div class="card-body outgoing-body p-0">
                                <div id="chart-dashbord"></div>
                                <div class="code-box-copy">
                                    <h1>{{ $mulipleModelCompleted }} <sub>{{ $doc_type->doc_name }}</sub></h1>

                                </div>
                            </div>
                            <div class="footer outgoing-footer">
                                <div class="code-box-copy">
                                    <a href="{{ route('admin.indent/outgoing') }}">View Details</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-50 box-col-6 des-xl-50">
                        <div class="card">
                            <div class="card-header dispatch-header">
                                <div class="header-top d-sm-flex align-items-center">
                                    <h3>Dispatch</h3>

                                </div>
                            </div>
                            <div class="card-body dispatch-body p-0">
                                <div id="chart-dashbord"></div>
                                <div class="code-box-copy">
                                    <h1>{{ $mulipleModelDispatch }} <sub>{{ $doc_type->doc_name }}</sub></h1>

                                </div>
                            </div>
                            <div class="footer dispatch-footer">
                                <div class="code-box-copy">
                                    <a href="{{ route('admin.indent_dispatch/view') }}">View Details</a>
                                </div>
                            </div>
                        </div>
                    </div>



                </div>
            </div>


            <div class="row">
                <div class="col-sm-12 col-xl-6 box-col-6">
                    {{-- <div class="card">
                        <div class="card-header pb-0">
                            <h5>Indent report for last 4 month</h5>
                        </div>
                        <div class="card-body">
                            <div id="basic-bar-indent"></div>
                        </div>
                    </div> --}}
                    <div class="card myBarGraph">
                        <div class="card-header text-center pb-0">
                            <h5>Bar Chart</h5>
                            <hr>
                        </div>
                        <div class="card-body">
                            <canvas id="myBarGraph"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-xl-6 box-col-6">
                    <div class="card pichart">
                        <div class="card-header text-center pb-0">
                            <h5 > Current Status</h5>
                            <hr>
                        </div>
                        <div class="card-body apex-chart">
                            {{-- <div id="donutchart"></div> --}}
                            <div id="pichart"></div>
                        </div>
                    </div>
                </div>

            </div>
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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        //start piechart//
        var docPieChart = {
            series: [{{ $mulipleModelNew }}, {{ $mulipleModelOnProcess }}, {{ $mulipleModelCompleted }},
                {{ $mulipleModelDispatch }}
            ],
            chart: {
                width: 380,
                type: 'pie',
            },
            labels: ['New Arrivel', 'On Process', 'Completed', 'Dispatch'],
            colors: ['#1B4C43', '#BA895D', '#31D2F2', '#D22D3D'],
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
        //end piechart//

        //start barchart//
        var counts = <?php echo json_encode(array_values($counts)); ?>;
        var monthlyReport = {
            series: [{
                data: counts
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

        var renderMonthlyReport = new ApexCharts(document.querySelector("#dasboard_barchart"), monthlyReport);
        renderMonthlyReport.render();
        //end barchart//


        var barData = {
            labels: ["New Arrival", "On Process", "Completed", "Dispatch"],
            datasets: [{
                label: "Current status",
                backgroundColor: [
                    '#1B4C43', // Color for "New Arrival"
                    '#BA895D', // Color for "On Process"
                    '#31D2F2', // Color for "Completed"
                    '#D22D3D' // Color for "Dispatch"
                ],
                fillColor: "rgba(40, 105, 92, 0.4)",
                strokeColor: vihoAdminConfig.primary,
                highlightFill: "rgba(36, 105, 92, 0.6)",
                highlightStroke: vihoAdminConfig.primary,
                data: [35, 59, 80, 81, 56, 55, 40]
            }]
        };



        var barOptions = {
            scaleBeginAtZero: true,
            scaleShowGridLines: true,
            scaleGridLineColor: "rgba(0,0,0,0.1)",
            scaleGridLineWidth: 1,
            scaleShowHorizontalLines: true,
            scaleShowVerticalLines: true,
            barShowStroke: true,
            barStrokeWidth: 2,
            barValueSpacing: 5,
            barDatasetSpacing: 1,
        };


        var barCtx = document.getElementById("myBarGraph").getContext("2d");
        var myBarChart = new Chart(barCtx, {
            type: 'bar',
            data: barData,
            options: barOptions
        });
    </script>
@endpush
