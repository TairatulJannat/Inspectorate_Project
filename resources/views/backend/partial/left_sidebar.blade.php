<?php
$currentControllerName = Request::segment(2);

?>
<style>
    li a span {
        color: #f6f6f6;
    }

    li a {
        color: #e2e2e2;
    }
</style>
<header class="main-nav">
    <div class="sidebar-user text-center"><a class="setting-primary" href="javascript:void(0)"><i
                data-feather="settings"></i></a><img class="img-90 rounded-circle"
            src="{{ asset('assets/backend/images/dashboard/1.png') }}" alt="">
        <div class="badge-bottom"><span class="badge badge-primary">New</span></div>
        <a href="" style="color: #fff">
            <h6 class="mt-3 f-14 f-w-600">{{ \Illuminate\Support\Facades\Auth::user()->name }}</h6>
        </a>
        {{-- <p class="mb-0 font-roboto" style="color: #fff"></p> --}}
    </div>
    <nav>
        <div class="main-navbar">
            <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
            <div id="mainnav">
                <ul class="nav-menu custom-scrollbar">
                    <li class="back-btn">
                        <div class="mobile-back text-end"><span>Back</span><i class="fa fa-angle-right ps-2"
                                aria-hidden="true"></i></div>
                    </li>
                    <li>
                        <a class="nav-link menu-title link-nav {{ $currentControllerName == 'adminDashboard' ? 'active_menu' : '' }}"
                            href="{{ route('admin.adminDashboard') }}">
                            <i data-feather="home" class="text-light"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>

                    @if (count(menu_check('Indent')) !== 0)
                        <li class="dropdown"><a
                                class="nav-link menu-title {{ $currentControllerName == 'Indent' ? 'active' : '' }}"
                                href="javascript:void(0)"><i data-feather="book-open"
                                    class="text-light"></i><span>Indent</span></a>
                            <ul class="nav-submenu menu-content {{ Request::is('*/Indent/*') ? 'open_menu' : '' }}">
                                @if (sub_menu_check('indent/view') !== null)
                                    <li><a class="text-light" href="{{ route('admin.indent/view') }}"
                                            class="{{ Request::is('*/*/all_menu') ? 'active' : '' }}">View Indent</a>
                                    </li>
                                @endif
                                @if (sub_menu_check('indent/views') !== null)
                                    <li><a href=""
                                            class="{{ Request::is('*/*/all_menu') ? 'active' : '' }}">Received
                                            Indent</a></li>
                                @endif
                            </ul>
                        </li>
                        {{-- <li class="dropdown"><a class="nav-link menu-title " href="javascript:void(0)"><i
                                    data-feather="list"></i><span>Indent</span></a>
                            <ul class="nav-submenu menu-content">

                                <li><a href="" class="">View Indent</a>
                                </li>
                                <li><a href=""
                                        class="{{ Request::is('*/*/add_role') ? 'active' : '' }}">Option</a>
                                </li>
                            </ul>
                        </li> --}}
                    @endif

                    @if (count(menu_check('PrelimGeneral')) !== 0)
                        <li class="dropdown"><a
                                class="nav-link menu-title {{ $currentControllerName == 'Indent' ? 'active' : '' }}"
                                href="javascript:void(0)"><i data-feather="book-open"
                                    class="text-light"></i><span>Specification</span></a>
                            <ul class="nav-submenu menu-content {{ Request::is('*/Indent/*') ? 'open_menu' : '' }}">
                                @if (sub_menu_check('indent/view') !== null)
                                    <li><a class="text-light" href="{{ route('admin.prelimgeneral/view') }}"
                                            class="{{ Request::is('*/*/all_menu') ? 'active' : '' }}">View
                                            Prelim/General</a>
                                    </li>
                                @endif
                                @if (sub_menu_check('indent/views') !== null)
                                    <li><a href=""
                                            class="{{ Request::is('*/*/all_menu') ? 'active' : '' }}">Received
                                            Indent</a></li>
                                @endif
                            </ul>
                        </li>
                    @endif
                    {{-- @if (count(menu_check('Tender')) !== 0)
                        <li class="dropdown"><a class="nav-link menu-title " href="javascript:void(0)"><i
                                    data-feather="list"></i><span>Tender</span></a>
                            <ul class="nav-submenu menu-content">
                                <li><a href=""
                                        class="{{ Request::is('*/*/all_role') ? 'active' : '' }}">Option</a>
                                </li>
                                <li><a href=""
                                        class="{{ Request::is('*/*/add_role') ? 'active' : '' }}">Option</a>
                                </li>
                            </ul>
                        </li>
                    @endif --}}
                    @if (count(menu_check('Specification')) !== 0)
                        <li class="dropdown"><a class="nav-link menu-title " href="javascript:void(0)"><i
                                    data-feather="list"></i><span>Specification</span></a>
                            <ul class="nav-submenu menu-content">
                                <li><a href="{{ route('admin.prelimgeneral/view') }}"
                                        class="{{ Request::is('*/*/all_role') ? 'active' : '' }}">PrelimGeneral</a>
                                </li>
                                <li><a href=""
                                        class="{{ Request::is('*/*/add_role') ? 'active' : '' }}">Option</a>
                                </li>
                            </ul>
                        </li>
                    @endif
                    @if (count(menu_check('Contact')) !== 0)
                        <li class="dropdown"><a class="nav-link menu-title " href="javascript:void(0)"><i
                                    data-feather="list"></i><span>Contact</span></a>
                            <ul class="nav-submenu menu-content">
                                <li><a href=""
                                        class="{{ Request::is('*/*/all_role') ? 'active' : '' }}">Option</a>
                                </li>
                                <li><a href=""
                                        class="{{ Request::is('*/*/add_role') ? 'active' : '' }}">Option</a>
                                </li>
                            </ul>
                        </li>
                    @endif
                    @if (count(menu_check('I-Note')) !== 0)
                        <li class="dropdown"><a class="nav-link menu-title " href="javascript:void(0)"><i
                                    data-feather="list"></i><span>I-Note</span></a>
                            <ul class="nav-submenu menu-content">
                                <li><a href=""
                                        class="{{ Request::is('*/*/all_role') ? 'active' : '' }}">Option</a>
                                </li>
                                <li><a href=""
                                        class="{{ Request::is('*/*/add_role') ? 'active' : '' }}">Option</a>
                                </li>
                            </ul>
                        </li>
                    @endif
                    {{-- <li class="dropdown"><a class="nav-link menu-title " href="javascript:void(0)"><i
                                data-feather="list"></i><span>Tender</span></a>
                        <ul class="nav-submenu menu-content">
                            <li><a href="" class="{{ Request::is('*/*/all_role') ? 'active' : '' }}">Option</a>
                            </li>
                            <li><a href="" class="{{ Request::is('*/*/add_role') ? 'active' : '' }}">Option</a>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown"><a class="nav-link menu-title " href="javascript:void(0)"><i
                                data-feather="list"></i><span>Specification</span></a>
                        <ul class="nav-submenu menu-content">
                            <li><a href="" class="">Option</a>
                            </li>
                            <li><a href="" class="">Option</a>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown"><a class="nav-link menu-title " href="javascript:void(0)"><i
                                data-feather="list"></i><span>Contact</span></a>
                        <ul class="nav-submenu menu-content">
                            <li><a href="" class="">Option</a>
                            </li>
                            <li><a href="" class="">Option</a>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown"><a class="nav-link menu-title " href="javascript:void(0)"><i
                                data-feather="list"></i><span>I-Note</span></a>
                        <ul class="nav-submenu menu-content">
                            <li><a href="" class="">Option</a>
                            </li>
                            <li><a href="" class="">Option</a>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown"><a class="nav-link menu-title " href="javascript:void(0)"><i
                                data-feather="list"></i><span>Settings</span></a>
                        <ul class="nav-submenu menu-content">

                            <li><a href=""
                                class=""> <span>Document Type</span></a>
                            </li>
                            <li><a href=""
                                class=""> <span>Department Management</span></a>
                            </li>
                            <li><a href=""
                                class=""> <span>Section Management</span></a>
                            </li>
                            <li><a href=""
                                class=""> <span>Army Division</span></a>
                            </li>
                            <li><a href=""
                                class=""> <span>Army Battalion</span></a>
                            </li>
                            <li><a href=""
                                class=""> <span>Army Unit</span></a>
                            </li>
                            <li><a href=""
                                class=""> <span>Additional Documents</span></a>
                            </li>
                        </ul>
                    </li> --}}






                    <li class="sidebar-main-title">
                        <div>
                            <h6>Role Permission</h6>
                        </div>
                    </li>

                    {{-- @if (count(menu_check('Menu')) !== 0) --}}
                    {{-- <li class="dropdown"><a class="nav-link menu-title active" href="javascript:void(0)"><i --}}
                    {{-- data-feather="list"></i><span>Menu</span></a> --}}
                    {{-- <ul class="nav-submenu menu-content"> --}}
                    {{-- <li><a href="{{route('admin.menu/menu_create')}}" class="active">Create Menu</a></li> --}}
                    {{-- <li><a href="{{route('admin.menu/all_menu')}}" class="{{Request::is('*/*/all_menu')?'active': ''}}">All Menu</a></li> --}}
                    {{-- </ul> --}}
                    {{-- </li> --}}
                    {{-- @endif --}}

                    @if (count(menu_check('Route')) !== 0)
                        <li class="dropdown"><a
                                class="nav-link menu-title link-nav {{ Request::is('*/dynamic_route') ? 'active' : '' }}"
                                style="color: #fff" href="{{ route('admin.dynamic_route') }}"><i
                                    data-feather="home"></i><span>Module/Route</span></a>
                        </li>
                    @endif

                    @if (count(menu_check('Role')) !== 0)
                        <li class="dropdown"><a
                                class="nav-link menu-title {{ Request::is('*/role/*') ? 'active' : '' }}"
                                style="color: #fff" href="javascript:void(0)"><i
                                    data-feather="list"></i><span>Roles</span></a>
                            <ul class="nav-submenu menu-content">
                                <li><a href="{{ route('admin.role/all_role') }}" style="color: #fff"
                                        class="{{ Request::is('*/*/all_role') ? 'active' : '' }}">All role</a></li>
                                <li><a href="{{ route('admin.role/add_role') }}" style="color: #fff"
                                        class="{{ Request::is('*/*/add_role') ? 'active' : '' }}">Add role</a></li>
                            </ul>
                        </li>
                    @endif

                    @if (count(menu_check('User')) !== 0)
                        <li class="dropdown"><a
                                class="nav-link menu-title link-nav {{ Request::is('*/all_user') ? 'active' : '' }}"
                                style="color: #fff" href="{{ route('admin.all_user') }}"><i
                                    data-feather="home"></i><span>Admin
                                    Users</span></a>
                        </li>
                    @endif
                </ul>
            </div>
            <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
        </div>
    </nav>
</header>
