<footer class="footer">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6 footer-copyright">
                <p class="mb-0">{{ __('Copyright © ' . date('Y') . ' | All Rights Reserved by Bangladesh Army') }}</p>
            </div>
            <div class="col-md-6">
                {{--                <p class="pull-right mb-0">Developed By <a href="https://portfolio-ratin.com/" target="_blank"> Trust Innovation Limited</a></p> --}}
            </div>
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
<script src="{{ asset('assets/backend/js/script.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
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


    
        // var options = {
        // chart: {
        //     type: 'pie'
        // },
        // series: [44, 55, 13, 33],
        //     labels: ['Apple', 'Mango', 'Orange', 'Watermelon']
    
        // }
    
        // var chart = new ApexCharts(document.querySelector("#mypiechart"), options);
    
        // chart.render();


        var options8 = {
    chart: {
        width: 380,
        type: 'pie',
    },
    labels: ['Team A', 'Team B', 'Team C', 'Team D','Team E'],
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
    colors:[vihoAdminConfig.primary, vihoAdminConfig.secondary, '#222222', '#717171', '#e2c636']
}

var chart8 = new ApexCharts(
    document.querySelector("#mypiechart"),
    options8
);

chart8.render();

</script>
@stack('js')
</body>

</html>
