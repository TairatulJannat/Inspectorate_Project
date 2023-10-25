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

    <div class="row">

        <div class="col-sm-12 col-xl-6 box-col-6">
            <div class="card">
                <div class="card-header pb-0">
                    <h5>Documents Processed (Total Quantity)</h5>
                </div>
                <div class="card-body" style="position: relative;">
                    <div id="basic-bar" style="min-height: 0px;">
                        <div id="apexchartspadqzjhq" class="apexcharts-canvas apexchartspadqzjhq light"
                            style="width: 580px; height: 350px;"><svg id="SvgjsSvg5416" width="580" height="350"
                                xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink"
                                xmlns:svgjs="http://svgjs.com/svgjs" class="apexcharts-svg" xmlns:data="ApexChartsNS"
                                transform="translate(0, 0)" style="background: transparent;">
                                <g id="SvgjsG5418" class="apexcharts-inner apexcharts-graphical"
                                    transform="translate(120, 0)">
                                    <defs id="SvgjsDefs5417">
                                        <linearGradient id="SvgjsLinearGradient5421" x1="0" y1="0"
                                            x2="0" y2="1">
                                            <stop id="SvgjsStop5422" stop-opacity="0.4" stop-color="rgba(216,227,240,0.4)"
                                                offset="0"></stop>
                                            <stop id="SvgjsStop5423" stop-opacity="0.5" stop-color="rgba(190,209,230,0.5)"
                                                offset="1"></stop>
                                            <stop id="SvgjsStop5424" stop-opacity="0.5" stop-color="rgba(190,209,230,0.5)"
                                                offset="1"></stop>
                                        </linearGradient>
                                        <clipPath id="gridRectMaskpadqzjhq">
                                            <rect id="SvgjsRect5426" width="442.3671875" height="277.348" x="0" y="0"
                                                rx="0" ry="0" fill="#ffffff" opacity="1" stroke-width="0"
                                                stroke="none" stroke-dasharray="0"></rect>
                                        </clipPath>
                                        <clipPath id="gridRectMarkerMaskpadqzjhq">
                                            <rect id="SvgjsRect5427" width="444.3671875" height="279.348" x="-1" y="-1"
                                                rx="0" ry="0" fill="#ffffff" opacity="1" stroke-width="0"
                                                stroke="none" stroke-dasharray="0"></rect>
                                        </clipPath>
                                    </defs>
                                    <rect id="SvgjsRect5425" width="0" height="277.348" x="0" y="0" rx="0"
                                        ry="0" fill="url(#SvgjsLinearGradient5421)" opacity="1" stroke-width="0"
                                        stroke-dasharray="3" class="apexcharts-xcrosshairs" y2="277.348" filter="none"
                                        fill-opacity="0.9"></rect>
                                    <g id="SvgjsG5456" class="apexcharts-yaxis apexcharts-xaxis-inversed" rel="0">
                                        <g id="SvgjsG5457"
                                            class="apexcharts-yaxis-texts-g apexcharts-xaxis-inversed-texts-g"
                                            transform="translate(0, 0)"><text id="SvgjsText5460"
                                                font-family="Helvetica, Arial, sans-serif" x="-15" y="70.59767272727274"
                                                text-anchor="end" dominant-baseline="auto" font-size="11px"
                                                font-weight="regular" fill="#373d3f" class="apexcharts-yaxis-label "
                                                style="font-family: Helvetica, Arial, sans-serif;">Prelim.
                                                Spec.</text><text id="SvgjsText5461"
                                                font-family="Helvetica, Arial, sans-serif" x="-15" y="98.33247272727274"
                                                text-anchor="end" dominant-baseline="auto" font-size="11px"
                                                font-weight="regular" fill="#373d3f" class="apexcharts-yaxis-label "
                                                style="font-family: Helvetica, Arial, sans-serif;">Gen. Spec.</text><text
                                                id="SvgjsText5462" font-family="Helvetica, Arial, sans-serif" x="-15"
                                                y="126.06727272727275" text-anchor="end" dominant-baseline="auto"
                                                font-size="11px" font-weight="regular" fill="#373d3f"
                                                class="apexcharts-yaxis-label "
                                                style="font-family: Helvetica, Arial, sans-serif;">Model Spec.</text><text
                                                id="SvgjsText5463" font-family="Helvetica, Arial, sans-serif" x="-15"
                                                y="153.80207272727276" text-anchor="end" dominant-baseline="auto"
                                                font-size="11px" font-weight="regular" fill="#373d3f"
                                                class="apexcharts-yaxis-label "
                                                style="font-family: Helvetica, Arial, sans-serif;">Indent</text><text
                                                id="SvgjsText5464" font-family="Helvetica, Arial, sans-serif" x="-15"
                                                y="181.53687272727277" text-anchor="end" dominant-baseline="auto"
                                                font-size="11px" font-weight="regular" fill="#373d3f"
                                                class="apexcharts-yaxis-label "
                                                style="font-family: Helvetica, Arial, sans-serif;">Offer</text><text
                                                id="SvgjsText5465" font-family="Helvetica, Arial, sans-serif" x="-15"
                                                y="209.27167272727277" text-anchor="end" dominant-baseline="auto"
                                                font-size="11px" font-weight="regular" fill="#373d3f"
                                                class="apexcharts-yaxis-label "
                                                style="font-family: Helvetica, Arial, sans-serif;">Contact
                                            </text><text id="SvgjsText5466" font-family="Helvetica, Arial, sans-serif"
                                                x="-15" y="237.00647272727278" text-anchor="end" dominant-baseline="auto"
                                                font-size="11px" font-weight="regular" fill="#373d3f"
                                                class="apexcharts-yaxis-label "
                                                style="font-family: Helvetica, Arial, sans-serif;">China</text><text
                                                id="SvgjsText5467" font-family="Helvetica, Arial, sans-serif" x="-15"
                                                y="264.74127272727276" text-anchor="end" dominant-baseline="auto"
                                                font-size="11px" font-weight="regular" fill="#373d3f"
                                                class="apexcharts-yaxis-label "
                                                style="font-family: Helvetica, Arial, sans-serif;">I-Note</text></g>
                                        <line id="SvgjsLine5468" x1="0" y1="278.348" x2="442.3671875"
                                            y2="278.348" stroke="#78909c" stroke-dasharray="0" stroke-width="1">
                                        </line>
                                    </g>
                                    <g id="SvgjsG5442" class="apexcharts-xaxis apexcharts-yaxis-inversed">
                                        <g id="SvgjsG5443" class="apexcharts-xaxis-texts-g" transform="translate(0, -8)">
                                            <text id="SvgjsText5444" font-family="Helvetica, Arial, sans-serif"
                                                x="442.3671875" y="307.348" text-anchor="middle" dominant-baseline="auto"
                                                font-size="12px" font-weight="regular" fill="#373d3f"
                                                class="apexcharts-xaxis-label "
                                                style="font-family: Helvetica, Arial, sans-serif;">
                                                <tspan id="SvgjsTspan5445">1500</tspan>
                                                <title>1500</title>
                                            </text><text id="SvgjsText5446" font-family="Helvetica, Arial, sans-serif"
                                                x="353.79375" y="307.348" text-anchor="middle" dominant-baseline="auto"
                                                font-size="12px" font-weight="regular" fill="#373d3f"
                                                class="apexcharts-xaxis-label "
                                                style="font-family: Helvetica, Arial, sans-serif;">
                                                <tspan id="SvgjsTspan5447">1200</tspan>
                                                <title>1200</title>
                                            </text><text id="SvgjsText5448" font-family="Helvetica, Arial, sans-serif"
                                                x="265.22031250000003" y="307.348" text-anchor="middle"
                                                dominant-baseline="auto" font-size="12px" font-weight="regular"
                                                fill="#373d3f" class="apexcharts-xaxis-label "
                                                style="font-family: Helvetica, Arial, sans-serif;">
                                                <tspan id="SvgjsTspan5449">900</tspan>
                                                <title>900</title>
                                            </text><text id="SvgjsText5450" font-family="Helvetica, Arial, sans-serif"
                                                x="176.64687500000002" y="307.348" text-anchor="middle"
                                                dominant-baseline="auto" font-size="12px" font-weight="regular"
                                                fill="#373d3f" class="apexcharts-xaxis-label "
                                                style="font-family: Helvetica, Arial, sans-serif;">
                                                <tspan id="SvgjsTspan5451">600</tspan>
                                                <title>600</title>
                                            </text><text id="SvgjsText5452" font-family="Helvetica, Arial, sans-serif"
                                                x="88.07343750000001" y="307.348" text-anchor="middle"
                                                dominant-baseline="auto" font-size="12px" font-weight="regular"
                                                fill="#373d3f" class="apexcharts-xaxis-label "
                                                style="font-family: Helvetica, Arial, sans-serif;">
                                                <tspan id="SvgjsTspan5453">300</tspan>
                                                <title>300</title>
                                            </text><text id="SvgjsText5454" font-family="Helvetica, Arial, sans-serif"
                                                x="-0.49999999999994316" y="307.348" text-anchor="middle"
                                                dominant-baseline="auto" font-size="12px" font-weight="regular"
                                                fill="#373d3f" class="apexcharts-xaxis-label "
                                                style="font-family: Helvetica, Arial, sans-serif;">
                                                <tspan id="SvgjsTspan5455">0</tspan>
                                                <title>0</title>
                                            </text>
                                        </g>
                                    </g>

                                    <g id="SvgjsG5429" class="apexcharts-bar-series apexcharts-plot-series">
                                        <g id="SvgjsG5430" class="apexcharts-series" rel="1"
                                            seriesName="seriesx1" data:realIndex="0">

                                            <path id="SvgjsPath5434"
                                                d="M 0.1 59.62982L 132.22033333333334 59.62982L 132.22033333333334 79.04418L 0.1 79.04418L 0.1 59.62982"
                                                fill="rgba(36,105,92,0.85)" fill-opacity="1" stroke-opacity="1"
                                                stroke-linecap="butt" stroke-width="0" stroke-dasharray="0"
                                                class="apexcharts-bar-area" index="0"
                                                clip-path="url(#gridRectMaskpadqzjhq)"
                                                pathTo="M 0.1 59.62982L 132.22033333333334 59.62982L 132.22033333333334 79.04418L 0.1 79.04418L 0.1 59.62982"
                                                pathFrom="M 0.1 59.62982L 0.1 59.62982L 0.1 79.04418L 0.1 79.04418L 0.1 59.62982"
                                                cy="87.36462" cx="132.22033333333334" j="2" val="448"
                                                barHeight="19.41436" barWidth="132.12033333333335"></path>
                                            <path id="SvgjsPath5435"
                                                d="M 0.1 87.36462L 138.70838541666666 87.36462L 138.70838541666666 106.77898L 0.1 106.77898L 0.1 87.36462"
                                                fill="rgba(36,105,92,0.85)" fill-opacity="1" stroke-opacity="1"
                                                stroke-linecap="butt" stroke-width="0" stroke-dasharray="0"
                                                class="apexcharts-bar-area" index="0"
                                                clip-path="url(#gridRectMaskpadqzjhq)"
                                                pathTo="M 0.1 87.36462L 138.70838541666666 87.36462L 138.70838541666666 106.77898L 0.1 106.77898L 0.1 87.36462"
                                                pathFrom="M 0.1 87.36462L 0.1 87.36462L 0.1 106.77898L 0.1 106.77898L 0.1 87.36462"
                                                cy="115.09942000000001" cx="138.70838541666666" j="3" val="470"
                                                barHeight="19.41436" barWidth="138.60838541666666">
                                            </path>
                                            <path id="SvgjsPath5436"
                                                d="M 0.1 115.09942000000001L 159.3521875 115.09942000000001L 159.3521875 134.51378L 0.1 134.51378L 0.1 115.09942000000001"
                                                fill="rgba(36,105,92,0.85)" fill-opacity="1" stroke-opacity="1"
                                                stroke-linecap="butt" stroke-width="0" stroke-dasharray="0"
                                                class="apexcharts-bar-area" index="0"
                                                clip-path="url(#gridRectMaskpadqzjhq)"
                                                pathTo="M 0.1 115.09942000000001L 159.3521875 115.09942000000001L 159.3521875 134.51378L 0.1 134.51378L 0.1 115.09942000000001"
                                                pathFrom="M 0.1 115.09942000000001L 0.1 115.09942000000001L 0.1 134.51378L 0.1 134.51378L 0.1 115.09942000000001"
                                                cy="142.83422000000002" cx="159.3521875" j="4" val="540"
                                                barHeight="19.41436" barWidth="159.25218750000002"></path>
                                            <path id="SvgjsPath5437"
                                                d="M 0.1 142.83422000000002L 171.14864583333335 142.83422000000002L 171.14864583333335 162.24858L 0.1 162.24858L 0.1 142.83422000000002"
                                                fill="rgba(36,105,92,0.85)" fill-opacity="1" stroke-opacity="1"
                                                stroke-linecap="butt" stroke-width="0" stroke-dasharray="0"
                                                class="apexcharts-bar-area" index="0"
                                                clip-path="url(#gridRectMaskpadqzjhq)"
                                                pathTo="M 0.1 142.83422000000002L 171.14864583333335 142.83422000000002L 171.14864583333335 162.24858L 0.1 162.24858L 0.1 142.83422000000002"
                                                pathFrom="M 0.1 142.83422000000002L 0.1 142.83422000000002L 0.1 162.24858L 0.1 162.24858L 0.1 142.83422000000002"
                                                cy="170.56902000000002" cx="171.14864583333335" j="5" val="580"
                                                barHeight="19.41436" barWidth="171.04864583333335">
                                            </path>
                                            <path id="SvgjsPath5438"
                                                d="M 0.1 170.56902000000002L 203.58890625 170.56902000000002L 203.58890625 189.98338L 0.1 189.98338L 0.1 170.56902000000002"
                                                fill="rgba(36,105,92,0.85)" fill-opacity="1" stroke-opacity="1"
                                                stroke-linecap="butt" stroke-width="0" stroke-dasharray="0"
                                                class="apexcharts-bar-area" index="0"
                                                clip-path="url(#gridRectMaskpadqzjhq)"
                                                pathTo="M 0.1 170.56902000000002L 203.58890625 170.56902000000002L 203.58890625 189.98338L 0.1 189.98338L 0.1 170.56902000000002"
                                                pathFrom="M 0.1 170.56902000000002L 0.1 170.56902000000002L 0.1 189.98338L 0.1 189.98338L 0.1 170.56902000000002"
                                                cy="198.30382000000003" cx="203.58890625" j="6" val="690"
                                                barHeight="19.41436" barWidth="203.48890625"></path>
                                            <path id="SvgjsPath5439"
                                                d="M 0.1 198.30382000000003L 324.5026041666667 198.30382000000003L 324.5026041666667 217.71818000000002L 0.1 217.71818000000002L 0.1 198.30382000000003"
                                                fill="rgba(36,105,92,0.85)" fill-opacity="1" stroke-opacity="1"
                                                stroke-linecap="butt" stroke-width="0" stroke-dasharray="0"
                                                class="apexcharts-bar-area" index="0"
                                                clip-path="url(#gridRectMaskpadqzjhq)"
                                                pathTo="M 0.1 198.30382000000003L 324.5026041666667 198.30382000000003L 324.5026041666667 217.71818000000002L 0.1 217.71818000000002L 0.1 198.30382000000003"
                                                pathFrom="M 0.1 198.30382000000003L 0.1 198.30382000000003L 0.1 217.71818000000002L 0.1 217.71818000000002L 0.1 198.30382000000003"
                                                cy="226.03862000000004" cx="324.5026041666667" j="7" val="1100"
                                                barHeight="19.41436" barWidth="324.40260416666666">
                                            </path>
                                            <path id="SvgjsPath5440"
                                                d="M 0.1 226.03862000000004L 353.99375000000003 226.03862000000004L 353.99375000000003 245.45298000000003L 0.1 245.45298000000003L 0.1 226.03862000000004"
                                                fill="rgba(36,105,92,0.85)" fill-opacity="1" stroke-opacity="1"
                                                stroke-linecap="butt" stroke-width="0" stroke-dasharray="0"
                                                class="apexcharts-bar-area" index="0"
                                                clip-path="url(#gridRectMaskpadqzjhq)"
                                                pathTo="M 0.1 226.03862000000004L 353.99375000000003 226.03862000000004L 353.99375000000003 245.45298000000003L 0.1 245.45298000000003L 0.1 226.03862000000004"
                                                pathFrom="M 0.1 226.03862000000004L 0.1 226.03862000000004L 0.1 245.45298000000003L 0.1 245.45298000000003L 0.1 226.03862000000004"
                                                cy="253.77342000000004" cx="353.99375000000003" j="8" val="1200"
                                                barHeight="19.41436" barWidth="353.89375"></path>
                                            <path id="SvgjsPath5441"
                                                d="M 0.1 253.77342000000004L 407.07781250000005 253.77342000000004L 407.07781250000005 273.18778000000003L 0.1 273.18778000000003L 0.1 253.77342000000004"
                                                fill="rgba(36,105,92,0.85)" fill-opacity="1" stroke-opacity="1"
                                                stroke-linecap="butt" stroke-width="0" stroke-dasharray="0"
                                                class="apexcharts-bar-area" index="0"
                                                clip-path="url(#gridRectMaskpadqzjhq)"
                                                pathTo="M 0.1 253.77342000000004L 407.07781250000005 253.77342000000004L 407.07781250000005 273.18778000000003L 0.1 273.18778000000003L 0.1 253.77342000000004"
                                                pathFrom="M 0.1 253.77342000000004L 0.1 253.77342000000004L 0.1 273.18778000000003L 0.1 273.18778000000003L 0.1 253.77342000000004"
                                                cy="281.50822000000005" cx="407.07781250000005" j="9" val="1380"
                                                barHeight="19.41436" barWidth="406.9778125"></path>
                                            <g id="SvgjsG5431" class="apexcharts-datalabels"></g>
                                        </g>
                                    </g>

                                    <line id="SvgjsLine5490" x1="0" y1="0" x2="442.3671875"
                                        y2="0" stroke-dasharray="0" stroke-width="0"
                                        class="apexcharts-ycrosshairs-hidden"></line>
                                    <g id="SvgjsG5491" class="apexcharts-yaxis-annotations"></g>
                                    <g id="SvgjsG5492" class="apexcharts-xaxis-annotations"></g>
                                    <g id="SvgjsG5493" class="apexcharts-point-annotations"></g>
                                </g>
                            </svg>
                            <div class="apexcharts-legend"></div>
                            <div class="apexcharts-tooltip light">
                                <div class="apexcharts-tooltip-title"
                                    style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;"></div>
                                <div class="apexcharts-tooltip-series-group"><span class="apexcharts-tooltip-marker"
                                        style="background-color: rgb(36, 105, 92);"></span>
                                    <div class="apexcharts-tooltip-text"
                                        style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;">
                                        <div class="apexcharts-tooltip-y-group"><span
                                                class="apexcharts-tooltip-text-label"></span><span
                                                class="apexcharts-tooltip-text-value"></span></div>
                                        <div class="apexcharts-tooltip-z-group"><span
                                                class="apexcharts-tooltip-text-z-label"></span><span
                                                class="apexcharts-tooltip-text-z-value"></span></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-sm-12 col-xl-6 box-col-6">
            <div class="card">
                <div class="card-header pb-0">
                    <h5>Department Wise Document Delivered </h5>
                </div>
                <div class="card-body apex-chart" style="position: relative;">
                    <div id="piechart" style="min-height: 300px;">
                        <div id="apexchartsqukeyar7k" class="apexcharts-canvas apexchartsqukeyar7k light"
                            style="width: 380px; height: 255.713px;"><svg id="SvgjsSvg5060" width="380"
                                height="255.71341463414637" xmlns="http://www.w3.org/2000/svg" version="1.1"
                                xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs"
                                class="apexcharts-svg" xmlns:data="ApexChartsNS" transform="translate(0, 0)"
                                style="background: transparent;">
                                <foreignObject x="0" y="0" width="380" height="255.71341463414637">

                                    <style type="text/css">
                                        .apexcharts-legend {
                                            display: flex;
                                            overflow: auto;
                                            padding: 0 10px;
                                        }

                                        .apexcharts-legend.position-bottom,
                                        .apexcharts-legend.position-top {
                                            flex-wrap: wrap
                                        }

                                        .apexcharts-legend.position-right,
                                        .apexcharts-legend.position-left {
                                            flex-direction: column;
                                            bottom: 0;
                                        }

                                        .apexcharts-legend.position-bottom.left,
                                        .apexcharts-legend.position-top.left,
                                        .apexcharts-legend.position-right,
                                        .apexcharts-legend.position-left {
                                            justify-content: flex-start;
                                        }

                                        .apexcharts-legend.position-bottom.center,
                                        .apexcharts-legend.position-top.center {
                                            justify-content: center;
                                        }

                                        .apexcharts-legend.position-bottom.right,
                                        .apexcharts-legend.position-top.right {
                                            justify-content: flex-end;
                                        }

                                        .apexcharts-legend-series {
                                            cursor: pointer;
                                            line-height: normal;
                                        }

                                        .apexcharts-legend.position-bottom .apexcharts-legend-series,
                                        .apexcharts-legend.position-top .apexcharts-legend-series {
                                            display: flex;
                                            align-items: center;
                                        }

                                        .apexcharts-legend-text {
                                            position: relative;
                                            font-size: 14px;
                                        }

                                        .apexcharts-legend-text *,
                                        .apexcharts-legend-marker * {
                                            pointer-events: none;
                                        }

                                        .apexcharts-legend-marker {
                                            position: relative;
                                            display: inline-block;
                                            cursor: pointer;
                                            margin-right: 3px;
                                        }

                                        .apexcharts-legend.right .apexcharts-legend-series,
                                        .apexcharts-legend.left .apexcharts-legend-series {
                                            display: inline-block;
                                        }

                                        .apexcharts-legend-series.no-click {
                                            cursor: auto;
                                        }

                                        .apexcharts-legend .apexcharts-hidden-zero-series,
                                        .apexcharts-legend .apexcharts-hidden-null-series {
                                            display: none !important;
                                        }

                                        .inactive-legend {
                                            opacity: 0.45;
                                        }
                                    </style>
                                </foreignObject>
                                <g id="SvgjsG5062" class="apexcharts-inner apexcharts-graphical"
                                    transform="translate(110, 20)">
                                    <defs id="SvgjsDefs5061">
                                        <clipPath id="gridRectMaskqukeyar7k">
                                            <rect id="SvgjsRect5063" width="245.65625" height="267.65625" x="-1" y="-1"
                                                rx="0" ry="0" fill="#ffffff" opacity="1"
                                                stroke-width="0" stroke="none" stroke-dasharray="0"></rect>
                                        </clipPath>
                                        <clipPath id="gridRectMarkerMaskqukeyar7k">
                                            <rect id="SvgjsRect5064" width="245.65625" height="267.65625" x="-1" y="-1"
                                                rx="0" ry="0" fill="#ffffff" opacity="1"
                                                stroke-width="0" stroke="none" stroke-dasharray="0"></rect>
                                        </clipPath>
                                        <filter id="SvgjsFilter5073" filterUnits="userSpaceOnUse">
                                            <feFlood id="SvgjsFeFlood5074" flood-color="#000000" flood-opacity="0.45"
                                                result="SvgjsFeFlood5074Out" in="SourceGraphic"></feFlood>
                                            <feComposite id="SvgjsFeComposite5075" in="SvgjsFeFlood5074Out"
                                                in2="SourceAlpha" operator="in" result="SvgjsFeComposite5075Out">
                                            </feComposite>
                                            <feOffset id="SvgjsFeOffset5076" dx="1" dy="1"
                                                result="SvgjsFeOffset5076Out" in="SvgjsFeComposite5075Out">
                                            </feOffset>
                                            <feGaussianBlur id="SvgjsFeGaussianBlur5077" stdDeviation="1 "
                                                result="SvgjsFeGaussianBlur5077Out" in="SvgjsFeOffset5076Out">
                                            </feGaussianBlur>
                                            <feMerge id="SvgjsFeMerge5078" result="SvgjsFeMerge5078Out"
                                                in="SourceGraphic">
                                                <feMergeNode id="SvgjsFeMergeNode5079" in="SvgjsFeGaussianBlur5077Out">
                                                </feMergeNode>
                                                <feMergeNode id="SvgjsFeMergeNode5080" in="[object Arguments]">
                                                </feMergeNode>
                                            </feMerge>
                                            <feBlend id="SvgjsFeBlend5081" in="SourceGraphic" in2="SvgjsFeMerge5078Out"
                                                mode="normal" result="SvgjsFeBlend5081Out">
                                            </feBlend>
                                        </filter>
                                        <filter id="SvgjsFilter5086" filterUnits="userSpaceOnUse">
                                            <feFlood id="SvgjsFeFlood5087" flood-color="#000000" flood-opacity="0.45"
                                                result="SvgjsFeFlood5087Out" in="SourceGraphic"></feFlood>
                                            <feComposite id="SvgjsFeComposite5088" in="SvgjsFeFlood5087Out"
                                                in2="SourceAlpha" operator="in" result="SvgjsFeComposite5088Out">
                                            </feComposite>
                                            <feOffset id="SvgjsFeOffset5089" dx="1" dy="1"
                                                result="SvgjsFeOffset5089Out" in="SvgjsFeComposite5088Out">
                                            </feOffset>
                                            <feGaussianBlur id="SvgjsFeGaussianBlur5090" stdDeviation="1 "
                                                result="SvgjsFeGaussianBlur5090Out" in="SvgjsFeOffset5089Out">
                                            </feGaussianBlur>
                                            <feMerge id="SvgjsFeMerge5091" result="SvgjsFeMerge5091Out"
                                                in="SourceGraphic">
                                                <feMergeNode id="SvgjsFeMergeNode5092" in="SvgjsFeGaussianBlur5090Out">
                                                </feMergeNode>
                                                <feMergeNode id="SvgjsFeMergeNode5093" in="[object Arguments]">
                                                </feMergeNode>
                                            </feMerge>
                                            <feBlend id="SvgjsFeBlend5094" in="SourceGraphic" in2="SvgjsFeMerge5091Out"
                                                mode="normal" result="SvgjsFeBlend5094Out">
                                            </feBlend>
                                        </filter>
                                        <filter id="SvgjsFilter5099" filterUnits="userSpaceOnUse">
                                            <feFlood id="SvgjsFeFlood5100" flood-color="#000000" flood-opacity="0.45"
                                                result="SvgjsFeFlood5100Out" in="SourceGraphic"></feFlood>
                                            <feComposite id="SvgjsFeComposite5101" in="SvgjsFeFlood5100Out"
                                                in2="SourceAlpha" operator="in" result="SvgjsFeComposite5101Out">
                                            </feComposite>
                                            <feOffset id="SvgjsFeOffset5102" dx="1" dy="1"
                                                result="SvgjsFeOffset5102Out" in="SvgjsFeComposite5101Out">
                                            </feOffset>
                                            <feGaussianBlur id="SvgjsFeGaussianBlur5103" stdDeviation="1 "
                                                result="SvgjsFeGaussianBlur5103Out" in="SvgjsFeOffset5102Out">
                                            </feGaussianBlur>
                                            <feMerge id="SvgjsFeMerge5104" result="SvgjsFeMerge5104Out"
                                                in="SourceGraphic">
                                                <feMergeNode id="SvgjsFeMergeNode5105" in="SvgjsFeGaussianBlur5103Out">
                                                </feMergeNode>
                                                <feMergeNode id="SvgjsFeMergeNode5106" in="[object Arguments]">
                                                </feMergeNode>
                                            </feMerge>
                                            <feBlend id="SvgjsFeBlend5107" in="SourceGraphic" in2="SvgjsFeMerge5104Out"
                                                mode="normal" result="SvgjsFeBlend5107Out">
                                            </feBlend>
                                        </filter>
                                        <filter id="SvgjsFilter5112" filterUnits="userSpaceOnUse">
                                            <feFlood id="SvgjsFeFlood5113" flood-color="#000000" flood-opacity="0.45"
                                                result="SvgjsFeFlood5113Out" in="SourceGraphic"></feFlood>
                                            <feComposite id="SvgjsFeComposite5114" in="SvgjsFeFlood5113Out"
                                                in2="SourceAlpha" operator="in" result="SvgjsFeComposite5114Out">
                                            </feComposite>
                                            <feOffset id="SvgjsFeOffset5115" dx="1" dy="1"
                                                result="SvgjsFeOffset5115Out" in="SvgjsFeComposite5114Out">
                                            </feOffset>
                                            <feGaussianBlur id="SvgjsFeGaussianBlur5116" stdDeviation="1 "
                                                result="SvgjsFeGaussianBlur5116Out" in="SvgjsFeOffset5115Out">
                                            </feGaussianBlur>
                                            <feMerge id="SvgjsFeMerge5117" result="SvgjsFeMerge5117Out"
                                                in="SourceGraphic">
                                                <feMergeNode id="SvgjsFeMergeNode5118" in="SvgjsFeGaussianBlur5116Out">
                                                </feMergeNode>
                                                <feMergeNode id="SvgjsFeMergeNode5119" in="[object Arguments]">
                                                </feMergeNode>
                                            </feMerge>
                                            <feBlend id="SvgjsFeBlend5120" in="SourceGraphic" in2="SvgjsFeMerge5117Out"
                                                mode="normal" result="SvgjsFeBlend5120Out">
                                            </feBlend>
                                        </filter>
                                        <filter id="SvgjsFilter5125" filterUnits="userSpaceOnUse">
                                            <feFlood id="SvgjsFeFlood5126" flood-color="#000000" flood-opacity="0.45"
                                                result="SvgjsFeFlood5126Out" in="SourceGraphic"></feFlood>
                                            <feComposite id="SvgjsFeComposite5127" in="SvgjsFeFlood5126Out"
                                                in2="SourceAlpha" operator="in" result="SvgjsFeComposite5127Out">
                                            </feComposite>
                                            <feOffset id="SvgjsFeOffset5128" dx="1" dy="1"
                                                result="SvgjsFeOffset5128Out" in="SvgjsFeComposite5127Out">
                                            </feOffset>
                                            <feGaussianBlur id="SvgjsFeGaussianBlur5129" stdDeviation="1 "
                                                result="SvgjsFeGaussianBlur5129Out" in="SvgjsFeOffset5128Out">
                                            </feGaussianBlur>
                                            <feMerge id="SvgjsFeMerge5130" result="SvgjsFeMerge5130Out"
                                                in="SourceGraphic">
                                                <feMergeNode id="SvgjsFeMergeNode5131" in="SvgjsFeGaussianBlur5129Out">
                                                </feMergeNode>
                                                <feMergeNode id="SvgjsFeMergeNode5132" in="[object Arguments]">
                                                </feMergeNode>
                                            </feMerge>
                                            <feBlend id="SvgjsFeBlend5133" in="SourceGraphic" in2="SvgjsFeMerge5130Out"
                                                mode="normal" result="SvgjsFeBlend5133Out">
                                            </feBlend>
                                        </filter>
                                    </defs>
                                    <g id="SvgjsG5066" class="apexcharts-pie" data:innerTranslateX="0"
                                        data:innerTranslateY="-25">
                                        <g id="SvgjsG5067" transform="translate(0, -5) scale(1)">
                                            <g id="SvgjsG5068" class="apexcharts-slices">
                                                <g id="SvgjsG5069" class="apexcharts-series apexcharts-pie-series"
                                                    seriesName="TeamxA" rel="1" data:realIndex="0">
                                                    <path id="SvgjsPath5070"
                                                        d="M 121.828125 8.971417682926813 A 112.85670731707319 112.85670731707319 0 0 1 234.68038817688006 120.82658503189067 L 121.828125 121.828125 L 121.828125 8.971417682926813"
                                                        fill="rgba(36,105,92,1)" fill-opacity="1" stroke="#ffffff"
                                                        stroke-opacity="1" stroke-linecap="butt" stroke-width="2"
                                                        stroke-dasharray="0"
                                                        class="apexcharts-pie-area apexcharts-pie-slice-0" index="0"
                                                        j="0" data:angle="89.49152542372882" data:startAngle="0"
                                                        data:strokeWidth="2" data:value="44"
                                                        data:pathOrig="M 121.828125 8.971417682926813 A 112.85670731707319 112.85670731707319 0 0 1 234.68038817688006 120.82658503189067 L 121.828125 121.828125 L 121.828125 8.971417682926813">
                                                    </path>
                                                </g>
                                                <g id="SvgjsG5082" class="apexcharts-series apexcharts-pie-series"
                                                    seriesName="TeamxB" rel="2" data:realIndex="1">
                                                    <path id="SvgjsPath5083"
                                                        d="M 234.68038817688006 120.82658503189067 A 112.85670731707319 112.85670731707319 0 0 1 80.73016154227523 226.9356593925403 L 121.828125 121.828125 L 234.68038817688006 120.82658503189067"
                                                        fill="rgba(186,137,93,1)" fill-opacity="1" stroke="#ffffff"
                                                        stroke-opacity="1" stroke-linecap="butt" stroke-width="2"
                                                        stroke-dasharray="0"
                                                        class="apexcharts-pie-area apexcharts-pie-slice-1" index="0"
                                                        j="1" data:angle="111.86440677966102"
                                                        data:startAngle="89.49152542372882" data:strokeWidth="2"
                                                        data:value="55"
                                                        data:pathOrig="M 234.68038817688006 120.82658503189067 A 112.85670731707319 112.85670731707319 0 0 1 80.73016154227523 226.9356593925403 L 121.828125 121.828125 L 234.68038817688006 120.82658503189067">
                                                    </path>
                                                </g>
                                                <g id="SvgjsG5095" class="apexcharts-series apexcharts-pie-series"
                                                    seriesName="TeamxC" rel="3" data:realIndex="2">
                                                    <path id="SvgjsPath5096"
                                                        d="M 80.73016154227523 226.9356593925403 A 112.85670731707319 112.85670731707319 0 0 1 38.22784273636688 197.64124518306852 L 121.828125 121.828125 L 80.73016154227523 226.9356593925403"
                                                        fill="rgba(34,34,34,1)" fill-opacity="1" stroke="#ffffff"
                                                        stroke-opacity="1" stroke-linecap="butt" stroke-width="2"
                                                        stroke-dasharray="0"
                                                        class="apexcharts-pie-area apexcharts-pie-slice-2" index="0"
                                                        j="2" data:angle="26.440677966101703"
                                                        data:startAngle="201.35593220338984" data:strokeWidth="2"
                                                        data:value="13"
                                                        data:pathOrig="M 80.73016154227523 226.9356593925403 A 112.85670731707319 112.85670731707319 0 0 1 38.22784273636688 197.64124518306852 L 121.828125 121.828125 L 80.73016154227523 226.9356593925403">
                                                    </path>
                                                </g>
                                                <g id="SvgjsG5108" class="apexcharts-series apexcharts-pie-series"
                                                    seriesName="TeamxD" rel="4" data:realIndex="3">
                                                    <path id="SvgjsPath5109"
                                                        d="M 38.22784273636688 197.64124518306852 A 112.85670731707319 112.85670731707319 0 0 1 42.381268915557484 41.673066240434494 L 121.828125 121.828125 L 38.22784273636688 197.64124518306852"
                                                        fill="rgba(113,113,113,1)" fill-opacity="1" stroke="#ffffff"
                                                        stroke-opacity="1" stroke-linecap="butt" stroke-width="2"
                                                        stroke-dasharray="0"
                                                        class="apexcharts-pie-area apexcharts-pie-slice-3" index="0"
                                                        j="3" data:angle="87.4576271186441"
                                                        data:startAngle="227.79661016949154" data:strokeWidth="2"
                                                        data:value="43"
                                                        data:pathOrig="M 38.22784273636688 197.64124518306852 A 112.85670731707319 112.85670731707319 0 0 1 42.381268915557484 41.673066240434494 L 121.828125 121.828125 L 38.22784273636688 197.64124518306852">
                                                    </path>
                                                </g>
                                                <g id="SvgjsG5121" class="apexcharts-series apexcharts-pie-series"
                                                    seriesName="TeamxE" rel="5" data:realIndex="4">
                                                    <path id="SvgjsPath5122"
                                                        d="M 42.381268915557484 41.673066240434494 A 112.85670731707319 112.85670731707319 0 0 1 121.80842778884356 8.971419401832748 L 121.828125 121.828125 L 42.381268915557484 41.673066240434494"
                                                        fill="rgba(226,198,54,1)" fill-opacity="1" stroke="#ffffff"
                                                        stroke-opacity="1" stroke-linecap="butt" stroke-width="2"
                                                        stroke-dasharray="0"
                                                        class="apexcharts-pie-area apexcharts-pie-slice-4" index="0"
                                                        j="4" data:angle="44.745762711864415"
                                                        data:startAngle="315.25423728813564" data:strokeWidth="2"
                                                        data:value="22"
                                                        data:pathOrig="M 42.381268915557484 41.673066240434494 A 112.85670731707319 112.85670731707319 0 0 1 121.80842778884356 8.971419401832748 L 121.828125 121.828125 L 42.381268915557484 41.673066240434494">
                                                    </path>
                                                </g><text id="SvgjsText5071" font-family="Helvetica, Arial, sans-serif"
                                                    x="185.38560986755405" y="57.70407799234762" text-anchor="middle"
                                                    dominant-baseline="auto" font-size="12px" font-weight="regular"
                                                    fill="#ffffff" filter="url(#SvgjsFilter5073)"
                                                    class="apexcharts-pie-label"
                                                    style="font-family: Helvetica, Arial, sans-serif;">24.9%</text><text
                                                    id="SvgjsText5084" font-family="Helvetica, Arial, sans-serif"
                                                    x="173.06532272174937" y="196.1665192317248" text-anchor="middle"
                                                    dominant-baseline="auto" font-size="12px" font-weight="regular"
                                                    fill="#ffffff" filter="url(#SvgjsFilter5086)"
                                                    class="apexcharts-pie-label"
                                                    style="font-family: Helvetica, Arial, sans-serif;">31.1%</text><text
                                                    id="SvgjsText5097" font-family="Helvetica, Arial, sans-serif"
                                                    x="70.5909272782506" y="196.16651923172475" text-anchor="middle"
                                                    dominant-baseline="auto" font-size="12px" font-weight="regular"
                                                    fill="#ffffff" filter="url(#SvgjsFilter5099)"
                                                    class="apexcharts-pie-label"
                                                    style="font-family: Helvetica, Arial, sans-serif;">7.3%</text><text
                                                    id="SvgjsText5110" font-family="Helvetica, Arial, sans-serif"
                                                    x="31.574755275715006" y="119.42468148277526" text-anchor="middle"
                                                    dominant-baseline="auto" font-size="12px" font-weight="regular"
                                                    fill="#ffffff" filter="url(#SvgjsFilter5112)"
                                                    class="apexcharts-pie-label"
                                                    style="font-family: Helvetica, Arial, sans-serif;">24.3%</text><text
                                                    id="SvgjsText5123" font-family="Helvetica, Arial, sans-serif"
                                                    x="87.46255907110933" y="38.338873202442" text-anchor="middle"
                                                    dominant-baseline="auto" font-size="12px" font-weight="regular"
                                                    fill="#ffffff" filter="url(#SvgjsFilter5125)"
                                                    class="apexcharts-pie-label"
                                                    style="font-family: Helvetica, Arial, sans-serif;">12.4%</text>
                                            </g>


                                        </g>
                                    </g>

                                    <line id="SvgjsLine5135" x1="0" y1="0" x2="243.65625"
                                        y2="0" stroke-dasharray="0" stroke-width="0"
                                        class="apexcharts-ycrosshairs-hidden"></line>
                                </g>
                            </svg>
                            <div class="apexcharts-tooltip dark">
                                <div class="apexcharts-tooltip-series-group"><span class="apexcharts-tooltip-marker"
                                        style="background-color: rgb(36, 105, 92);"></span>
                                    <div class="apexcharts-tooltip-text"
                                        style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;">
                                        <div class="apexcharts-tooltip-y-group"><span
                                                class="apexcharts-tooltip-text-label"></span><span
                                                class="apexcharts-tooltip-text-value"></span></div>
                                        <div class="apexcharts-tooltip-z-group"><span
                                                class="apexcharts-tooltip-text-z-label"></span><span
                                                class="apexcharts-tooltip-text-z-value"></span></div>
                                    </div>
                                </div>
                                <div class="apexcharts-tooltip-series-group"><span class="apexcharts-tooltip-marker"
                                        style="background-color: rgb(186, 137, 93);"></span>
                                    <div class="apexcharts-tooltip-text"
                                        style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;">
                                        <div class="apexcharts-tooltip-y-group"><span
                                                class="apexcharts-tooltip-text-label"></span><span
                                                class="apexcharts-tooltip-text-value"></span></div>
                                        <div class="apexcharts-tooltip-z-group"><span
                                                class="apexcharts-tooltip-text-z-label"></span><span
                                                class="apexcharts-tooltip-text-z-value"></span></div>
                                    </div>
                                </div>
                                <div class="apexcharts-tooltip-series-group"><span class="apexcharts-tooltip-marker"
                                        style="background-color: rgb(34, 34, 34);"></span>
                                    <div class="apexcharts-tooltip-text"
                                        style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;">
                                        <div class="apexcharts-tooltip-y-group"><span
                                                class="apexcharts-tooltip-text-label"></span><span
                                                class="apexcharts-tooltip-text-value"></span></div>
                                        <div class="apexcharts-tooltip-z-group"><span
                                                class="apexcharts-tooltip-text-z-label"></span><span
                                                class="apexcharts-tooltip-text-z-value"></span></div>
                                    </div>
                                </div>
                                <div class="apexcharts-tooltip-series-group"><span class="apexcharts-tooltip-marker"
                                        style="background-color: rgb(113, 113, 113);"></span>
                                    <div class="apexcharts-tooltip-text"
                                        style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;">
                                        <div class="apexcharts-tooltip-y-group"><span
                                                class="apexcharts-tooltip-text-label"></span><span
                                                class="apexcharts-tooltip-text-value"></span></div>
                                        <div class="apexcharts-tooltip-z-group"><span
                                                class="apexcharts-tooltip-text-z-label"></span><span
                                                class="apexcharts-tooltip-text-z-value"></span></div>
                                    </div>
                                </div>
                                <div class="apexcharts-tooltip-series-group"><span class="apexcharts-tooltip-marker"
                                        style="background-color: rgb(226, 198, 54);"></span>
                                    <div class="apexcharts-tooltip-text"
                                        style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;">
                                        <div class="apexcharts-tooltip-y-group"><span
                                                class="apexcharts-tooltip-text-label"></span><span
                                                class="apexcharts-tooltip-text-value"></span></div>
                                        <div class="apexcharts-tooltip-z-group"><span
                                                class="apexcharts-tooltip-text-z-label"></span><span
                                                class="apexcharts-tooltip-text-z-value"></span></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="resize-triggers">
                        <div class="expand-trigger">
                            <div style="width: 441px; min-height: 50px;">
                                <div class="apexcharts-legend center position-bottom" xmlns="http://www.w3.org/1999/xhtml"
                                    style="inset: auto 0px 10px; position: absolute;">
                                    <div class="apexcharts-legend-series" rel="1" data:collapsed="false"
                                        style="margin: 0px 5px;"><span class="apexcharts-legend-marker" rel="1"
                                            data:collapsed="false"
                                            style="background: rgb(36, 105, 92); color: rgb(36, 105, 92); height: 12px; width: 12px; left: 0px; top: 0px; border-width: 0px; border-color: rgb(255, 255, 255); border-radius: 2px;"></span><span
                                            class="apexcharts-legend-text" rel="1" i="0"
                                            data:default-text="Net%20Profit" data:collapsed="false"
                                            style="color: rgb(55, 61, 63); font-size: 12px; font-family: Helvetica, Arial, sans-serif;">
                                            IE & I</span></div>
                                    <div class="apexcharts-legend-series" rel="2" data:collapsed="false"
                                        style="margin: 0px 5px;"><span class="apexcharts-legend-marker" rel="2"
                                            data:collapsed="false"
                                            style="background: rgb(186, 137, 93); color: rgb(186, 137, 93); height: 12px; width: 12px; left: 0px; top: 0px; border-width: 0px; border-color: rgb(255, 255, 255); border-radius: 2px;"></span><span
                                            class="apexcharts-legend-text" rel="2" i="1"
                                            data:default-text="Revenue" data:collapsed="false"
                                            style="color: rgb(55, 61, 63); font-size: 12px; font-family: Helvetica, Arial, sans-serif;">IV
                                            & EE</span>
                                    </div>
                                    <div class="apexcharts-legend-series" rel="3" data:collapsed="false"
                                        style="margin: 0px 5px;"><span class="apexcharts-legend-marker" rel="3"
                                            data:collapsed="false"
                                            style="background: rgb(34, 34, 34); color: rgb(34, 34, 34); height: 12px; width: 12px; left: 0px; top: 0px; border-width: 0px; border-color: rgb(255, 255, 255); border-radius: 2px;"></span><span
                                            class="apexcharts-legend-text" rel="3" i="2"
                                            data:default-text="Free%20Cash%20Flow" data:collapsed="false"
                                            style="color: rgb(55, 61, 63); font-size: 12px; font-family: Helvetica, Arial, sans-serif;">IGS
                                            & C</span></div>
                                    <div class="apexcharts-legend-series" rel="3" data:collapsed="false"
                                        style="margin: 0px 5px;"><span class="apexcharts-legend-marker" rel="3"
                                            data:collapsed="false"
                                            style="background: rgb(34, 34, 34); color: rgb(34, 34, 34); height: 12px; width: 12px; left: 0px; top: 0px; border-width: 0px; border-color: rgb(255, 255, 255); border-radius: 2px;"></span><span
                                            class="apexcharts-legend-text" rel="3" i="2"
                                            data:default-text="Free%20Cash%20Flow" data:collapsed="false"
                                            style="color: rgb(55, 61, 63); font-size: 12px; font-family: Helvetica, Arial, sans-serif;">IA
                                            & E</span></div>
                                </div>
                            </div>
                        </div>
                        <div class="contract-trigger"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-12 col-xl-6 box-col-6">
            <div class="card">
                <div class="card-header pb-0">
                    <h5>Section Wise Document Received</h5>
                </div>
                <div class="card-body peity-charts" style="display: flex; justify-content:center;">
                    <svg class="" height="16" width="480">
                        <rect fill="#24695c" x="20" y="111.11111111111111" width="50" height="138.88888888888889">
                        </rect>
                        <rect fill="#ba895d" x="100" y="166.66666666666669" width="50" height="83.33333333333331">
                        </rect>
                        <rect fill="#E2C636" x="170" y="20" width="50" height="250"></rect>
                        <rect fill="#717171" x="240" y="83.33333333333334" width="50" height="166.66666666666666">
                        </rect>
                        <rect fill="#717171" x="310" y="83.33333333333334" width="50" height="166.66666666666666">
                        </rect>
                        <rect fill="#717171" x="380" y="83.33333333333334" width="50" height="166.66666666666666">
                        </rect>

                        <!-- Text for column names -->
                        <text x="30" y="100" font-family="Arial"  fill="#000"> IE &amp; I</text>
                        <text x="100" y="155" font-family="Arial" font-size="12" fill="#000">IV &amp; EE</text>
                        <text x="170" y="10" font-family="Arial" font-size="12" fill="#000">IGS &amp; C</text>
                        <text x="240" y="73" font-family="Arial" font-size="12" fill="#000">IA &amp; E</text>
                        <text x="310" y="73" font-family="Arial" font-size="12" fill="#000">IA &amp; E</text>
                        <text x="380" y="73" font-family="Arial" font-size="12" fill="#000">IA &amp; E</text>


                    </svg>
                </div>

            </div>
        </div>
        <div class="col-sm-12 col-xl-6 box-col-6">
            <div class="card">
                <div class="card-header">
                    <h5>Department Wise Document Received</h5>
                </div>
                <div class="card-body chart-block">
                    <div id="bar-chart2">
                        <div style="position: relative;">
                            <div dir="ltr" style="position: relative; width: 587px; height: 400px;">
                                <div aria-label="A chart."
                                    style="position: absolute; left: 0px; top: 0px; width: 100%; height: 100%;"><svg
                                        width="587" height="400" aria-label="A chart." style="overflow: hidden;">
                                        <defs id="defs">
                                            <clipPath id="_ABSTRACT_RENDERER_ID_3">
                                                <rect x="112" y="77" width="363" height="247"></rect>
                                            </clipPath>
                                            <filter id="_ABSTRACT_RENDERER_ID_5">
                                                <feGaussianBlur in="SourceAlpha" stdDeviation="2"></feGaussianBlur>
                                                <feOffset dx="1" dy="1"></feOffset>
                                                <feComponentTransfer>
                                                    <feFuncA type="linear" slope="0.1"></feFuncA>
                                                </feComponentTransfer>
                                                <feMerge>
                                                    <feMergeNode></feMergeNode>
                                                    <feMergeNode in="SourceGraphic"></feMergeNode>
                                                </feMerge>
                                            </filter>
                                        </defs>
                                        <rect x="0" y="0" width="587" height="400" stroke="none"
                                            stroke-width="0" fill="#ffffff"></rect>

                                        <g>
                                            <rect x="112" y="77" width="363" height="247" stroke="none"
                                                stroke-width="0" fill-opacity="0" fill="#ffffff"></rect>
                                            <g
                                                clip-path="url(file:///F:/html%20tamplate/viho/theme/chart-google.html#_ABSTRACT_RENDERER_ID_3)">
                                                <g>
                                                    <rect x="112" y="77" width="1" height="247" stroke="none"
                                                        stroke-width="0" fill="#cccccc"></rect>
                                                    <rect x="203" y="77" width="1" height="247" stroke="none"
                                                        stroke-width="0" fill="#cccccc"></rect>
                                                    <rect x="293" y="77" width="1" height="247" stroke="none"
                                                        stroke-width="0" fill="#cccccc"></rect>
                                                    <rect x="384" y="77" width="1" height="247" stroke="none"
                                                        stroke-width="0" fill="#cccccc"></rect>
                                                    <rect x="474" y="77" width="1" height="247" stroke="none"
                                                        stroke-width="0" fill="#cccccc"></rect>
                                                </g>
                                                <g>
                                                    <rect x="-249" y="79" width="452" height="58"
                                                        stroke="#24695c" stroke-width="1" fill="#24695c"></rect>
                                                    <rect x="-249" y="141" width="542" height="58"
                                                        stroke="#ba895d" stroke-width="1" fill="#ba895d"></rect>
                                                    <rect x="-249" y="202" width="633" height="58"
                                                        stroke="#222222" stroke-width="1" fill="#222222"></rect>
                                                    <rect x="-249" y="264" width="723" height="58"
                                                        stroke="#717171" stroke-width="1" fill="#717171"></rect>
                                                </g>
                                                <g>
                                                    <rect x="203" y="108" width="0" height="1" stroke="none"
                                                        stroke-width="0" fill="#999999"></rect>
                                                    <rect x="293" y="170" width="0" height="1" stroke="none"
                                                        stroke-width="0" fill="#999999"></rect>
                                                    <rect x="384" y="231" width="0" height="1" stroke="none"
                                                        stroke-width="0" fill="#999999"></rect>
                                                    <rect x="474" y="293" width="0" height="1" stroke="none"
                                                        stroke-width="0" fill="#999999"></rect>
                                                </g>
                                            </g>
                                            <g></g>
                                            <g>
                                                <g><text text-anchor="middle" x="112.5" y="343.05" font-family="Arial"
                                                        font-size="13" stroke="none" stroke-width="0"
                                                        fill="#444444">8</text></g>
                                                <g><text text-anchor="middle" x="203" y="343.05" font-family="Arial"
                                                        font-size="13" stroke="none" stroke-width="0"
                                                        fill="#444444">10</text></g>
                                                <g><text text-anchor="middle" x="293.5" y="343.05" font-family="Arial"
                                                        font-size="13" stroke="none" stroke-width="0"
                                                        fill="#444444">12</text></g>
                                                <g><text text-anchor="middle" x="384" y="343.05" font-family="Arial"
                                                        font-size="13" stroke="none" stroke-width="0"
                                                        fill="#444444">14</text></g>
                                                <g><text text-anchor="middle" x="474.5" y="343.05" font-family="Arial"
                                                        font-size="13" stroke="none" stroke-width="0"
                                                        fill="#444444">16</text></g>
                                                <g><text text-anchor="end" x="99" y="112.8" font-family="Arial"
                                                        font-size="13" stroke="none" stroke-width="0"
                                                        fill="#222222">Copper</text></g>
                                                <g><text text-anchor="end" x="99" y="174.3" font-family="Arial"
                                                        font-size="13" stroke="none" stroke-width="0"
                                                        fill="#222222">Silver</text></g>
                                                <g><text text-anchor="end" x="99" y="235.8" font-family="Arial"
                                                        font-size="13" stroke="none" stroke-width="0"
                                                        fill="#222222">Gold</text></g>
                                                <g><text text-anchor="end" x="99" y="297.3" font-family="Arial"
                                                        font-size="13" stroke="none" stroke-width="0"
                                                        fill="#222222">Platinum</text></g>
                                            </g>
                                            <g>
                                                <g>
                                                    <g><text text-anchor="end" x="199" y="112.55" font-family="Arial"
                                                            font-size="13" stroke="none" stroke-width="0"
                                                            fill="#ffffff">10</text>
                                                        <rect x="184" y="101.5" width="15" height="13"
                                                            stroke="none" stroke-width="0" fill-opacity="0"
                                                            fill="#ffffff"></rect>
                                                    </g>
                                                </g>
                                                <g>
                                                    <g><text text-anchor="end" x="289" y="174.55" font-family="Arial"
                                                            font-size="13" stroke="none" stroke-width="0"
                                                            fill="#ffffff">12</text>
                                                        <rect x="274" y="163.5" width="15" height="13"
                                                            stroke="none" stroke-width="0" fill-opacity="0"
                                                            fill="#ffffff"></rect>
                                                    </g>
                                                </g>
                                                <g>
                                                    <g><text text-anchor="end" x="380" y="235.55" font-family="Arial"
                                                            font-size="13" stroke="none" stroke-width="0"
                                                            fill="#ffffff">14</text>
                                                        <rect x="365" y="224.5" width="15" height="13"
                                                            stroke="none" stroke-width="0" fill-opacity="0"
                                                            fill="#ffffff"></rect>
                                                    </g>
                                                </g>
                                                <g>
                                                    <g><text text-anchor="end" x="470" y="297.55" font-family="Arial"
                                                            font-size="13" stroke="none" stroke-width="0"
                                                            fill="#ffffff">16</text>
                                                        <rect x="455" y="286.5" width="15" height="13"
                                                            stroke="none" stroke-width="0" fill-opacity="0"
                                                            fill="#ffffff"></rect>
                                                    </g>
                                                </g>
                                            </g>
                                        </g>
                                        <g></g>
                                    </svg>
                                    <div aria-label="A tabular representation of the data in the chart."
                                        style="position: absolute; left: -10000px; top: auto; width: 1px; height: 1px; overflow: hidden;">
                                        <table>
                                            <thead>
                                                <tr>
                                                    <th>Element</th>
                                                    <th>Density</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Copper</td>
                                                    <td>10</td>
                                                </tr>
                                                <tr>
                                                    <td>Silver</td>
                                                    <td>12</td>
                                                </tr>
                                                <tr>
                                                    <td>Gold</td>
                                                    <td>14</td>
                                                </tr>
                                                <tr>
                                                    <td>Platinum</td>
                                                    <td>16</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div aria-hidden="true"
                                style="display: none; position: absolute; top: 410px; left: 597px; white-space: nowrap; font-family: Arial; font-size: 13px; font-weight: bold;">
                                16</div>
                            <div></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>





    </div>


@endsection
@push('js')
    <script src="{{ asset('assets/backend/js/chart/chartjs/Chart.js') }}"></script>
    <script>
        var background = ["rgba(255, 99, 132, 0.6)", "rgba(54, 162, 235, 0.6)", "rgba(255, 206, 86, 0.6)",
            "rgb(74,179,29,0.6)", "rgba(153, 102, 255, 0.6)", "rgba(179,61,85,0.6)", "rgb(176,20,93,0.6)",
            "rgb(28,151,208,0.6)", "rgba(75, 192, 192, 0.6)", "rgba(153, 102, 255, 0.6)", "rgb(229,121,27,0.6)",
            "rgb(235,60,54,0.6)", "rgb(53,186,24,0.6)", "rgb(8,37,79,0.6)", "rgba(153, 102, 255, 0.6)",
            "rgba(179,61,85,0.6)", "rgb(7,33,165,0.6)", "rgb(25,27,29,0.6)", "rgb(116,44,196,0.6)", "rgb(96,7,102,0.6)",
            "rgba(255, 99, 132, 0.6)", "rgba(54, 162, 235, 0.6)", "rgb(100,110,21,0.6)", "rgb(31,134,58,0.6)",
            "rgba(92,0,255,0.6)", "rgb(131,23,113,0.6)", "rgb(96,233,56,0.6)", "rgb(28,151,208,0.6)",
            "rgb(190,170,10,0.6)", "rgba(67,22,155,0.6)", "rgb(229,121,27,0.6)", "rgba(117,26,24,0.6)",
            "rgb(53,186,24,0.6)", "rgb(8,37,79,0.6)", "rgba(153, 102, 255, 0.6)", "rgb(246,0,255)",
            "rgb(62,167,33,0.6)", "rgb(153,9,9,0.6)", "rgb(11,185,217,0.6)", "rgb(96,7,102,0.6)",
        ];
        background = background.sort(() => Math.random() - 0.5);


        $.ajax({
            url: "{{ url('daily_submission_chart') }}",
            type: "GET",
            data: {},
            success: function(response) {
                if (response) {
                    if (response.permission == false) {
                        toastr.error('you dont have that Permission to see report chart', 'Permission Denied');
                    } else {
                        var ctx = document.getElementById('dayly_submission_chart').getContext('2d');
                        var myChart = new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: response.lebel,
                                datasets: [{
                                    label: 'Total Submission',
                                    data: response.data,
                                    backgroundColor: background,
                                    borderColor: ['rgba(255,99,132,1)', ],
                                    borderWidth: 1
                                }]
                            },
                            options: {
                                scales: {
                                    yAxes: [{
                                        ticks: {
                                            beginAtZero: true
                                        }
                                    }]
                                },
                            }
                        });
                    }
                }
            },
            error: function(response) {
                $('#usernameError').text(response.responseJSON.errors.username);
            }
        });
    </script>
@endpush
