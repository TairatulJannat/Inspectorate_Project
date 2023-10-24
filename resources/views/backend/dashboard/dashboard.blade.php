@extends('backend.app')
@section('title','Dashboard')
@push('css')
    <link rel="stylesheet" type="text/css" href="{{asset('assets/backend/css/animate.css')}}">
@endpush
@section('main_menu','Dashboard')
@section('active_menu','Dashboard')
@section('content')


    <div class="row">

   
        


              


        {{--<div class="col-xl-6 xl-100 box-col-12">--}}
        {{--                <div class="card">--}}
        {{--                  <div class="card-header pb-0 d-flex justify-content-between align-items-center">--}}
        {{--                    <h5>Course State</h5>--}}
        {{--                  </div>--}}
        {{--                  <div class="card-body">--}}
        {{--                    <div class="user-status table-responsive">--}}
        {{--                      <table class="table table-bordernone">--}}
        {{--                        <tbody>--}}
        {{--                          <tr>--}}
        {{--                            <td class="f-w-600">Simply dummy text of the printing</td>--}}
        {{--                            <td>1</td>--}}
        {{--                            <td class="font-primary">Pending</td>--}}
        {{--                            <td>--}}
        {{--                              <div class="span badge rounded-pill pill-badge-secondary">6523</div>--}}
        {{--                            </td>--}}
        {{--                          </tr>--}}
        {{--                        </tbody>--}}
        {{--                      </table>--}}
        {{--                    </div>--}}
        {{--                  </div>--}}
        {{--                </div>--}}
                     {{-- </div> --}}


















        {{--        <div class="col-xl-6 xl-100 box-col-12">--}}
        {{--            <div class="card">--}}
        {{--                <div class="cal-date-widget card-body">--}}
        {{--                    <div class="row">--}}
        {{--                        <div class="col-xl-12 col-xs-12 col-md-6 col-sm-6">--}}
        {{--                            <div class="cal-info text-center">--}}
        {{--                                <div>--}}
        {{--                                    <h2>{{date("d")}}</h2>--}}
        {{--                                    <div class="d-inline-block"><span class="b-r-dark pe-3">{{date("M")}}</span><span class="ps-3">{{date("Y")}}</span></div>--}}
        {{--                                    --}}{{--                            <p class="f-16">There is no minimum donation, any sum is appreciated</p>--}}
        {{--                                </div>--}}
        {{--                            </div>--}}
        {{--                        </div>--}}
        {{--                    </div>--}}
        {{--                </div>--}}
        {{--            </div>--}}
        {{--        </div>--}}

        {{--        <div class="col-xl-6 box-col-12 des-xl-100 dashboard-sec">--}}
        {{--            <div class="card income-card">--}}
        {{--                <div class="card-header">--}}
        {{--                    <div class="header-top d-sm-flex align-items-center">--}}
        {{--                        <h5>Daily Application submit</h5>--}}
        {{--                        <div class="center-content">--}}
        {{--                        </div>--}}
        {{--                        <div class="setting-list">--}}
        {{--                            <ul class="list-unstyled setting-option">--}}
        {{--                                <li>--}}
        {{--                                    <div class="setting-primary"><i class="icon-settings"></i></div>--}}
        {{--                                </li>--}}
        {{--                                <li><i class="view-html fa fa-code font-primary"></i></li>--}}
        {{--                                <li><i class="icofont icofont-maximize full-card font-primary"></i></li>--}}
        {{--                                <li><i class="icofont icofont-minus minimize-card font-primary"></i></li>--}}
        {{--                                <li><i class="icofont icofont-refresh reload-card font-primary"></i></li>--}}
        {{--                                <li><i class="icofont icofont-error close-card font-primary"></i></li>--}}
        {{--                            </ul>--}}
        {{--                        </div>--}}
        {{--                    </div>--}}
        {{--                </div>--}}
        {{--                <div class="card-body p-0">--}}
        {{--                    <div id="chart-timeline-dashbord"></div>--}}
        {{--                    <div class="code-box-copy">--}}
        {{--                    </div>--}}
        {{--                </div>--}}
        {{--            </div>--}}
        {{--        </div>--}}
    </div>











@endsection
@push('js')
    <script src="{{asset('assets/backend/js/chart/chartjs/Chart.js')}}"></script>
    <script>
        var background = ["rgba(255, 99, 132, 0.6)", "rgba(54, 162, 235, 0.6)", "rgba(255, 206, 86, 0.6)", "rgb(74,179,29,0.6)", "rgba(153, 102, 255, 0.6)", "rgba(179,61,85,0.6)", "rgb(176,20,93,0.6)", "rgb(28,151,208,0.6)", "rgba(75, 192, 192, 0.6)", "rgba(153, 102, 255, 0.6)", "rgb(229,121,27,0.6)", "rgb(235,60,54,0.6)", "rgb(53,186,24,0.6)", "rgb(8,37,79,0.6)", "rgba(153, 102, 255, 0.6)", "rgba(179,61,85,0.6)", "rgb(7,33,165,0.6)", "rgb(25,27,29,0.6)", "rgb(116,44,196,0.6)", "rgb(96,7,102,0.6)", "rgba(255, 99, 132, 0.6)", "rgba(54, 162, 235, 0.6)", "rgb(100,110,21,0.6)", "rgb(31,134,58,0.6)", "rgba(92,0,255,0.6)", "rgb(131,23,113,0.6)", "rgb(96,233,56,0.6)", "rgb(28,151,208,0.6)", "rgb(190,170,10,0.6)", "rgba(67,22,155,0.6)", "rgb(229,121,27,0.6)", "rgba(117,26,24,0.6)", "rgb(53,186,24,0.6)", "rgb(8,37,79,0.6)", "rgba(153, 102, 255, 0.6)", "rgb(246,0,255)", "rgb(62,167,33,0.6)", "rgb(153,9,9,0.6)", "rgb(11,185,217,0.6)", "rgb(96,7,102,0.6)",];
        background = background.sort(() => Math.random() - 0.5);


        $.ajax({
            url: "{{url('daily_submission_chart')}}",
            type: "GET",
            data: {},
            success: function (response) {
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
                                    borderColor: ['rgba(255,99,132,1)',],
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
            error: function (response) {
                $('#usernameError').text(response.responseJSON.errors.username);
            }
        });
    </script>
@endpush
