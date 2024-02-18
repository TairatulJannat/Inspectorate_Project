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
<script src="{{ asset('assets/backend/js/flatpickr.js') }}"></script>
<script src="{{ asset('assets/backend/js/bootstrap-toggle.min.js') }}"></script>
@stack('custom-scripts')
@stack('js')
{!! Toastr::message() !!}

</body>

</html>
