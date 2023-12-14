<style>
    .footer-copyright p a:hover {
        color: #059c74;
    }
</style>
<footer class="footer">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6 footer-copyright">
                <p class="mb-0">Developed By <a href="https://tilbd.net/" target="_blank" style="hover:"> Trust Innovation
                        Limited</a></p>
            </div>
            {{-- <div class="col-md-6">
                               <p class="pull-right mb-0">Developed By <a href="https://tilbd.net/" target="_blank"> Trust Innovation Limited</a></p>
                               {{ __('Copyright © ' . date('Y') . ' | All Rights Reserved by Bangladesh Army') }}
            </div> --}}
        </div>
    </div>
</footer>
</div>
</div>
<script src="{{ asset('assets/backend/js/jquery-3.5.1.min.js') }}"></script>
<script src="{{ asset('assets/backend/js/icons/feather-icon/feather.min.js') }}"></script>
<script src="{{ asset('assets/backend/js/icons/feather-icon/feather-icon.js') }}"></script>
<script src="{{ asset('assets/backend/js/sidebar-menu.js') }}"></script>
<script src="{{ asset('assets/backend/js/config.js') }}"></script>
<script src="{{ asset('assets/backend/js/bootstrap/popper.min.js') }}"></script>
<script src="{{ asset('assets/backend/js/bootstrap/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/backend/js/bootstrap/bootstrap-switch.min.js') }}"></script>
<script src="{{ asset('assets/backend/js/script.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
@stack('custom-scripts')
@stack('js')
{!! Toastr::message() !!}
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
        series: [44, 55, 41, 17],
        labels: ['New Arrival', 'Decision', 'Outgoing', 'Dispatch'],
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
        series: [44, 55, 41, 17],
        labels: ['New Arrival', 'Decision', 'Outgoing', 'Dispatch'],
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
</body>

</html>
