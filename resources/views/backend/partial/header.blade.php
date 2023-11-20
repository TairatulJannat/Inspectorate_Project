<div class="page-main-header">
    <div class="main-header-right row m-0">
        <div class="main-header-left" style=" background-color:#006A4E;">
            <div class="logo-wrapper"><a href=""><img class="img-fluid"
                        src="{{ asset('assets/backend/images/logo/army_logo.png') }} " alt=""
                        style="margin-left: 70px;
                    height: 80px; padding:5px;"></a>
            </div>
            <div class="dark-logo-wrapper"><a href="#"><img class="img-fluid" src="" alt=""
                        style="margin-left: 100px"></a></div>
            <div class="toggle-sidebar"><i class="status_toggle middle text-light" data-feather="align-center"
                    id="sidebar-toggle"></i></div>
        </div>
        <div class="left-menu-header col">
            <ul>
                <li>
                    <h3 class="font-success" style="font-size: 24px;font-weight: bold">Inspectorate of Electrical Equipments & Instruments</h3>
                </li>
            </ul>
        </div>
        <div class="nav-right col pull-right right-menu p-0">
            <ul class="nav-menus">
                <li><a class="text-dark" href="#!" onclick="javascript:toggleFullScreen()"><i
                            data-feather="maximize"></i></a></li>

                <li class="onhover-dropdown p-0 d-flex justify-content-center align-item center">

                    <div class=" dropdown-basic">

                        <div class="dropdown">
                            <button class="dropbtn btn-primary" type="button" data-bs-original-title="" title="">
                                <img class="img-90 rounded-circle"
                                    src="{{ asset('assets/backend/images/dashboard/1.png') }}" alt=""
                                    height='30px' width="30px">

                                {{ \Illuminate\Support\Facades\Auth::user()->name }} <span><i
                                        class="icofont icofont-arrow-down"></i></span>
                            </button>
                            <div class="dropdown-content"><a href=""
                                    onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();"
                                    type='button'>Log out</a></div>
                        </div>
                        <form id="logout-form" action="{{ route('admin_logout') }}" method="POST"
                            style="display: none;">
                            @csrf
                        </form>
                    </div>
                    {{-- <button
                        onclick="event.preventDefault();
                document.getElementById('logout-form').submit();"
                        class="btn btn-primary" type="button"><a href="login_two.html"
                            style="text-decoration: none;"><i data-feather="log-out"></i>Log out</a></button>
                    <form id="logout-form" action="{{ route('admin_logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form> --}}
                </li>
            </ul>
        </div>
        <div class="d-lg-none mobile-toggle pull-right w-auto"><i data-feather="more-horizontal"></i></div>
    </div>
</div>
